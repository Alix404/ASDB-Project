<div class="row">
    <div class="col-sm-12 col-lg-8 postsCard">
        <h1 class="card-header"><?= $articles->titre; ?></h1>
        <div class="card">
            <div class="card-body">
                <p><em><?= $articles->categorie; ?></em></p>

                <p><?= $articles->contenu; ?></p>
                <a href="index.php?p=posts.index">revenir à l'Accueil</a>
            </div>
        </div>
    </div>
</div>