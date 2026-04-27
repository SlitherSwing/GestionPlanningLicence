<?php


session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';
verifierConnexion();

   
    require_once __DIR__ . '/../Require/Credentials.php';
    require_once __DIR__ . '/../Require/Requete.php';

    $modules = moduleData($con);


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="modules.css">
    <title>Corps Enseignant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <section class="Page">

        <?php include '../require/sidebar.php'; ?>




        <div class="Modules-Content">
            <section class="Top-Modules">

                <div class="House-Modules"> <img src="assets/maison.png"></div>
                <div class="House-Modules-Text">
                    <p>> Modules </p>
                </div>

            </section>
            <hr class="Lign-Modules">

            <section class="Modules-Title">

                <div class="Modules-Inter">
                    <p class="Modules"> &emsp;Modules</p>
                </div>

            </section>

            <section class="The-Modules">

                <div class="Arborescence-Modules">


                    

                    <?php foreach ($modules as $row): ?>
                        <details open>

                            <summary><?= htmlspecialchars($row['name']) ?> (<?=  $row['hours_count'] ?>h)</summary>
                            <ul class="List-Modules">
                                <li>
                                    <details>
                                        <summary><?= htmlspecialchars($row['description']) ?></summary>
                                    </details>
                                </li>
                            </ul>
                        </details>

                    <?php endforeach; ?>
                   

                </div>

            </section>
            <button class="Add-Modules">
                <p>Ajouter un module</p>
            </button>
        </div>
    </section>
