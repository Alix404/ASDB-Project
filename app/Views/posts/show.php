<div class="row" id="posts">
    <div class="col-sm-8" id="postsCard">
        <h1 class="card-header my-4"><?= $articles->titre; ?></h1>
        <div class="card mb-4">
            <div class="card-body">
                <p><em><?= $articles->categorie; ?></em></p>

                <p><?= $articles->contenu; ?></p>
            </div>
        </div>
    </div>
</div>