<?php
session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';

verifierConnexion();

$interventions = calendarData($con);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier</title>
<!-- Lien vers le fichier CSS principal -->
<link rel="stylesheet" href="style.css" />

<!-- Connexion à Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Import de la police Poppins -->
<link
     href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- Import des icônes Google -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>

    <!-- Contenu principal -->
    <section class="Page">

        <!-- Inclusion du menu (évite de dupliquer le code) -->
        <?php include '../require/sidebar.php'; ?>

        <div class="Main-Content">

            <!-- Fil d’Ariane -->
            <nav class="Breadcrumb">
                <ol>
                    <li>
                        <a href="corps.enseignant.php">
                            <span class="material-symbols-outlined">home</span>
                        </a>
                    </li>
                    <li>></li>
                    <li><a href="calendrier.php">Calendrier</a></li>
                </ol>
            </nav>

            <div class="Main">

                <!-- En-tête de la page -->
                <section class="Heading">

                    <div class="Header-Calendar">
                        <h2>Calendrier</h2>
                        <p>Interventions de la semaine</p>
                    </div>

                    <!-- Bouton ajouter une intervention -->
                    <form>
                        <div class="Button-Add-Inter">
                            <button class="Add-Inter">
                                Ajouter une nouvelle intervention
                            </button>
                        </div>
                    </form>

                </section>

                <!-- Tableau des interventions -->
                <div class="Table">
                    <table>

                        <!-- En-tête -->
                        <tr class="Table-Head">
                            <th>Date</th>
                            <th>Module & titre</th>
                            <th>Type</th>
                            <th>Intervenants</th>
                            <th>Visio</th>
                            <th></th>
                        </tr>

                        <!-- Boucle PHP pour afficher les interventions -->
                        <?php foreach ($interventions as $row): ?>

                            <tr>

                                <!-- Date début + fin -->
                                <td>
                                    <?= date('d/m/Y H\hi', strtotime($row['start_date'])) ?>
                                    à
                                    <?= date('H\hi', strtotime($row['end_date'])) ?>
                                </td>

                                <!-- Infos module -->
                                <td>
                                    Module ID: <?= htmlspecialchars($row['module_id']) ?><br>
                                    <?= htmlspecialchars($row['title']) ?>
                                </td>

                                <!-- Type intervention -->
                                <td>
                                    Type ID: <?= htmlspecialchars($row['intervention_type_id']) ?>
                                </td>

                                <!-- Intervenants -->
                                <td>
                                    Non défini
                                </td>

                                <!-- Si intervention en visio ou non -->
                                <td>
                                    <?php if ($row['remotely'] == 1): ?>
                                        <!-- Icône visio -->
                                        <svg>...</svg>
                                    <?php else: ?>
                                        <!-- Icône présentiel -->
                                        <svg>...</svg>
                                    <?php endif; ?>
                                </td>

                                <!-- Lien vers la fiche -->
                                <td>
                                    <span class="Eyes-Calen">
                                        <svg>...</svg>
                                        Accéder à la fiche
                                    </span>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </table>
                </div>

            </div>

    </section>

</body>

</html>