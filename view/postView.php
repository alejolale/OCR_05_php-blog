<?php $title = 'OCR || ' . $post->title(); ?>
<?php ob_start(); ?>
<?php include_once 'navBar.php'?>

<!-- Page Header-->
<header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <?php if (isset($post)) : ?>
                        <h1><?= htmlspecialchars($post->title()) ?></h1>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="flex mb-4">
                <?php if ($hasSession) : ?>
                    <form method="post" action=<?php echo '?action=post&id=' . $post->id(); ?> >
                        <button type="submit" class="btn btn-primary" value="edit" name="edit">Editer</button>
                        <button type="submit" class="btn btn-danger" value="delete" name="delete">Supprimer</button>
                    </form>
                <?php endif; ?>
            </div>
            <div>

                <!--TODO  edit delete avec un utilisateur admin-->
                <?php if ($edit) : ?>
                    <h2 class="py-5">Edition du post</h2>
                    <form method="post" action=<?php echo '/?action=editPost&id='.$post->id() ?> class="pb-5">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre du post :</label>
                            <input value="<?= $post->title() ?>" type="text" class="form-control" id="title" name="title" placeholder="Titre.." required>
                        </div>
                        <div class="mb-3">
                            <label for="header" class="form-label">Entête du post :</label>
                            <input value="<?= $post->header() ?>" type="text" class="form-control" id="header" name="header" placeholder="Entête.." required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu :</label>
                            <textarea  class="form-control" id="content" name="content" rows="3" required><?php echo htmlspecialchars($post->content()); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Editer le post</button>
                    </form>
                <?php else : ?>
                    <div class="post-preview">
                        <h3 class="post-subtitle"><?= htmlspecialchars($post->header()) ?></h3>
                        <p><?= htmlspecialchars($post->content()) ?></p>
                        <p class="post-meta">
                            Rédigé par :
                            <?= htmlspecialchars($post->fullname()) ?>
                        </p>
                        <p class="post-meta">
                            <?php
                            $isEdited = $post->editedAt();
                            if (isset($isEdited)) : ?>
                                Edité le : <?= htmlspecialchars(date('d-m,  Y', strtotime($post->editedAt()))) ?>
                            <?php else : ?>
                                Crée le : <?= htmlspecialchars(date('d-m,  Y', strtotime($post->createdAt()))) ?>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
                <?php if (!$edit) : ?>
                    <h2 class="py-5">Créer un nouveau commentaire</h2>
                    <form method="post" action="/?action=posts" class="pb-5">
                        <div class="mb-3">
                            <label for="comment" class="form-label">Commentaire :</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Creer</button>
                    </form>
                <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once 'footer.php'?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
