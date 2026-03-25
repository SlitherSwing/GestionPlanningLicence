<?php
    include 'autorisation.php';

    $sql = "SELECT * FROM course ORDER BY start_date DESC";
    $stmt = $con->query($sql);
    $interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calendrier</title>
        <link rel="stylesheet" href="css/calendrier.css" />
        <link rel="stylesheet" href="style.css" />
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

                <a href="Interventions.php" class="Icones">
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

                        <?php foreach ($interventions as $row): ?>

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
                                        <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M32,5.074v21.854c0,0.189-0.107,0.365-0.279,0.449c-0.068,0.033-0.146,0.051-0.221,0.051c-0.107,0-0.216-0.033-0.307-0.104 l-7.939-6.121v3.129c0,0.277-0.225,0.5-0.5,0.5H0.5c-0.275,0-0.5-0.223-0.5-0.5V7.667c0-0.275,0.225-0.5,0.5-0.5h22.254 c0.275,0,0.5,0.225,0.5,0.5v3.899l7.918-6.872c0.146-0.128,0.354-0.158,0.537-0.078C31.885,4.7,32,4.877,32,5.074z"></path> </g> </g></svg>
                                    <?php else: ?>
                                        <svg fill="#000000" height="24px" width="24px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 520 520" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M505.29,157.622c-9.005-5.568-20.585-6.075-30.037-1.342L397,195.244v-42.185c0-16.862-13.256-30.136-30.118-30.136 H183.734l-68.365-80.99c-10.883-12.866-30.131-14.591-43.027-3.685C59.476,49.14,57.866,68.36,68.764,81.233l335.867,396.909 c6.038,7.134,14.641,10.797,23.318,10.797c6.962,0,13.97-2.377,19.71-7.23c12.866-10.891,14.276-30.164,3.378-43.038L397,375.045 v-19.903l78.136,38.964c4.309,2.154,9.098,3.22,13.764,3.22c5.576,0,11.435-1.528,16.34-4.562 c8.99-5.561,14.76-15.386,14.76-25.971v-183.2C520,173.007,514.28,163.183,505.29,157.622z"></path> <path d="M0,153.059v244.267c0,16.862,14.138,30.597,31,30.597h260.756L29.879,122.647C13.443,123.128,0,136.499,0,153.059z"></path> </g> </g></svg>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span class="Eyes-Calen"><svg class="Eyes-Calen" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>Accéder à la fiche</span>
                                </td>

                            </tr>

                        <?php endforeach; ?>
                       
                    </table>

                </div>

            </div>

        </section>

    </body>
</html>


