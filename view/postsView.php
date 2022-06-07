<?php $title = 'Blog OpenClassRooms OCR || posts'; ?>
<?php ob_start(); ?>
<?php include_once 'navBar.php'?>

<!-- Page Header-->
<header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Posts</h1>
                    <?php if ($confirmed === 1) : ?>
                        <a class="nav-link text-white underlined" href=<?php echo '/?action=myPosts' ?>><u>Consulter mes publications</u></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- TODO get last posts to display -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php if (isset($message)) : ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo($message); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($hasSession) && $confirmed) : ?>
                <h2 class="py-5">Créer un nouveau post</h2>
                <form id="publication-form" method="post" action="/?action=postCreation" class="pb-5">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre du post :</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Titre.." required>
                    </div>
                    <div class="mb-3">
                        <label for="header" class="form-label">Entête du post :</label>
                        <input type="text" class="form-control" id="header" name="header" placeholder="Entête.." required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu :</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                    </div>
                    <button type="submit" id="publicationPost" class="btn btn-primary">Creer nouveau post</button>
                </form>
            <?php endif; ?>
            <?php include_once 'posts.php' ?>
        </div>
    </div>
</div>

<?php include_once 'footer.php'?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>