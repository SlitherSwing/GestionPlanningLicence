<?php
    session_start();
    include('autorisation.php');

    if (!empty($_POST['NameType'])) {
        
        $nameType = $_POST['NameType'];

        $sql = "SELECT * FROM intervention_type WHERE name LIKE :nom ORDER BY name DESC";
        $stmt = $con->prepare($sql);
        
        $stmt->execute([':nom' => "%" . $nameType . "%"]);

    } else {
        
        $sql = "SELECT * FROM intervention_type ORDER BY name DESC";
        $stmt = $con->query($sql);

    }
    $typeinterventions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $count = count($typeinterventions);

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
            <div class="Breadcrumb">
                <nav>
                    <ol>
                        <li><a href=""><span class="material-symbols-outlined">home</span></a></li>
                        <li>></li>
                        <li><a href="">Types-Intervention</a></li>
                    </ol>
                </nav>
            </div>
            <div class="Main">
                <div class="Heading">
                    <h2>Types-Intervention</h2>
                    <button>Ajouter un type</button>
                </div>
                <div class="Content">
                    <div class="Filters">
                        <p>Filtres</p>
                        <div>
                            <form method="post">
                                <div class="Type-Name">
                                    <label for="NameType">Nom</label>
                                    <input id="NameType" type="text" placeholder="Saisissez le Nom" name="NameType" width="400px">
                                </div>

                                <div class="Filter-Name">
                                    <label for="Submit"></label>
                                    <input id="Submit" type="submit" value="Filtrer">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="Table">
                        <p><?= count($typeinterventions) ?> types</p>
                        <table>
                            <tr class="Table-Head">
                                <th>Nom</th>
                                <th>Descriptif</th>
                                <th>Couleur</th>
                                <th></th>
                            </tr>

                            <?php foreach ($typeinterventions as $type): ?>

                                <tr>

                                    <td>
                                        <?=  htmlspecialchars($type['name']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($type['description']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($type['color']) ?>
                                    </td>

                                    <td>
                                        <span class="Eyes-Calen"><svg class="Eyes-Calen" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>Accéder à la fiche</span>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</body>

</html>