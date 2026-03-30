<?php
$user = 'Nom_Utilisateur';
$password = 'Mot_De_Passe';
$dbName = 'Nom_De_La_Base_De_Données';

try {
    $con = new \PDO("mysql:host=Adresse_IP;dbname=$dbName;charset=UTF8", $user, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>