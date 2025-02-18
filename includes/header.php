<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
<header>
    <nav class=barrenav>
        <a href="index.php">Accueil</a>
        <a href="/pages/livre_or.php">Livre d'or</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/pages/profile.php">Profil</a>
            <a href="/pages/comments.php">Ajouter un commentaire</a>
            <a href="logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="/pages/register.php">Inscription</a>
            <a href="/pages/login.php">Connexion</a>
        <?php endif; ?>
    </nav>
</header>