<?php
session_start();
include 'config.php';

// Vérifier si l'utilisateur est connecté
$email = $_SESSION['email'] ?? null;
if (!$email) {
    die("Veuillez vous connecter.");
}

// Récupérer les projets associés à l'utilisateur
$stmt = $conn->prepare("SELECT nomprojet FROM membreprojet WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$projets = [];
while ($row = $result->fetch_assoc()) {
    $projets[] = $row['nomprojet'];
}

$stmt->close();

// Vérifier si un projet a été sélectionné et stocker en session
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nomprojet'])) {
    $_SESSION['nomprojet'] = $_POST['nomprojet']; // Stocke le projet en session
    header("Location: Messagerie.php"); // Redirige vers la page de messagerie
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix du Projet</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }

        select, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Choisissez un projet</h2>
        <form method="POST">
            <select name="nomprojet" required>
                <option value="" selected disabled>Sélectionner un projet</option>
                <?php foreach ($projets as $projet) : ?>
                    <option value="<?php echo htmlspecialchars($projet); ?>"><?php echo htmlspecialchars($projet); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Accéder à la discussion</button>
        </form>
    </div>
</body>
</html>
