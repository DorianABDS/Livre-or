<?php
session_start();
include_once '../models/CommentV2.php';

$comment = new Comment();

// Déterminer la page actuelle
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Page par défaut = 1
$limit = 4; // Nombre de commentaires par page
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
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Livre d'Or</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="main">
        <h1>Livre d'Or</h1>

        <!-- Afficher les commentaires -->
        <section class="comments-section">
            <?php if ($comments): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <p><strong><?php echo htmlspecialchars($comment['login']); ?>:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                        <p><em><?php echo htmlspecialchars($comment['date']); ?></em></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun commentaire à afficher.</p>
            <?php endif; ?>
        </section>

        <!-- Pagination -->
        <nav class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="livre_orV2.php?page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </nav>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
