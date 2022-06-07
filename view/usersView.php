<?php $title = 'Utilisateurs'; ?>

<?php ob_start(); ?>
<?php include_once 'navBar.php'?>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../src/assets/images/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Utilisateurs</h1>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content-->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Validation</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user) {
                    ?>
                    <tr>
                        <td>
                            <a href=<?php echo '/?action=user&id=' . $user->id() ?> >
                               <?= htmlspecialchars($user->firstname()) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($user->lastname()) ?></td>
                        <td class="d-flex flex-row align-items-center">
                            <?php if ($user->confirmed() === 0) : ?>
                            <button type="button" id="submit" data-id="<?= $user->id() ?>" class="btn btn-primary approve" value="confirm" data-toggle="modal" data-target="#exampleModal">
                                Valider
                            </button>
                            <?php else : ?>
                            Validé
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Validation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Valider l'utilisateur ?
            </div>
            <div class="modal-footer">
                <form method="post" action=<?php echo '/?action=userValidation&id=' . $user->id() ?> >
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">valider</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'?>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>



