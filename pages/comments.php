<?php
require_once('../config/Database.php');
include_once '../models/Comment.php';

$commentaire = new Comment($db, $comment, $id_user);

// if the form is done, add comment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST["comment"];
    $id_user = $_POST["id_user"];
    $commentaire->create($comment, $id_user);
}

// get all comments
$allComments = $commentaire->readAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaires</title>
</head>
<body>

    <h2>Ajouter un commentaire</h2>
    <form action="index.php" method="POST">
        <textarea name="comment" placeholder="Votre commentaire..." required></textarea>
        <input type="hidden" name="id_user" value="1">
        <button type="submit">Envoyer</button>
    </form>

    <h2>Liste des commentaires</h2>
    <?php foreach ($allComments as $c): ?>
        <p><strong>ID <?= $c['id'] ?>:</strong> <?= htmlspecialchars($c['comment']) ?> (User <?= $c['id_user'] ?>, <?= $c['date'] ?>)
            <a href="update_comment.php?id=<?= $c['id'] ?>">Modifier</a>
            <a href="handle_comment.php?action=delete&id=<?= $c['id'] ?>">Supprimer</a>
        </p>
    <?php endforeach; ?>

</body>
</html>
