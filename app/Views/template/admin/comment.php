<div class="row">
    <div class="col postsCard comment-card">
        <div class="card" id="comment-<?= $comment->id; ?>">
            <h4 class="card-header"><?= $comment->username ?></h4>
            <div class="card-body">
                <p><?= htmlentities($comment->content); ?></p>
                <p class="text-right">
                    <a href="index.php?p=posts.delete&posts_id=<?= $_GET['id']; ?>&comment_id=<?= $comment->id; ?>"
                       class="btn form-button-del">Supprimer le commentaire</a>
                    <button class="btn form-button-edit reply" data-id="<?= $comment->id; ?>">Répondre</button>
                </p>
            </div>
        </div>
    </div>
</div>
<div style="margin-left: 50px;">
    <?php if (isset($comment->children)): ?>
        <?php foreach ($comment->children as $comment): ?>
            <?php require 'comment.php' ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
