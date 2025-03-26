<?php
session_start();
include 'config.php';


// Vérifier si 'nomprojet' est défini dans la session
if (!isset($_SESSION['nomprojet'])) {
    die("Nom du projet non défini.");
}

$nomprojet = $_SESSION['nomprojet'];

// Vérifier si un message est envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    $utilisateur = $_SESSION['email']; // ou utiliser un autre identifiant unique pour l'utilisateur

    // Insérer le message dans la base de données
    $stmt = $conn->prepare("INSERT INTO messages (nomprojet, utilisateur, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nomprojet, $utilisateur, $message);
    $stmt->execute();
    $stmt->close();
}

// Récupérer tous les messages pour le projet en cours
$stmt = $conn->prepare("SELECT utilisateur, message, timestamp FROM messages WHERE nomprojet = ? ORDER BY timestamp ASC");
$stmt->bind_param("s", $nomprojet);
$stmt->execute();
$result = $stmt->get_result();

// Stocker les messages dans un tableau
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
$stmt->close();

// Récupérer les membres du projet
$stmt = $conn->prepare("SELECT etudiant FROM membreprojet WHERE nomprojet = ?");
$stmt->bind_param("s", $nomprojet);
$stmt->execute();
$result = $stmt->get_result();

// Stocker les membres dans un tableau
$membres = [];
while ($row = $result->fetch_assoc()) {
    $membres[] = $row['etudiant'];
}
$_SESSION['membres'] = $membres; // Stocke les membres dans la session

$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion - Projet</title>
    <link rel="stylesheet" href="styless.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?php echo htmlspecialchars($nomprojet); ?> - Discussion</h1>
        </header>
        
        <div class="main-content">
            <!-- Liste des membres -->
            <div class="members-list">
                <ul id="list">
                    <?php foreach ($_SESSION['membres'] as $membre) : ?>
                        <li><?php echo htmlspecialchars($membre); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Zone de chat -->
            <div class="chat-box">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody id="chat">
                        <?php foreach ($messages as $message) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['utilisateur']); ?></td>
                                <td><?php echo htmlspecialchars($message['message']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="message-input">
                    <input type="text" id="message" placeholder="Écrire un message...">
                    <button onclick="sendMessage()">Envoyer</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction d'envoi de message
        function sendMessage() {
            const messageInput = document.getElementById("message");
            const messageText = messageInput.value.trim();

            if (messageText === "") {
                alert("Veuillez entrer un message.");
                return;
            }

            // Envoi du message via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "Messagerie.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Ajouter le message à la discussion
                    const chat = document.getElementById("chat");
                    const newMessage = document.createElement("tr");
                    newMessage.innerHTML = `<td><?php echo $_SESSION['email']; ?></td><td>${messageText}</td>`;
                    chat.appendChild(newMessage);
                    messageInput.value = ""; // Réinitialiser l'input
                }
            };
            xhr.send("message=" + encodeURIComponent(messageText));
        }

        // Permet d'envoyer un message avec la touche "Enter"
        document.getElementById("message").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                sendMessage();
            }
        });
    </script>
</body>
</html>
