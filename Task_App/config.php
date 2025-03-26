<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "taskup";

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}
?>
