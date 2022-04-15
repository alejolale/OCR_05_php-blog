 <?php if (isset($posts) && count($posts) > 0) : ?>
    <h2 class="py-5">Dernières publications</h2>
        <?php foreach ($posts as $post) {
            ?>
            <div class="post-preview">
                <a href=<?php echo '/?action=post&id=' . $post->id() ?>>
                    <h2 class="post-title"><?= htmlspecialchars($post->title()) ?></h2>
                    <h3 class="post-subtitle"><?= htmlspecialchars($post->header()) ?></h3>
                </a>
                <p class="post-meta">
                    Posté par
                    <a href=<?php echo '/?action=user&id=' . $post->userId() ?>><?= htmlspecialchars($post->fullname()) ?></a>
                    le <?= htmlspecialchars(date('d-m,  Y', strtotime($post->createdAt()))) ?>
                </p>
            </div>
            <hr />
        <?php } ?>
<?php endif; ?>


