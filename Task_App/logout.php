<?php
session_start();
session_destroy(); // Détruire la session
header("Location: page.html"); // Rediriger vers la page de connexion
exit();
?>