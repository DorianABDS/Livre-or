<?php
require_once '../models/CommentV2.php';
$commentObj = new Comment();
$comments = $commentObj->getComments();
?>

<h2>Commentaires</h2>
<?php foreach ($comments as $comment) : ?>
    <p><strong><?= htmlspecialchars($comment['login']) ?></strong> (<?= $comment['date'] ?>) :</p>
    <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
    <hr>
<?php endforeach; ?>
