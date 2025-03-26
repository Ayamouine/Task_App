<?php
session_start();

if (!isset($_SESSION)) {
    die("Erreur: La session ne démarre pas !");
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Formulaire d'inscription
    if (isset($_POST['inscription'])) {
        $nom = $conn->real_escape_string($_POST['nom']);
        $prenom = $conn->real_escape_string($_POST['prenom']);
        $email = $conn->real_escape_string($_POST['email']);
        $num = $conn->real_escape_string($_POST['num']);
        $pass = $conn->real_escape_string($_POST['pass']);
        $profession = $conn->real_escape_string($_POST['profession']);
        $filiere = $conn->real_escape_string($_POST['filiere']);

        // Vérifier si l'email existe déjà
        $sql_check = "SELECT * FROM etudiants WHERE email='$email'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            echo "<script>alert('Cet email est déjà utilisé. Veuillez choisir un autre.');</script>";
        } else {
            // Insérer les données
            $sql_insert = "INSERT INTO etudiants (nom, prenom, email, num, pass, profession, filiere) 
                           VALUES ('$nom', '$prenom', '$email', '$num', '$pass', '$profession','$filiere')";

            if ($conn->query($sql_insert) === TRUE) {
                $_SESSION['nom'] = $nom;
                $_SESSION['nomdutilisateur'] = $nom."".$prenom;
                $_SESSION['email'] = $email;
                header("location: bor.php");
                exit();
            } else {
                echo "<script>alert('Erreur: " . $conn->error . "');</script>";
            }
        }
    }

    // Formulaire de connexion
    if (isset($_POST['connexion'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $pass = $conn->real_escape_string($_POST['pass']);
       

        // Vérifier si l'utilisateur existe
        $sql = "SELECT * FROM etudiants WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Vérifier le mot de passe
            if ($pass == $row['pass']) {
                
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['nom'] = $row['nom'];
                    $_SESSION['nomdutilisateur']=$row['nom']."".$row['prenom'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['profession'] = $row['profession'];

                    header("Location: bor.php");
                    exit();
                
            } else {
                echo "<script>alert('Mot de passe incorrect.');</script>";
            }
        } else {
            echo "<script>alert('Aucun utilisateur trouvé avec cet email.');</script>";
        }
    }

    $conn->close();
}
?>
