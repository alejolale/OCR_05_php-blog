<?php $title = 'OCR_reponse'; ?>
<?php ob_start(); ?>
<?php include_once 'navBar.php'; ?>

<header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h3><?php echo "$responseMessage" ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>

<?php
    if (!empty($errors)) {
        include_once 'contactForm.php';
    }
?>

<div class="col-lg-8 col-md-10 mx-auto">
    <a href="index.html" class="mt-3 border-primary text-primary ">Retourner</a>
</div>


<?php include_once 'footer.php'?>

<?php $content= ob_get_clean(); ?>

<?php require('template.php'); ?>
