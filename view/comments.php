<div class="card">
    <div class="card-header">
        Commentaires
    </div>
    <div class="card-body">
        <?php foreach ($comments as $comment) {
            ?>
            <p class="card-text"><?= htmlspecialchars($comment->content()) ?></p>
            <div class="post-preview">
                <p class="post-meta">
                    Commenté par :
                    <?= htmlspecialchars($comment->userName()) ?>
                    le
                    <?= htmlspecialchars(date('d-m,  Y', strtotime($post->createdAt()))) ?>
                </p>
            </div>
            <hr />
        <?php } ?>
    </div>
</div>