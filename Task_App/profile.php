<?php
session_start();
include 'config.php';

$email = $_SESSION['email']; // Ou selon ta logique, l'email peut venir d'une session ou d'un formulaire
$sql = "SELECT * FROM etudiants WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['id'] = $row['id'];
    $_SESSION['filiere'] = $row['filiere'];
    $_SESSION['nomdutilisateura'] = $row['nom'] . " " . $row['prenom'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['num'] = $row['num'];
} else {
    echo "Aucun utilisateur trouvé";
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>Mon Profil</h1>
            <a href="logout.php" class="logout-btn">Déconnexion</a>
        </div>

        <div class="profile-content">
            

            <div class="profile-info">
                <form action="update_profile.php" method="post" class="profile-form">
                    <div class="form-group">
                        <label>Nom complet</label>
                        <input type="text" name="fullname" value="<?php echo isset($_SESSION['nomdutilisateura']) ? $_SESSION['nomdutilisateura'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '';  ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="tel" name="phone" value="<?php echo isset($_SESSION['num']) ? $_SESSION['num'] : '';  ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>filiere</label>
                        <textarea name="address"><?php echo isset($_SESSION['filiere']) ? $_SESSION['filiere'] : '';  ?></textarea>
                    </div>
                    
                    <button type="submit" class="save-btn">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>

    <script src="profile.js"></script>
</body>
</html>