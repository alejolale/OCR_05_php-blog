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
                    <h1>Login</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content-->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <form class="flex-column" method="post" action="#####">
                <label class="" for="email">email</label>
                <input class="col-lg-6" id="email" name="email"  type="email" />

                <label for="password">Mot de passe</label>
                <input class="col-lg-6" id="password" name="password"  type="password" />

                <div class="clearfix mt-3"><input type="submit" class="btn btn-primary align-self-center"  value="Login →" /></div>
            </form>
        </div>
    </div>
</div>

<?php include_once 'footer.php'?>
<?php $content= ob_get_clean(); ?>

<?php require('template.php'); ?>



