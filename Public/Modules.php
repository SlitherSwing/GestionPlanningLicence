<?php

session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';

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

                <a href="calendrier.php" class="Icones">
                    <img src="assets/Calendar.svg" class="logo">
                    Calendrier
                </a>

                <a href="interventions.php" class="Icones">
                    <img src="assets/Frame.svg" class="logo">
                    Interventions
                </a>

                <a href="corps.enseignant.php" class="Icones">
                    <img src="assets/Board.svg" class="logo">
                    Corps enseignant
                </a>

            </div>

            <div class="Block-Settings">

                <p class="Block-Title">PARAMÉTRAGE</p>

                <a href="modules.php" class="Icones">
                    <img src="assets/Vector.svg" class="logo">
                    Modules
                </a>

                <a href="types.intervention.php" class="Icones">
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
                        <summary>Gestion de projet - Méthode Agile (63h)</summary>
                    </details>

                    <details open>
                        <summary>Cadre légal - Droit numérique (21h)</summary>
                        <ul class="List-Modules">
                            <li>
                                <details>
                                    <summary>RGPD</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>Propriété intellectuelle</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>RSE</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>Accessibilité</summary>
                                </details>
                            </li>
                        </ul>
                    </details>

                    <details open>
                        <summary>Eco-Conception (3,5h)</summary>
                    </details>

                    <details open>
                        <summary>Anglais - Préparation au TOEIC(17,5h)</summary>
                    </details>

                    <details open>
                        <summary>Communication - Soft Skills (28h)</summary>
                    </details>

                    <details open>
                        <summary>Devops et Cybersécurité(56h)</summary>
                        <ul class="List-Modules">
                            <li>
                                <details>
                                    <summary>Environment de travail(7h)</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>Environment de production(7h)</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>Docker(14h)</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>Git(7h)</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>Devops/Cyber(21h)</summary>
                                </details>
                            </li>
                        </ul>
                    </details>

                    <details open>
                        <summary>Retour d'expérience(REX) (3,5h)</summary>
                        <ul class="List-Modules">
                            <li>
                                <details>
                                    <summary>Conférence (3,5h)</summary>
                                </details>
                            </li>
                        </ul>
                    </details>

                    <details open>
                        <summary>Rédaction de comptes rendus d'activités (14h)</summary>
                    </details>

                    <details open>
                        <summary>Ergonomie et maquettage des applications (59h)</summary>
                        <ul class="List-Modules">
                            <li>
                                <details>
                                    <summary>User Experience / User Interface (49h)</summary>
                                    <ul>
                                        <li>
                                            <details>
                                                <summary>Les fondammentaux de l'UX (21h)</summary>
                                            </details>
                                        </li>
                                        <li>
                                            <details>
                                                <summary>L'UI et l'UX en mode projet (28h)</summary>
                                            </details>
                                        </li>
                                    </ul>
                                </details>
                            </li>

                        </ul>
                    </details>

                    <details open>
                        <summary>Architechture des données (10,5h)</summary>
                        <ul class="List-Modules">
                            <li>
                                <details>
                                    <summary>Structurer et mettre en place une architecture de base de données(7h)
                                    </summary>
                                </details>
                            </li>
                            <li>
                                <details>><summary>Monitorer une base de données + performance (3,5h)</summary>
                                </details>
                            </li>
                            <ul>
                                <li>
                                    <details>L'UI et l'UX en mode projet (28h)</details>
                                </li>
                            </ul>
                    </details>
                    </li>

                    </ul>
                    </details>

                    <details open>
                        <summary>Développement front (126h)</summary>
                        <ul class="List-Modules">
                            <li>
                                <details>
                                    <summary>Tailwind CSS (14h)</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>Javascript (35h)</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>React (49h)</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>NextJS (28h)</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>NextJS (28h)</summary>
                                </details>
                            </li>
                        </ul>
                    </details>

                    <details open>
                        <summary>Développement back (112h)</summary>
                        <ul class="List-Modules">
                            <li>
                                <details>
                                    <summary>Mise à niveau de PHP (21h)</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>PHP Objet (28h)</summary>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>Symfony (63h)</summary>
                                </details>
                            </li>
                        </ul>
                    </details>

                </div>

            </section>
            <button class="Add-Modules">
                <p>Ajouter un module</p>
            </button>
        </div>
</body>
