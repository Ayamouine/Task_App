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

// Vérifier la méthode HTTP
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier que tous les champs sont remplis
    if (empty($_POST["nom-membre"]) || empty($_POST["nom-tache"]) || empty($_POST["description-tache"]) || empty($_POST["statut-tache"])) {
        echo json_encode(["status" => "error", "message" => "Veuillez remplir tous les champs."]);
        exit();
    }

    // Sécuriser les entrées
    $nomMembre = $conn->real_escape_string(trim($_POST["nom-membre"]));
    $nomTache = $conn->real_escape_string(trim($_POST["nom-tache"]));
    $descriptionTache = $conn->real_escape_string(trim($_POST["description-tache"]));
    $statut = $conn->real_escape_string(trim($_POST["statut-tache"]));

    // Vérifier la longueur des champs
    if (strlen($nomMembre) > 100 || strlen($nomTache) > 100 || strlen($descriptionTache) > 255 || strlen($statut) > 50) {
        echo json_encode(["status" => "error", "message" => "Les champs sont trop longs."]);
        exit();
    }

    $sql_check1 ="SELECT * FROM membreprojet WHERE nomprojet = '".$_SESSION['nomprojet']."' AND etudiant = '$nomMembre'";
    $resultt = $conn->query($sql_check1);
    if ($resultt->num_rows > 0){
         // Vérifier si la tâche existe déjà pour ce membre
    $sql_check = "SELECT * FROM taches WHERE nommembre = '$nomMembre' AND nomtache = '$nomTache' AND nomprojet = '".$_SESSION['nomprojet']."'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Cette tâche existe déjà pour ce membre."]);
    } else {
        // Insérer la nouvelle tâche
        $sql_insert = "INSERT INTO taches (nommembre, nomtache, descriptiont, statut, nomprojet) 
                       VALUES ('$nomMembre', '$nomTache', '$descriptionTache', '$statut','" . $_SESSION['nomprojet'] . "')";

        if ($conn->query($sql_insert) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Tâche ajoutée avec succès", "id" => $conn->insert_id]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erreur SQL: " . $conn->error]);
        }
    }
    }
    else{
        echo json_encode(["status" => "error", "message" => "Ce membre n'appartient pas à ce projet."]);
    }
   
}

$conn->close();
?>
