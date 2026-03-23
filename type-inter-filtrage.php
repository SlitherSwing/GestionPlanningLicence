<?php
    include 'autorisation.php';

    $sql = "SELECT * FROM intervention_type ORDER BY name DESC";
    $stmt = $con->query($sql);
    $typeinterventions = $stmt->fetchAll(PDO::FETCH_ASSOC);



    if (isset($__POST['NameType'])){
        $nameType = $__POST['NameType'];

        if ($__POST['NameType'] = 'Soutenance')
    }

?>