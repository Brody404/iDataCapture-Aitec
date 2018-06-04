  <div class="row">
      <div class="col-12">
          <div class="card-box" id = "formulaire2">
              <h4 class="m-t-0 header-title">Création d'un formulaire</h4>
              <br>
              <?php
                if (isset($err)) { ?>
                  <div class="alert alert-danger" role="alert" style = "background-color:#F8000080; color:white;">
                    <b><?php echo $err;?><b>
                  </div>
                <?php } ?>

              <div class="card-box sm" style = "background-color : white">
                <p class="m-b-30 font-14">
                  <ul>
                    <li>Suivez correctement les consignes en pour créer efficacement un bon formulaire qui plaira aux personnes qui seront amenés à le remplir !</li>
                    <li>N'oubliez pas de remplir tout les champs correctement !</li>
                    <li>Respectez également les limitations de caractères !</li>
                  </ul>
                </p>
              </div>
              <div class="row">
                  <div class="col-12">
                      <div class="p-20">
                          <form class="form-horizontal" role="form" method = "post" action = "./index.php?act=etape2&c=form">
                              <div class="form-group row">
                                  <label class="col-2 col-form-label">Titre du formulaire :</label>
                                  <div class="col-10">
                                      <input name = "titre" maxlength="25" type="text" class="form-control" placeholder="Votre titre">
                                      <span class="help-block"><small>Un titre d'une longueur maximal de 25 caractères.</small></span>
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <label class="col-2 col-form-label">Description :</label>
                                  <div class="col-10">
                                      <textarea name = "description" class="form-control" rows="5"></textarea>
                                      <span class="help-block"><small>Description simple mais complète de maximum 5 lignes.</small></span>
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <label class="col-2 col-form-label">Nombre de sections :</label>
                                  <div class="col-md-10">
                                      <input class="form-control" min = "1" value = "1"
                                      <?php if (Session::is_connected() && isset($secti_number) && !empty($secti_number) && !is_null($secti_number))
                                          echo "max=\"$secti_number\""; ?> type="number" name="secti_number">
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <label class="col-2 col-form-label">Arrière plan du formulaire</label>
                                  <div class="col-10">
                                      <input type="file" class="form-control-file" onchange = "readURL" name="background-image" id="bg_pic" />
                                  </div>
                              </div>

                              <button class="btn btn-block btn-rounded btn-info waves-effect waves-light" onclick = "return confirm('Êtes-vous sûr ?')" type="submit">
                                Passer à l'étape suivante
                              </button>

                          </form>
                      </div>
                  </div>

              </div>
              <!-- end row -->

          </div> <!-- end card-box -->
      </div><!-- end col -->
  </div>
  <script src="./assets/js/formulaire.js"></script>
