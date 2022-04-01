<?php $title = 'OCR || ' . $user->title(); ?>
<?php ob_start(); ?>
<?php include_once 'navBar.php'?>

<!-- Page Header-->
<header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <?php if (isset($user)) : ?>
                        <h1><?= htmlspecialchars($user->title()) ?></h1>
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
                <form method="post" action=<?php echo 'post&id=' . $user->id(); ?> >
                    <button type="submit" class="btn btn-primary" value="edit" name="edit">Editer</button>
                    <button type="submit" class="btn btn-danger" value="delete" name="delete">Supprimer</button>
                </form>
            </div>
            <div>
                <div class="post-preview">
                    <h3 class="post-subtitle"><?= htmlspecialchars($user->header()) ?></h3>
                    <p><?= htmlspecialchars($user->content()) ?></p>
                    <p class="post-meta">
                    <?php
                    $has = $user->editedAt();
                    if (isset($has)) : ?>
                        Edité le : <?= htmlspecialchars(date('d-m,  Y', strtotime($user->editedAt()))) ?>
                    <?php else : ?>
                        Crée le : <?= htmlspecialchars(date('d-m,  Y', strtotime($user->createdAt()))) ?>
                    <?php endif; ?>
                    </p>

                </div>
            </div>
                <h2 class="py-5">Créer un nouveau commentaire</h2>
                <form method="post" action="/?action=posts" class="pb-5">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Commentaire :</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Creer</button>
                </form>
        </div>
    </div>
</div>

<?php include_once 'footer.php'?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
