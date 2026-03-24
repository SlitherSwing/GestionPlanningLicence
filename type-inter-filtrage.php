<?php
    include 'autorisation.php';

    if (!empty($_POST['NameType'])) {
        
        $nameType = $_POST['NameType'];

        $sql = "SELECT * FROM intervention_type WHERE name LIKE :nom ORDER BY name DESC";
        $stmt = $con->prepare($sql);
        
        $stmt->execute([':nom' => "%" . $nameType . "%"]);

    } else {
        
        $sql = "SELECT * FROM intervention_type ORDER BY name DESC";
        $stmt = $con->query($sql);

    }
    $typeinterventions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $count = count($typeinterventions);
?>