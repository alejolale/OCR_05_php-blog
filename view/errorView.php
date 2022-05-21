<?php $title = 'Erreur - Blog OpenClassRooms OCR'; ?>

<?php ob_start(); ?>
<?php include_once 'navBar.php' ?>
    <!-- Page Header-->
    <header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1><?php echo($error) ?? 'Error' ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <p><a class=" nav-link pointer-event " href="index.html">Retourner</a></p>
            </div>
        </div>
    </div>

<?php include_once 'footer.php'?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>