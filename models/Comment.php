<?php
require_once '../config/Database.php';

class Comment extends Database
{
     public function __construct()
    {
        parent::__construct(); // Call the construct of the database class
    }

    public function addComment($user_id, $comment)
    {
        $stmt = $this->db->prepare("INSERT INTO comment (comment, id_user) VALUES (:comment, :id_user)");
        return $stmt->execute([
            'comment' => $comment,
            'id_user' => $user_id
        ]);
    }
    public function getComments($limit, $offset)
{
    $stmt = $this->db->prepare("SELECT comment.comment, comment.date, user.login 
                                FROM comment  
                                JOIN user ON comment.id_user = user.id 
                                ORDER BY comment.date DESC 
                                LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function countComments()
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM comment");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

}
