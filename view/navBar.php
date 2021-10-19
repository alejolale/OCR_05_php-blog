<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.html">OCR_blog</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.html">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">A propos</a></li>
                <li class="nav-item"><a class="nav-link" href="post.html">Posts</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                <!--TODO add logout on auth user-->
                <li class="nav-item"><a class="nav-link" href=<?php echo '/?action=login' ?>>Se connecter</a></li>
            </ul>
        </div>
    </div>
</nav>