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


        if ($message === "Mise à jour réussie") {
            session_destroy();
            header("Location: /pages/login.php");
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
            <h1 class="title-h1">Bienvenue, <?= htmlspecialchars($currentUser['login']); ?> !</h1>
            <img src="../assets/img/rightlogo.png" alt="logo">
        </div>

        <?php if (!empty($message)) : ?>
            <p><?= $message ?></p>
        <?php endif; ?>
        <section class="profile-bloc">
            <h2 class="title-h2">Modifier vos informations personnelles</h2>
            <form class="form" method="POST">

                <input class="input" type="text" name="login" id="login" value="<?= htmlspecialchars($currentUser['login']) ?>" placeholder="Nouveau login" required><br /><br />

                <input class="input" type="password" name="password" id="password" placeholder="Nouveau mot de passe" required><br /><br />
           
                <button type="submit" class="button">Modifier</button>
            </form>
        </section>
        <?php include '../includes/footer.php'; ?>

    </main>

</body>

</html>