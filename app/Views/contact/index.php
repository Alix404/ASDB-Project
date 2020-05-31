<form action="" method="post">
    <?= $form->input('username', 'pseudo', ['required' => true])?>
    <?= $form->input('email', 'email', ['type' => 'email', 'required' => true])?>
    <?= $form->input('subject', 'objet du mail', ['required' => true])?>
    <?= $form->input('message', 'Votre message', ['type' => 'textarea', 'required' => true])?>
    <button type="submit" class="btn form-button-add">Envoyer mon message</button>
</form>