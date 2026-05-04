<?php
session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';

verifierConnexion();

// Variables pour le formulaire
$name = '';
$color = '';
$description = '';
$message = '';
$error = '';
$id = '';

// Si on a un ID dans l'URL, c'est une modification
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $typeData = getTypeInterventionById($con, $id);
    if ($typeData) {
        $name = $typeData['name'];
        $color = $typeData['color'];
        $description = $typeData['description'];
    }
}

// Si le formulaire est envoyé
if (isset($_POST['typeinter'])) {
    $name = trim($_POST['name']);
    $color = trim($_POST['color']);
    $description = trim($_POST['description']);

    // Si les champs sont vides, on affiche un message d'erreur
    if ($name === '' || $color === '' || $description === '') {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Si on a un ID, on modifie, sinon on crée
        if ($id !== '') {
            $saved = updateTypeIntervention($con, $id, $name, $color, $description);
            if ($saved) {
                $message = "Le type d'intervention a bien été modifié.";
            } else {
                $error = "La modification a échoué.";
            }
        } else {
            $saved = insertTypeIntervention($con, $name, $color, $description);
            if ($saved) {
                $message = "Le type d'intervention a bien été enregistré.";
                // On vide les champs après création
                $name = '';
                $color = '';
                $description = '';
            } else {
                $error = "L'enregistrement a échoué.";
            }
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

    <!-- Page principale -->
    <main class="Page">

        <!-- Inclusion de la sidebar -->
        <?php include '../require/sidebar.php'; ?>

        <!-- Contenu principal -->
        <div class="Main-Content">

            <!-- Fil d’Ariane -->
            <div class="Breadcrumb">

                <nav>
                    <ol>
                        <li><a href="corps.enseignant.php"><span class="material-symbols-outlined">home</span></a></li>
                        <li>></li>
                        <li><a href="types.intervention.php">Types-Intervention</a></li>
                        <li>></li>
                        <li><a href="types.intervention.cours.php"><?= $id !== '' ? 'Modifier' : 'Ajouter' ?></a></li>
                    </ol>
                </nav>

            </div>

            <!-- Contenu de la page -->
            <div class="Main">

                <!-- Titre -->
                <div class="Heading">
                    <h2><?= $id !== '' ? 'Modifier' : 'Ajouter' ?> un type d'intervention</h2>
                </div>

                <!-- Bloc formulaire type d’intervention -->
                <div class="Type_intervention_Cour">

                    <!-- Formulaire -->
                    <form action="" method="post">

                        <div>

                            <!-- Nom -->
                            <div>
                                <label for="Type_intervention_Cour_Nom">Nom - champ obligatoire</label>
                                <input id="Type_intervention_Cour_Nom" type="text" placeholder="Cours" name="name"
                                    value="<?= htmlspecialchars($name) ?>" required>
                            </div>

                            <!-- Couleur -->
                            <div>
                                <label for="Type_intervention_Cour_Code">Code couleur (hexadécimal) - champ
                                    obligatoire</label>
                                <input id="Type_intervention_Cour_Code" type="text" name="color" placeholder="#FFFFFF"
                                    value="<?= htmlspecialchars($color) ?>" required>
                            </div>

                        </div>

                        <!-- Description -->
                        <label for="Type_intervention_Cour_Description">Description - champ obligatoire</label>
                        <textarea id="Type_intervention_Cour_Description"
                            placeholder="Cours dispensé par un ou plusieurs intervenants" name="description"
                            required><?= htmlspecialchars($description) ?></textarea>

                        <!-- Boutons -->
                        <div>

                            <a href="types.intervention.php" class="A-button"
                                style="background-color: #F0F0F0;color: black;">
                                Retour à la liste
                            </a>

                            <?php if ($id !== '') { ?>
                                <button class=Delete-Button id="Type_intervention_Cour_Submit" name="typeinter"
                                    type="submit">
                                    Supprimer
                                </button>
                            <?php } ?>

                            <button class=Save-Button id="Type_intervention_Cour_Submit" name="typeinter" type="submit">
                                <?= $id !== '' ? 'Mettre à jour' : 'Enregistrer les informations' ?>
                            </button>

                        </div>

                    </form>
                    <div class="Save-Message">
                        <!-- Message succès -->
                        <?php if ($message !== '') { ?>
                            <p><?= htmlspecialchars($message) ?></p>
                        <?php } ?>

                        <!-- Message erreur -->
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