<?php if (isset($tab_secti) && isset($tab_desc) && isset($tab_field) && !empty($tab_field) && !empty($tab_desc) && !empty($tab_secti)) {
  $speciaux = array('&amp;','$quot;',"'",'&#039','&apos;','&lt;','$gt;',' '); // Définition des caractère spéciaux à éviter
  ?>

  <form class="form-horizontal" role="form" method = "post" action = "./index.php?act=etape4&c=form">
          <input name = "secti_number" value = <?=$secti_number?> type="hidden">

            <ul class="nav nav-tabs nav-justified">
              <?php for ($x = 1; $x <= count($tab_secti); $x++) {
                $section = str_replace($speciaux,"",$tab_secti[$x]);?>
                    <li class="nav-item">
                        <a href="#<?php echo $x.$section;?>" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <?php echo $tab_secti[$x]; ?>
                        </a>
                    </li>
               <?php } ?>
             </ul>

            <div class="tab-content">
            <?php for ($i = 1; $i <= count($tab_secti); $i++) {
              echo "<strong> JE SUIS EN $i</strong>";
              $section = str_replace($speciaux,"",$tab_secti[$i]); ?>
              <div role="tabpanel" class="tab-pane fade active show" id = "<?php echo $i.$section;?>">

                <div id="accordion<?php echo $i.$section;?>" role="tablist" aria-multiselectable="true" class="m-b-30">


                    <?php for ($j = 1; $j <= $tab_field[$i]; $j++) {
                      echo "<strong> JE SUIS EN $j</strong>"; ?>
                      <div class="card">

                      <div class="card-header" role="tab" id = "<?php echo "Heading".$j.$i.$section;?>">
                        <h5 class="mb-0 mt-0">
                           Champ #<?=$j?>
                        <a data-toggle="collapse" data-parent="#accordion<?php echo $i.$section;?>" href="#<?php echo "collapse".$j.$i.$section;?>" class="text-dark collapsed" aria-expanded="false" aria-controls="<?php echo "collapse".$j.$i.$section;?>">
                        </a>
                        </h5>
                      </div>

                     <div id="<?php echo "collapse".$j.$i.$section;?>" class="collapse" role="tabpanel" aria-labelledby="<?php echo "Heading".$j.$i.$section;?>">
                      <div class="card-body">

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Nom du champ :</label>
                            <div class="col-10">
                                <input type="text" class="form-control" placeholder="Le nom de votre champ">
                            </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-2 col-form-label">Type de champ :</label>
                          <div class="col-10">
                                <?php if (!empty($field_type)) { ?>
                                  <select class="form-control">
                                    <?php foreach($field_type as $field) {
                                      echo "<option>".$field->get('type_name')."</option>";
                                      } ?>
                                  </select>
                                <?php }else{ ?>
                                  <input type="text" class="form-control" placeholder="Le type de votre champ">
                                <?php } ?>
                          </div>
                        </div>

                        <div class="form-check">
                          <div class="checkbox">
                              <input id="<?php echo "checkbox".$j.$i.$section;?>" type="checkbox">
                              <label for="<?php echo "checkbox".$j.$i.$section;?>">
                                  La complétion de ce champ est obligatoire
                              </label>
                          </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Valeur par défaut :</label>
                            <div class="col-10">
                                <input type="text" class="form-control" placeholder="La valeur par défaut de votre champ">
                                <span class="help-block"><small>Vous n'êtes pas obligé de définir cet attribut, vous pouvez le laisser vide.</small></span>
                            </div>
                        </div>


                        <div class="form-group row">
                          <label class="col-2 col-form-label">Taille maximal du champ :</label>
                          <div class="col-md-10">
                            <input class="form-control" type="number" name="number">
                            <span class="help-block"><small>Si votre champ est de type textuel, vous êtes libre de définir sa taille si vous le souhaiter.</small></span>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-2 col-form-label">Classement du champ :</label>
                          <div class="col-10">
                            <select class="form-control">
                            <?php for($i = 1; $i <= $tab_field[$i]; $i++) {
                              echo "<option>".$i."</option>";
                            } ?>
                            </select>
                          </div>
                        </div>

                      </div> <!-- fin de card-body -->

                     </div>

                   <?php } ?>
                 </div>

                </div>

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
      <?php } ?>
