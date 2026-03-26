<?php
session_start();
require_once('../Require/Credentials.php');
require_once('../Require/Requete.php');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Interventions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>

    <main class="Page">
        <div class="Sidebar-Menu">
            <div class="Block-Patch">
                <img src="./assets/logo.png" class="Logo">

                <div class="Text">
                    <h1>Lycée Saint-Vincent</h1>
                    <p>Enseignement Supérieur</p>
                </div>
            </div>

            <div class="Block-Menu">

                <p class="Block-Title">MENU</p>

                <a href="#" class="Icones">
                    <img src="./assets/Calendar.svg" class="logo">
                    Calendrier
                </a>

                <a href="Interventions.php" class="Icones">
                    <img src="./assets/Frame.svg" class="logo">
                    Interventions
                </a>

                <a href="Corps-Enseignant.php" class="Icones">
                    <img src="./assets/Board.svg" class="logo">
                    Corps enseignant
                </a>

            </div>

            <div class="Block-Settings">

                <p class="Block-Title">PARAMÉTRAGE</p>

                <a href="#" class="Icones">
                    <img src="./assets/Vector.svg" class="logo">
                    Modules
                </a>

                <a href="types-Intervention.php" class="Icones">
                    <img src="./assets/Chart.svg" class="logo">
                    Types d'intervention
                </a>

            </div>

            <div class="Block-Profile">

                <img src="./assets/ProfilePicture.png" class="ProfilePicture">

                <div>
                    <div>
                        <span class="Username">
                            <?= $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?>
                        </span>
                        <img src="./assets/Chevron-down.svg" class="Chevron-down">
                    </div>
                    <span class="Role">
                        <?= $_SESSION['role'] ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="Main-Content">
            <div class="Breadcrumb">
                <nav>
                    <ol>
                        <li><a href=""><span class="material-symbols-outlined">home</span></a></li>
                        <li>></li>
                        <li><a href="TypesIntervention.php">Types-Intervention</a></li>
                        <li>></li>
                        <li><a href="">Cour</a></li>
                    </ol>
                </nav>
            </div>
            <div class="Main">
                <div class="Heading">
                    <h2>Cours</h2>
                </div>
                <div class="Type_intervention_Cour">
                    <form action="" method="post">
                        <div>
                            <div>
                                <label for="Type_intervention_Cour_Nom">Nom - champ obligatoire</label>
                                <input id="Type_intervention_Cour_Nom" type="text" placeholder="Cours" name="">
                            </div>
                            <div>
                                <label for="Type_intervention_Cour_Code">Code couleur (hexadécimal) - champ
                                    obligatoire</label>
                                <input id="Type_intervention_Cour_Code" type="text" placeholder="#FFFFFF" required>
                            </div>
                        </div>
                        <label for="Type_intervention_Cour_Description">Description - champ obligatoire</label>
                        <textarea id="Type_intervention_Cour_Description" type=""
                            placeholder="Cours dispensé par un ou plusieurs intervenants" required></textarea>
                        <div>
                            <button>Retour à la liste</button>
                            <button>Supprimer</button>
                            <label for="Type_intervention_Cour_Submit"><button>Enregistrer les
                                    informations</button></label>
                            <input id="Type_intervention_Cour_Submit" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>
</body>

</html>