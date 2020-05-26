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
            <div class="row comment-title">
                <h1>Les commentaires</h1>
            </div>
            <?php foreach ($comments as $comment): ?>
                <?php require ROOT . '/app/Views/template/comment.php' ?>
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
        </div>
    </div>
<?php endif; ?>

