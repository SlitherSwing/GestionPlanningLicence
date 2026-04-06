<?php


function verifierConnexion()
{
    if (!isset($_SESSION['email'])) {
        header('Location: index.php');
        exit();
    }
}
function findUserByEmail(PDO $con, string $email): array
{
    $query = $con->prepare("SELECT * FROM user WHERE email =:email");
    $query->bindParam(':email', $email);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function countTeachersByFilters(PDO $con, string $nom, string $prenom, string $email): int
{
    $sql = "SELECT COUNT(*)
            FROM instructor
            INNER JOIN user ON user.id = instructor.user_id
            INNER JOIN instructor_module ON instructor_module.instructor_id = instructor.id
            INNER JOIN module ON module.id = instructor_module.module_id
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

    $stmt = $con->prepare($sql);
    $stmt->execute($params);

    return (int) $stmt->fetchColumn();
}

function findTeachersByFilters(PDO $con, string $nom, string $prenom, string $email, int $limit, int $offset): array
{
    $sql = "SELECT instructor.id, user.last_name, user.first_name, user.email, module.name, module.hours_count
            FROM instructor
            INNER JOIN user ON user.id = instructor.user_id
            INNER JOIN instructor_module ON instructor_module.instructor_id = instructor.id
            INNER JOIN module ON module.id = instructor_module.module_id
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

function calendarData(PDO $con): array
{
    $sql = "SELECT * FROM course ORDER BY start_date DESC";
    $stmt = $con->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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