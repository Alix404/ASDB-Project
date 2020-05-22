<?php if (!empty($errors)): ?>
    <div id="danger" class="alert alert-danger">
        Identifiants incorrects
    </div>
<?php endif; ?>

<div class="row title">
    <h1>Se connecter</h1>
</div>
<form action="" method="post">

    <?= $form->input('username', 'Votre pseudo ou email', ['required' => true]) ?>

    <?= $form->input('password', 'Mot de passe', ['type' => 'password', 'required' => true]) ?>
    <?= $form->link('users.forget', 'mot de passe oublié') ?>

    <?= $form->input('remember', 'Se souvenir de moi', ['type' => 'checkbox']) ?>

    <button type="submit" class="btn btn-primary form-button-info">Se connecter</button>
</form>