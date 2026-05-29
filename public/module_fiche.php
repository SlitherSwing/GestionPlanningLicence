<?php
session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';

verifierConnexion();

$code = '';
$name = '';
$heures = '';
$description = '';
$parentId = '';
$capstoneProject = 0;
$message = '';
$error = '';
$id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $moduleData = getModuleById($con, $id);
    if ($moduleData) {
        $code = $moduleData['code'];
        $name = $moduleData['name'];
        $heures = $moduleData['hours_count'] ?? '';
        $description = $moduleData['description'];
        $parentId = $moduleData['parent_id'] ?? '';
        $capstoneProject = (int) ($moduleData['capstone_project'] ?? 0);
    }
}

if (isset($_POST['supprimer']) && $id !== '') {
    $nbInterventions = countInterventionsByModule($con, (int) $id);
    if ($nbInterventions > 0) {
        $error = "Impossible de supprimer : " . $nbInterventions . " intervention(s) liée(s) à ce module.";
    } else {
        $deleted = deleteModule($con, (int) $id);
        if ($deleted) {
            header('Location: modules.php');
            exit();
        } else {
            $error = "La suppression a échoué.";
        }
    }
}

if (isset($_POST['enregistrer'])) {
    $code = trim($_POST['code']);
    $name = trim($_POST['name']);
    $heures = trim($_POST['heures']);
    $description = trim($_POST['description']);
    $parentId = trim($_POST['parent_id'] ?? '');
    $parentIdInt = $parentId !== '' ? (int) $parentId : null;
    $capstoneProject = isset($_POST['capstone_project']) ? 1 : 0;

    if ($code === '' || $name === '' || $description === '') {
        $error = "Les champs Code, Nom et Description sont obligatoires.";
    } elseif ($heures !== '' && !ctype_digit($heures)) {
        $error = "Le nombre d'heures doit être un nombre entier.";
    } else {
        $heuresInt = $heures === '' ? 0 : (int) $heures;

        if ($id !== '') {
            $saved = updateModule($con, (int) $id, $code, $name, $heuresInt, $description, $parentIdInt, $capstoneProject);
            if ($saved) {
                $message = "Le module a bien été modifié.";
            } else {
                $error = "La modification a échoué.";
            }
        } else {
            ajouterModule($con, $code, $name, $heuresInt, $description, $parentIdInt, $capstoneProject);
            $message = "Le module a bien été enregistré.";
            $code = '';
            $name = '';
            $heures = '';
            $description = '';
        }
    }
}

$modules = moduleData($con);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Module</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>

    <?php if (isset($_POST['confirmer_suppression']) && $id !== ''): ?>
        <div class="Delete-Draw">
            <div class="Delete-Modal">
                <div class="Delete-Header">
                    <div class="Delete-Icon">
                        <span class="material-symbols-outlined" style="color:red;font-size:40px;">delete</span>
                    </div>
                    <div class="Delete-Title">
                        <h3>Supprimer le module</h3>
                        <p>Confirmation de l'action</p>
                    </div>
                    <div class="Delete-Close">
                        <a href="module_fiche.php?id=<?= $id ?>"
                            style="text-decoration:none;color:inherit;font-size:20px;">X</a>
                    </div>
                </div>
                <div class="Delete-Content">
                    <p>
                        Vous vous apprêtez à supprimer le module <strong><?= htmlspecialchars($name) ?></strong>.<br>
                        Cette action est irrévocable.<br>
                        Aucune intervention ne doit être liée à ce module pour pouvoir le supprimer.
                    </p>
                    <p class="Delete-Question">Confirmez-vous l'action ?</p>
                </div>
                <div class="Delete-Actions">
                    <a href="module_fiche.php?id=<?= $id ?>" class="A-button"
                        style="background-color:#F0F0F0;color:black;">Annuler</a>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="supprimer" value="1">
                        <button type="submit" class="Delete-Button">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <main class="Page">

        <?php include '../require/sidebar.php'; ?>

        <div class="Main-Content">

            <div class="Breadcrumb">
                <nav>
                    <ol>
                        <li><a href="corps_enseignant.php"><span class="material-symbols-outlined">home</span></a></li>
                        <li>></li>
                        <li><a href="modules.php">Modules</a></li>
                        <li>></li>
                        <li><a href="module_fiche.php"><?= $id !== '' ? 'Modifier' : 'Ajouter' ?></a></li>
                    </ol>
                </nav>
            </div>

            <div class="Main">

                <div class="Heading">
                    <h2><?= $id !== '' ? 'Modifier' : 'Ajouter' ?> un module</h2>
                </div>

                <div class="Type_intervention_Cour">

                    <form action="" method="post">

                        <div>
                            <div>
                                <label for="Module_Code">Code - champ obligatoire</label>
                                <input id="Module_Code" type="text" name="code" placeholder="WEB101"
                                    value="<?= htmlspecialchars($code) ?>" required>
                            </div>

                            <div>
                                <label for="Module_Nom">Nom - champ obligatoire</label>
                                <input id="Module_Nom" type="text" name="name" placeholder="Développement Web"
                                    value="<?= htmlspecialchars($name) ?>" required>
                            </div>
                        </div>

                        <div>
                            <div>
                                <label for="Module_Heures">Nombre d'heures (entier, facultatif)</label>
                                <input id="Module_Heures" type="text" name="heures" placeholder="30"
                                    value="<?= htmlspecialchars($heures) ?>">
                            </div>

                            <div>
                                <label for="Module_Parent">Module parent (facultatif)</label>
                                <select id="Module_Parent" name="parent_id">
                                    <option value="">-- Aucun --</option>
                                    <?php foreach ($modules as $mod): ?>
                                        <?php if ($id !== '' && $mod['id'] == $id)
                                            continue; ?>
                                        <option value="<?= $mod['id'] ?>"<?= $parentId !== '' && $mod['id'] == $parentId ? ' selected' : '' ?>>
                                            <?= htmlspecialchars($mod['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <label for="Module_Description">Description - champ obligatoire</label>
                        <textarea id="Module_Description" placeholder="Description du module et de ses objectifs"
                            name="description" required><?= htmlspecialchars($description) ?></textarea>

                        <div>
                            <label for="Module_Capstone">Projet de fin d'études (capstone)</label>
                            <input type="checkbox" id="Module_Capstone" name="capstone_project" value="1"<?= $capstoneProject ? ' checked' : '' ?>>
                        </div>

                        <div>
                            <a href="modules.php" class="A-button" style="background-color: #F0F0F0;color: black;">
                                Retour à la liste
                            </a>

                            <?php if ($id !== '') { ?>
                                <button type="submit" name="confirmer_suppression" class="Delete-Button">
                                    Supprimer
                                </button>
                            <?php } ?>

                            <button class="Save-Button" name="enregistrer" type="submit">
                                <?= $id !== '' ? 'Mettre à jour' : 'Enregistrer les informations' ?>
                            </button>
                        </div>

                    </form>

                    <div class="Save-Message">
                        <?php if ($message !== '') { ?>
                            <p><?= htmlspecialchars($message) ?></p>
                        <?php } ?>
                        <?php if ($error !== '') { ?>
                            <p><?= htmlspecialchars($error) ?></p>
                        <?php } ?>
                    </div>
                </div>

            </div>

        </div>

    </main>

</body>

</html>