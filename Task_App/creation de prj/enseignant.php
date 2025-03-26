<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Informations de connexion à la base de données
$host = 'localhost'; // Serveur MySQL
$dbname = 'creation du prj'; // Nom de la base de données
$user = 'root'; // Nom d'utilisateur MySQL
$password = ''; // Mot de passe MySQL

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   

    // Message de succès
    echo "<p style='color: green;'>La base de données et les tables ont été créées avec succès !</p>";
} catch (PDOException $e) {
    // Gestion des erreurs
    echo "<p style='color: red;'>Erreur lors de la création de la base de données ou des tables : " . $e->getMessage() . "</p>";
}
?>