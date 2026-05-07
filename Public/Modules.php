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





<div class="Modal-Screen" id="Modal-Ajout-Module">

        <!-- En-tête de la modale -->
        <div>
            <div>
                <!-- Icône -->
                <div>
                    <span class="material-symbols-outlined">add</span>
                </div>
                <!-- Titre + texte -->
                <div>
                    <h3>Ajouter un module</h3>
                    <p>Remplissez les informations ci-dessous.</p>
                </div>
                <!-- Bouton fermer -->
                <div>
                    <a href="#" class="Close-Modal">x</a>
                </div>
            </div>
        </div>
        <!-- Formulaire d'ajout -->
        <div>
            <form action="" method="post">
                <!-- POST = envoi des données au serveur -->

                <!-- Nom du module -->
                <div style="display: grid;grid-template-columns: 1fr 1fr;gap: 20px;">

                    <div>
                        <label for="Ajout-Module-Nom">Nom du module</label>
                        <input id="Ajout-Module-Nom" type="text" name="NomDuModule" required>
                    </div>
                    <div>
                        <label for="Ajout-Module-Heure">Nombre d'heures </label>
                        <input id="Ajout-Module-Heure" type="text" name="HeureDuModule" required>
                    </div>

                </div>
                <!-- Nom du module -->
                <div>
                    <label for="Ajout-Module-Code">Code du module</label>
                    <input id="Ajout-Module-Code" type="text" name="CodeDuModule" required>
                </div>
                <!-- Description du module -->
                <div>
                    <label for="DescriptionModule">Description du module</label>
                    <input id="Ajout-Module-Description" type="DescriptionDuModule" name="DescriptionDuModule"
                        placeholder="Saisissez une description" required>
                </div>
                <!-- Boutons -->
                <div class="Modal-Bottom">
                    <!-- Annuler -->
                    <button style="background-color: #F0F0F0;color: black;"><a href="#"> Annuler</a></button>
                    <!-- Envoyer le formulaire -->
                    <button>Confirmer</button>
                </div>
            </form>
        </div>
    </div>




<!-- Conteneur principal  -->
<section class="Page">
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