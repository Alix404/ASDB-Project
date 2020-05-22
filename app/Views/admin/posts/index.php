<h1>Admisnistrer les articles</h1>

<p>
    <a href="?p=admin.posts.add" class="btn form-button-add">Ajouter</a>
</p>

<table class="table">
    <thead>
    <tr>
        <td>ID</td>
        <td>Titre</td>
        <td>Actions</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post) : ?>

        <tr>
            <td><?= $post->id; ?></td>
            <td><?= $post->titre; ?></td>
            <td>
                <a class="btn form-button-edit" href="?p=admin.posts.edit&id=<?= $post->id ?>">Editer</a>

                <form action="?p=admin.posts.delete" method="post" style="display: inline">
                    <input type="hidden" name="id" value="<?= $post->id; ?>">
                    <button type="submit" class="btn form-button-del">Supprimer
                    </button>
                </form>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>