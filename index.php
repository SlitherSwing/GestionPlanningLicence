<!DOCTYPE html>
<html lang="fr">
<?php
include 'localhost';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Portail de connexion</title>
</head>

<body>
    <main class="connection-page">
        <aside class="banner">
            <div class="logo-container">
                <img src="./assets/logo.png" class="school-logo" alt="Logo du lycée Saint-Vincent">
                <div class="school-name-container">
                    <p>Lycée Saint-Vincent</p>
                    <p>Enseignement Supérieur</p>
                </div>
            </div>
        </aside>
        <section class="connection-container">
            <h1>
                Gestion du supérieur
            </h1>
            <h3>
                Connexion au portail
            </h3>
            <form class="connection-form">
                <label for="email">Email - champ obligatoire</label>
                <input type="email" id="email" name="email" placeholder="Veuillez rentrer votre adresse e-mail"
                    required>
                <label for="password">Mot de passe - champ obligatoire</label>
                <input type="password" id="password" name="password" placeholder="Veuillez rentrer votre mot de passe"
                    required>
                <button type="submit">Accèder au portail</button>
            </form>
        </section>
    </main>
</body>

</html>