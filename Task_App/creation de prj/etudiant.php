<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Informations de connexion à la base de données
$host = 'localhost'; // Serveur MySQL
$dbname = 'gestion_ecole'; // Nom de la base de données
$user = 'root'; // Nom d'utilisateur MySQL
$password = ''; // Mot de passe MySQL

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Créer la base de données si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    

    // Créer la table `etudiant`
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS etudiant (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(50) NOT NULL,
            prenom VARCHAR(50) NOT NULL,
            code_apogee VARCHAR(20) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE
        )
    ");

    // Message de succès
    echo "<p style='color: green;'>La base de données et les tables ont été créées avec succès !</p>";
} catch (PDOException $e) {
    // Gestion des erreurs
    echo "<p style='color: red;'>Erreur lors de la création de la base de données ou des tables : " . $e->getMessage() . "</p>";
}
?>