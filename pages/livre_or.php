<?php
session_start();
include_once '../models/Comment.php';
$comment = new Comment();

// Déterminer la page actuelle
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Page par défaut = 1
$limit = 6; // Nombre de commentaires par page
$offset = ($page - 1) * $limit; // Calcul de l'offset

// Récupérer les commentaires avec pagination
$comments = $comment->getComments($limit, $offset);

// Compter le nombre total de commentaires pour la pagination
$totalComments = $comment->countComments(); // Assurez-vous que cette méthode fonctionne
$totalPages = ceil($totalComments / $limit);
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
        </div>
        <div class="sections">
            <form action="" method="post" class="form"> 
                <input class="searchbar" name="searchbar" placeholder="Rechercher un commentaire">
                <button class="search-btn"><img src="../assets/img/loupe.svg" alt="loupe">
                </button> 
            </form>
    </div>
    </section>

    <section class="card-container">
    <?php foreach ($comments as $comment): ?>
    <article class="card">
        <div class="card-content">
            <h3 class="title-h3"><?= $comment['login']; ?></h3>
            <div class="text-card">
                <p>"<?= nl2br(htmlspecialchars($comment['comment'])); ?>"</p>
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
            <a class="link-pages"href="livre_or.php?page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </nav>
    
</main>

