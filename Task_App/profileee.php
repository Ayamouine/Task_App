<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
require_once 'config/db.php';

// Récupérer les infos de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
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
            <div class="profile-picture">
                <img src="<?php echo htmlspecialchars($user['profile_pic'] ?? 'images/default-profile.jpg'); ?>" alt="Photo de profil">
                <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                    <label for="profile_picture" class="upload-label">Changer</label>
                </form>
            </div>

            <div class="profile-info">
                <form action="update_profile.php" method="post" class="profile-form">
                    <div class="form-group">
                        <label>Nom complet</label>
                        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Adresse</label>
                        <textarea name="address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                    </div>
                    
                    <button type="submit" class="save-btn">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>

    <script src="profile.js"></script>
</body>
</html>