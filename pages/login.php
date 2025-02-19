<?php

session_start();
include_once '../models/User.php';
$newCo = new User();
$newConnexion = $newCo->login();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style-login_register.css">
    <link rel="stylesheet" href="../assets/css/style-commun.css">
    

    <title>Connexion</title>
</head>

<body> 

<?php include '../includes/header.php' ?> 

<main class="main">
    <section>
        <!-- si une session est déjà ouverte on ne propose pas de se reconnecter -->
        <?php if (isset($_SESSION['user'])) : ?>
            <?php header("location:../index.php"); ?>
            <!-- si pas de session ouverte on propose de se connecter -->
        <?php else : ?>
            <div class="title-bloc">
                <img src="../assets/img/leftlogo.png" alt="logo">
                <h1 class="title-h1"> Connexion</h1>
                <img src="../assets/img/rightlogo.png" alt="logo">
            </div>
            <section class="registration-bloc">
                <form method="post" action="" class="form">
                    <input class="input" type="text" name="login" id="login" value="" placeholder="Entrez votre pseudo" required><br /><br />                                 
                    <input class="input" type="password" name="password" id="password" value="" placeholder="Entrez votre mot de passe" required><br /><br />
                    <button type="submit" name="submit" class="button">Se connecter</button>
                    <p>OU</p>
                    <a href="./register.php" class="button btn-link">S'inscrire</a>
                    <p class="alert"><?php if (isset($_SESSION['message'])) echo $_SESSION['message'] ?></p>
                </form>                
            </section>
           
        <?php endif ?>
       
    </section>
</main>

<?php // include '../component/footer.php'; ?>
            
            