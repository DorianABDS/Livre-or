<?php
session_start();
include_once '../models/Comment.php';
$comment = new Comment();
$commentModel = new Comment();
// PAGINATION & SEARCH
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

// Check if a search has been performed
$keyword = isset($_POST['searchbar']) ? trim($_POST['searchbar']) : (isset($_GET['searchbar']) ? trim($_GET['searchbar']) : "");

// Retrieve comments by search
if (!empty($keyword)) {
    $comments = $comment->searchComments($keyword, $limit, $offset);
    $totalComments = $comment->countSearchComments($keyword);
} else {
    $comments = $comment->getComments($limit, $offset);
    $totalComments = $comment->countComments();
}

$totalPages = ceil($totalComments / $limit);

// VERIFICATION UTILISATEUR CONNECTÉ
$message = "";
if (isset($_POST['add-new-com'])) {
    if (isset($_SESSION['user'])) {
        header('Location: comments.php');
        exit;
    } else {
        $message = "Veuillez vous connecter pour laisser un commentaire!";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style-livre_or.css">
    <link rel="stylesheet" href="../assets/css/style-commun.css">    
    <title>Livre d'Or</title>
</head>

<body>   
<main class="main">
    <div class="title-bloc">
        <img src="../assets/img/leftlogo.png" alt="logo">
        <h1 class="title-h1"> Livre d'Or</h1>
        <img src="../assets/img/rightlogo.png" alt="logo">
    </div>
    <h2 class="title-h2">Commentaires</h2>

    <section class="add-search">
        <div class="sections"></div>
        <div class="sections">
            <form action="" method="post" class="form">        
                <button type="submit" class="button btn-add-com" name="add-new-com">Ajouter un commentaire</button>
            </form>
            <div class="alert-comment"><?= $message ?></div>
        </div>
        <div class="sections">
            <form action="" method="post" class="form"> 
                <input class="searchbar" name="searchbar" placeholder="Rechercher un commentaire" value="<?= htmlspecialchars($keyword) ?>">
                <button type="submit" class="search-btn">
                    <img src="../assets/img/loupe.svg" alt="loupe">
                </button> 
            </form>
        </div>
    </section>

    <section class="card-container">
        <?php foreach ($comments as $comment): ?>
        <article class="card">
            <div class="card-content">
                <h3 class="title-h3"><?= htmlspecialchars($comment['login']); ?></h3>
                <div class="text-card">
                <p>"<?= nl2br($commentModel->highlightKeyword($comment['comment'], $keyword)); ?>"</p>

                </div>
                <div class="date-time"> 
                    <p>Posté le : <?= htmlspecialchars($comment['date']); ?></p>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </section>

    <nav class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="link-pages <?= ($i === $page) ? 'active' : ''; ?>" 
               href="livre_or.php?page=<?= $i; ?><?= !empty($keyword) ? '&searchbar='.urlencode($keyword) : '' ?>">
                <?= $i; ?>
            </a>
        <?php endfor; ?>
    </nav>
</main>
</body>
</html>
