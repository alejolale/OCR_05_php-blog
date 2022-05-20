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
                    <h1>Mon profil</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content-->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php if (isset($message)) : ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo($message); ?>
                </div>
            <?php endif; ?>

            <h3 class="mt-5 ml-0">Modifier Profil</h3>
            <form class="row flex-column justify-content-end mt-5" method="post" action="/?action=accountEdition">
                <input type="hidden" value="account" name="account">
                <div class="row justify-content-between">
                    <label for="firstname">Prénom : </label>
                    <input class="col-lg-6" id="firstname" name="firstname" required type="text" value="<?= $firstname ?>" />
                </div>

                <div class="row justify-content-between mt-4">
                    <label for="lastname" >Nom : </label>
                    <input class="col-lg-6" id="lastname" name="lastname" required type="text" value="<?= $lastname ?>" />
                </div>

                <div class="mx-auto mt-5 text-center">
                    <div class="mt-3"><input type="submit" class="btn btn-primary align-self-center"  value="Modifier profil →" /></div>
                </div>
            </form>
        </div>

        <div class="col-lg-8 col-md-10 mx-auto mt-5">
            <h3 class="mt-5">Modifier mon mot de passe</h3>
            <form class="row flex-column justify-content-end mt-5" method="post" action="/?action=accountEdition">
                <input type="hidden" value="passwordEdition" name="passwordEdition">
                <div class="row justify-content-between">
                    <label for="password">Mot de passe actuel : </label>
                    <input class="col-lg-6" id="password" name="password" required type="password" />
                </div>

                <div class="row justify-content-between mt-4">
                    <label for="new" >Nouveau mot de passe : </label>
                    <input class="col-lg-6" id="new" name="new" required type="password" />
                </div>

                <div class="row justify-content-between mt-4">
                    <label for="confirmation" >Confirmation : </label>
                    <input class="col-lg-6" id="confirmation" name="confirmation" required type="password" />
                </div>

                <div class="mx-auto mt-5 text-center">
                    <div class="mt-3"><input type="submit" class="btn btn-primary align-self-center"  value="Modifier mot de passe →" /></div>
                </div>
            </form>
            <?php if (($userType === 'admin')) : ?>
                <div class="mx-auto mt-3 text-center">
                    <div class="mt-3 w-full"><a href="<?= '/?action=users' ?>" class="align-self-start">Voir tous les utilisateurs</a></div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include_once 'footer.php'?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>



