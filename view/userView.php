<?php $title = 'User'; ?>

<?php ob_start(); ?>

<?php include_once 'navBar.php'?>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>User</h1>
                    <span class="subheading">A Blog Theme by Start Bootstrap</span>
                     <p>
                         <strong><?= htmlspecialchars($user->firstname()) ?></strong>  <?= htmlspecialchars($user->lastname()) ?>
                     </p>
                </div>
            </div>
        </div>
    </div>
</header>

<?php include_once 'footer.php'?>

<?php $content= ob_get_clean(); ?>

<?php require('template.php'); ?>



