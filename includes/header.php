<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php 
$current_page = basename($_SERVER['PHP_SELF']); // Récupère le fichier actuel
?>

<header>
    <nav class="barrenav">
        <a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">
            <img src="../LIVRE-OR/assets/img/home.svg" alt="home">
        </a>
        <a href="livre_or.php" class="<?= ($current_page == 'livre_or.php') ? 'active' : '' ?>">
            <img src="../LIVRE-OR/assets/img/book.svg" alt="book">
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php" class="<?= ($current_page == 'profile.php') ? 'active' : '' ?>">
                <img src="../LIVRE-OR/assets/img/profile.svg" alt="profile">
            </a>
        <?php else: ?>
            <a href="login.php" class="<?= ($current_page == 'login.php') ? 'active' : '' ?>">
                <img src="../LIVRE-OR/assets/img/profile.svg" alt="profile">
            </a>
        <?php endif; ?>
    </nav>
</header>

</body>
</html>
