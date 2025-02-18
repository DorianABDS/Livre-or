<?php

require_once('../config/Database.php');

class Comment extends Database
{
    private $id;
    public $comment;
    private $id_user;
    public int $date;

    public function __construct(?int $date)
    {
        $this->date = $date ?? time();
    }

    public function save()
    {
        $sql = "INSERT INTO comments (comment, id_user, date) VALUES (:comment, :id_user, :date)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['comment' => $this->comment, 'id_user' => $this->id_user, 'date' => $this->date]);
    }

    public static function fetchAll()
    {
        $db = new Database();
        $sql = "SELECT * FROM comments";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
}