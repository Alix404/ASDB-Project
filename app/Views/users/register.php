<?php

if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <p>Vous n'avez pas rempli le formulaire correctement</p>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<div class="row title">
    <h1>Inscription</h1>
</div>

<form action="" method="post">

    <?= $form->input('username', 'Pseudo', ['required' => true]); ?>
    <?= $form->input('email', 'Email', ['type' => 'email', 'required' => true]); ?>
    <?= $form->input('password', 'Mot de passe', ['type' => 'password', 'required' => true]); ?>
    <?= $form->input('confirm_password', 'Confirmez votre mot de passe', ['type' => 'password', 'required' => true]); ?>

    <button type="submit" class="btn btn-primary form-button-info">M'inscrire</button>
</form>