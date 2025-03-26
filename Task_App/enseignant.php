<?php

session_start();

include 'config.php';


 if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Formulaire d'inscription
    if (isset($_POST['addprojet'])) {
        $nom = $conn->real_escape_string($_POST['nom']);
        $prenom = $conn->real_escape_string($_POST['prenom']);
        
        $descriptionp = $conn->real_escape_string($_POST['descriptionp']);
        $nomprojet = $conn->real_escape_string($_POST['nomprojet']);

        $sql_check = "SELECT * FROM projet WHERE nomprojet='$nomprojet'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            echo "<script>alert('Ce projet est déja existe');</script>";
        } else {
            // Insérer les données
            $sql_insert = "INSERT INTO projet (nom, prenom, nomprojet , descriptionp) 
                           VALUES ('$nom', '$prenom', '$nomprojet', '$descriptionp')";

            if ($conn->query($sql_insert) === TRUE) {
                $_SESSION['nomenseignant'] = $nom ." ".$prenom ;
               
                $_SESSION['nomprojet'] = $nomprojet;
                $_SESSION['descriptionp'] = $descriptionp;

                header("location: gestion-membres.html");
                exit();
            } else {
                echo "<script>alert('Erreur: " . $conn->error . "');</script>";
            }
        }




    }
}
    $conn->close();


?>