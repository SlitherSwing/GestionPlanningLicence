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

                        <label>Date de début</label>
                        <input type="date">

                        <label>Date de fin</label>
                        <input type="date">

                        <label>Module</label>
                        <input type="search">

                        <input type="submit" value="Filtrer">

                    </form>

                </div>

                <div class="Table">

                    <p>Interventions</p>

                    <table>

                        <tr class="Table-Head">
                            <th>Date</th>
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

                                    <!-- Icône visio -->
                                    <svg>
                                        <path
                                            d="M32,5.074v21.854c0,0.189-0.107,0.365-0.279,0.449..." />
                                    </svg>

                                <?php else: ?>

                                    <!-- Icône visio OFF -->
                                    <svg>
                                        <path
                                            d="M505.29,157.622c-9.005-5.568..." />
                                    </svg>

                                <?php endif; ?>

                            </td>

                            <td>

                                <!-- Icône œil -->
                                <span class="Eyes-Calen">

                                    <svg width="25px" height="25px">

                                        <path
                                            d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15..."></path>

                                        <path
                                            d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12..."></path>

                                    </svg>

                                    Accéder à la fiche

                                </span>

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