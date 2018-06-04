<div class="row">
    <div class="col-12">
        <div class="card-box" <?php if (isset($data['bg_pic'])) echo "style = \"background-image:".$data['bg_pic']."\";"?>>
            <h4 class="m-t-0 header-title">Création d'un formulaire (étape 3)</h4>
            <br>
            <?php if(isset($err)) { ?>
              <div class="alert alert-danger" role="alert" style = "background-color:#F8000080; color:white;">
                <b><?php echo $err;?><b>
              </div>
            <?php } ?>

            <div class="card-box sm" style = "background-color : white">
              <p class="m-b-30 font-14">
                <ul>
                  <li>Dans cette section, vous n'êtes pas obligé de définir un ordre sur les champs, ni leur taille maximum</li>
                  <li>N'oubliez pas cependant de remplir tout les champs correctement !</li>
                  <li>Respectez également les limitations de caractères !</li>
                </ul>
              </p>
            </div>
            <?php if (isset($titre)) echo "<h1>".$titre."</h1>";?>
            <?php if (isset($description)) echo "<p>".$description."</p>"; ?>
            <br>
            <div class="row">
                <div class="col-xl-12">
                  <?php if (isset($tab_secti) && isset($tab_desc) && isset($tab_field) && !empty($tab_field) && !empty($tab_desc) && !empty($tab_secti)) {
                    $speciaux = array('&amp;','$quot;',"'",'&#039','&apos;','&lt;','$gt;',' '); // Définition des caractère spéciaux à éviter
                    ?>
                    <form class="form-horizontal" role="form" method = "post" action = "./index.php?act=finalize&c=form">
                      <?php for ($p = 1; $p <= count($tab_id_section); $p++) { ?>
                            <input name = "secti<?=$p?>" value = "<?=$tab_id_section[$p]?>" type="hidden">
                      <?php } ?>
                      <?php for ($p = 1; $p <= count($tab_field); $p++) { ?>
                            <input name = "field<?=$p?>" value = "<?=$tab_field[$p]?>" type="hidden">
                      <?php } ?>
                      <input name = "formId" value = "<?=$formId?>" type="hidden">

                                              <div class="row">
                                                  <div class="col-xl-12">

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
                                                          $section = str_replace($speciaux,"",$tab_secti[$i]); ?>

                                                          <div role="tabpanel" class="tab-pane fade show" id="<?php echo $i.$section;?>">

                                                              <div class="col-xl-12 mt-md-3">

                                                                <div id = "<?php echo "accordion".$i;?>" role="tablist" aria-multiselectable="true" class="m-b-30">

                                                                <?php for ($j = 1; $j <= $tab_field[$i]; $j++) { ?>

                                                                  <div class="card">
                                                                    <!-- PARTIE HEADER -->
                                                                    <div class="card-header" role="tab" id="<?php echo "heading".$j.$i.$section;?>">
                                                                      <h5 class="mb-0 mt-0">
                                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion<?=$i?>" href="#<?php echo "collapse".$j.$i.$section;?>" aria-expanded="false" aria-controls="<?php echo "collapse".$j.$i.$section;?>">
                                                                          Champ #<?=$j?>
                                                                        </a>
                                                                      </h5>
                                                                    </div>
                                                                    <!-- FIN PARTIE HEADER
                                                                    DEBUT PARTIE CONTENU -->

                                                                    <div id="<?php echo "collapse".$j.$i.$section;?>" class="collapse" role="tabpanel" aria-labelledby="<?php echo "heading".$j.$i.$section;?>">
                                                                     <div class="card-body">

                                                                       <!-- CONTENU -->
                                                                       <div class="form-group row">
                                                                           <label class="col-2 col-form-label">Nom du champ :</label>
                                                                           <div class="col-10">
                                                                               <input type="text" name = "<?php echo $i.$j."nom";?>" class="form-control" placeholder="Le nom de votre champ">
                                                                           </div>
                                                                       </div>

                                                                       <div class="form-group row">
                                                                           <label class="col-2 col-form-label">Ce champ est-il obligatoire ?</label>
                                                                           <div class="col-10">
                                                                             <input name = "<?php echo $i.$j."required";?>" id="<?php echo "checkbox".$j.$i.$section;?>" type="checkbox" value = "on">
                                                                             <label for="<?php echo "checkbox".$j.$i.$section;?>">
                                                                                 La complétion de ce champ est obligatoire
                                                                             </label>
                                                                           </div>
                                                                       </div>

                                                                       <div class="form-group row">
                                                                           <label class="col-2 col-form-label">Type de champ :</label>
                                                                           <div class="col-10">
                                                                             <?php if (!empty($field_type)) { ?>
                                                                               <select name = "<?php echo $i.$j."type";?>" class="form-control">
                                                                                 <?php foreach($field_type as $field) {
                                                                                   echo "<option>".$field->get('type_name')."</option>";
                                                                                   } ?>
                                                                               </select>
                                                                             <?php }else{ ?>
                                                                               <input type="text" class="form-control" placeholder="Le type de votre champ">
                                                                             <?php } ?>
                                                                           </div>
                                                                       </div>

                                                                       <div class="form-group row">
                                                                           <label class="col-2 col-form-label">Valeur par défaut du champ :</label>
                                                                           <div class="col-10">
                                                                             <input name = "<?php echo $i.$j."defaut";?>" type="text" class="form-control" placeholder="La valeur par défaut de votre champ">
                                                                             <span class="help-block"><small>Vous n'êtes pas obligé de définir cet attribut, vous pouvez le laisser vide.</small></span>
                                                                           </div>
                                                                       </div>

                                                                       <div class="form-group row">
                                                                           <label class="col-2 col-form-label">Taille maximal champ :</label>
                                                                           <div class="col-10">
                                                                             <input class="form-control" min = "1" type="number" name = "<?php echo $i.$j."taille";?>">
                                                                             <span class="help-block"><small>Si votre champ est de type textuel, vous êtes libre de définir sa taille si vous le souhaiter.</small></span>
                                                                           </div>
                                                                       </div>

                                                                       <div class="form-group row">
                                                                           <label class="col-2 col-form-label">Ordre du champ :</label>
                                                                           <div class="col-10">
                                                                             <select name = "<?php echo $i.$j."ordre";?>" class="form-control">
                                                                             <?php for ($y = 1; $y <= $tab_field[$i]; $y++) {
                                                                               echo "<option>".$y."</option>";
                                                                             } ?>
                                                                             </select>
                                                                           </div>
                                                                       </div>

                                                                       <div class="form-group row">
                                                                           <label class="col-2 col-form-label">Valeurs possible du champ :</label>
                                                                           <div class="col-10">
                                                                             <select name = "<?php echo $i.$j."valeurs[]";?>" size = "7" multiple data-role="tagsinput">
                                                                            </select>
                                                                            <span class="help-block"><small>Maximum 7 valeurs.</small></span>
                                                                            <span class="help-block"><small>Si votre champ est un sélecteur, vous pouvez insérer les valeurs ici en cliquant sur "Entrée" à chaque fois qu'une valeur est saisie.</small></span>
                                                                           </div>
                                                                       </div>

                                                                      <!-- FIN DU CONTENU -->

                                                                     </div>
                                                                    </div>
                                                                    <!-- FIN PARTIE CONTENU -->

                                                                  </div> <!-- fin de card -->

                                                                <?php } ?>

                                                                </div> <!-- fin de l'accordion -->

                                                              </div> <!-- fin de col-xl-12 -->

                                                          </div>

                                                        <?php } ?>


                                                  </div> <!-- fin tab content -->

                                                </div> <!-- fin de col-xl-12 -->
                                              </div> <!-- fin de row -->

                    <button class="btn btn-rounded btn-danger waves-effect waves-light" onclick = "return confirm('Êtes-vous sûr ?')">
                        Revenir à l'étape précédente
                    </button>
                    <button class="btn btn-rounded btn-info waves-effect waves-light" onclick = "return confirm('Êtes-vous sûr ?')" type="submit">
                      Terminer mon formulaire
                    </button>

                  </form>
                  <?php } ?>

                </div>
            </div>
            <!-- end row -->

        </div> <!-- end card-box -->
    </div><!-- end col -->
</div>
