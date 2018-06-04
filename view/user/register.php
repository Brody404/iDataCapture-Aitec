<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Création de compte</h4>
    </div>
</div>

<?php if (isset($err)) { ?>
  <div class="alert alert-danger" role="alert">
    <?php echo $err; ?>
  </div>
<?php } ?>

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Créer un compte</div>
      <div class="card-body">
        <form method="post" action="index.php?c=utilisateur&act=created">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Prénom*</label>
                <input class="form-control" type="text" maxlength="25" placeholder="Votre prénom"
                <?php if(isset($nom) && !empty($nom)) echo "value=\"$nom\""?> name = "nom">
              </div>
              <div class="col-md-6">
                <label>Nom*</label>
                <input class="form-control" type="text" maxlength="25" placeholder="Votre nom"
                <?php if(isset($prenom) && !empty($prenom)) echo "value=\"$prenom\""?> name = "prenom">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Adresse email*</label>
            <input class="form-control" maxlength="50" type="email" placeholder="Votre adresse email"
            <?php if(isset($email) && !empty($email)) echo "value=\"$email\""?> name = "email">
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Mot de passe*</label>
                <input class="form-control" type="password" maxlength="20" placeholder="Votre mot de passe" name = "mdp1">
                <span class="help-block"><small>Maximum 20 caractères.</small></span>
              </div>
              <div class="col-md-6">
                <label>Confirmation du mot de passe*</label>
                <input class="form-control" type="password" maxlength="20" placeholder="Confirmez votre mot de passe" name = "mdp2">
                <span class="help-block"><small>Doit correspondre au premier mot de passe.</small></span>
              </div>
            </div>
          </div>

          <div class="form-group">
              <label>Numéro de téléphone (facultatif)</label>
                  <input data-parsley-type="number" type="text" name = "telephone"
                         class="form-control" placeholder="Votre numéro"
                         <?php if (isset($telephone) && !empty($telephone)) echo "value = \"$telephone\"";?>>
              </div>

          <div class="form-group">
              <label>Adresse (facultative)</label>
                  <input type="text" class="form-control" name = "adresse"
                         maxlength="100" placeholder="Votre adresse"
                         <?php if (isset($adresse) && !empty($adresse)) echo "value = \"$adresse\"";?>>
                  <span class="help-block"><small>Ne doit pas dépasser les 100 caractères.</small></span>
          </div>

          <input class="btn btn-primary btn-block" type = "submit" value = "Créer mon compte">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="./index.php?c=utilisateur&act=connect"><i class="fa fa-user-circle"></i> Me connecter</a>
        </div>
        <div class="form-group m-t-30 mb-0">
            <div class="col-sm-12">
                <a href="./index.php?c=utilisateur&act=recuperation" class="text-muted"><i class="fa fa-lock m-r-5"></i> J'ai oublié mon mot de passe</a>
            </div>
        </div>
      </div>
    </div>
  </div>
