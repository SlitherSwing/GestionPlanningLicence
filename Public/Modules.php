<?php

session_start();
require_once __DIR__ . '/../Require/Credentials.php';
require_once __DIR__ . '/../Require/Requete.php';

$modules = moduleData($con);

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/modules.css">
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

        <div class="Sidebar-Menu">

            <div class="Block-Patch">
                <img src="assets/Logo.png" class="Logo">

                <div class="Text">
                    <h1>Lycée Saint-Vincent</h1>
                    <p>Enseignement Supérieur</p>
                </div>
            </div>

            <div class="Block-Menu">

                <p class="Block-Title">MENU</p>

                <a href="Calendrier.php" class="Icones">
                    <img src="assets/Calendar.svg" class="logo">
                    Calendrier
                </a>

                <a href="Interventions.php" class="Icones">
                    <img src="assets/Frame.svg" class="logo">
                    Interventions
                </a>

                <a href="CorpsEnseignant.php" class="Icones">
                    <img src="assets/Board.svg" class="logo">
                    Corps enseignant
                </a>

            </div>

            <div class="Block-Settings">

                <p class="Block-Title">PARAMÉTRAGE</p>

                <a href="Modules.html" class="Icones">
                    <img src="assets/Vector.svg" class="logo">
                    Modules
                </a>

                <a href="TypesIntervention.php" class="Icones">
                    <img src="assets/Chart.svg" class="logo">
                    Types d'intervention
                </a>

            </div>

            <div class="Block-Profile">

                <img src="assets/ProfilePicture.png" class="ProfilePicture">

                <div>
                    <div>
                        <span class="Username">
                            <?= $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?>
                        </span>
                        <img src="assets/Chevron-down.svg" class="Chevron-down">
                    </div>
                    <span class="Role">
                        <?= $_SESSION['role'] ?>
                    </span>
                </div>

            </div>

        </div>




        <div style="margin-right: 50px;">
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


                    <details open>

                    <?php foreach ($modules as $row): ?>

                        <summary><?= htmlspecialchars($row['name']) ?> (<?=  $row['hours_count'] ?>)</summary>
                        <ul class="List-Modules">
                            <li>
                                <details>
                                    <summary><?= htmlspecialchars($row['description']) ?></summary>
                                </details>
                            </li>
                        </ul>

                    <? end foreach; ?>
                    </details>

                </div>

            </section>
            <button class="Add-Modules">
                <p>Ajouter un module</p>
            </button>
        </div>
    </section>
