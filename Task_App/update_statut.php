<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["nomdutilisateur"]) || !isset($_POST["nomprojet"]) || !isset($_POST["nomtache"]) || !isset($_POST["statut"])) {
        echo json_encode(["status" => "error", "message" => "Données manquantes"]);
        exit();
    }

    $nomMembre = $conn->real_escape_string($_SESSION["nomdutilisateur"]);
    $nomProjet = $conn->real_escape_string($_POST["nomprojet"]);
    $nomTache = $conn->real_escape_string($_POST["nomtache"]);
    $nouveauStatut = $conn->real_escape_string($_POST["statut"]);

    // Vérifier si la tâche existe pour cet utilisateur et ce projet
    $sql_check = "SELECT * FROM taches WHERE nommembre = '$nomMembre' AND nomprojet = '$nomProjet' AND nomtache = '$nomTache'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Mettre à jour le statut
        $sql = "UPDATE taches SET statut = '$nouveauStatut' WHERE nommembre = '$nomMembre' AND nomprojet = '$nomProjet' AND nomtache = '$nomTache'";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Statut mis à jour"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erreur SQL: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Tâche non trouvée"]);
    }
}

$conn->close();
?>
