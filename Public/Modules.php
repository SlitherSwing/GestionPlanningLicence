<?php


session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';
verifierConnexion();

$modules = moduleData($con);


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Corps Enseignant</title>
    <!-- Connexion à Google Fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Import de la police Poppins -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Import des icônes Google -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>

    <!-- Conteneur principal  -->
    <section class="Page">

        <!-- Inclusion du menu latéral (sidebar réutilisée avec PHP) -->
        <?php include '../require/sidebar.php'; ?>

        <!-- Contenu principal des modules -->
        <div class="Modules-Content">

            <!-- En-tête avec navigation -->
            <section class="Top-Modules">

                <!-- Icône maison -->
                <div class="House-Modules">
                    <img src="assets/maison.png">
                </div>

                <!-- Fil d’Ariane -->
                <div class="House-Modules-Text">
                    <p>> Modules </p>
                </div>

            </section>

            <!-- Séparation visuelle -->
            <hr class="Lign-Modules">

            <!-- Titre de la section modules -->
            <section class="Modules-Title">

                <div class="Modules-Inter">
                    <p class="Modules"> &emsp;Modules</p>
                </div>

            </section>

            <!-- Arborescence des modules -->
            <section class="The-Modules">



                <?php foreach ($modules as $row): ?>
                    <details open>

                        <summary><?= htmlspecialchars($row['name']) ?> (<?= $row['hours_count'] ?>h)</summary>
                        <ul class="List-Modules">
                            <li>
                                <details>
                                    <summary><?= htmlspecialchars($row['description']) ?></summary>
                                </details>
                            </li>
                        </ul>
                    </details>

                <?php endforeach; ?>

            </section>

            <!-- Bouton ajout module -->
            <button class="Add-Modules">
                <a style="color:white;" href="#Modal-Ajout-Module">Ajouter un module</a>
            </button>

        </div>

    </section>

</body>

</html>