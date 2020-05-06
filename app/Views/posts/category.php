<h1 class="card-header my-4"><?= $category->titre; ?></h1>

<div class="row">
    <div class="col-sm-8" id="postsCard">
        <?php
        if (!empty($articles)): ?>
            <div class="card mt-4 mb-4">
                <div class="card-body">
                    <?php

                    foreach ($articles as $post):?>

                        <h2><a href="<?= $post->url; ?>"> <?= $post->titre; ?></a></h2>
                        <p><em><?= $post->categorie; ?></em></p>
                        <p><?= $post->extrait; ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="card mt-4 mb-4">
                <div class="card-body">
                    <h5>Il n'y a malheureusement aucuns articles dans cette catégorie, elle sera soit supprimée, soit
                        réalimenté ultérieurement<br><br><a href="index.php?p=posts.index">revenir à l'Accueil</a></h5>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-sm-4" id="categoryCard">
        <div class="card my-4">
            <h5 class="card-header">Les catégories</h5>
            <div class="card-body">
                <ul class="list-unstyled mb-0">

                    <?php foreach ($categories as $categorie): ?>
                        <li>
                            <a href="<?= $categorie->url; ?>"><?= $categorie->titre; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>