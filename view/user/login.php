<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Connexion</h4>
    </div>
</div>

<?php if (isset($err)) { ?>
  <div class="alert alert-danger" role="alert">
    <?php echo $err; ?>
  </div>
<?php } ?>

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Connexion</div>
      <div class="card-body">
        <form method = "post" action = "index.php?c=utilisateur&act=connected">
          <div class="form-group">
            <label for="exampleInputEmail1">Adresse mail</label>
            <input class="form-control" name = "email" type="email" placeholder="Entrez votre adresse mail">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Mot de passe</label>
            <input class="form-control" name = "mdp" type="password" placeholder="Entrez votre mot de passe">
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox">Se souvenir de moi</label>
            </div>
          </div>
          <input type = "submit" class="btn btn-primary btn-block" value = "Me connecter">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="./index.php?c=utilisateur&act=create"><i class="fa fa-user-circle"></i> Créer un compte</a>
        </div>
        <div class="form-group m-t-30 mb-0">
            <div class="col-sm-12">
                <a href="./index.php?c=utilisateur&act=recuperation" class="text-muted"><i class="fa fa-lock m-r-5"></i> J'ai oublié mon mot de passe</a>
            </div>
        </div>
      </div>
    </div>
  </div>
