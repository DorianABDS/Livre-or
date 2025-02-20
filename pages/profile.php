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
    <link rel="stylesheet" href="../assets/css/style-profile.css">
    <link rel="stylesheet" href="../assets/css/style-commun.css">

    <title>Profil</title>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <main class="main">
        <div class="title-bloc">
            <img src="../assets/img/leftlogo.png" alt="logo">
            <h1 class="title-h1">Modifier mon profil</h1>
            <img src="../assets/img/rightlogo.png" alt="logo">
        </div>

        <?php if (!empty($message)) : ?>
            <p><?= $message ?></p>
        <?php endif; ?>
        <section class="profile-bloc">
            <form method="POST">
                <label for="login">Nouveau Login :</label>
                <input type="text" name="login" id="login" value="" class="input" <?= htmlspecialchars($currentUser['login']) ?>">

                <label for="password">Nouveau Mot de Passe :</label>
                <input type="password" name="password" id="password" class="input">

                <button type="submit" class="button">Modifier</button>
            </form>

            <a href="/logout.php" class="button-logout">Se déconnecter</a>
        </section>
        <?php include '../includes/footer.php'; ?>
    </main>

</body>

</html>