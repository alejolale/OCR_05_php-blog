<?php if (!$edit) : ?>
    <h3 class="py-5">Créer un nouveau commentaire</h3>
    <form method="post" action=<?php echo '/?action=commentCreation&id=' . $post->id() ?> class="pb-5">
        <div class="mb-3">
            <label for="user" class="form-label">username :</label>
            <input
                type="text"
                name="user"
                class="form-control mb-3"
                placeholder="UserName..."
                id="user"
                value="<?= $userId ? $user->firstname() . ' ' . $user->lastname() : '' ?>"
                required />
            <label for="comment" class="form-label">Commentaire :</label>
            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="ici votre commentaire..." required></textarea>
            <input type="hidden" name="userId" value=<?= $userId ? $userId : null ?>>
        </div>
        <button type="submit" class="btn btn-primary">Creer</button>
    </form>
<?php endif; ?>