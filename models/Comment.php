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
    public function getComments($limit, $offset, $keyword = "")
    {
        $stmt = $this->db->prepare("SELECT comment.comment, comment.date, user.login 
                                    FROM comment 
                                    JOIN user ON comment.id_user = user.id 
                                    ORDER BY comment.date DESC 
                                    LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si un mot-clé est recherché, on applique le surlignage
        if (!empty($keyword)) {
            foreach ($comments as &$comment) {
                $comment['comment'] = $this->highlightKeyword($comment['comment'], $keyword);
            }
        }

        return $comments;
    }

    public function highlightKeyword($text, $keyword) {
        if (!empty($keyword)) {
            return preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<span class="highlight">$1</span>', $text);
        }
        return $text;
    }
    


    public function countComments()
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM comment");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }



    public function searchComments($keyword, $limit, $offset)
    {
        $query = "SELECT comment.comment, comment.date, user.login 
                  FROM comment 
                  JOIN user  ON comment.id_user = user.id 
                  WHERE comment.comment LIKE :keyword 
                  ORDER BY comment.date DESC 
                  LIMIT :limit OFFSET :offset";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function countSearchComments($keyword)
    {
        $query = "SELECT COUNT(*) as total FROM comment WHERE comment LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function getUserComments($userId, $limit, $offset) {
        $stmt = $this->db->prepare("
            SELECT comment.*, user.login 
            FROM comment 
            JOIN user ON comment.id_user = user.id 
            WHERE comment.id_user = :userId
            ORDER BY comment.date DESC 
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
