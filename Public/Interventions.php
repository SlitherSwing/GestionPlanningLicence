<?php
session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';

verifierConnexion();
$interventions = calendarData($con);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Interventions</title>
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

    <!-- Modale ajout interventions -->
    <div class="Modal-Screen" id="Modal-Ajout">

        <div>
            <div>

                <!-- Icône "+" -->
                <div>
                    <span class="material-symbols-outlined">add</span>
                </div>

                <!-- Titre et description de la modale -->
                <div>
                    <h3>Ajouter une intervention</h3>
                    <p>Remplissez les informations ci-dessous.</p>
                </div>

                <!-- Bouton de fermeture -->
                <div>
                    <a href="#" class="Close-Modal">X</a>
                </div>

            </div>
        </div>

        <div>

            <!-- Formulaire ajout intervention -->
            <form action="" method="post">

                <!-- Champ titre -->
                <div>
                    <label for="Ajout-intervention-Titre">Titre</label>
                    <input id="Ajout-intervention-Titre" type="text"
                        placeholder="Saisissez un titre sur l’intervention">
                </div>

                <!-- Dates début et fin -->
                <div style="display: grid;grid-template-columns: 1fr 1fr;gap: 20px;">

                    <div>
                        <label for="Ajout-intervention-Date-Début">Date de début</label>
                        <input id="Ajout-intervention-Date-Début" type="datetime-local">
                    </div>

                    <div>
                        <label for="Ajout-intervention-Date-Fin">Date de fin</label>
                        <input id="Ajout-intervention-Date-Fin" type="datetime-local">
                    </div>

                </div>

                <!-- Module et type -->
                <div style="display: grid;grid-template-columns: 1fr 1fr;gap: 20px;">

                    <div>
                        <label for="Ajout-intervention-Module">Module</label>
                        <select id="Ajout-intervention-Module"></select>
                    </div>

                    <div>
                        <label for="Ajout-intervention-Type">Type d’intervention</label>
                        <select id="Ajout-intervention-Type"></select>
                    </div>

                </div>

                <!-- Intervenants -->
                <div>
                    <label>Intervenants</label>
                    <input type="" placeholder="?">
                </div>

                <!-- Visio -->
                <div style="display: flex;flex-direction: row;">

                    <label>Intervention en visio</label>

                    <input type="checkbox">

                </div>

                <!-- Boutons -->
                <div class="Modal-Bottom">
                    <button style="background-color: #F0F0F0;color: black;">Annuler</button>
                    <button>Confirmer</button>
                </div>

            </form>

        </div>

    </div>

    <!-- Modale modification -->
    <div class="Modal-Screen" id="Modal-Modif">

        <div>
            <div>

                <!-- Icône -->
                <div>
                    <span class="material-symbols-outlined">add</span>
                </div>

                <!-- Titre modale -->
                <div>
                    <h3>Modifier une intervention</h3>
                    <p>Remplissez les informations ci-dessous.</p>
                </div>

                <!-- Fermeture -->
                <div>
                    <a href="#" class="Close-Modal">X</a>
                </div>

            </div>
        </div>

        <div>

            <!-- Formulaire modification -->
            <form action="" method="post">

                <div>
                    <label>Titre</label>
                    <input type="text">
                </div>

                <div style="display: grid;grid-template-columns: 1fr 1fr;gap: 20px;">

                    <div>
                        <label>Date de début</label>
                        <input type="datetime-local">
                    </div>

                    <div>
                        <label>Date de fin</label>
                        <input type="datetime-local">
                    </div>

                </div>

                <div style="display: grid;grid-template-columns: 1fr 1fr;gap: 20px;">

                    <div>
                        <label>Module</label>
                        <select></select>
                    </div>

                    <div>
                        <label>Type d’intervention</label>
                        <select></select>
                    </div>

                </div>

                <div>
                    <label>Intervenants</label>
                    <input type="">
                </div>

                <div style="display: flex;flex-direction: row;">

                    <label>Visio</label>
                    <input type="checkbox">

                </div>

                <div class="Modal-Bottom">
                    <button>Annuler</button>
                    <button style="background-color: red;">Supprimer</button>
                    <button>Enregistrer</button>
                </div>

            </form>

        </div>

    </div>

    <!-- page -->
    <div class="Page">

        <!-- Sidebar -->
        <?php include '../require/sidebar.php'; ?>

        <div class="Main-Content">

            <!-- Fil d’Ariane -->
            <nav class="Breadcrumb">
                <ol>
                    <li><a href="corps.enseignant.php"><span class="material-symbols-outlined">home</span></a></li>
                    <li>></li>
                    <li><a href="interventions.php">Interventions</a></li>
                </ol>
            </nav>

            <div class="Main">

                <div class="Heading">
                    <h2>Interventions</h2>
                    <a href="#Modal-Ajout">Ajouter une intervention</a>
                </div>

                <div class="Content">

                    <div class="Filters">

                        <!-- Zone filtres -->
                        <p>Filtres</p>

                        <form method="post">
                            <div>
                                <label for="Name">Date de début</label>
                                <input id="Name" type="date" placeholder="Saisissez la Date de début" name="Name">
                            </div>
                            <div>
                                <label for="First-Name">Date de fin</label>
                                <input id="First-Name" type="date" placeholder="Saisissez la Date de fin"
                                    name="First-Name">
                            </div>
                            <div>
                                <label for="Email">Module</label>
                                <input id="Email" type="search" placeholder="Saisissez le Module" name="Email">
                            </div>
                            <div>
                                <label for="Submit"></label>
                                <input id="Submit" type="submit" value="Filtrer">
                            </div>
                        </form>

                    </div>

                    <div class="Table">

                        <p>Interventions</p>

                        <table>

                            <tr class="Table-Head">
                                <th>Date de l'intervention</th>
                                <th>Module & Titre</th>
                                <th>Type</th>
                                <th>Intervenants</th>
                                <th>Visio</th>
                                <th></th>
                            </tr>

                            <?php foreach ($interventions as $row): ?>

                                <tr>

                                    <td>
                                        <?= date('d/m/Y H\hi', strtotime($row['start_date'])) ?>
                                        à
                                        <?= date('H\hi', strtotime($row['end_date'])) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['title']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['intervention_type_id']) ?>
                                    </td>

                                    <td>Non défini</td>

                                    <td>

                                        <?php if ($row['remotely'] == 1): ?>
                                            <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"
                                                xml:space="preserve">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g>
                                                        <path
                                                            d="M32,5.074v21.854c0,0.189-0.107,0.365-0.279,0.449c-0.068,0.033-0.146,0.051-0.221,0.051c-0.107,0-0.216-0.033-0.307-0.104 l-7.939-6.121v3.129c0,0.277-0.225,0.5-0.5,0.5H0.5c-0.275,0-0.5-0.223-0.5-0.5V7.667c0-0.275,0.225-0.5,0.5-0.5h22.254 c0.275,0,0.5,0.225,0.5,0.5v3.899l7.918-6.872c0.146-0.128,0.354-0.158,0.537-0.078C31.885,4.7,32,4.877,32,5.074z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                        <?php else: ?>
                                            <svg fill="#000000" height="24px" width="24px" version="1.1" id="Capa_1"
                                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                viewBox="0 0 520 520" xml:space="preserve">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g>
                                                        <path
                                                            d="M505.29,157.622c-9.005-5.568-20.585-6.075-30.037-1.342L397,195.244v-42.185c0-16.862-13.256-30.136-30.118-30.136 H183.734l-68.365-80.99c-10.883-12.866-30.131-14.591-43.027-3.685C59.476,49.14,57.866,68.36,68.764,81.233l335.867,396.909 c6.038,7.134,14.641,10.797,23.318,10.797c6.962,0,13.97-2.377,19.71-7.23c12.866-10.891,14.276-30.164,3.378-43.038L397,375.045 v-19.903l78.136,38.964c4.309,2.154,9.098,3.22,13.764,3.22c5.576,0,11.435-1.528,16.34-4.562 c8.99-5.561,14.76-15.386,14.76-25.971v-183.2C520,173.007,514.28,163.183,505.29,157.622z">
                                                        </path>
                                                        <path
                                                            d="M0,153.059v244.267c0,16.862,14.138,30.597,31,30.597h260.756L29.879,122.647C13.443,123.128,0,136.499,0,153.059z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <span class="Eyes-Calen"><svg class="Eyes-Calen" width="25px" height="25px"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z"
                                                        stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path
                                                        d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z"
                                                        stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </g>
                                            </svg>Accéder à la fiche</span>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>