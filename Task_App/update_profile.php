<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit();
}

$userId = $_SESSION['user_id'];

// Préparation des données
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'] ?? null;
$address = $_POST['address'] ?? null;

// Mise à jour en base de données
try {
    $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, phone = ?, address = ? WHERE id = ?");
    $stmt->execute([$fullname, $email, $phone, $address, $userId]);
    
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur de base de données']);
}