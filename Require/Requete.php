<?php

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

function findTypesIntervention(PDO $con, ): array
{
    $sql = "INSERT INTO intervention_type (:name, :couleur, :description)";
    $stmt = $con->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':couleur' => $couleur,
        ':description' => $description
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}