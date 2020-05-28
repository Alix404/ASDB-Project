<?php

use Core\Session\Session;

$user = Session::getInstance()->read('auth');
$adminName = explode('_', $user->username);
if ($adminName[0] == 'Admin' && $user->id == 1) {
    $commentTemplatePath = 'admin/comment.php';
} else {
    $commentTemplatePath = 'users/comment.php';
}
?>

<div class="row title">
    <h1>Les Articles</h1>
</div>
<?php if (!empty($comments)) : ?>
    <div class="row">
        <div class="col postsCard">
            <div class="card">
                <h2 class="card-header"><?= $articles->titre; ?></h2>
                <div class="card-body">
                    <p><em><?= $articles->categorie; ?></em></p>

                    <p><?= $articles->contenu; ?></p>
                    <a href="index.php?p=posts.index">revenir à l'Accueil</a>
                </div>
            </div>
            <form action="" id="form-comment" method="post">
                <h4 class="form-title">Poster un commentaire ?</h4>
                <?= $form->input('content', 'Écrivez votre commentaire', ['type' => 'textarea']) ?>
                <input type="hidden" name="parent_id" value="0" id="parent_id">
                <button type="submit" class="btn form-button-add">Commenter</button>
            </form>
            <div class="row comment-title">
                <h1>Les commentaires</h1>
            </div>
            <?php foreach ($comments as $comment): ?>
                <?php require ROOT . '/app/Views/template/' . $commentTemplatePath ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col postsCard">
            <div class="card">
                <h2 class="card-header"><?= $articles->titre; ?></h2>
                <div class="card-body">
                    <p><em><?= $articles->categorie; ?></em></p>

                    <p><?= $articles->contenu; ?></p>
                    <a href="index.php?p=posts.index">revenir à l'Accueil</a>
                </div>
            </div>
            <form action="" id="form-comment" method="post">
                <h4 class="form-title">Poster un commentaire ?</h4>
                <?= $form->input('content', 'Écrivez votre commentaire', ['type' => 'textarea']) ?>
                <input type="hidden" name="parent_id" value="0" id="parent_id">
                <button type="submit" class="btn form-button-add">Commenter</button>
            </form>
        </div>
    </div>
<?php endif; ?>

