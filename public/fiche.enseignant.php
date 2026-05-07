<?php

session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';

verifierConnexion();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'infos';
$message = '';
$erreur = '';

if ($tab !== 'interventions') {
    $tab = 'infos';
}

if ($id <= 0) {
    header('Location: corps.enseignant.php');
    exit();
}


$enseignant = requeteEnseignant($con, $id);
if (!$enseignant) {
    header('Location: corps.enseignant.php');
    exit();
}

// Si les valeurs sont envoyées, on les récupère
if (isset($_POST['Save-Infos'])) {
    $nom = trim($_POST['Last-Name'] ?? '');
    $prenom = trim($_POST['First-Name'] ?? '');
    $email = trim($_POST['Email'] ?? '');

    // Si les champs sont vides, on affiche un message d'erreur
    if ($nom === '' || $prenom === '' || $email === '') {
        $erreur = "Tous les champs doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "L'adresse email n'est pas valide.";
    } else {
        $requeteUpdate = $con->prepare("UPDATE user
        SET last_name = :last_name, first_name = :first_name, email = :email
        WHERE id = :user_id");

        // On met à jour les informations de l'enseignant
        $requeteUpdate->execute([
            'last_name' => $nom,
            'first_name' => $prenom,
            'email' => $email,
            'user_id' => $enseignant['user_id']
        ]);

        $message = "Les informations ont bien été enregistrées.";

        $enseignant = requeteEnseignant($con, $id);
    }
}

$modules = requeteModules($con, $id);

$dateDebut = '';
$dateFin = '';
$moduleFiltre = '';

// Si les valeurs sont envoyées, on les récupère
if (isset($_POST['Filter-Interventions'])) {
    $dateDebut = trim($_POST['Start-Date'] ?? '');
    $dateFin = trim($_POST['End-Date'] ?? '');
    $moduleFiltre = trim($_POST['Module'] ?? '');
    $tab = 'interventions';
}

$interventions = requeteIntervention($con, $id, $dateDebut, $dateFin, $moduleFiltre);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Fiche Enseignant</title>
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
    <div class="Page">

        <!-- Inclusion du menu latéral -->
        <?php include '../require/sidebar.php'; ?>

        <div class="Main-Content">

            <!-- Fil d’Ariane -->
            <nav class="Breadcrumb">
                <ol>
                    <li><a href="corps.enseignant.php"><span class="material-symbols-outlined">home</span></a></li>
                    <li>></li>
                    <li><a href="corps.enseignant.php">Corps enseignant</a></li>
                    <li>></li>

                    <!-- Nom de l’enseignant affiché  -->
                    <li><?= htmlspecialchars($enseignant['first_name']) . " " . htmlspecialchars($enseignant['last_name']) ?></li>

                    <li>></li>

                    <!-- Onglet infos ou interventions -->
                    <li>
                        <?php if ($tab === 'infos') { ?>
                            Informations générales
                        <?php } else { ?>
                            Interventions
                        <?php } ?>
                    </li>
                </ol>
            </nav>

            <div class="Main">

                <!-- Titre avec nom de l’enseignant -->
                <div class="Heading">
                    <h2>
                        <?= htmlspecialchars($enseignant['first_name']) . " " . htmlspecialchars($enseignant['last_name']) ?>
                    </h2>
                </div>

                <!-- Liste des modules -->
                <div class="Module-List">
                    <h3>
                        Modules Enseignés
                    </h3>

                    <div class="Teacher-Modules-Block">

                        <!-- Si aucun module -->
                        <?php if ($modules === []) { ?>
                            <p>Aucun module renseigné.</p>

                        <!-- Sinon on affiche la liste -->
                        <?php } else { ?>
                            <ul class="Teacher-Modules-List">
                                <?php foreach ($modules as $module) { ?>
                                    <li>
                                        <?= htmlspecialchars($module['name']) . " : " . htmlspecialchars($module['hours_count']) . "h" ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>

                    </div>
                </div>

                <!-- Onglets navigation -->
                <div class="Teacher-Tabs">

                    <!-- Onglet infos -->
                    <a href="fiche.enseignant.php?id=<?= $id ?>&tab=infos"
                        class="<?php if ($tab === 'infos') { echo 'Active-Tab'; } ?>">
                        Informations générales
                    </a>

                    <!-- Onglet interventions -->
                    <a href="fiche.enseignant.php?id=<?= $id ?>&tab=interventions"
                        class="<?php if ($tab === 'interventions') { echo 'Active-Tab'; } ?>">
                        Interventions
                    </a>
                </div>

                <!-- Message de succès -->
                <?php if ($message !== '') { ?>
                    <p class="Success-Message"><?= $message ?></p>
                <?php } ?>

                <!-- Message d’erreur -->
                <?php if ($erreur !== '') { ?>
                    <p class="Error-Message"><?= $erreur ?></p>
                <?php } ?>

                <!-- Si on est sur l’onglet infos -->
                <?php if ($tab === 'infos') { ?>

                    <div class="Content">
                        <div class="Teacher-Card">
                            <p>Informations générales</p>

                            <!-- Formulaire modification -->
                            <form method="post" action="fiche.enseignant.php?id=<?= $id ?>&tab=infos" class="Teacher-Form">

                                <!-- Nom + prénom -->
                                <div class="Teacher-Form-Row">
                                    <div>
                                        <label for="Last-Name">Nom de famille - champ obligatoire</label>
                                        <input id="Last-Name" type="text" name="Last-Name"
                                            value="<?= htmlspecialchars($enseignant['last_name']) ?>" required>
                                    </div>

                                    <div>
                                        <label for="First-Name">Prénom - champ obligatoire</label>
                                        <input id="First-Name" type="text" name="First-Name"
                                            value="<?= htmlspecialchars($enseignant['first_name']) ?>" required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="Teacher-Form-Row">
                                    <div>
                                        <label for="Email">Email - champ obligatoire</label>
                                        <input id="Email" type="email" name="Email"
                                            value="<?= htmlspecialchars($enseignant['email']) ?>" required>
                                    </div>
                                </div>

                                <!-- Module -->
                                <div class="Teacher-Form-Row">
                                    <div>
                                        <label for="Modules">Modules enseignés - champ obligatoire</label>
                                        <input id="Modules" type="text" name="Modules"
                                            value="<?= htmlspecialchars($module['name']) ?>" required>
                                    </div>

                                    <!-- Bouton -->
                                    <div class="Teacher-Form-Button">
                                        <button type="submit" name="Save-Infos">Enregistrer les informations</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                <?php } else { ?>

                    <!-- Onglet interventions -->
                    <div class="Content">

                        <!-- Filtres -->
                        <div class="Filters">
                            <p>Filtres</p>

                            <div>
                                <form method="post" action="fiche.enseignant.php?id=<?= $id ?>&tab=interventions">

                                    <!-- Dates -->
                                    <div>
                                        <label for="Start-Date">Date de début</label>
                                        <input id="Start-Date" type="date" name="Start-Date"
                                            value="<?= htmlspecialchars($dateDebut) ?>">
                                    </div>

                                    <div>
                                        <label for="End-Date">Date de fin</label>
                                        <input id="End-Date" type="date" name="End-Date"
                                            value="<?= htmlspecialchars($dateFin) ?>">
                                    </div>

                                    <!-- Filtre module -->
                                    <div>
                                        <label for="Module">Module</label>
                                        <select id="Module" name="Module" class="Teacher-Select">
                                            <option value="">Tous les modules</option>

                                            <?php foreach ($modules as $module) { ?>
                                                <option value="<?= $module['id'] ?>"
                                                    <?php if ($moduleFiltre == $module['id']) { echo 'selected'; } ?>>
                                                    <?= htmlspecialchars($module['name']) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <!-- Bouton filtrer -->
                                    <div>
                                        <label for="Submit"></label>
                                        <input id="Submit" type="submit" name="Filter-Interventions" value="Filtrer">
                                    </div>

                                </form>
                            </div>
                        </div>

                        <!-- Tableau des interventions -->
                        <div class="Table">
                            <p>Interventions programmées</p>

                            <table>
                                <tr class="Table-Head">
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Module</th>
                                    <th>Titre</th>
                                    <th>Type</th>
                                    <th>En visio</th>
                                </tr>

                                <!-- Si aucun résultat -->
                                <?php if ($interventions === []) { ?>
                                    <tr>
                                        <td class="Table-Structure" colspan="6">
                                            Aucune intervention ne correspond aux filtres saisis.
                                        </td>
                                    </tr>

                                <!-- Sinon affichage -->
                                <?php } else { ?>
                                    <?php foreach ($interventions as $intervention) { ?>
                                        <tr>

                                            <!-- Dates -->
                                            <td class="Table-Structure">
                                                <?= date('d/m/Y H:i', strtotime($intervention['start_date'])) ?>
                                            </td>

                                            <td class="Table-Structure">
                                                <?= date('d/m/Y H:i', strtotime($intervention['end_date'])) ?>
                                            </td>

                                            <!-- Infos -->
                                            <td class="Table-Structure">
                                                <?= htmlspecialchars($intervention['module_name']) ?>
                                            </td>

                                            <!-- Gestion titre vide -->
                                            <td class="Table-Structure">
                                                <?php if ($intervention['title'] === null || $intervention['title'] === '') { ?>
                                                    -
                                                <?php } else { ?>
                                                    <?= htmlspecialchars($intervention['title']) ?>
                                                <?php } ?>
                                            </td>

                                            <td class="Table-Structure">
                                                <?= htmlspecialchars($intervention['type_name']) ?>
                                            </td>

                                            <!-- Visio -->
                                            <td class="Table-Structure">
                                                <?php if ($intervention['remotely'] == 1) { ?>
                                                    Oui
                                                <?php } else { ?>
                                                    Non
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>