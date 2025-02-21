<?php

require_once '../config/Database.php';
include_once '../models/User.php';
include_once '../models/Comment.php';


// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


// Retrieve user information
$user = new User();
$currentUser = $user->getUserById($_SESSION['user']);

if (!$currentUser) {
    echo "Utilisateur introuvable.";
    exit();
}

// Update session if login is changed
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newLogin = !empty($_POST['login']) ? $_POST['login'] : null;
    $newPassword = !empty($_POST['password']) ? $_POST['password'] : null;

    if ($newLogin || $newPassword) {
        $message = $user->updateUser($_SESSION['user'], $newLogin, $newPassword);


        if ($message === "Mise à jour réussie") {
            session_destroy();
            header("Location: /pages/login.php");
        }
    } else {
        $message = "Veuillez remplir au moins un champ.";
    }
}

$comment = new Comment();
$commentModel = new Comment();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

$keyword = isset($_POST['searchbar']) ? trim($_POST['searchbar']) : (isset($_GET['searchbar']) ? trim($_GET['searchbar']) : "");

if (!empty($keyword)) {
    $comments = $comment->searchComments($keyword, $limit, $offset);
    $totalComments = $comment->countSearchComments($keyword);
} else {
    $comments = $comment->getComments($limit, $offset);
    $totalComments = $comment->countComments();
}

$totalPages = ceil($totalComments / $limit);

$message = "";
if (isset($_POST['add-new-com'])) {
    if (isset($_SESSION['user'])) {
        header('Location: comments.php');
        exit;
    } else {
        $message = "Veuillez vous connecter pour laisser un commentaire !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/style-profile.css">
    <link rel="stylesheet" href="../assets/css/style-commun.css">

    <title>Profil</title>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <main class="main">
        <div class="title-bloc">
            <img src="../assets/img/leftlogo.png" alt="logo">
            <h1 class="title-h1">Bienvenue, <?= htmlspecialchars($currentUser['login']); ?> !</h1>
            <img src="../assets/img/rightlogo.png" alt="logo">
        </div>

        <?php if (!empty($message)) : ?>
            <p><?= $message ?></p>
        <?php endif; ?>
        <section class="profile-bloc">
            <h2 class="title-h2">Modifier vos informations personnelles</h2>
            <form class="form" method="POST">
                <div class="input-box">

                    <input class="input" type="text" name="login" id="login" value="<?= htmlspecialchars($currentUser['login']) ?>" placeholder="Nouveau login" required><br /><br />

                    <input class="input" type="password" name="password" id="password" placeholder="Nouveau mot de passe" required><br /><br />
                </div>

                <div class="button-box">
                    <button type="submit" class="button">Modifier</button>
                </div>
            </form>
        </section>
        
        <section class="card-container">
        <div class="all-comments">
            <h2>Mes commentaires </h2>
            <div class="card-container">
                <?php foreach ($comments as $comment): ?>
                        <article class="card">
                            <div class="card-content">
                                <h3 class="title-h3">Vous</h3>
                                <div class="text-card">
                                    <p class="text">"<?= nl2br($commentModel->highlightKeyword($comment['comment'], $keyword)); ?>"</p>
                                </div>
                                <div class="date-time"> 
                                    <p>Posté le : <?= htmlspecialchars($comment['date']); ?></p>
                                </div>
                            </div>
                        </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <nav class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="link-pages <?= ($i === $page) ? 'active' : ''; ?>" 
               href="profile.php?page=<?= $i; ?><?= !empty($keyword) ? '&searchbar='.urlencode($keyword) : '' ?>">
                <?= $i; ?>
            </a>
        <?php endfor; ?>
    </nav>

        <?php include '../includes/footer.php'; ?>

    </main>

</body>

</html>