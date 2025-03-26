<?php
session_start();
include 'config.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérifier la connexion à la base de données
if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Erreur de connexion à la base"]);
    exit();
}

// Vérifier si la session est valide
if (!isset($_SESSION['nomprojet']) || !isset($_SESSION['nomenseignant'])) {
    echo json_encode(["status" => "error", "message" => "Session invalide"]);
    exit();
}

// Vérifier si la requête est bien une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['membre-email']) || !isset($_POST['nomdumembre'])) {
        echo json_encode(["status" => "error", "message" => "Données manquantes"]);
        exit();
    }

    $email = trim($_POST['membre-email']);
    $nom = trim($_POST['nomdumembre']);

    if (empty($email) || empty($nom)) {
        echo json_encode(["status" => "error", "message" => "Tous les champs sont obligatoires"]);
        exit();
    }

    // Vérifier si le membre existe déjà dans le projet
    $sql_check = "SELECT * FROM membreprojet WHERE etudiant = ? AND nomprojet = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $nom, $_SESSION['nomprojet']);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Ce membre existe déjà"]);
    } else {
        // Insérer le nouveau membre dans le projet
        $sql_insert = "INSERT INTO membreprojet (nomprojet, etudiant, enseignant, email) 
                       VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssss", $_SESSION['nomprojet'], $nom, $_SESSION['nomenseignant'], $email);

        if ($stmt_insert->execute()) {
            echo json_encode(["status" => "success", "message" => "Membre ajouté avec succès"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erreur SQL: " . $conn->error]);
        }
    }

    // Fermer les statements
    $stmt_check->close();
    $stmt_insert->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>
