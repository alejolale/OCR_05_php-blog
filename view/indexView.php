<?php $title = 'Blog OpenClassRooms OCR'; ?>
<?php ob_start(); ?>
<?php include_once 'navBar.php'?>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Sergio Prieto</h1>
                    <span class="subheading">Développeur web en alternance</span>
                    <img class="img-thumbnail mt-5 w-25 " src="../src/assets/images/myPhoto.png" alt="Sergio prieto photo">
                    <h2 class="mt-4">Chargé de construire vos rêves tech 🧑‍💻</h2>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php include_once 'posts.php'?>
            <!-- Pager-->
            <div class="clearfix"><a class="btn btn-primary float-right" href=<?php echo '/?action=posts' ?>>Voir les posts →</a></div>
        </div>
    </div>
</div>
<hr />

<?php include_once 'contactForm.php' ?>
<hr />
<div class="container">
    <div class="row flex-column col-lg-8 col-md-10 mx-auto">
        <div class="align-self-center">
            <lottie-player src="https://assets5.lottiefiles.com/private_files/lf30_BX96aR.json"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop autoplay></lottie-player>
        </div>
        <a href="#" class="text-md-center">Colsulter mon CV</a>
    </div>
</div>

<?php include_once 'footer.php'?>

<?php $content= ob_get_clean(); ?>

<?php require('template.php'); ?>
