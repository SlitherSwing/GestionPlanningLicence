<?php
session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';

verifierConnexion();

// Si les valeurs sont envoyées, on les récupère
$name = $_POST['name'] ?? '';
$color = $_POST['color'] ?? '';
$description = $_POST['description'] ?? '';
$message = '';
$error = '';

// Si les valeurs sont envoyées, on les récupère
if (isset($_POST['typeinter'])) {
    $name = trim($name);
    $color = trim($color);
    $description = trim($description);

    // Si les champs sont vides, on affiche un message d'erreur
    if ($name === '' || $color === '' || $description === '') {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $saved = insertTypeIntervention($con, $name, $color, $description);

        if ($saved) {
            $message = "Le type d'intervention a bien été enregistré.";
            $name = '';
            $color = '';
            $description = '';
        } else {
            $error = "L'enregistrement a échoué.";
        }
    }
}
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
        <?php include '../require/sidebar.php'; ?>
        <div class="Main-Content">
            <div class="Breadcrumb">
                <nav>
                    <ol>
                        <li><a href="corps.enseignant.php"><span class="material-symbols-outlined">home</span></a></li>
                        <li>></li>
                        <li><a href="types.intervention.php">Types-Intervention</a></li>
                        <li>></li>
                        <li><a href="">Cours</a></li>
                    </ol>
                </nav>
            </div>
            <div class="Main">
                <div class="Heading">
                    <h2>Cours</h2>
                </div>
                <div class="Type_intervention_Cour">
                    <?php if ($message !== '') { ?>
                        <p><?= htmlspecialchars($message) ?></p>
                    <?php } ?>
                    <?php if ($error !== '') { ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php } ?>
                    <form action="" method="post">
                        <div>
                            <div>
                                <label for="Type_intervention_Cour_Nom">Nom - champ obligatoire</label>
                                <input id="Type_intervention_Cour_Nom" type="text" placeholder="Cours" name="name"
                                    value="<?= htmlspecialchars($name) ?>" required>
                            </div>
                            <div>
                                <label for="Type_intervention_Cour_Code">Code couleur (hexadécimal) - champ
                                    obligatoire</label>
                                <input id="Type_intervention_Cour_Code" type="text" name="color" placeholder="#FFFFFF"
                                    value="<?= htmlspecialchars($color) ?>" required>
                            </div>
                        </div>
                        <label for="Type_intervention_Cour_Description">Description - champ obligatoire</label>
                        <textarea id="Type_intervention_Cour_Description" type=""
                            placeholder="Cours dispensé par un ou plusieurs intervenants" name="description"
                            required><?= htmlspecialchars($description) ?></textarea>
                        <div>
                            <a href="" class="A-button" style="background-color: #F0F0F0;color: black;">Retour à la
                                liste</a>
                            <a href="" class="A-button" style="background-color: red;">Supprimer</a>
                            <button id="Type_intervention_Cour_Submit" name="typeinter" type="submit" value="1">
                                Enregistrer les informations
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>
</body>

</html>