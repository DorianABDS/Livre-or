<?php

require_once ('../config/Database.php');

class User extends Database
{
    private $id;
    private $login;
    protected $password;

    public function __construct()
    {
        parent::__construct(); // Call the parent constructor first
        $this->id = null; // Initialize ID to null
        $this->login = ""; // Initialize login as an empty string
        $this->password = ""; // Initialize password as an empty string
    }

    public function login()

    {
        if (isset($_POST['submit'])) {
            if (!empty($_POST['login']) && !empty($_POST['password'])) {
                $login = htmlentities($_POST['login']);
                $password = $_POST['password'];
                // Prepare and execute query to fetch user by login
                $req = $this->db->prepare("SELECT * FROM user WHERE login = :login");
                $req->execute(["login" => $login]);
                $user = $req->fetch(PDO::FETCH_ASSOC);

                if (!$user) { // Vérifie si l'utilisateur existe
                    $_SESSION['message']  = "Pseudo ou Mot de passe incorrect !";
                } else {  // Verify password
                    if (password_verify($password, $user['password']) ||  $password == $user['password']) {

                        session_start();
                        $_SESSION['user'] = $user['id'];
                        $userNum = new User();
                        header("location: login.php");
                        exit(); // Exit after redirection
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
        
            session_start(); // Assurez-vous que la session est démarrée
        
            // Vérification que les données de mise à jour sont envoyées par POST
            if (isset($_POST['submit'])) {
                if (!empty($_POST['login']) && !empty($_POST['password'])) {
                    $login = htmlentities($_POST['login']);
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash le nouveau mot de passe
                    
                    // Mise à jour du pseudo et du mot de passe dans la base de données
                    $req = $this->db->prepare("UPDATE user SET login = :login, password = :password WHERE id = :id");
                    $req->execute([
                        "login" => $login,
                        "password" => $password,
                        "id" => $_SESSION['user_id'] // Utiliser l'ID de l'utilisateur connecté
                    ]);
        
                    // Message de confirmation
                    $_SESSION['message'] = "Votre profil a été mis à jour avec succès.";
        
                    // Détruire la session (se déconnecter après modification)
                    session_destroy();
        
                    // Rediriger vers la page de connexion
                    header("Location: login.php");
                    exit();
                } else {
                    // Message d'erreur si l'un des champs est vide
                    $_SESSION['message'] = "Veuillez remplir tous les champs.";
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
            return "Modification réussie !";
        } else {
            return "Erreur lors de la modification.";
        }
    }
}
