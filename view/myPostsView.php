<?php $title = 'My posts'; ?>
<?php ob_start(); ?>
<?php include_once 'navBar.php'?>

<!-- Page Header-->
<header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Mes posts</h1>
                </div>
            </div>
        </div>
    </div>
</header>


<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php if (isset($message)) : ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo($message); ?>
                </div>
            <?php endif; ?>

            <div>
                <?php if(isset($posts) && count($posts) > 0 ): ?>
                <?php
                foreach ($posts as $post) {
                    ?>
                    <div class="post-preview">
                        <a href=<?php echo '/?action=post&id='.$post->id() ?>>
                            <h2 class="post-title"><?= htmlspecialchars($post->title()) ?></h2>
                            <h3 class="post-subtitle"><?= htmlspecialchars($post->header()) ?></h3>
                        </a>
                    </div>
                    <hr />
                <?php } ?>
                <?php endif; ?>


            </div>

        </div>
    </div>
</div>

<?php include_once 'footer.php'?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
