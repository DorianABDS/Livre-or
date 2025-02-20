<?php
require_once __DIR__ . '/../models/User.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="../assets/css/style-includes.css">
</head>
<body>

<?php 
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header>
    <nav class="barrenav">
        <a href="../index.php" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">
            <img src="../assets/img/home.svg" alt="home">
        </a>
        <a href="../pages/livre_or.php" class="<?= ($current_page == 'pages/livre_or.php') ? 'active' : '' ?>">
            <img src="../assets/img/book.svg" alt="book">
        </a>
    
    <?php if (isset($_SESSION['user'])): ?>
        
        <a href="../pages/profile.php" class="<?= ($current_page == 'pages/login.php') ? 'active' : '' ?>">
            <img src="../assets/img/profile.svg" alt="profile">
        </a>
        <a href="../pages/logout.php" class="">
            <img src="../assets/img/disconnect.svg" alt="disconnect">
        </a>
        <?php else: ?>
            <a href="../pages/login.php" class="<?= ($current_page == 'pages/login.php') ? 'active' : '' ?>">
                <img src="../assets/img/profile.svg" alt="profile">
            </a>
        <?php endif; ?>
    </nav>
</header>

</body>
</html>
