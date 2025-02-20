<?php
session_start();
include_once '../models/User.php';

$newIns = new User();
$newInscription = $newIns->register();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style-login_register.css">
    <link rel="stylesheet" href="../assets/css/style-commun.css">

    <title>Inscription</title>
</head>

<body> 
<?php include '../includes/header.php' ?>

<main class="main">
    <section class="">
        <!-- si une session est déjà ouverte on ne propose pas de se reconnecter -->
        <?php if (isset($_SESSION['user'])) : ?>
            <?php header("location:login.php"); ?>
            
            <!-- si pas de session ouverte on propose de se connecter -->
        <?php else : ?>
            <div class="title-bloc">
                <img src="../assets/img/leftlogo.png" alt="logo">
                <h1 class="title-h1"> Inscription</h1>
                <img src="../assets/img/rightlogo.png" alt="logo">
            </div>
            <section class="registration-bloc">
                <form method="post" action="" class="form">
                    <input class="input" type="text" name="login" id="login" value="" placeholder="Entrez votre pseudo" required><br /><br />                                 
                    <input class="input" type="password" name="password" id="password" value="" placeholder="Entrez votre mot de passe" required><br /><br />
                    <button type="submit" name="submit" class="button">S'inscrire</button>
                </form> 
                <br>
                    <P>Déja inscrit?</P>
                    <a href="./login.php" class="button btn-link">Se connecter</a><br>
                    <p class="alert"><?php if (isset($_SESSION['message'])) echo $_SESSION['message'] ?></p>               
            </section>
        <?php endif ?>
    </section>
</main>


<!-- <?php // include '../component/footer.php'; ?> -->