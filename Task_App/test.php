<?php
include("config.php");

$nom = "Test User";
$email = "test@example.com";

$sql = "INSERT INTO membreprojet (etudiant) VALUES ('$nom')";

if ($conn->query($sql) === TRUE) {
    echo "✅ Membre ajouté avec succès !";
} else {
    echo "❌ Erreur : " . $conn->error;
}
?>
