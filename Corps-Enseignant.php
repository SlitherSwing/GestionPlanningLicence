<?php
session_start();
include 'autorisation.php';

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
} else {
    $query = $con->prepare("SELECT instructor.id, user.last_name, user.first_name, user.email, module.name, module.hours_count FROM instructor INNER JOIN user ON user.id = instructor.user_id INNER JOIN instructor_module ON instructor_module.instructor_id = instructor.id INNER JOIN module ON module.id = instructor_module.module_id ");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);


}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Corps Enseignant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
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

                <a href="#" class="Icones">
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
                    <li><a href="">Corps enseignant</a></li>
                </ol>
            </nav>
            <div class="Main">
                <div class="Heading">
                    <h2>Corps enseignant</h2>
                    <button>Ajouter un enseignant</button>
                </div>
                <div class="Content">
                    <div class="Filters">
                        <p>Filtres</p>
                        <div>
                            <form method="post">
                                <div>
                                    <label for="Name">Nom de famille</label>
                                    <input id="Name" type="search" placeholder="Saisissez le nom de famille"
                                        name="Name">
                                </div>
                                <div>
                                    <label for="First-Name">Prénom</label>
                                    <input id="First-Name" type="search" placeholder="Saisissez le prénom"
                                        name="First-Name">
                                </div>
                                <div>
                                    <label for="Email">Email</label>
                                    <input id="Email" type="email" placeholder="Saisissez l'email" name="Email">
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
                                <th>Nom de famille</th>
                                <th>Prénom</th>
                                <th>Modules enseignés</th>
                                <th>Nombre d'heures</th>
                                <th>Lien</th>
                            </tr>
                            <?php foreach ($result as $resultat) { ?>
                                <tr>
                                    <td class="Table-Structure"><?= htmlspecialchars($resultat['last_name']) ?></td>
                                    <td class="Table-Structure"><?= htmlspecialchars($resultat['first_name']) ?></td>
                                    <td class="Table-Structure"><?= htmlspecialchars($resultat['name']) ?></td>
                                    <td class="Table-Structure"><?= htmlspecialchars($resultat['hours_count']) ?></td>
                                    <td class="Table-Structure"><a href="#">
                                            <div class="Table-Link"><span class="material-symbols-outlined">
                                                    visibility
                                                </span>
                                                Accèder à la fiche
                                            </div>
                                        </a>
                        </div>
                        </td>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        </nav>
    </div>
    </div>
</body>

</html>