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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">
    <link href="./css/index.css" rel="stylesheet" type="text/css">
    <title><?= App::getInstance()->title ?></title>
</head>


<body>

<div class="header">
    <nav class="navbar navbar-expand-lg fixed-top" id="navigation">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                ASDB <small>A new kind of think</small>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php?p=posts.index">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php?p=users.register">S'inscrire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php?p=users.login">Connexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>


<div class="container" style="padding-top: 100px">
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

</body>
</html>
