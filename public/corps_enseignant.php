<?php

session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';

// Variables utilisées pour stocker les requêtes de l'utilisateur
$nom = '';
$prenom = '';
$email = '';
$offset = 0;
$limit = 10;

// On renvoi ici les gens non connectés
verifierConnexion();

// Si le formulaire d'ajout a été soumis, on insère le nouvel enseignant
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomAjout = trim($_POST['nom'] ?? '');
    $prenomAjout = trim($_POST['prenom'] ?? '');
    $emailAjout = trim($_POST['email'] ?? '');

    if ($nomAjout !== '' && $prenomAjout !== '') {
        insertionEnseignant($con, $nomAjout, $prenomAjout, $emailAjout);
        header('Location: corps_enseignant.php');
        exit();
    }
}

// Si le formulaire de filtre a été envoyé, on récupère les valeurs saisies
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

// On regroupe les instructeurs pour éviter les doublons quand ils ont plusieurs modules
$instructeursGroupes = [];

foreach ($result as $row) {
    $id = $row['id'];

    // Si l'instructeur n'est pas encore dans le tableau, on l'ajoute
    if (!isset($instructeursGroupes[$id])) {
        $instructeursGroupes[$id] = [
            'id' => $row['id'],
            'last_name' => $row['last_name'],
            'first_name' => $row['first_name'],
            'email' => $row['email'],
            'modules' => []  // On initialise un tableau pour stocker les modules
        ];
    }

    // Si l'instructeur a un module, on l'ajoute à sa liste
    if ($row['name'] !== null) {
        $instructeursGroupes[$id]['modules'][] = [
            'name' => $row['name'],
            'hours_count' => $row['hours_count']
        ];
    }
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Corps Enseignant</title>
    <!-- Connexrion à Google Fonts -->
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

    <!-- Modale (popup pour ajouter un enseignant) -->
    <div class="Modal-Screen" id="Modal-Ajout">

        <!-- En-tête de la modale -->
        <div>
            <div>

                <!-- Icône -->
                <div>
                    <span class="material-symbols-outlined">add</span>
                </div>

                <!-- Titre + texte -->
                <div>
                    <h3>Ajouter un enseignant</h3>
                    <p>Remplissez les informations ci-dessous.</p>
                </div>

                <!-- Bouton fermer -->
                <div>
                    <a href="#" class="Close-Modal">x</a>
                </div>

            </div>
        </div>

        <!-- Formulaire d'ajout -->
        <div>
            <form action="" method="post">
                <!-- POST = envoi des données au serveur -->

                <!-- Nom + prénom en grille -->
                <div style="display: grid;grid-template-columns: 1fr 1fr;gap: 20px;">

                    <div>
                        <label for="Ajout-Enseignant-Nom">Nom de famille - champ obligatoire</label>
                        <input id="Ajout-Enseignant-Nom" type="text" name="nom" required>
                    </div>

                    <div>
                        <label for="Ajout-Enseignant-Prenom">Prénom - champ obligatoire</label>
                        <input id="Ajout-Enseignant-Prenom" type="text" name="prenom" required>
                    </div>

                </div>

                <!-- Champ email -->
                <div>
                    <label for="Ajout-Enseignant-Email">Email</label>
                    <input id="Ajout-Enseignant-Email" type="email" name="email"
                        placeholder="Saisissez une adresse mail">
                </div>

                <!-- Boutons -->
                <div class="Modal-Bottom">
                    <!-- Annuler -->
                    <button style="background-color: #F0F0F0;color: black;">Annuler</button>
                    <!-- Envoyer le formulaire -->
                    <button>Confirmer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="Page">

        <!-- Inclusion du menu latéral -->
        <?php include '../require/sidebar.php'; ?>

        <div class="Main-Content">

            <!-- Fil d’Ariane -->
            <nav class="Breadcrumb">
                <ol>
                    <li>
                        <a href="corps_enseignant.php">
                            <span class="material-symbols-outlined">home</span>
                        </a>
                    </li>
                    <li>></li>
                    <li><a href="corps_enseignant.php">Corps enseignant</a></li>
                </ol>
            </nav>

            <div class="Main">

                <!-- Titre + bouton ouverture modale -->
                <div class="Heading">
                    <h2>Corps enseignant</h2>

                    <!-- Lien vers la modale -->
                    <button style="padding:0">
                        <a href="#Modal-Ajout">Ajouter un enseignant</a>
                    </button>
                </div>

                <div class="Content">

                    <!-- Filtres -->
                    <div class="Filters">
                        <p>Filtres</p>

                        <div>
                            <!-- Formulaire GET pour filtrer -->
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

                    <!-- Tableau de la recherche -->
                    <div class="Table">

                        <!-- Nombre d'enseignants trouvés -->
                        <p><?= count($result) ?> enseignants trouvés</p>

                        <table>

                            <!-- En-tête -->
                            <tr class="Table-Head">
                                <th>Nom de famille</th>
                                <th>Prénom</th>
                                <th>Modules enseignés</th>
                                <th>Lien</th>
                            </tr>

                            <!-- Si aucun résultat -->
                            <?php if ($result === []) { ?>
                                <tr>
                                    <td class="Table-Structure" colspan="5">
                                        Aucun enseignant ne correspond aux filtres saisis.
                                    </td>
                                </tr>

                                <!-- Sinon on affiche les résultats -->
                            <?php } else { ?>
                                <?php foreach ($instructeursGroupes as $instructeur) { ?>
                                    <tr>

                                        <!-- Sécurité : htmlspecialchars évite les injections HTML -->
                                        <td class="Table-Structure"><?= htmlspecialchars($instructeur['last_name']) ?></td>
                                        <td class="Table-Structure"><?= htmlspecialchars($instructeur['first_name']) ?></td>
                                        <td class="Table-Structure">
                                            <?php if (!empty($instructeur['modules'])): ?>
                                                <?php foreach ($instructeur['modules'] as $module): ?>
                                                    <?= htmlspecialchars($module['name']) ?> (<?= $module['hours_count'] ?>h)<br>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                        <!-- Lien vers la fiche enseignant -->
                                        <td class="Table-Structure">
                                            <a href="fiche_enseignant.php?id=<?= (int) $instructeur['id'] ?>&tab=infos">
                                                <div class="Table-Link">
                                                    <span class="material-symbols-outlined">
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
                                    <a class="Pagination-Link"
                                        href="corps_enseignant.php?page=<?= $page - 1 ?>&NameType=<?= urlencode($nameType) ?>">
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
                                        href="corps_enseignant.php?page=<?= $i ?>&NameType=<?= urlencode($nameType) ?>">
                                        <?= $i ?>
                                    </a>
                                <?php } ?>

                                <?php if ($page < $totalPages) { ?>
                                    <!-- Lien vers la page suivante -->
                                    <a class="Pagination-Link"
                                        href="corps_enseignant.php?page=<?= $page + 1 ?>&NameType=<?= urlencode($nameType) ?>">
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