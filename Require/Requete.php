<?php


/*
 * Vérifie si un utilisateur est connecté via la session. Redirige vers la page de connexion (index.php) sinon.
 * Utilisée sur presque toutes les pages protégées (Calendrier, Interventions, Modules, etc.).
 */

function verifierConnexion()
{
    if (!isset($_SESSION['email'])) {
        header('Location: index.php');
        exit();
    }
}
/*
 * Récupère les informations d'un utilisateur (via son email) dans la base de données.
 * Principalement utilisée pour l'authentification (page : index.php).
 * 
 * @param string $email Email de l'utilisateur
 * Retourne un tableau contenant les données de l'utilisateur recherché
 */
function findUserByEmail(PDO $con, string $email): array
{
    $query = $con->prepare("SELECT * FROM user WHERE email =:email");
    $query->bindParam(':email', $email);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

/*
 * Compte le nombre total d'enseignants correspondant aux filtres fournis.
 * Utilisée pour gérer la pagination de l'annuaire (page : corps.enseignant.php).
 * 
 * @param string $nom Filtre sur le nom de famille
 * @param string $prenom Filtre sur le prénom
 * @param string $email Filtre sur l'email
 * Retourne le nombre d'enseignants correspondant aux filtres
 */
function countTeachersByFilters(PDO $con, string $nom, string $prenom, string $email): int
{
    $sql = "SELECT COUNT(DISTINCT instructor.id)
            FROM instructor
            INNER JOIN user ON user.id = instructor.user_id
            LEFT JOIN instructor_module ON instructor_module.instructor_id = instructor.id
            LEFT JOIN module ON module.id = instructor_module.module_id
            WHERE 1=1";

    $params = [];

    /*
     * Filtres sur le nom, le prénom et l'email
     */
    if ($nom !== '') {
        $sql .= " AND user.last_name = :last_name";
        $params['last_name'] = $nom;
    }

    if ($prenom !== '') {
        $sql .= " AND user.first_name = :first_name";
        $params['first_name'] = $prenom;
    }

    if ($email !== '') {
        $sql .= " AND user.email = :email";
        $params['email'] = $email;
    }

    $stmt = $con->prepare($sql);
    $stmt->execute($params);

    return (int) $stmt->fetchColumn();
}

/*
 * Récupère la liste des enseignants avec pagination et filtrage dynamique.
 * Utilisée pour afficher le tableau des enseignants (page : corps.enseignant.php).
 * 
 * @param string $nom Filtre sur le nom de famille
 * @param string $prenom Filtre sur le prénom
 * @param string $email Filtre sur l'email
 * @param int $limit Nombre maximal de résultats par page
 * @param int $offset Lignes à ignorer (pour la pagination)
 * Retourne la liste des enseignants
 */
function findTeachersByFilters(PDO $con, string $nom, string $prenom, string $email, int $limit, int $offset): array
{
    $sql = "SELECT instructor.id, user.last_name, user.first_name, user.email, module.name, module.hours_count
            FROM instructor
            INNER JOIN user ON user.id = instructor.user_id
            LEFT JOIN instructor_module ON instructor_module.instructor_id = instructor.id
            LEFT JOIN module ON module.id = instructor_module.module_id
            WHERE 1=1";

    $params = [];

    if ($nom !== '') {
        $sql .= " AND user.last_name = :last_name";
        $params['last_name'] = $nom;
    }

    if ($prenom !== '') {
        $sql .= " AND user.first_name = :first_name";
        $params['first_name'] = $prenom;
    }

    if ($email !== '') {
        $sql .= " AND user.email = :email";
        $params['email'] = $email;
    }

    $sql .= " ORDER BY user.last_name ASC LIMIT :limit OFFSET :offset";

    $stmt = $con->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue(':' . $key, $value);
    }

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
 * Récupère tous les cours/interventions triés par date décroissante.
 * Utilisée pour l'affichage chronologique global (pages : Calendrier.php, Interventions.php).
 * 
 * Retourne la liste intégrale des cours
 */
function calendarData(PDO $con): array
{
    $sql = "SELECT * FROM course ORDER BY start_date DESC";
    $stmt = $con->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
 * Ajoute un nouveau type d'intervention en base de données.
 * Utilisée lors de la soumission du formulaire de création (page : types.intervention.cours.php).
 * 
 * @param string $name Nom du type d'intervention
 * @param string $color Code couleur
 * @param string $description Description de l'intervention
 * Retourne vrai si l'insertion a réussi, sinon faux
 */
function insertTypeIntervention(PDO $con, string $name, string $color, string $description): bool
{
    $sql = "INSERT INTO intervention_type (name, color, description) VALUES (:name, :color, :description)";
    $params = [
        ':name' => $name,
        ':color' => $color,
        ':description' => $description,
    ];
    $stmt = $con->prepare($sql);
    return $stmt->execute($params);
}

/*
 * Récupère les informations génériques (nom, prénom, email) d'un enseignant spécifique.
 * Utilisée pour afficher l'en-tête du profil d'un intervenant (page : fiche.enseignant.php).
 * 
 * @param int $id Identifiant (ID) de l'enseignant (instructor)
 * Retourne les données du profil de l'enseignant
 */
function requeteEnseignant(PDO $con, int $id): array
{
    $sql = "SELECT instructor.id, user.id AS user_id, user.first_name, user.last_name, user.email
            FROM instructor
            INNER JOIN user ON user.id = instructor.user_id
            WHERE instructor.id = :id";
    $stmt = $con->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
 * Récupère la liste des modules d'enseignement affectés à cet enseignant.
 * Utilisée pour l'onglet "Modules liés" d'un enseignant (page : fiche.enseignant.php ou Modules).
 * 
 * @param int $id Identifiant (ID) de l'enseignant
 * Retourne les modules assignés à l'enseignant
 */
function requeteModules(PDO $con, int $id): array
{
    $sql = "SELECT module.id, module.name, module.hours_count
            FROM instructor_module
            INNER JOIN module ON module.id = instructor_module.module_id
            WHERE instructor_module.instructor_id = :id
            ORDER BY module.name";
    $stmt = $con->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
 * Récupère l'historique des cours/interventions d'un enseignant ciblé avec option de filtrage.
 * Utilisée dans l'onglet "Interventions" du profil de l'enseignant (page : fiche.enseignant.php).
 * 
 * @param int $id Identifiant (ID) de l'enseignant (instructor)
 * @param string $dateDebut Sélecteur : à partir de la date
 * @param string $dateFin Sélecteur : jusqu'à la date
 * @param string $moduleFiltre Sélecteur : l'ID d'un module en particulier
 * Retourne les interventions correspondant aux filtres
 */
function requeteIntervention(PDO $con, int $id, string $dateDebut, string $dateFin, string $moduleFiltre): array
{
    $sqlInterventions = "SELECT course.start_date, course.end_date, course.title,
module.name AS module_name, intervention_type.name AS type_name, course.remotely
FROM course
INNER JOIN course_instructor ON course_instructor.course_id = course.id
INNER JOIN module ON module.id = course.module_id
INNER JOIN intervention_type ON intervention_type.id = course.intervention_type_id
WHERE course_instructor.instructor_id = :id";

    $parametres = ['id' => $id];

    if ($dateDebut !== '') {
        $sqlInterventions .= " AND course.start_date >= :date_debut";
        $parametres['date_debut'] = $dateDebut . ' 00:00:00';
    }

    if ($dateFin !== '') {
        $sqlInterventions .= " AND course.end_date <= :date_fin";
        $parametres['date_fin'] = $dateFin . ' 23:59:59';
    }

    if ($moduleFiltre !== '') {
        $sqlInterventions .= " AND course.module_id = :module_id";
        $parametres['module_id'] = $moduleFiltre;
    }

    $sqlInterventions .= " ORDER BY course.start_date ASC";

    $requeteInterventions = $con->prepare($sqlInterventions);
    $requeteInterventions->execute($parametres);
    return $requeteInterventions->fetchAll(PDO::FETCH_ASSOC);
}

/*
 * Insère un nouvel enseignant dans la base de données.
 * Utilisée lors de la soumission du formulaire d'ajout (page : corps.enseignant.php).
 *
 * @param string $nom Nom de famille
 * @param string $prenom Prénom
 * @param string $email Adresse email
 * Retourne l'ID de l'enseignant inséré, ou faux en cas d'échec
 */
function insertionEnseignant(PDO $con, string $nom, string $prenom, string $email): bool
{
    $sql = "INSERT INTO user (last_name, first_name, email, password, role) VALUES (:last_name, :first_name, :email, :password, :role)";
    $params = [
        ':last_name' => $nom,
        ':first_name' => $prenom,
        ':email' => $email,
        ':password' => password_hash('default123', PASSWORD_DEFAULT),
        ':role' => 'instructor',
    ];
    $stmt = $con->prepare($sql);
    $result = $stmt->execute($params);

    if ($result) {
        $userId = $con->lastInsertId();
        $sql = "INSERT INTO instructor (user_id) VALUES (:user_id)";
        $stmt = $con->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
    }

    return $result;
}

/*
 * Récupère les types d'intervention, avec possibilité de filtrer sur le nom.
 * Utilisée pour l'affichage du tableau de gestion des types et de ses filtres (page : types.intervention.php).
 *
 * @param string $name Terme de recherche par nom (si vide, on renvoie tout)
 * Retourne le catalogue dynamique des types d'intervention
 */
function filtreTypeIntervention(PDO $con, string $name): array
{
    if (!empty($name)) {

        $sql = "SELECT * FROM intervention_type WHERE name LIKE :nom ORDER BY name DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([':nom' => "%" . $name . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } else {

        $sql = "SELECT * FROM intervention_type ORDER BY name DESC";
        $stmt = $con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}