<?php
// Exemple : Après avoir ajouté une tâche, rediriger vers la gestion des membres
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Traitement du formulaire d'ajout de tâche
    // ...

    // Redirection vers la gestion des membres
    header('Location: gestion_membres.php');
    exit; // Assurez-vous de terminer le script après la redirection
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tâches</title>
</head>
<body>
    <h1>Gestion des Tâches</h1>
    <p>Bienvenue sur la page de gestion des tâches.</p>

    <!-- Formulaire d'ajout de tâche -->
    <form method="POST">
        <label for="tache">Tâche :</label>
        <input type="text" name="tache" required><br>
        <label for="description">Description :</label>
        <textarea name="description" required></textarea><br>
        <button type="submit">Ajouter une tâche</button>
    </form>

    <!-- Lien vers la page de gestion des membres -->
    <a href="gestion_membres.php">Aller à la gestion des membres</a>
</body>
</html>