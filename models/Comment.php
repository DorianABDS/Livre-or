<?php

require_once('../config/Database.php');

class Comment extends Database
{
    private int $id;
    public string $comment;
    private int $id_user;
    public int $date;
    protected PDO $db;

    public function __construct(PDO $db, string $comment, int $id_user, int $date = 0, int $id = 0)
    {
        parent::__construct();

        $this->db = $db;
        $this->id = $id;
        $this->comment = $comment;
        $this->id_user = $id_user;
        $this->date = $date ?: time();
    }

    public function id_userGet()
    {
        return $this->id_user;
    }

    // Getter and Setter for $id
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Getter and Setter for $id_user
    public function getIdUser(): int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): void
    {
        $this->id_user = $id_user;
    }

    // Getter and Setter for $db
    public function getDb(): PDO
    {
        return $this->db;
    }

    public function setDb(PDO $db): void
    {
        $this->db = $db;
    }

    // Add a comment
    public function create(string $comment, int $id_user): bool
    {
        try {
            $sql = "INSERT INTO commentaires (comment, id_user, date) VALUES (:comment, :id_user, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":comment", $comment);
            $stmt->bindParam(":id_user", $id_user);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    // read the comment
    public function readAll(): ?array
    {
        try {
            $sql = "SELECT * FROM commentaires ORDER BY date DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "erreur : " . $e->getMessage();
        }
        return [];
    }
}
