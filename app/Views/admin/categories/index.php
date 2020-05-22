<?php
$categories = App::getInstance()->getTable('Category')->all();
?>

<h1>Admisnistrer les catégorie</h1>

<p>
    <a href="?p=admin.categories.add" class="btn form-button-add">Ajouter</a>
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
    <?php foreach ($items as $category) : ?>

        <tr>
            <td><?= $category->id; ?></td>
            <td><?= $category->titre; ?></td>
            <td>
                <a class="btn form-button-edit" href="?p=admin.categories.edit&id=<?= $category->id ?>">Editer</a>

                <form action="?p=admin.categories.delete" method="post" style="display: inline">
                    <input type="hidden" name="id" value="<?= $category->id; ?>">
                    <button type="submit" class="btn form-button-del">Supprimer
                    </button>
                </form>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>