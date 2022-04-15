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
            <?php if (isset($message)) : ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo($message); ?>
                </div>
            <?php endif; ?>
            <div class="flex mb-4">
                <?php if ($hasSession && $isVisible) : ?>
                    <form method="post" action=<?php echo $action . $post->id(); ?> >

                        <button type="submit" class="btn btn-primary" value="edit" name=<?= $edit ? "" : "edit" ?>>
                            <?= $edit ? 'Retour' : 'Editer' ?>
                        </button>
                        <button type="button" class="btn btn-danger" value="delete" data-toggle="modal" data-target="#exampleModal">Supprimer</button>
                    </form>
                <?php endif; ?>
            </div>
            <div>

                <!--TODO  edit delete avec un utilisateur admin-->
                <?php if ($edit) : ?>
                    <h2 class="py-5">Edition du post</h2>
                    <form method="post" action=<?php echo '/?action=postUpdate&id='.$post->id() ?> class="pb-5">
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
            <?php include_once 'commentForm.php'?>

            <!-- TODO only admin who has created the post or superAdmin -->
            <?php if ($hasSession && count($disableComments) > 0) : ?>
                <?php include_once 'validateComments.php'?>
            <?php endif; ?>

            <?php include_once 'comments.php'?>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Suppresion du post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Valider la suppresion du post ?
                    </div>
                    <div class="modal-footer">
                        <form method="post" action=<?php echo '/?action=deletePost&id='.$post->id() ?> >
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="deletebtn btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

<?php include_once 'footer.php'?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
