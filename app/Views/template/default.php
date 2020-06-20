<?php

use Core\Session\Session;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <title><?= App::getInstance()->title ?></title>
</head>


<body>

<div class="header">
    <nav class="navbar navbar-expand-lg fixed-top navigation">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                ASDB <small>A new kind of think</small>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon navigation-toggler"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href= "./index.php?p=posts.index">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "./curriculum/AlixVendeville.pdf">Mon CV</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "./index.php?p=contact.index">Me contacter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "./index.php?p=users.register">S'inscrire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "./index.php?p=users.login">Connexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>


<div class="container body-container" style="padding-top: 100px">
    <?php if (Session::getInstance()->hasFlashes()): ?>
        <?php foreach (Session::getInstance()->getFlashes() as $key => $flash): ?>
            <div class="alert alert-<?= $key ?>">
                <ul>
                    <li><?= $flash ?></li>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?= $content; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
<script src="js/comments.js"></script>
</body>
</html>
