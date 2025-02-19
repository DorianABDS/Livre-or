<?php
session_start();
require_once '../models/Comment.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$comment = new Comment();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (!empty($_POST['comment'])) {
        $user_id = $_SESSION['user']; // ID use connected
        $comment_text = trim($_POST['comment']);

        if ($comment->addComment($user_id, $comment_text)) {
            $message = "Votre commentaire a été ajouté avec succès !";
        } else {
            $message = "Une erreur est survenue, veuillez réessayer.";
        }
    } else {
        $message = "Veuillez entrer un commentaire.";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Commentaire</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<main class="main">
    <section class="comment-section">
        <h1>Ajouter un Commentaire</h1>

        <?php if (!empty($message)) : ?>
            <p class="alert"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="post" action="" class="form">
            <textarea name="comment" id="comment" placeholder="Écrivez votre commentaire ici..." required></textarea><br>
            <button type="submit" name="submit" class="button">Envoyer</button>
        </form>

        <br>
        <a href="livre_or.php" class="button">Voir les commentaires</a>
    </section>
</main>

</body>
</html>

