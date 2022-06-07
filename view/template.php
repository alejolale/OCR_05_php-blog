<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?= $title ?></title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../styles.css" rel="stylesheet" />

    </head>

    <body>
        <?= $content ?>
    </body>

    <!-- Bootstrap core JS-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script type="text/javascript">

        $(".trash").click(function () {
            const id = $(this).data('id');
            const postId = $(this).attr('data-postId');

            $('#comentaryForm').attr('action','/?action=deleteComment&id='+postId+'&commentId='+id);
        });
        $(".approve").click(function () {
            const id = $(this).data('id');
            const postId = $(this).attr('data-postId');

            $('#exampleModalLabel').text('Confirmation de commentaire');
            $('#exampleModalcontent').text('Valider le commentaire ?');
            $('#comentaryForm').attr('action','/?action=commentConfirmation&id='+postId+'&commentId='+id);
            $('.deletebtn').text('Confirmer').attr('class','btn btn-primary');
        });
    </script>

    <!--tiny-->
    <script src="https://cdn.tiny.cloud/1/hvvk1bhs0xt9xs23nc1cryvwg9zrh7xog4inbn3psrgup3nj/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea#message',  //Change this value according to your HTML
            auto_focus: 'element1',
            width: "100%",
            height: "200"
        });

        tinymce.init({
            selector: 'textarea#content',  //Change this value according to your HTML
            auto_focus: 'element1',
            width: "100%",
            height: "200"
        });

        tinymce.init({
            selector: 'textarea#comment',  //Change this value according to your HTML
            auto_focus: 'element1',
            width: "100%",
            height: "200"
        });

        $( document ).ready(function() {
            $('#contactPost').on("click", function(){
                tinyMCE.triggerSave();
                document.getElementById("contact-form").submit();
                return false;
            });

            $('#publicationPost').on("click", function(){
                tinyMCE.triggerSave();
                document.getElementById("publication-form").submit();
                return false;
            });

            $('#postComment').on("click", function(){
                tinyMCE.triggerSave();
                document.getElementById("comment-form").submit();
                return false;
            });
        });
    </script>
</html>

