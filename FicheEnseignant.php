<?php

session_start();
include 'credentials.php';

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'infos';
$message = '';
$erreur = '';

if ($tab !== 'interventions') {
    $tab = 'infos';
}

if ($id <= 0) {
    header('Location: Corps-Enseignant.php');
    exit();
}

$requeteEnseignant = $con->prepare("SELECT instructor.id, user.id AS user_id, user.first_name, user.last_name, user.email
FROM instructor
INNER JOIN user ON user.id = instructor.user_id
WHERE instructor.id = :id");
$requeteEnseignant->execute(['id' => $id]);
$enseignant = $requeteEnseignant->fetch(PDO::FETCH_ASSOC);

if (!$enseignant) {
    header('Location: Corps-Enseignant.php');
    exit();
}

if (isset($_POST['Save-Infos'])) {
    $nom = trim($_POST['Last-Name'] ?? '');
    $prenom = trim($_POST['First-Name'] ?? '');
    $email = trim($_POST['Email'] ?? '');

    if ($nom === '' || $prenom === '' || $email === '') {
        $erreur = "Tous les champs doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "L'adresse email n'est pas valide.";
    } else {
        $requeteUpdate = $con->prepare("UPDATE user
        SET last_name = :last_name, first_name = :first_name, email = :email
        WHERE id = :user_id");

        $requeteUpdate->execute([
            'last_name' => $nom,
            'first_name' => $prenom,
            'email' => $email,
            'user_id' => $enseignant['user_id']
        ]);

        $message = "Les informations ont bien été enregistrées.";

        $requeteEnseignant->execute(['id' => $id]);
        $enseignant = $requeteEnseignant->fetch(PDO::FETCH_ASSOC);
    }
}

$requeteModules = $con->prepare("SELECT module.id, module.name, module.hours_count
FROM instructor_module
INNER JOIN module ON module.id = instructor_module.module_id
WHERE instructor_module.instructor_id = :id
ORDER BY module.name");
$requeteModules->execute(['id' => $id]);
$modules = $requeteModules->fetchAll(PDO::FETCH_ASSOC);

$dateDebut = '';
$dateFin = '';
$moduleFiltre = '';

if (isset($_POST['Filter-Interventions'])) {
    $dateDebut = trim($_POST['Start-Date'] ?? '');
    $dateFin = trim($_POST['End-Date'] ?? '');
    $moduleFiltre = trim($_POST['Module'] ?? '');
    $tab = 'interventions';
}

$sqlInterventions = "SELECT course.start_date, course.end_date, course.title,
module.name AS module_name, intervention_type.name AS type_name, course.remotely
FROM course
INNER JOIN course_instructor ON course_instructor.course_id = course.id
INNER JOIN module ON module.id = course.module_id
INNER JOIN intervention_type ON intervention_type.id = course.intervention_type_id
WHERE course_instructor.instructor_id = :id";

$parametres = ['id' => $id];

if ($dateDebut !== '') {
    $sqlInterventions .= " AND course.start_date >= :date_debut";
    $parametres['date_debut'] = $dateDebut . ' 00:00:00';
}

if ($dateFin !== '') {
    $sqlInterventions .= " AND course.end_date <= :date_fin";
    $parametres['date_fin'] = $dateFin . ' 23:59:59';
}

if ($moduleFiltre !== '') {
    $sqlInterventions .= " AND course.module_id = :module_id";
    $parametres['module_id'] = $moduleFiltre;
}

$sqlInterventions .= " ORDER BY course.start_date ASC";

$requeteInterventions = $con->prepare($sqlInterventions);
$requeteInterventions->execute($parametres);
$interventions = $requeteInterventions->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Fiche Enseignant</title>
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

                <a href="Calendrier.php" class="Icones">
                    <img src="./assets/Calendar.svg" class="logo">
                    Calendrier
                </a>

                <a href="Interventions.php" class="Icones">
                    <img src="./assets/Frame.svg" class="logo">
                    Interventions
                </a>

                <a href="CorpsEnseignant.php" class="Icones">
                    <img src="./assets/Board.svg" class="logo">
                    Corps enseignant
                </a>

            </div>

            <div class="Block-Settings">

                <p class="Block-Title">PARAMÉTRAGE</p>

                <a href="Modules.html" class="Icones">
                    <img src="./assets/Vector.svg" class="logo">
                    Modules
                </a>

                <a href="TypesIntervention.php" class="Icones">
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
                    <li><a href="Corps-Enseignant.php"><span class="material-symbols-outlined">home</span></a></li>
                    <li>></li>
                    <li><a href="Corps-Enseignant.php">Corps enseignant</a></li>
                    <li>></li>
                    <li><?= htmlspecialchars($enseignant['first_name']) . " " . htmlspecialchars($enseignant['last_name']) ?>
                    </li>
                    <li>></li>
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
                <div class="Heading">
                    <h2>
                        <?= htmlspecialchars($enseignant['first_name']) . " " . htmlspecialchars($enseignant['last_name']) ?>
                    </h2>
                </div>
                <div class="Module-List">
                    <h3>
                        Modules Enseignés
                    </h3>
                    <div class="Teacher-Modules-Block">
                        <?php if ($modules === []) { ?>
                            <p>Aucun module renseigné.</p>
                        <?php } else { ?>
                            <ul class="Teacher-Modules-List">
                                <?php foreach ($modules as $module) { ?>
                                    <li><?= htmlspecialchars($module['name']) . " : " . htmlspecialchars($module['hours_count']) . "h" ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>

                <div class="Teacher-Tabs">
                    <a href="Fiche-Enseignant.php?id=<?= $id ?>&tab=infos" class="<?php if ($tab === 'infos') {
                          echo 'Active-Tab';
                      } ?>">
                        Informations générales
                    </a>

                    <a href="Fiche-Enseignant.php?id=<?= $id ?>&tab=interventions" class="<?php if ($tab === 'interventions') {
                          echo 'Active-Tab';
                      } ?>">
                        Interventions
                    </a>
                </div>

                <?php if ($message !== '') { ?>
                    <p class="Success-Message"><?= $message ?></p>
                <?php } ?>

                <?php if ($erreur !== '') { ?>
                    <p class="Error-Message"><?= $erreur ?></p>
                <?php } ?>

                <?php if ($tab === 'infos') { ?>
                    <div class="Content">
                        <div class="Teacher-Card">
                            <p>Informations générales</p>

                            <form method="post" action="Fiche-Enseignant.php?id=<?= $id ?>&tab=infos" class="Teacher-Form">
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

                                <div class="Teacher-Form-Row">
                                    <div>
                                        <label for="Email">Email - champ obligatoire</label>
                                        <input id="Email" type="email" name="Email"
                                            value="<?= htmlspecialchars($enseignant['email']) ?>" required>
                                    </div>
                                </div>
                                <div class="Teacher-Form-Row">
                                    <div>
                                        <label for="Modules">Modules enseignés - champ obligatoire</label>
                                        <input id="Modules" type="text" name="Modules"
                                            value="<?= htmlspecialchars($module['name']) ?>" required>
                                    </div>
                                    <div class="Teacher-Form-Button">
                                        <button type="submit" name="Save-Infos">Enregistrer les informations</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="Content">
                        <div class="Filters">
                            <p>Filtres</p>
                            <div>
                                <form method="post" action="Fiche-Enseignant.php?id=<?= $id ?>&tab=interventions">
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

                                    <div>
                                        <label for="Module">Module</label>
                                        <select id="Module" name="Module" class="Teacher-Select">
                                            <option value="">Tous les modules</option>
                                            <?php foreach ($modules as $module) { ?>
                                                <option value="<?= $module['id'] ?>" <?php if ($moduleFiltre == $module['id']) {
                                                      echo 'selected';
                                                  } ?>>
                                                    <?= htmlspecialchars($module['name']) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="Submit"></label>
                                        <input id="Submit" type="submit" name="Filter-Interventions" value="Filtrer">
                                    </div>
                                </form>
                            </div>
                        </div>

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

                                <?php if ($interventions === []) { ?>
                                    <tr>
                                        <td class="Table-Structure" colspan="6">Aucune intervention ne correspond aux filtres
                                            saisis.</td>
                                    </tr>
                                <?php } else { ?>
                                    <?php foreach ($interventions as $intervention) { ?>
                                        <tr>
                                            <td class="Table-Structure">
                                                <?= date('d/m/Y H:i', strtotime($intervention['start_date'])) ?>
                                            </td>
                                            <td class="Table-Structure">
                                                <?= date('d/m/Y H:i', strtotime($intervention['end_date'])) ?>
                                            </td>
                                            <td class="Table-Structure">
                                                <?= htmlspecialchars($intervention['module_name']) ?>
                                            </td>
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