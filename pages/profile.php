<?php
session_start();
require_once '../config/Database.php';
require_once '../models/User.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


// Retrieve user information
$user = new User();
$currentUser = $user->getUserById($_SESSION['user']);

if (!$currentUser) {
    echo "Utilisateur introuvable.";
    exit();
}

 // Update session if login is changed
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newLogin = !empty($_POST['login']) ? $_POST['login'] : null;
    $newPassword = !empty($_POST['password']) ? $_POST['password'] : null;

    if ($newLogin || $newPassword) {
        $message = $user->updateUser($_SESSION['user'], $newLogin, $newPassword);
       // Update session if login is changed
        if ($newLogin) {
            $_SESSION['login'] = $newLogin;
        }
    } else {
        $message = "Veuillez remplir au moins un champ.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Profil</title>
</head>
<body>
    <h2>Modifier mon profil</h2>
    
    <?php if (!empty($message)) : ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="login">Nouveau Login :</label>
        <input type="text" name="login" id="login" value="<?= htmlspecialchars($currentUser['login']) ?>">
        
        <label for="password">Nouveau Mot de Passe :</label>
        <input type="password" name="password" id="password">

        <button type="submit">Modifier</button>
    </form>

    <a href="/logout.php">Se déconnecter</a>
</body>
</html>
