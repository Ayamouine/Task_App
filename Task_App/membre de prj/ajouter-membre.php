<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['membre-email'];

    $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($utilisateur_id);
        $stmt->fetch();

        $projet_id = 1; 
        $stmt = $conn->prepare("INSERT INTO membres_projet (utilisateur_id, projet_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $utilisateur_id, $projet_id);

        if ($stmt->execute()) {
            echo "Membre ajouté avec succès.";
        } else {
            echo "Erreur : " . $stmt->error;
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }

    $stmt->close();
}

$conn->close();
?>