<?php $title = 'Signup - Blog OpenClassRooms OCR'; ?>

<?php ob_start(); ?>
<?php include_once 'navBar.php' ?>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Inscription au blog</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content-->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php  if (!isset($user)) : ?>
                <form class="row flex-column justify-content-end" method="post" action="/?action=signup">

                    <?php if (isset($message)) : ?>
                        <div class="alert alert-warning" role="alert">
                            <?php echo($message); ?>
                        </div>
                    <?php endif; ?>

                    <div class="row justify-content-between">
                        <label  for="firstname">Votre prénom : </label>
                        <input class="col-lg-6" id="firstname" name="firstname" required type="text" />
                    </div>

                    <div class="row justify-content-between mt-4">
                        <label  for="lastname">Votre nom : </label>
                        <input class="col-lg-6" id="lastname" name="lastname" required type="text" />
                    </div>

                    <div class="row justify-content-between mt-4">
                        <label  for="email">Votre adresse Email : </label>
                        <input class="col-lg-6" id="email" name="email" required type="email" />
                    </div>

                    <div class="row justify-content-between mt-4">
                        <label for="password" >Mot de passe : </label>
                        <input class="col-lg-6" id="password" name="password" required type="password" />
                    </div>

                    <div class="row justify-content-between mt-4">
                        <label for="passwordConfirmation" >Confirmez mot de passe : </label>
                        <input class="col-lg-6" id="passwordConfirmation" name="passwordConfirmation" required type="password" />
                    </div>

                    <div class="mx-auto mt-3 text-center">
                        <div class="mt-3"><input type="submit" class="btn btn-primary align-self-center" value="S'inscrire →" /></div>
                        <p><a class="nav-link pointer-event" href=<?php echo '/?action=login' ?>>Login</a></p>
                    </div>
                </form>
            <?php else : ?>
                <div class="alert alert-success" role="alert">
                    Bonjour <?php htmlspecialchars($user->firstname()); ?> et bienvenue sur le site !
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once 'footer.php'?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>



