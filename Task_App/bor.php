<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    session_destroy(); // Détruire la session si elle est invalide
    header("Location: page.html"); 
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="aya.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/ionicons.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Navigation Sidebar -->
        <div class="navigation">
            <div class="sidebar-header">
                <h3>Navigation</h3>
            </div>
            <ul>
                <li class="active">
                    <a href="bor.php">
                        <span class="icon"><ion-icon name="grid-outline"></ion-icon></span>
                        <span class="title">DASHBOARD</span>
                    </a>
                </li>
                
                <li>
                    <?php if (isset($_SESSION['profession']) && $_SESSION['profession'] == "admis"): ?>
                        <a href="enseignant.html">
                            <span class="icon"><ion-icon name="folder-outline"></ion-icon></span>
                            <span class="title">Création de Projet</span>
                        </a>
                    <?php else: ?>
                        <a href="#" onclick="alert('Vous ne pouvez pas créer des projets'); return false;">
                            <span class="icon"><ion-icon name="folder-outline"></ion-icon></span>
                            <span class="title">Création de Projet</span>
                        </a>
                    <?php endif; ?>
                </li>

                <li>
                    <a href="gestion-membres.html">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <span class="title">Gestion des membres</span>
                    </a>
                </li>
                <li>
                    <a href="gestion-taches.html">
                        <span class="icon"><ion-icon name="checkmark-done-outline"></ion-icon></span>
                        <span class="title">Gestion de Tâches</span>
                    </a>
                </li>
                <li>
                    <a href="messageri1.php">
                        <span class="icon"><ion-icon name="chatbubble-outline"></ion-icon></span>
                        <span class="title">MESSAGERIE</span>
                    </a>
                </li>
                <li>
                    <a href="profile.php">
                        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                        <span class="title">PROFIL</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="search">
                    <label>
                        <input type="text" placeholder="Rechercher...">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                <div class="user">
                    <img src="logotaskup.jpg" alt="Utilisateur">
                </div>
            </div>
            
            <!-- Tableau de Bord -->
            <div class="dashboard-content">
                <h1>Tableau de Bord</h1>
                
                <div class="sections-container">
                    <!-- Section Projets -->
                    <div class="section-card projects-section">
                        <div class="section-title">
                        <?php if (isset($_SESSION['profession']) && $_SESSION['profession'] == "admis"): ?>
                        <a href="enseignant.html">
                            <span class="icon"><ion-icon name="folder-outline"></ion-icon></span>
                            <span class="title">Création de Projet</span>
                        </a>
                    <?php else: ?>
                        <a href="#" onclick="alert('Vous ne pouvez pas créer des projets'); return false;">
                            <span class="icon"><ion-icon name="folder-outline"></ion-icon></span>
                            <span class="title">Création de Projet</span>
                        </a>
                    <?php endif; ?>
                           
                        </div>
                        <div class="section-content"></div>
                    </div>
                    
                    <!-- Section Tâches -->
                    <div class="section-card tasks-section">
                        <div class="section-title">
                            <a href="taches.php">
                                <ion-icon name="checkmark-done-outline"></ion-icon>
                                <span class="title">Tâches</span>
                            </a>
                        </div>
                        <div class="section-content"></div>
                    </div>
                    
                    <!-- Section Messagerie -->
                    <div class="section-card messages-section">
                        <div class="section-title">
                            <a href="messageri1.php">
                                <ion-icon name="chatbubble-outline"></ion-icon>
                                <span class="title">Messagerie</span>
                            </a>
                        </div>
                        <div class="section-content"></div>
                    </div>
                    
                    <!-- Section Profil -->
                    <div class="section-card profile-section">
                        <div class="section-title">
                            <a href="profile.php">
                                <ion-icon name="person-outline"></ion-icon>
                                <span class="title">Profil</span>
                            </a>
                        </div>
                        <div class="section-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>
