<?php

use Core\Session\Session;

?>


<div class="row title">
    <h1>Bonjour <?= Session::getInstance()->read('auth')->username; ?></h1>
</div>

<form action="" method="post">
    <div class="form-group">
        <input type="password" name="password" placeholder="Nouveau mot de passe" class="form-control" required/>
    </div>

    <div class="form-group">
        <input type="password" name="confirm_password" placeholder="Confirmation du nouveau mot de passe"
               class="form-control" required/>
    </div>
    <button type="submit" class="btn btn-primary form-button-info">Changer de mot de passe</button>
</form>

