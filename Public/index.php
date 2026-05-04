<?php
session_start();
require_once __DIR__ . '/../require/credentials.php';
require_once __DIR__ . '/../require/requete.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $typedPassword = $_POST['password'];

    // On séléctionne l'utilisateur via l'adresse e-mail
    $user = findUserByEmail($con, $email);
    if (!empty($user)) {
        if (password_verify($typedPassword, $user['password'])) {
            // On stock les informations de l'utilisateurs dans une super global 
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['role'] = $user['role'];
            header('Location: corps.enseignant.php');
            exit();
        } else {
            $error = "Problème de connexion";
        }
    } else {
        $error = "Problème de connexion";
    }

}
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Portail de connexion</title>
</head>

<body>
    <!-- Contenu principal -->
<main class="Connection-Page">

    <!-- Partie gauche -->
    <div class="Sidebar-Menu">

        <div class="Block-Patch">
            <!-- Logo -->
            <img src="assets/Logo.png" class="Logo">

            <!-- Nom établissement -->
            <div class="Text">
                <h1>Lycée Saint-Vincent</h1>
                <p>Enseignement Supérieur</p>
            </div>
        </div>
    </div>

    <!-- Zone de connexion -->
    <section class="Connection-Container">

        <!-- Titre principal -->
        <h1>
            Gestion du supérieur
        </h1>

        <!-- Sous-titre -->
        <h3>
            Connexion au portail
        </h3>

        <!-- Formulaire de connexion -->
        <form action="" method="post" class="Connection-Form">
            <!-- POST = envoi sécurisé des identifiants -->

            <!-- Champ email -->
            <label for="email">Email - champ obligatoire</label>
            <input type="email" id="email" name="email"
                placeholder="Veuillez rentrer votre adresse e-mail"
                required>

            <!-- Champ mot de passe -->
            <label for="password">Mot de passe - champ obligatoire</label>
            <input type="password" id="password" name="password"
                placeholder="Veuillez rentrer votre mot de passe"
                required>

            <!-- Bouton de connexion -->
            <button type="submit">Accèder au portail</button>
        </form>

        <!-- Affichage message d'erreur si connexion échoue -->
        <?php if (isset($error)) { ?>
            <p class="Error"><?php echo $error; ?></p>
        <?php } ?>

    </section>
</main>

</body>
</html>