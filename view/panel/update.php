
<!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
              <br>
              <h1>Modification de mon compte</h1>
              <br>
            </div>
        </div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-12">
        <div class="card-box">

            <h4 class="header-title m-t-0 m-b-30">Compte Utilisateur</h4>
            <?php if (isset($err)) { ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $err; ?>
              </div>
            <?php } ?>
            <form method="post" action="index.php?c=utilisateur&act=updated" data-parsley-validate novalidate>
                <div class="form-group">
                    <label for="nom">Mon nom*</label>
                    <input type="text" name="nom" required
                           placeholder="Votre nom" class="form-control" id="nom"
                           <?php if (isset($nom) && !empty($nom)) echo "value = \"$nom\"";?>>
                </div>
                <div class="form-group">
                    <label for="prenom">Mon prénom*</label>
                    <input type="text" name="prenom" required
                           placeholder="Votre prénom" class="form-control" id="prenom"
                           <?php if (isset($prenom) && !empty($prenom)) echo "value = \"$prenom\"";?>>
                </div>
                <div class="form-group">
                    <label for="email">Mon adresse email</label>
                    <input type="email" name="email" parsley-type="email" required readonly
                           placeholder="Votre adresse email" class="form-control" id="email"
                           <?php if (isset($email) && !empty($email)) echo "value = \"$email\"";?>>
                </div>
                <div class="form-group">
                    <label>Numéro de téléphone</label>
                        <input data-parsley-type="number" type="text" name = "telephone"
                               class="form-control" placeholder="Votre numéro (uniquement des chiffres)"
                               <?php if (isset($telephone) && !empty($telephone)) echo "value = \"$telephone\"";?>>
                    </div>

                <div class="form-group">
                    <label>Adresse (bureau)</label>
                        <input type="text" class="form-control" name = "adresse"
                               data-parsley-maxlength="100" placeholder="Votre adresse (100 caractères maximum)"
                               <?php if (isset($adresse) && !empty($adresse)) echo "value = \"$adresse\"";?>>
                </div>

                <?php if (Session::is_admin() && isset($active)) { ?>
                  <div class="form-group">
                      <div class="checkbox">
                          <input id="active" type="checkbox" <?php if (!empty($active) && $active != false) echo "checked"; ?>>
                          <label for="active">Compte activé</label>
                      </div>
                  </div>
                <?php } ?>

                <div class="form-group text-right m-b-0">
                    <button class="btn btn-rounded btn-success waves-effect waves-light" type="submit">
                        Modifier mon compte
                    </button>
                    <a type="reset" href = "./index.php?act=details&c=utilisateur" class="btn btn-rounded btn-secondary waves-effect waves-light m-l-5">
                        Annuler les modifications
                    </a>
                </div>

            </form>
        </div>
    </div><!-- end col -->
</div>
