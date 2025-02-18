<?php
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style-livre_or.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&" rel="stylesheet">

    <title>Livre d'Or</title>
</head>

<body>    
<main class="main">
    <div class="title-bloc">
    <img src="../assets/img/leftlogo.png" alt="logo">
    <h1 class="title-h1"> Livre d'Or</h1>
    <img src="../assets/img/rightlogo.png" alt="logo">
    </div>
    <h2 class="title-h2">Commentaires</h2>

    <section class="add-search">
    <form action="" method="post" class="form">
        
        <button type="submit" class="button" name="add-new-com">Ajouter un commentaire</button>
        <input class="searchbar" name="searchbar" placeholder="Rechercher un commentaire">
        <button class="search-btn"><img src="../assets/img/loupe.svg" alt="loupe"></button> 
        
    </form>

    </section>

    <section class="card-container">
        <h3 class="title-h3">{Pseudo User}</h3>
        <article class="text-card">
            <p>{comment}</p>
        </article>
        <div class="date-time"> 
            <p>Posté le : {jour/mois/année}</p>
        </div>
    </section>
    
</main>

