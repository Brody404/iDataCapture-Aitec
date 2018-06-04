<!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
              <br>
              <h1>Mon compte utilisateur</h1>
              <br>
            </div>
        </div>
<!-- end page title end breadcrumb -->


        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Informations générales du compte</b></h4>
                    <p class="text-muted m-b-30 font-14">
                      <?php if (isset($msg)) { ?>
                        <div class="alert alert-info" role="alert">
                          <?php echo $msg; ?>
                        </div>
                      <?php }else{
                              echo "Vous trouverez ici toutes les informations relatives à votre compte utilisateur.";
                       } ?>
                    </p>

                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Nom :</label>
                                        <div class="col-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user-circle"></i></span>
                                                <p class="form-control input-lg"><?php if (isset($nom) && !is_null($nom) && !empty($nom)) echo $nom; else echo "Nom introuvable.";?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Prenom :</label>
                                        <div class="col-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user-circle-o"></i></span>
                                                <p class="form-control input-lg"><?php if (isset($prenom) && !is_null($prenom) && !empty($prenom)) echo $prenom; else echo "Prénom introuvable.";?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Email :</label>
                                        <div class="col-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                <p class="form-control input-lg"><?php if (isset($email) && !is_null($email) && !empty($email)) echo $email; else echo "Email introuvable.";?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Téléphone :</label>
                                        <div class="col-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                <p class="form-control input-lg"><?php if (isset($telephone) && !is_null($telephone) && !empty($telephone)) echo $telephone; else echo "Aucun numéro disponible.";?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Adresse :</label>
                                        <div class="col-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                                <p class="form-control input-lg"><?php if (isset($adresse) && !is_null($adresse) && !empty($adresse)) echo $adresse; else echo "Aucune adresse disponible.";?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Abonnement :</label>
                                        <div class="col-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-trophy"></i></span>
                                                <p class="form-control input-lg"><?php if (isset($type)) echo "<a href=\"./index.php?act=abonnement&c=utilisateur\">".$type."</a>"; else echo "Abonnement introuvable.";?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Nombre de formulaires créés :</label>
                                        <div class="col-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                                <p class="form-control input-lg"><?php if (isset($form_number) && isset($nb_form))
                                                        echo $nb_form . " / " . $form_number;
                                                      else
                                                        echo "Aucune information disponible ...";
                                                ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Nombre de formulaires complétés :</label>
                                        <div class="col-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-check-square"></i></span>
                                                <p class="form-control input-lg"><?php if (isset($form_complete))
                                                        echo $form_complete;
                                                      else
                                                        echo "Aucune information disponible ...";
                                                ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Date d'inscription :</label>
                                        <div class="col-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa fa-calendar-check-o"></i></span>
                                                <p class="form-control input-lg"><?php if (isset($date_i))
                                                        echo $date_i;
                                                      else
                                                        echo "Aucune information disponible ...";
                                                ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Dernière mise à jour :</label>
                                        <div class="col-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa fa-calendar-check-o"></i></span>
                                                <p class="form-control input-lg"><?php if (isset($date_maj))
                                                        echo $date_maj;
                                                      else
                                                        echo "Aucune information disponible ...";
                                                ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <a href="./index.php?act=update&c=utilisateur" type="button" class="btn btn-block btn-success btn-rounded"><i class="fa fa-edit"></i> Modifier mon compte</a>
                                    <br>
                                   <form class="form-inline" method = "post" action = "./index.php?act=delete&c=utilisateur">
                                    <div class="form-group mx-sm-3">
                                      <label class="sr-only">Password</label>
                                      <input name = "mdp" type="password" class="form-control" placeholder="Mot de passe">
                                    </div>
                                    <button type="submit" onclick = "return confirm('Êtes-vous sûr ?')" class="btn btn-rounded btn-danger">Supprimer mon compte</button>
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
