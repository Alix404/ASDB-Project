<div class="row">
    <div class="col-sm-12 col-lg-8 postsCard">
        <?php
        if (!empty($articles)): ?>
            <div class="card">
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
            <div class="card">
                <h1 class="card-header"><?= $category->titre; ?></h1>
                <div class="card-body">
                    <p>Il n'y a malheureusement aucuns articles dans cette catégorie, elle sera soit supprimée, soit
                        réalimenté ultérieurement</p><br><br><a href="index.php?p=posts.index">revenir à l'Accueil</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-sm-12 col-lg-4 categoryCard">
        <div class="card">
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