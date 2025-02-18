<?php
require_once '../config/Database.php';

class Comment extends Database
{
     public function __construct()
    {
        parent::__construct(); // Appelle le constructeur de Database
    }

    public function addComment($user_id, $comment)
    {
        $stmt = $this->db->prepare("INSERT INTO comment (comment, id_user) VALUES (:comment, :id_user)");
        return $stmt->execute([
            'comment' => $comment,
            'id_user' => $user_id
        ]);
    }
    public function getComments()
    {
        $stmt = $this->db->prepare("SELECT comment.comment, comment.date, user.login 
                                    FROM comment 
                                    JOIN user ON comment.id_user = user.id 
                                    ORDER BY comment.date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
