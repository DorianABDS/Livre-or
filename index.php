<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style-commun.css">
    <title>Livre d'or</title>
</head>

<body>

<?php 
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header>
    <nav class="barrenav">
        <a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">
            <img src="assets/img/home.svg" alt="home">
        </a>
        <a href="pages/livre_or.php" class="<?= ($current_page == 'pages/livre_or.php') ? 'active' : '' ?>">
            <img src="assets/img/book.svg" alt="book">
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="pages/profile.php" class="<?= ($current_page == 'pages/profile.php') ? 'active' : '' ?>">
                <img src="assets/img/profile.svg" alt="profile">
            </a>
            <a href="../pages/logout.php" class="<?= ($current_page == 'logout.php') ? 'active' : '' ?>">
                <img src="../assets/img/disconnect.svg" alt="disconnect">
            </a>
        <?php else: ?>
            <a href="pages/login.php" class="<?= ($current_page == 'pages/login.php') ? 'active' : '' ?>">
                <img src="assets/img/profile.svg" alt="profile">
            </a>
        <?php endif; ?>
    </nav>
</header>

    <main class="index-main">
        <img class="guestbook" src="../Livre-or/assets/img/guestbook.png" alt="Guestbook">
        <div class="index-container-box">
            <img class="wedding" src="../Livre-or/assets/img/wedding-photo" alt="Couple">
            <p>
                <a>Bienvenue sur le Livre d'Or ! ✨🎉</a>
                <br><br>
                Nous sommes ravis de vous avoir accueilli et espérons que vous avez vécu une expérience inoubliable !
                <br>
                Ce livre d'or est votre espace pour partager vos impressions, vos souvenirs et vos moments forts.
                <br>
                Que vous ayez assisté en tant que participant, invité ou organisateur, votre témoignage est précieux !
                <br>
                Qu'avez-vous le plus apprécié ? Une rencontre marquante, une animation mémorable, une ambiance particulière ?
                <br>
                Laissez un message pour remercier, encourager ou simplement partager votre ressenti.
                <br>
                Merci pour votre participation et à bientôt pour une nouvelle édition ! 🎊😊
                <br>
                <button class="btn-comment button" onclick="window.location.href='comments.php'">
                    Voir les commentaires
                </button>
            </p>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>