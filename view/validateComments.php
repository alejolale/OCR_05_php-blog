<h3 class="py-5">Validation des commentaires</h3>
<br>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Prénom</th>
      <th scope="col">Commentaire</th>
      <th scope="col">Validation</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach ($disableComments as $comment) {
            ?>
          <tr>
              <th scope="row"><?= htmlspecialchars(date('d/m/Y', strtotime($comment->createdAt()))) ?></th>
              <td><?= htmlspecialchars($comment->userName()) ?></td>
              <td><?= htmlspecialchars($comment->content()) ?></td>
              <td class="d-flex flex-row align-items-center">
                  <button type="button" id="submit" data-id="<?= $comment->id() ?>" data-postId="<?= $comment->publicationId() ?>" class="btn btn-primary approve" value="approve" data-toggle="modal" data-target="#deleteModal">
                          Valider
                  </button>
                  <span type="button" id="submit" data-id="<?= $comment->id() ?>" data-postId="<?= $comment->publicationId() ?>" class="fa-stack fa-lg text-danger trash" value="delete" data-toggle="modal" data-target="#deleteModal" >
                      <i class="fas fa-trash fa-stack-1x "></i>
                  </span>

              </td>
          </tr>
      <?php } ?>
  </tbody>
</table>

<!-- Modal -> use Jquery to change values -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Suppresion du commentaire</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="exampleModalcontent" class="modal-body">
                Valider la suppresion du commentaire ?
            </div>
            <div class="modal-footer">
                <form id="comentaryForm" method="post" >
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="deletebtn btn btn-danger">Supprimer</button>
                    <input type="hidden" value="">
                </form>
            </div>
        </div>
    </div>
</div>
