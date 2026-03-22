<?php
    session_start();
    include 'autorisation.php';
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"/>
</head>
<body>
    <div class="Modal-Screen" id="Modal-Ajout">
        <div>
            <div>
                <div>
                    <span class="material-symbols-outlined">add</span>
                </div>
                <div>
                    <h3>Ajouter une intervention</h3>
                    <p>Remplissez les informations ci-dessous.</p>
                </div>
                <div>
                    <a href="#" class="Close-Modal">X</a>
                </div>
            </div>
        </div>
        <div>
            <form action="" method="post">
                <div>
                    <label for="Ajout-intervention-Titre">Titre</label>
                    <input id="Ajout-intervention-Titre" type="text" placeholder="Saisissez un titre sur l’intervention">
                </div>
                <div style="display: grid;grid-template-columns: 1fr 1fr;gap: 20px;">
                    <div>
                        <label for="Ajout-intervention-Date-Début">Date de début - champ obligatoire</label>
                        <input id="Ajout-intervention-Date-Début" type="datetime-local">
                    </div>
                    <div>
                        <label for="Ajout-intervention-Date-Fin">Date de fin - champ obligatoire</label>
                        <input id="Ajout-intervention-Date-Fin" type="datetime-local">
                    </div>
                </div>
                <div style="display: grid;grid-template-columns: 1fr 1fr;gap: 20px;">
                    <div>
                        <label for="Ajout-intervention-Module">Module - champ obligatoire</label>
                        <select name="" id="Ajout-intervention-Module"></select>
                    </div>
                    <div>
                        <label for="Ajout-intervention-Type">Type d’intervention - champ obligatoire</label>
                        <select name="Ajout-intervention-Type" id=""></select>
                    </div>                   
                </div>
                <div>
                    <label for="Ajout-intervention-Type">Intervenants - champ obligatoire</label>
                    <input id="Ajout-intervention-Type" type="" placeholder="?">
                </div>
                <div style="display: flex;flex-direction: row;">
                    <label for="Ajout-intervention-check"></label>
                    <label for="Ajout-intervention-check">Intervention effectuée en visio</label>
                    <input id="Ajout-intervention-check" type="checkbox">
                </div>
                <div class="Modal-Bottom">
                    <button style="background-color: #F0F0F0;color: black;">Annuler</button>
                    <button>Confirmer</button>
                </div>
            </form>
        </div>
        <div>

        </div>
    </div>
    <div class="Modal-Screen" id="Modal-Modif">
        <div>
            <div>
                <div>
                    <span class="material-symbols-outlined">add</span>
                </div>
                <div>
                    <h3>Modifier une intervention</h3>
                    <p>Remplissez les informations ci-dessous.</p>
                </div>
                <div>
                    <a href="#" class="Close-Modal">X</a>
                </div>
            </div>
        </div>
        <div>
            <form action="" method="post">
                <div>
                    <label for="Ajout-intervention-Titre">Titre</label>
                    <input id="Ajout-intervention-Titre" type="text" placeholder="Saisissez un titre sur l’intervention">
                </div>
                <div style="display: grid;grid-template-columns: 1fr 1fr;gap: 20px;">
                    <div>
                        <label for="Ajout-intervention-Date-Début">Date de début - champ obligatoire</label>
                        <input id="Ajout-intervention-Date-Début" type="datetime-local">
                    </div>
                    <div>
                        <label for="Ajout-intervention-Date-Fin">Date de fin - champ obligatoire</label>
                        <input id="Ajout-intervention-Date-Fin" type="datetime-local">
                    </div>
                </div>
                <div style="display: grid;grid-template-columns: 1fr 1fr;gap: 20px;">
                    <div>
                        <label for="Ajout-intervention-Module">Module - champ obligatoire</label>
                        <select name="" id="Ajout-intervention-Module"></select>
                    </div>
                    <div>
                        <label for="Ajout-intervention-Type">Type d’intervention - champ obligatoire</label>
                        <select name="Ajout-intervention-Type" id=""></select>
                    </div>                   
                </div>
                <div>
                    <label for="Ajout-intervention-Type">Intervenants - champ obligatoire</label>
                    <input id="Ajout-intervention-Type" type="" placeholder="?">
                </div>
                <div style="display: flex;flex-direction: row;">
                    <label for="Ajout-intervention-check"></label>
                    <label for="Ajout-intervention-check">Intervention effectuée en visio</label>
                    <input id="Ajout-intervention-check" type="checkbox">
                </div>
                <div class="Modal-Bottom">
                    <button style="background-color: #F0F0F0;color: black;">Annuler</button>
                    <button style="background-color: red;">suprimer</button>
                    <button>Enregistrer les informations</button>
                </div>
            </form>
        </div>
        <div>

        </div>
    </div>
    <div class="Page">

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

                <a href="#" class="Icones">
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

                <a href="#" class="Icones">
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
            <nav class="Breadcrumb">
                <ol>
                    <li><a href=""><span class="material-symbols-outlined">home</span></a></li>
                    <li>></li>
                    <li><a href="">Interventions</a></li>
                </ol>
            </nav>
            <div class="Main">
                <div class="Heading">
                    <h2>Interventions</h2>
                    <a href="#Modal-Ajout">Ajouter une nouvelle intervention</a>
                </div>
                <div class="Content">
                    <div class="Filters">
                        <p>Filtres</p>
                        <div>
                            <form method="post">
                                <div>
                                    <label for="Name">Date de début</label>
                                    <input id="Name" type="date" placeholder="Saisissez la Date de début" name="Name">
                                </div>
                                <div>
                                    <label for="First-Name">Date de fin</label>
                                    <input id="First-Name" type="date" placeholder="Saisissez la Date de fin" name="First-Name">
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
                    </div>
                    <div class="Table">
                        <p>Template</p>
                        <table>
                            <tr class="Table-Head">
                                <th>Date de l’intervention</th>
                                <th>Module & titre</th>
                                <th>Type</th>
                                <th>Intervenants</th>
                                <th>En visio</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>Template</th>
                                <th>Template</th>
                                <th>Template</th>
                                <th><span class="material-symbols-outlined">videocam</span>Template</th>
                                <th><a href="#Modal-Modif"><span class="material-symbols-outlined">visibility</span>Template</a></th>
                            </tr>
                            <tr>
                                <th>Template</th>
                                <th>Template</th>
                                <th>Template</th>
                                <th><span class="material-symbols-outlined">videocam</span>Template</th>
                                <th><a href="#Modal-Modif"><span class="material-symbols-outlined">visibility</span>Template</a></th>
                            </tr>
                            <tr>
                                <th>Template</th>
                                <th>Template</th>
                                <th>Template</th>
                                <th><span class="material-symbols-outlined">videocam</span>Template</th>
                                <th><a href="#Modal-Modif"><span class="material-symbols-outlined">visibility</span>Template</a></th>
                            </tr>
                            <tr>
                                <th>Template</th>
                                <th>Template</th>
                                <th>Template</th>
                                <th><span class="material-symbols-outlined">videocam</span>Template</th>
                                <th><a href="#Modal-Modif"><span class="material-symbols-outlined">visibility</span>Template</a></th>
                            </tr>
                            <tr></tr>
                        </table>
                    </div>
                </div>
            </div>
        </nav>
</body>
</html>