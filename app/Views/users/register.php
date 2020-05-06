<?php

if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <p>Vous n'avez pas rempli le formulaire correctment</p>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


<form action="" method="post">

    <?= $form->input('username', 'Pseudo', ['required' => true]); ?>
    <?= $form->input('email', 'Email', ['type' => 'email', 'required' => true]); ?>
    <?= $form->input('password', 'Mot de passe', ['type' => 'password', 'required' => true]); ?>
    <?= $form->input('confirm_password', 'Confirmer votre mot de passe', ['type' => 'password', 'required' => true]); ?>

    <button type="submit" class="btn btn-primary">M'inscrire</button>
</form>