<?php

session_start();
include 'autorisation.php';

// Variables utilisées pour stocker les requêtes de l'utilisateur
$nom = '';
$prenom = '';
$email = '';
$offset = 0;
$limit = 10;

// On renvoi ici les gens non connectés
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
} else {
    // Si le formulaire a été envoyé, on récupère les valeurs saisies
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $nom = trim($_GET['Name'] ?? '');
        $prenom = trim($_GET['First-Name'] ?? '');
        $email = trim($_GET['Email'] ?? '');
    }

    // Si la superglobale $_GET["page"] existe, on récupère la valeur de la page, sinon on lui assigne la valeur 1
    if (isset($_GET["page"])) {
        $page = (int) $_GET["page"];
    } else {
        $page = 1;
    }

    // Si la page est inférieure à 1, on lui assigne la valeur 1
    if ($page < 1) {
        $page = 1;
    }

    // On calcule les éléments à afficher sur la page
    $offset = ($page - 1) * $limit;

    // Requête de base, on va chercher les enseignants avec leurs informations, modules etc. 
    $sqlBase = " FROM instructor
            INNER JOIN user ON user.id = instructor.user_id
            INNER JOIN instructor_module ON instructor_module.instructor_id = instructor.id
            INNER JOIN module ON module.id = instructor_module.module_id
            WHERE 1=1";

    // Si un nom a été saisi, on ajoute un filtre sur le nom
    if ($nom !== '') {
        $sqlBase = $sqlBase . " AND user.last_name = '$nom'";
    }

    // Si un prénom a été saisi, on ajoute un filtre sur le prénom
    if ($prenom !== '') {
        $sqlBase = $sqlBase . " AND user.first_name = '$prenom'";
    }

    // Si un email a été saisi, on ajoute un filtre sur l'email
    if ($email !== '') {
        $sqlBase = $sqlBase . " AND user.email = '$email'";
    }

    $sqlCount = "SELECT COUNT(*)" . $sqlBase;
    $totalResultats = $con->query($sqlCount)->fetchColumn();
    $totalPages = ceil($totalResultats / $limit);

    $sql = "SELECT instructor.id, user.last_name, user.first_name, user.email, module.name, module.hours_count"
        . $sqlBase
        . " ORDER BY user.last_name ASC
            LIMIT $limit OFFSET $offset";

    // On exécute la requête SQL, puis on récupère toutes les lignes dans un tableau PHP.
    $result = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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
                            <form method="get">
                                <div>
                                    <label for="Name">Nom de famille</label>
                                    <input id="Name" type="search" placeholder="Saisissez le nom de famille" name="Name"
                                        value="<?= htmlspecialchars($nom) ?>">
                                </div>
                                <div>
                                    <label for="First-Name">Prénom</label>
                                    <input id="First-Name" type="search" placeholder="Saisissez le prénom"
                                        name="First-Name" value="<?= htmlspecialchars($prenom) ?>">
                                </div>
                                <div>
                                    <label for="Email">Email</label>
                                    <input id="Email" type="search" placeholder="Saisissez l'email" name="Email"
                                        value="<?= htmlspecialchars($email) ?>">
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
                            <?php if ($result === []) { ?>
                                <tr>
                                    <td class="Table-Structure" colspan="5">Aucun enseignant ne correspond aux filtres
                                        saisis.</td>
                                </tr>
                            <?php } else { ?>
                                <?php foreach ($result as $resultat) { ?>
                                    <tr>
                                        <td class="Table-Structure"><?= htmlspecialchars($resultat['last_name']) ?></td>
                                        <td class="Table-Structure"><?= htmlspecialchars($resultat['first_name']) ?></td>
                                        <td class="Table-Structure"><?= htmlspecialchars($resultat['name']) ?></td>
                                        <td class="Table-Structure"><?= htmlspecialchars($resultat['hours_count']) ?></td>
                                        <td class="Table-Structure"><a
                                                href="Fiche-Enseignant.php?id=<?= (int) $resultat['id'] ?>&tab=infos">
                                                <div class="Table-Link"><span class="material-symbols-outlined">
                                                        visibility
                                                    </span>
                                                    Accèder à la fiche
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </table>
                        <?php if ($totalPages > 1) { ?>
                            <!-- On affiche la pagination seulement s'il y a plusieurs pages -->
                            <div class="Pagination">

                                <?php if ($page > 1) { ?>
                                    <!-- Lien vers la page précédente -->
                                    <a
                                        class="Pagination-Link"
                                        href="Corps-Enseignant.php?page=<?= $page - 1 ?>&Name=<?= urlencode($nom) ?>&First-Name=<?= urlencode($prenom) ?>&Email=<?= urlencode($email) ?>">
                                        Précédent
                                    </a>
                                <?php } ?>

                                <!-- Boucle pour afficher tous les numéros de page -->
                                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                    <?php
                                    $classePagination = 'Pagination-Link';

                                    if ($i == $page) {
                                        $classePagination = 'Pagination-Link Pagination-Active';
                                    }
                                    ?>

                                    <a
                                        class="<?= $classePagination ?>"
                                        href="Corps-Enseignant.php?page=<?= $i ?>&Name=<?= urlencode($nom) ?>&First-Name=<?= urlencode($prenom) ?>&Email=<?= urlencode($email) ?>">
                                        <?= $i ?>
                                    </a>
                                <?php } ?>

                                <?php if ($page < $totalPages) { ?>
                                    <!-- Lien vers la page suivante -->
                                    <a
                                        class="Pagination-Link"
                                        href="Corps-Enseignant.php?page=<?= $page + 1 ?>&Name=<?= urlencode($nom) ?>&First-Name=<?= urlencode($prenom) ?>&Email=<?= urlencode($email) ?>">
                                        Suivant
                                    </a>
                                <?php } ?>

                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
