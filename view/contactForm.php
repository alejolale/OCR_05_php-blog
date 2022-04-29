<div id="contact" class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="section-heading">Toujours disponible à vous écouter ☕</div>
            <span>Il faut juste nous donner quelques données pour vous contacter</span>
            <form id="contact-form" class="mt-5" action="/?action=contact" method="post">
                <label class="form-check-label " for="lastname">Nom :</label>
                <input class="form-control w-75" id="lastname" name="lastname" type="text" required>
                <label class="form-check-label mt-3" for="firstname">Prénom :</label>
                <input class="form-control w-75" id="firstname" name="firstname" type="text" required>
                <label class="form-check-label mt-3" for="email">Email :</label>
                <input class="form-control w-75" id="email" name="email" type="email" required>
                <label class="form-check-label mt-3" for="message">Votre message :</label>
                <textarea class="form-control w-75"  name="message" id="message" rows="5" required></textarea>
                <button type="submit" class="mt-3 w-75 form-control btn-primary ">Envoyer</button>
            </form>
        </div>
    </div>
</div>