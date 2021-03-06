<div class="row title">
    <h1 class="title"><?= $category->titre ?></h1>
</div>

<form action="" class="category-news-form" method="post">
    <input type="hidden" name="category_id" value="<?= $category->id ?>" required>
    <input type="hidden" name="category_name" value="<?= $category->titre ?>" required>
    <button type="submit" class="btn form-button-info">M'abonner à cette catégorie</button>
</form>

<div class="row">
    <div class="col-sm-12 col-lg-8 postsCard">
        <?php
        if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="card">
                    <h2 class="card-header"><?= $post->titre; ?></h2>
                    <div class="card-body">
                        <p><em><?= $post->categorie; ?></em></p>
                        <p><?= $post->extrait; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="card">
                <h1 class="card-header"><?= $category->titre; ?></h1>
                <div class="card-body">
                    <p>Il n'y a malheureusement aucun article dans cette catégorie, elle sera soit supprimée, soit
                        réalimentée ultérieurement</p><br><br><a href="index.php?p=posts.index">revenir à l'Accueil</a>
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