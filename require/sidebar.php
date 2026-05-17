<?php

if (isset($_POST['logout'])) {
    logout();
}

?>

<div class="Sidebar-Menu">
    <div class="Block-Patch">
        <img src="assets/Logo.png" class="Logo">

        <div class="Text">
            <h1>Lycée Saint-Vincent</h1>
            <p>Enseignement Supérieur</p>
        </div>
    </div>

    <div class="Block-Menu">

        <p class="Block-Title">MENU</p>

        <a href="calendrier.php" class="Icones">
            <img src="assets/Calendar.svg" class="logo">
            Calendrier
        </a>

        <a href="interventions.php" class="Icones">
            <img src="assets/Frame.svg" class="logo">
            Interventions
        </a>

        <a href="corps.enseignant.php" class="Icones">
            <img src="assets/Board.svg" class="logo">
            Corps enseignant
        </a>

    </div>

    <div class="Block-Settings">

        <p class="Block-Title">PARAMÉTRAGE</p>

        <a href="modules.php" class="Icones">
            <img src="assets/Vector.svg" class="logo">
            Modules
        </a>

        <a href="types.intervention.php" class="Icones">
            <img src="assets/Chart.svg" class="logo">
            Types d'intervention
        </a>

    </div>

    <div class="Block-Profile">

        <img src="assets/ProfilePicture.png" class="ProfilePicture">

        <div>
            <div>
                <span class="Username">
                    <?= $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?>
                </span>
                <button id="Logout-Toggle" class="Logout-Button"><img src="assets/Chevron-down.svg"
                        class="Chevron-down"></button>
            </div>

            <span class="Role">
                <?= $_SESSION['role'] ?>
            </span>
            <form id="Logout" method="POST" action="../require/Requete.php" style="display: none;">
                <input type="hidden" name="logout" value="logout">
                <button type="submit" class="Disconnect-button" style="display: block;">
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
</div>
<script src="./script.js" defer></script>