<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit();
}

$userId = $_SESSION['user_id'];

if (isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];
    
    // Vérifications
    $allowed = ['jpg', 'jpeg', 'png'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    
    if (!in_array(strtolower($ext), $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Format de fichier non supporté']);
        exit();
    }
    
    if ($file['size'] > 5000000) { // 5MB max
        echo json_encode(['success' => false, 'message' => 'Fichier trop volumineux']);
        exit();
    }
    
    // Générer un nom unique
    $filename = 'profile_' . $userId . '_' . time() . '.' . $ext;
    $uploadPath = 'uploads/profiles/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // Mise à jour en base de données
        $stmt = $pdo->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
        $stmt->execute([$uploadPath, $userId]);
        
        echo json_encode(['success' => true, 'path' => $uploadPath]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors du téléchargement']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Aucun fichier reçu']);
}