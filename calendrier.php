<?php
    include 'autorisation.php';
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calendrier</title>
        <link rel="stylesheet" href="css/calendrier.css" />
        <link rel="stylesheet" href="css/menu.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <section class="Page-Calen">

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




            <div class="Right-Calen">

                <section class="Top-Calen">

                    <div class="House-Calen"> <img src="images/maison.png"></div>
                    <div class="House-Calen-Text"><p>> Calendrier </p></div>

                </section>
                <hr class="Lign-Calen">

                <section class="Calen-Title">

                    <div class="Calen-Inter">
                        <p class="Calen">Calendrier</p>
                        <p class="Inter">Interventions de la semaine </p>
                    </div>

                    <form>
                        <div class="Button-Add-Inter" name="ButtonAddInter">
                        <button class="Add-Inter"> Ajouter une nouvelle intervenion</button>
                    </div>

                </section>

                <div class="Table-Calen">
                    <table>
                        <tr class="Table-Calen-Head">
                            <th>Date de l’intervention</th>
                            <th>Module & titre</th>
                            <th>Type</th>
                            <th>Intervenants</th>
                            <th>En visio</th>
                            <th></th>
                        </tr>

                        

                            <tr>

                                <td>
                                    <?= date('d/m/Y H\hi', strtotime($row['start_date'])) ?>
                                    à
                                    <?= date('H\hi', strtotime($row['end_date'])) ?>
                                </td>

                                <td>
                                    Module ID: <?= htmlspecialchars($row['module_id']) ?><br>
                                    <?= htmlspecialchars($row['title']) ?>
                                </td>

                                <td>
                                    Type ID: <?= htmlspecialchars($row['intervention_type_id']) ?>
                                </td>

                                <td>
                                    Non défini
                                </td>

                                <td>
                                    <?php if ($row['remotely'] == 1): ?>
                                        🎥
                                    <?php else: ?>
                                        ❌
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span class="Eyes-Calen">Accéder à la fiche</span>
                                </td>

                            </tr>
                       
                    </table>

                </div>

            </div>

        </section>

    </body>
</html>


