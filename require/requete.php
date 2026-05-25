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
function findUserByEmail(PDO $con, string $email): array|false
{
    $query = $con->prepare("SELECT * FROM user WHERE email =:email");
    $query->bindParam(':email', $email);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

/*
 * Compte le nombre total d'enseignants correspondant aux filtres fournis.
 * Utilisée pour gérer la pagination de l'annuaire (page : corps_enseignant.php).
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
 * Utilisée pour afficher le tableau des enseignants (page : corps_enseignant.php).
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
 * Utilisée pour l'affichage chronologique global (pages : calendrier.php, interventions.php).
 *
 * Retourne la liste intégrale des cours
 */
function calendarData(PDO $con): array
{
    return calendarDataFiltered($con, '', '', '');
}

/*
 * Récupère les cours/interventions avec filtres optionnels.
 * Utilisée pour l'affichage filtré (page : interventions.php).
 *
 * @param string $startDate Filtre : date de début (format YYYY-MM-DD)
 * @param string $endDate Filtre : date de fin (format YYYY-MM-DD)
 * @param string $moduleName Filtre : nom du module (recherche partielle)
 * Retourne la liste des interventions filtrées
 */
function calendarDataFiltered(PDO $con, string $startDate, string $endDate, string $moduleName): array
{
    $sql = "SELECT course.*, module.name AS module_name, intervention_type.name AS type_name, user.last_name, user.first_name
        FROM course
        JOIN module ON module.id = course.module_id
        JOIN intervention_type ON intervention_type.id = course.intervention_type_id
        JOIN course_instructor ON course_instructor.course_id = course.id
        JOIN instructor ON instructor.id = course_instructor.instructor_id
        JOIN user ON user.id = instructor.user_id
        WHERE 1=1";

    $params = [];

    if ($startDate !== '') {
        $sql .= " AND DATE(course.start_date) >= :start_date";
        $params[':start_date'] = $startDate;
    }

    if ($endDate !== '') {
        $sql .= " AND DATE(course.end_date) <= :end_date";
        $params[':end_date'] = $endDate;
    }

    if ($moduleName !== '') {
        $sql .= " AND module.name LIKE :module_name";
        $params[':module_name'] = "%" . $moduleName . "%";
    }

    $sql .= " ORDER BY course.start_date DESC";

    $stmt = $con->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/*
 * Ajoute un nouveau type d'intervention en base de données.
 * Utilisée lors de la soumission du formulaire de création (page : types_intervention_cours.php).
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
 * Récupère un type d'intervention par son ID.
 * Utilisée pour pré-remplir le formulaire de modification.
 *
 * @param int $id Identifiant du type d'intervention
 * Retourne les données du type d'intervention
 */
function getTypeInterventionById(PDO $con, int $id): array|false
{
    $sql = "SELECT * FROM intervention_type WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
 * Met à jour un type d'intervention existant.
 * Utilisée lors de la modification d'un type (page : types_intervention_cours.php).
 *
 * @param int $id Identifiant du type d'intervention
 * @param string $name Nom du type d'intervention
 * @param string $color Code couleur
 * @param string $description Description de l'intervention
 * Retourne vrai si la mise à jour a réussi, sinon faux
 */
function updateTypeIntervention(PDO $con, int $id, string $name, string $color, string $description): bool
{
    $sql = "UPDATE intervention_type SET name = :name, color = :color, description = :description WHERE id = :id";
    $params = [
        ':id' => $id,
        ':name' => $name,
        ':color' => $color,
        ':description' => $description,
    ];
    $stmt = $con->prepare($sql);
    return $stmt->execute($params);
}

function deleteTypeIntervention(PDO $con, int $id): bool
{
    $sql = "DELETE FROM intervention_type WHERE id = :id";
    $params = [
        ':id' => $id,
    ];
    $stmt = $con->prepare($sql);
    return $stmt->execute($params);
}
function deleteIntervention(PDO $con, int $id): bool
{
    $sql1 = "DELETE FROM course_instructor WHERE course_id = :id";
    $sql2 = "DELETE FROM course WHERE id = :id";

    $stmt1 = $con->prepare($sql1);
    $stmt1->execute([':id' => $id]);

    $stmt2 = $con->prepare($sql2);
    return $stmt2->execute([':id' => $id]);
}
/*
 * Récupère les informations génériques (nom, prénom, email) d'un enseignant spécifique.
 * Utilisée pour afficher l'en-tête du profil d'un intervenant (page : fiche_enseignant.php).
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
 * Utilisée pour l'onglet "Modules liés" d'un enseignant (page : fiche_enseignant.php ou Modules).
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
 * Utilisée dans l'onglet "Interventions" du profil de l'enseignant (page : fiche_enseignant.php).
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
 * Utilisée lors de la soumission du formulaire d'ajout (page : corps_enseignant.php).
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
 * Utilisée pour l'affichage du tableau de gestion des types et de ses filtres (page : types_intervention.php).
 *
 * @param string $name Terme de recherche par nom (si vide, on renvoie tout)
 * Retourne le catalogue dynamique des types d'intervention
 */
function filtreTypeIntervention(PDO $con, string $nameType): array
{
    if (!empty($nameType)) {

        $sql = "SELECT * FROM intervention_type WHERE name LIKE :nom ORDER BY name DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([':nom' => "%" . $nameType . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } else {

        $sql = "SELECT * FROM intervention_type ORDER BY name DESC";
        $stmt = $con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}


function moduleData(PDO $con): array
{
    $sql = "SELECT * FROM module ORDER BY id DESC";
    $stmt = $con->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



/*
 * Détruit la session de l'utilisateur connecté et le redirige vers la page de connexion.
 * Utilisée lors de la soumission du formulaire de déconnexion (sidebar.php).
 */
function logout(): void
{
    session_destroy();
    header('Location: ../public/index.php');
    exit();
}

if (basename($_SERVER['SCRIPT_FILENAME']) === 'requete.php' && isset($_POST['logout'])) {
    session_start();
    logout();
}


function insertIntervention(PDO $con, string $title, string $startDate, string $endDate, int $moduleId, int $typeId, int $remotely, array $instructorIds): bool
{
    $startDate = str_replace('T', ' ', $startDate) . ':00';
    $endDate = str_replace('T', ' ', $endDate) . ':00';

    $sql = "INSERT INTO course (title, start_date, end_date, module_id, intervention_type_id, remotely)
            VALUES (:title, :start_date, :end_date, :module_id, :intervention_type_id, :remotely)";

    $stmt = $con->prepare($sql);
    $result = $stmt->execute([
        ':title' => $title,
        ':start_date' => $startDate,
        ':end_date' => $endDate,
        ':module_id' => $moduleId,
        ':intervention_type_id' => $typeId,
        ':remotely' => $remotely,
    ]);

    if (!$result) {
        return false;
    }

    $courseId = (int) $con->lastInsertId();

    $sqlLink = "INSERT INTO course_instructor (course_id, instructor_id) VALUES (:course_id, :instructor_id)";
    $stmtLink = $con->prepare($sqlLink);

    foreach ($instructorIds as $instructorId) {
        $stmtLink->execute([
            ':course_id' => $courseId,
            ':instructor_id' => (int) $instructorId,
        ]);
    }

    return true;
}

/*
 * Récupère une intervention par son ID avec tous ses détails.
 * Utilisée pour pré-remplir la modale de modification.
 *
 * @param PDO $con Connexion à la base de données
 * @param int $id Identifiant de l'intervention
 * Retourne les données de l'intervention ou false
 */
function getInterventionById(PDO $con, int $id): array|false
{
    $sql = "SELECT course.*, module.name AS module_name, intervention_type.name AS type_name
            FROM course
            JOIN module ON module.id = course.module_id
            JOIN intervention_type ON intervention_type.id = course.intervention_type_id
            WHERE course.id = :id";
    $stmt = $con->prepare($sql);
    $stmt->execute([':id' => $id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        return false;
    }

    // Récupérer les intervenants associés
    $sqlInst = "SELECT instructor_id
                FROM course_instructor
                WHERE course_id = :course_id";
    $stmtInst = $con->prepare($sqlInst);
    $stmtInst->execute([':course_id' => $id]);
    $instructors = $stmtInst->fetchAll(PDO::FETCH_COLUMN);

    $course['instructor_ids'] = $instructors;

    return $course;
}

/*
 * Met à jour une intervention existante.
 *
 * @param PDO $con Connexion à la base de données
 * @param int $id Identifiant de l'intervention
 * @param string $title Titre de l'intervention
 * @param string $startDate Date de début
 * @param string $endDate Date de fin
 * @param int $moduleId Identifiant du module
 * @param int $typeId Identifiant du type d'intervention
 * @param int $remotely Intervention en visio (0 ou 1)
 * @param array $instructorIds Tableau des identifiants des intervenants
 * Retourne vrai si la mise à jour a réussi, sinon faux
 */
function updateIntervention(PDO $con, int $id, string $title, string $startDate, string $endDate, int $moduleId, int $typeId, int $remotely, array $instructorIds): bool
{
    $startDate = str_replace('T', ' ', $startDate) . ':00';
    $endDate = str_replace('T', ' ', $endDate) . ':00';

    $sql = "UPDATE course
            SET title = :title, start_date = :start_date, end_date = :end_date,
                module_id = :module_id, intervention_type_id = :intervention_type_id, remotely = :remotely
            WHERE id = :id";

    $stmt = $con->prepare($sql);
    $result = $stmt->execute([
        ':id' => $id,
        ':title' => $title,
        ':start_date' => $startDate,
        ':end_date' => $endDate,
        ':module_id' => $moduleId,
        ':intervention_type_id' => $typeId,
        ':remotely' => $remotely,
    ]);

    if (!$result) {
        return false;
    }

    // Supprimer les anciennes liaisons intervenants
    $sqlDelete = "DELETE FROM course_instructor WHERE course_id = :course_id";
    $stmtDelete = $con->prepare($sqlDelete);
    $stmtDelete->execute([':course_id' => $id]);

    // Insérer les nouvelles liaisons
    $sqlLink = "INSERT INTO course_instructor (course_id, instructor_id) VALUES (:course_id, :instructor_id)";
    $stmtLink = $con->prepare($sqlLink);

    foreach ($instructorIds as $instructorId) {
        $stmtLink->execute([
            ':course_id' => $id,
            ':instructor_id' => (int) $instructorId,
        ]);
    }

    return true;
}

function ajouterModule(PDO $con, string $code, string $nom, int $heure, string $description): void
{
    $sql = "INSERT INTO module (code, name, hours_count, description)
            VALUES (:code, :name, :hours_count, :description)";

    $stmt = $con->prepare($sql);
    $stmt->execute([
        ':code' => $code,
        ':name' => $nom,
        ':hours_count' => $heure,
        ':description' => $description,
    ]);
}

function getModuleById(PDO $con, int $id): array|false
{
    $sql = "SELECT * FROM module WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateModule(PDO $con, int $id, string $code, string $nom, int $heure, string $description): bool
{
    $sql = "UPDATE module SET code = :code, name = :name, hours_count = :hours_count, description = :description
            WHERE id = :id";
    $stmt = $con->prepare($sql);
    return $stmt->execute([
        ':id' => $id,
        ':code' => $code,
        ':name' => $nom,
        ':hours_count' => $heure,
        ':description' => $description,
    ]);
}

function deleteModule(PDO $con, int $id): bool
{
    $sql = "DELETE FROM module WHERE id = :id";
    $stmt = $con->prepare($sql);
    return $stmt->execute([':id' => $id]);
}

function countInterventionsByModule(PDO $con, int $moduleId): int
{
    $sql = "SELECT COUNT(*) FROM course WHERE module_id = :id";
    $stmt = $con->prepare($sql);
    $stmt->execute([':id' => $moduleId]);
    return (int) $stmt->fetchColumn();
}

/*
 * Ajoute un module à un enseignant.
 * Utilisée pour lier un module existant à un instructeur (page : fiche_enseignant.php).
 *
 * @param PDO $con Connexion à la base de données
 * @param int $instructorId Identifiant de l'enseignant
 * @param int $moduleId Identifiant du module à lier
 * Retourne vrai si l'ajout a réussi, faux si le lien existe déjà ou en cas d'erreur
 */
function addModuleToInstructor(PDO $con, int $instructorId, int $moduleId): bool
{
    $sql = "INSERT IGNORE INTO instructor_module (instructor_id, module_id)
            VALUES (:instructor_id, :module_id)";
    $stmt = $con->prepare($sql);
    return $stmt->execute([
        ':instructor_id' => $instructorId,
        ':module_id' => $moduleId,
    ]);
}

/*
 * Supprime un module d'un enseignant.
 * Utilisée pour dissocier un module d'un instructeur (page : fiche_enseignant.php).
 *
 * @param PDO $con Connexion à la base de données
 * @param int $instructorId Identifiant de l'enseignant
 * @param int $moduleId Identifiant du module à supprimer
 * Retourne vrai si la suppression a réussi
 */
function removeModuleFromInstructor(PDO $con, int $instructorId, int $moduleId): bool
{
    $sql = "DELETE FROM instructor_module
            WHERE instructor_id = :instructor_id AND module_id = :module_id";
    $stmt = $con->prepare($sql);
    return $stmt->execute([
        ':instructor_id' => $instructorId,
        ':module_id' => $moduleId,
    ]);
}

/*
 * Récupère tous les modules disponibles.
 * Utilisée pour peupler les listes déroulantes (page : fiche_enseignant.php).
 *
 * @param PDO $con Connexion à la base de données
 * @param int $excludeInstructorId Si fourni, exclut les modules déjà liés à cet instructeur
 * Retourne la liste des modules
 */
function getAllModules(PDO $con, int $excludeInstructorId = 0): array
{
    if ($excludeInstructorId > 0) {
        $sql = "SELECT m.* FROM module m
                WHERE m.id NOT IN (
                    SELECT module_id FROM instructor_module WHERE instructor_id = :instructor_id
                )
                ORDER BY m.name ASC";
        $stmt = $con->prepare($sql);
        $stmt->execute([':instructor_id' => $excludeInstructorId]);
    } else {
        $sql = "SELECT * FROM module ORDER BY name ASC";
        $stmt = $con->query($sql);
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
