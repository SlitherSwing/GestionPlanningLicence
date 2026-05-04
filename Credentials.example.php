<?php

/* Variables de connexion */
$user = 'Nom_Utilisateur';
$password = 'Mot_De_Passe';
$dbName = 'Nom_De_La_Base_De_Données';

try {

    /* Connexion PDO à la base de données */
    $con = new \PDO("mysql:host=Adresse_IP;dbname=$dbName;charset=UTF8", $user, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    /* Gestion des erreurs de connexion */
    die("Erreur de connexion : " . $e->getMessage());

}

?>