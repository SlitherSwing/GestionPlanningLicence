<?php
session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';

verifierConnexion();


$typeinterventions = filtreTypeIntervention($con, $_GET['NameType'] ?? '');

$count = count($typeinterventions);

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Interventions</title>
   <!-- Imports Google Fonts -->
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

<!-- Page principale -->
<main class="Page">

    <!-- Inclusion sidebar -->
    <?php include '../require/sidebar.php'; ?>

    <div class="Main-Content">

        <!-- Fil d’Ariane -->
        <div class="Breadcrumb">
            <nav>
                <ol>
                    <li><a href="corps.enseignant.php"><span class="material-symbols-outlined">home</span></a></li>
                    <li>></li>
                    <li><a href="types.intervention.php">Types-Intervention</a></li>
                </ol>
            </nav>
        </div>

        <div class="Main">

            <!-- Titre page -->
            <div class="Heading">
                <h2>Types-Intervention</h2>
                <a href="types.intervention.cours.php">Ajouter un type</a>
            </div>

            <!-- Contenu principal -->
            <div class="Content">

                <!-- Filtres -->
                <div class="Filters">
                    <p>Filtres</p>
                    <div>
                        <form method="get">

                            <div class="Type-Name">
                                <label for="NameType">Nom</label>
                                <input id="NameType" type="text" placeholder="Saisissez le Nom" name="NameType"
                                    width="400px">
                            </div>

                            <div class="Filter-Name">
                                <label for="Submit"></label>
                                <input id="Submit" type="submit" value="Filtrer">
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Tableau -->
                <div class="Table">

                    <p><?= count($typeinterventions) ?> types</p>

                    <table>

                        <!-- En-tête tableau -->
                        <tr class="Table-Head">
                            <th>Nom</th>
                            <th>Descriptif</th>
                            <th>Couleur</th>
                            <th></th>
                        </tr>

                        <!-- Liste types -->
                        <?php foreach ($typeinterventions as $type): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($type['name']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($type['description']) ?>
                                </td>

                                <td style="color: <?= $type['color'] ?>">
                                    <?= htmlspecialchars($type['color']) ?>
                                </td>

                                <td>
                                    <a href=" types.intervention.cours.php?id=<?= $type['id'] ?>">
                                        <span class="Eyes-Calen" style="display: flex;align-items: center;">
                                            <svg class="Eyes-Calen" width="25px" height="25px" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">

                                                <!-- SVG icon -->
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
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
                                            </svg>
                                            Accéder à la fiche
                                        </span>
                                    </a>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

</body>

</html>