<?php $title = 'Login - Blog OpenClassRooms OCR'; ?>

<?php ob_start(); ?>
<?php include_once 'navBar.php' ?>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Connexion</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content-->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php if (!$hasUser) : ?>
            <form class="row flex-column justify-content-end" method="post" action="/?action=login">

                <?php if (isset($message)) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?= $message ?>
                    </div>
                <?php endif; ?>

                <div class="row justify-content-between">
                    <label  for="email">Email : </label>
                    <input class="col-lg-6" id="email" name="email" required type="email" />
                </div>

                <div class="row justify-content-between mt-4">
                    <label for="password" >Mot de passe : </label>
                    <input class="col-lg-6" id="password" name="password" required type="password" />
                </div>

                <div class="mx-auto mt-3 text-center">
                    <div class="mt-3"><input type="submit" class="btn btn-primary align-self-center"  value="Login →" /></div>
                    <a class="nav-link pointer-event mt-3" href=<?php echo '/?action=signup' ?>>S'inscrire</a>
                </div>
            </form>
            <?php else : ?>
                <div class="alert alert-success" role="alert">
                    Bonjour <?= $firstname ?>, bienvenue sur le site !
                </div>
                <div class="mx-auto mt-3 text-center">
                    <div class="mt-3 w-full"><a href="<?= '/?action=posts' ?>" class="btn btn-primary align-self-center">Voir toutes les publications →</a></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once 'footer.php'?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>



