<div class="row title">
    <h1>Vos commentaires en attentes de validation</h1>
</div>
<?php if (!empty($comments)) : ?>
    <?php foreach ($comments as $comment): ?>
        <div class="row">
            <div class="col postsCard comment-card">
                <div class="card" id="comment-<?= $comment->id; ?>">
                    <h4 class="card-header"><?= $comment->username ?></h4>
                    <div class="card-body">
                        <p><?= htmlentities($comment->content); ?></p>
                        <form action="" class="form-comment" method="post">
                            <p class="text-right">
                                <input type="hidden" name="validation" value="1">
                                <input type="hidden" name="comment_id" value="<?=$comment->id?>">
                                <button class="btn form-button-info">Valider ce commentaire</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

