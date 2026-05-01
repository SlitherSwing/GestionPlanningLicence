<?php

session_start();
require_once __DIR__ . '/../Require/Credentials.php';
require_once __DIR__ . '/../Require/Requete.php';

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

    $totalResultats = countTeachersByFilters($con, $nom, $prenom, $email);
    $totalPages = ceil($totalResultats / $limit);

    // On exécute la requête SQL, puis on récupère toutes les lignes dans un tableau PHP.
    $result = findTeachersByFilters($con, $nom, $prenom, $email, $limit, $offset);
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Corps Enseignant</title>
   <!-- Import de la police Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Import des icônes Google -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <div class="Page">
        <!-- Conteneur principal de la page -->

        <!-- MENU LATÉRAL -->
        <div class="Sidebar-Menu">

            <!-- Bloc logo + nom du lycée -->
            <div class="Block-Patch">
                <img src="assets/Logo.png" class="Logo">

                <div class="Text">
                    <h1>Lycée Saint-Vincent</h1>
                    <p>Enseignement Supérieur</p>
                </div>
            </div>

            <!-- MENU PRINCIPAL -->
            <div class="Block-Menu">
                <p class="Block-Title">MENU</p>

                <!-- Liens de navigation -->
                <a href="Calendrier.php" class="Icones">
                    <img src="assets/Calendar.svg" class="logo">
                    Calendrier
                </a>

                <a href="Interventions.php" class="Icones">
                    <img src="assets/Frame.svg" class="logo">
                    Interventions
                </a>

                <a href="CorpsEnseignant.php" class="Icones">
                    <img src="assets/Board.svg" class="logo">
                    Corps enseignant
                </a>
            </div>

            <!-- PARAMÈTRES -->
            <div class="Block-Settings">
                <p class="Block-Title">PARAMÉTRAGE</p>

                <a href="Modules.html" class="Icones">
                    <img src="assets/Vector.svg" class="logo">
                    Modules
                </a>

                <a href="TypesIntervention.php" class="Icones">
                    <img src="assets/Chart.svg" class="logo">
                    Types d'intervention
                </a>
            </div>

            <!-- PROFIL UTILISATEUR -->
            <div class="Block-Profile">
                <img src="assets/ProfilePicture.png" class="ProfilePicture">

                <div>
                    <div>
                        <span class="Username">
                            <!-- Affiche le prénom + nom depuis la session -->
                            <?= $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?>
                        </span>
                        <img src="assets/Chevron-down.svg" class="Chevron-down">
                    </div>
                    <span class="Role">
                        <!-- Affiche le rôle de l'utilisateur -->
                        <?= $_SESSION['role'] ?>
                    </span>
                </div>
            </div>

        </div>

        <!-- CONTENU PRINCIPAL -->
        <div class="Main-Content">

            <!-- FIL D’ARIANE (navigation) -->
            <nav class="Breadcrumb">
                <ol>
                    <li><span class="material-symbols-outlined">home</span></li>
                    <li>></li>
                    <li><a href="CorpsEnseignant.php">Corps enseignant</a></li>
                </ol>
            </nav>

            <div class="Main">

                <!-- TITRE + BOUTON -->
                <div class="Heading">
                    <h2>Corps enseignant</h2>
                    <button>Ajouter un enseignant</button>
                </div>

                <div class="Content">

                    <!-- FILTRES DE RECHERCHE -->
                    <div class="Filters">
                        <p>Filtres</p>

                        <!-- Formulaire en GET pour filtrer -->
                        <form method="get">

                            <!-- Filtre nom -->
                            <div>
                                <label for="Name">Nom de famille</label>
                                <input id="Name" type="search" name="Name"
                                    value="<?= htmlspecialchars($nom) ?>">
                            </div>

                            <!-- Filtre prénom -->
                            <div>
                                <label for="First-Name">Prénom</label>
                                <input id="First-Name" type="search" name="First-Name"
                                    value="<?= htmlspecialchars($prenom) ?>">
                            </div>

                            <!-- Filtre email -->
                            <div>
                                <label for="Email">Email</label>
                                <input id="Email" type="search" name="Email"
                                    value="<?= htmlspecialchars($email) ?>">
                            </div>

                            <!-- Bouton submit -->
                            <div>
                                <input type="submit" value="Filtrer">
                            </div>

                        </form>
                    </div>

                    <!-- TABLEAU DES ENSEIGNANTS -->
                    <div class="Table">
                        <p>Enseignants</p>

                        <table>
                            <!-- En-tête du tableau -->
                            <tr class="Table-Head">
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Modules</th>
                                <th>Heures</th>
                                <th>Lien</th>
                            </tr>

                            <!-- Vérifie s'il n'y a aucun résultat -->
                            <?php if ($result === []) { ?>
                                <tr>
                                    <td colspan="5">
                                        Aucun enseignant trouvé
                                    </td>
                                </tr>

                            <!-- Sinon on affiche les résultats -->
                            <?php } else { ?>
                                <?php foreach ($result as $resultat) { ?>
                                    <tr>

                                        <!-- htmlspecialchars = sécurité XSS -->
                                        <td><?= htmlspecialchars($resultat['last_name']) ?></td>
                                        <td><?= htmlspecialchars($resultat['first_name']) ?></td>
                                        <td><?= htmlspecialchars($resultat['name']) ?></td>
                                        <td><?= htmlspecialchars($resultat['hours_count']) ?></td>

                                        <!-- Lien vers fiche enseignant -->
                                        <td>
                                            <a href="FicheEnseignant.php?id=<?= (int) $resultat['id'] ?>">
                                                Accéder à la fiche
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
                                    <a class="Pagination-Link"
                                        href="CorpsEnseignant.php?page=<?= $page - 1 ?>&Name=<?= urlencode($nom) ?>&First-Name=<?= urlencode($prenom) ?>&Email=<?= urlencode($email) ?>">
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

                                    <a class="<?= $classePagination ?>"
                                        href="CorpsEnseignant.php?page=<?= $i ?>&Name=<?= urlencode($nom) ?>&First-Name=<?= urlencode($prenom) ?>&Email=<?= urlencode($email) ?>">
                                        <?= $i ?>
                                    </a>
                                <?php } ?>

                                <?php if ($page < $totalPages) { ?>
                                    <!-- Lien vers la page suivante -->
                                    <a class="Pagination-Link"
                                        href="CorpsEnseignant.php?page=<?= $page + 1 ?>&Name=<?= urlencode($nom) ?>&First-Name=<?= urlencode($prenom) ?>&Email=<?= urlencode($email) ?>">
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
