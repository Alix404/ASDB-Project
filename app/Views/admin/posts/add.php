<?php

use Core\HTML\BootstrapForm;

$postTable = App::getInstance()->getTable('Post');

if (!empty($_POST)) {
    $result = $postTable->create([
        'titre' => $_POST['titre'],
        'contenu' => $_POST['contenu'],
        'categories_id' => $_POST['categories_id']
    ]);
    if ($result) {
        ?>
        <div class="alert alert-success">L'article a bien été modifié</div>
        <?php
    }
}

$categories = App::getInstance()->getTable('Category')->extract('id', 'titre');
$form = new BootstrapForm($_POST);
?>

<form method="post">
    <?= $form->input('titre', 'Titre de l\'article'); ?>
    <?= $form->input('contenu', 'Contenu', ['type' => 'textarea']); ?>
    <?= $form->select('categories_id', 'Catégorie', $categories); ?>
    <button class="btn form-button-info">Sauvegarder</button>
</form>