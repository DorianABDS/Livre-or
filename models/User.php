<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/Database.php';

class User extends Database
{
    private $id;
    private $login;
    protected $password;

    public function construct()
    {
        parent::__construct(); // D'abord appeler le constructeur parent
        $this->id = null; // Initialisation
        $this->login = ""; // Initialisation à une chaîne vide
        $this->password = ""; // Initialisation à une chaîne vide
    }

    public function login()
    {
        if (isset($_POST['submit'])) {
            if (!empty($_POST['login']) && !empty($_POST['password'])) {
                $login = htmlentities($_POST['login']);
                $password = $_POST['password'];
                $req = $this->db->prepare("SELECT * FROM user WHERE login = :login");
                $req->execute(["login" => $login]);
                $user = $req->fetch(PDO::FETCH_ASSOC);

                if (!$user) { // Vérifie si l'utilisateur existe
                    $_SESSION['message']  = "Pseudo ou Mot de passe incorrect !";
                } else {
                    if (password_verify($password, $user['password']) ||  $password == $user['password']) {

                        session_start();
                        $_SESSION['user'] = $user['id'];
                        $userNum = new User();
                        header("location: login.php");
                        exit(); // Ajout d'un exit() après la redirection
                    } else {
                        $_SESSION['message']  = "Pseudo ou Mot de passe incorrect !";
                    }
                }
            } else {
                $_SESSION['message']  = "Veuillez remplir tous les champs";
            }
        }
    }
    public function register()
    {
        if (isset($_POST['submit'])) {
            if (!empty($_POST['login']) && !empty($_POST['password'])) {
                $login = htmlentities($_POST['login']);
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                // Vérifier si l'utilisateur existe déjà
                $checklogin = $this->db->prepare("SELECT id FROM user WHERE login = :login");
                $checklogin->execute(["login" => $login]);

                if ($checklogin->fetch()) {
                    $_SESSION['message']  = "Ce pseudo est déjà utilisé !";
                } else {

                    $req = $this->db->prepare("INSERT INTO user (login, password)
                                               VALUES (:login, :password)");
                    $req->execute([
                        "login" => $login,
                        "password" => $password
                    ]);


                    $_SESSION['message']  = "Inscription réussie ! Connectez-vous.";
                    header("location:login.php");
                }
            } else {
                $_SESSION['message']  = "Veuillez remplir tous les champs";
            }
        }
    }

    public function getUserById($id)
    {
        // Fetch user details by ID
        $req = $this->db->prepare("SELECT id, login FROM user WHERE id = :id");
        $req->execute(["id" => $id]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $newLogin = null, $newPassword = null)
    {
        if (!$newLogin && !$newPassword) {
            return "Aucune modification apportée.";
        }

        $params = ["id" => $id];
        $sql = "UPDATE user SET ";

        if ($newLogin) {
            $sql .= "login = :login, ";
            $params["login"] = htmlentities($newLogin);
        }
        if ($newPassword) {
            $sql .= "password = :password, ";
            $params["password"] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        $sql = rtrim($sql, ", "); // remove the last comma
        $sql .= " WHERE id = :id";
        // Prepare and execute the update query
        $req = $this->db->prepare($sql);
        if ($req->execute($params)) {
            session_destroy();
            header("Location:../pages/login.php");
            exit();
        } else {
            return "Erreur lors de la modification.";
        }
    }
}
