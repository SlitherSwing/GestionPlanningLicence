<?php
session_start();
include 'autorisation.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $typedPassword = $_POST['password'];

    $query = $con->prepare("SELECT * FROM user WHERE email = :email");
    $query->bindParam(':email', $email);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);
    if ($user['email'] == $email && password_verify($typedPassword, $user['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['role'] = $user['role'];
        header('Location: Corps-Enseignant.html');
        exit();
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
            <?php if (isset($error)) { ?>
                <p class="Error"><?php echo $error; ?></p>
            <?php } ?>
        </section>
    </main>
</body>

</html>