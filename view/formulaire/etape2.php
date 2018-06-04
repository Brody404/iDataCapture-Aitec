<div class="row">
    <div class="col-12">
        <div class="card-box" <?php if (isset($data['bg_pic'])) echo "style = \"background-image:".$data['bg_pic']."\";"?>>
            <h4 class="m-t-0 header-title">Création d'un formulaire (étape 2)</h4>
            <br>
            <?php if(isset($err)) { ?>
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

              <h1><?php echo $data['nom'];?></h1>
              <br>
              <p><?php echo $data['description'];?></p>
              <br>
            <div class="row">
                <div class="col-12">
                    <div class="p-20">
                            <?php if (isset($secti_number)) { ?>
                      <form class="form-horizontal" role="form" method = "post" action = "./index.php?act=etape3&c=form">
                              <input name = "secti_number" value = <?=$secti_number?> type="hidden">
                              <input name = "formId" value = <?=$formId?> type="hidden">
                              <input name = "titre" value = "<?=$data['nom']?>" type="hidden">
                              <input name = "descripton" value = "<?php echo $data['description'];?>" type="hidden">

                              <?php for ($i = 1; $i <= $secti_number; $i++) { ?>
                                <h1>Section <?=$i?></h1>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Titre :</label>
                                    <div class="col-10">
                                        <input name = "titre<?=$i?>" maxlength="25" type="text" class="form-control" placeholder="Votre titre">
                                        <span class="help-block"><small>Un titre d'une longueur maximal de 25 caractères.</small></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Description :</label>
                                    <div class="col-10">
                                        <textarea name = "description<?=$i?>" class="form-control" rows="5"></textarea>
                                        <span class="help-block"><small>Description simple mais complète de maximum 5 lignes.</small></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Nombre de champs :</label>
                                    <div class="col-md-10">
                                        <input class="form-control" min = "1" value = "5"
                                        <?php if (Session::is_connected() && isset($field_number) && !empty($field_number) && !is_null($field_number))
                                            echo "max=\"$field_number\""; ?> type="number" name="field_number<?=$i?>">
                                    </div>
                                </div>
                              <?php } ?>
                              <button class="btn btn-rounded btn-danger waves-effect waves-light" onclick = "return confirm('Êtes-vous sûr ?')">
                                Revenir à l'étape précédente
                              </button>
                              <button class="btn btn-rounded btn-info waves-effect waves-light" onclick = "return confirm('Êtes-vous sûr ?')" type="submit">
                                Passer à l'étape suivante
                              </button>
                          </form>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- end card-box -->
    </div><!-- end col -->
</div>
