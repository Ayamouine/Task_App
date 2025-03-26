<?php
// Exemple : Après avoir ajouté un membre, rediriger vers la gestion des tâches
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Traitement du formulaire d'ajout de membre
    // ...

    // Redirection vers la gestion des tâches
    header('Location: gestion_taches.php');
    exit; // Assurez-vous de terminer le script après la redirection
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Membres</title>
</head>
<body>
    <h1>Gestion des Membres</h1>
    <p>Bienvenue sur la page de gestion des membres.</p>

    <!-- Formulaire d'ajout de membre -->
    <form method="POST">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required><br>
        <label for="email">Email :</label>
        <input type="email" name="email" required><br>
        <button type="submit">Ajouter un membre</button>
    </form>

    <!-- Lien vers la page de gestion des tâches -->
    <a href="gestion_taches.php">Aller à la gestion des tâches</a>
</body>
</html>