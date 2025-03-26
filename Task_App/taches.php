<?php
session_start();
include 'config.php';

if (!isset($_SESSION['nomdutilisateur'])) {
    echo "Veuillez vous connecter.";
    exit();
}

$nomEtudiant = $_SESSION['nomdutilisateur'];

// Récupérer les tâches de l'étudiant
$sql = "SELECT t.nomtache, t.statut, p.nomprojet 
        FROM taches t
        JOIN membreprojet m ON t.nommembre = m.etudiant
        JOIN projet p ON m.nomprojet = p.nomprojet
        WHERE t.nommembre = '$nomEtudiant'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Tâches</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Mes Tâches</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nom du Projet</th>
                <th>Nom de la Tâche</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nomprojet']) ?></td>
                    <td><?= htmlspecialchars($row['nomtache']) ?></td>
                    <td>
                        <select class="statut-select" 
                                data-nomprojet="<?= htmlspecialchars($row['nomprojet']) ?>"
                                data-nomtache="<?= htmlspecialchars($row['nomtache']) ?>">
                            <option value="En cours" <?= ($row['statut'] == 'En cours') ? 'selected' : '' ?>>En cours</option>
                            <option value="Terminée" <?= ($row['statut'] == 'Terminée') ? 'selected' : '' ?>>Terminée</option>
                            <option value="En attente" <?= ($row['statut'] == 'En attente') ? 'selected' : '' ?>>En attente</option>
                        </select>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        $(document).on("change", ".statut-select", function() {
            let nomProjet = $(this).data("nomprojet");
            let nomTache = $(this).data("nomtache");
            let nouveauStatut = $(this).val();
            
            $.post("update_statut.php", { nomprojet: nomProjet, nomtache: nomTache, statut: nouveauStatut }, function(response) {
                alert(response.message);
            }, "json");
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>
