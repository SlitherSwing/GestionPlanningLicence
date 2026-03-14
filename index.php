<!DOCTYPE html>
<html lang="fr">
<?php
include 'autorisation.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Portail de connexion</title>
</head>

<body>
    <main class="Connection-Page">
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

                <a href="#" class="Icones">
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
                    <span class="Username">Stella Ribas</span>
                    <img src="./assets/Chevron-down.svg" class="Chevron-down">
                    <span class="Role">Administrateur</span>
                </div>

            </div>

        </div>
        <section class="Connection-Container">
            <h1>
                Gestion du supérieur
            </h1>
            <h3>
                Connexion au portail
            </h3>
            <form action="" method="post" class="Connection-Form">
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