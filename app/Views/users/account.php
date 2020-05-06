<?php

use Core\Session\Session;

?>


<h1>Bonjour <?= Session::getInstance()->read('auth')->username; ?></h1>

<form action="" method="post">
    <div class="form-group">
        <input type="password" name="password" placeholder="Nouveau mot de passe" class="form-control"/>
    </div>

    <div class="form-group">
        <input type="password" name="confirm_password" placeholder="Confirmation du nouveau mot de passe" class="form-control"/>
    </div>
    <button type="submit" class="btn btn-primary">Changer de mot de passe</button>
</form>

