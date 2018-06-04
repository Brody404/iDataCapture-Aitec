                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Liste des abonnements</h4>
                    </div>
                </div>

                <?php if (isset($err)) { ?>
                  <div class="alert alert-danger" role="alert">
                    <?php echo $err; ?>
                  </div>
                <?php } ?>

                <div class="row">
                    <div class="col-xl-8 offset-xl-2">
                        <div class="row">

                          <?php if (isset($abonnements)) {
                                foreach ($abonnements as $abo) { ?>
                                  <article class="pricing-column col-lg-4 col-md-4">
                                    <?php if (strcmp($abo->get('type'), "Super VIP") == 0) { ?>
                                      <div class="ribbon"><span>POPULAIRE</span></div>
                                    <?php } ?>
                                      <div class="inner-box card-box">
                                          <div class="plan-header text-center">
                                              <h3 class="plan-title"><?php echo $abo->get("type");?></h3>
                                              <h2 class="plan-price"><?php echo $abo->get('prix');?> €</h2>
                                              <div class="plan-duration">Par jour</div>
                                          </div>
                                          <ul class="plan-stats list-unstyled text-center">
                                              <li><strong><?php echo $abo->get('form_number');?></strong> formulaires</li>
                                              <li><strong><?php echo $abo->get('secti_number');?></strong> sections / formulaires</li>
                                              <li><strong><?php echo $abo->get('data_number');?></strong> réponses / formulaires</li>
                                              <li><strong><?php echo $abo->get('field_number');?></strong> champs disponibles / formulaires</li>
                                          </ul>
                                          <?php
                                            if (Session::is_connected() && strcmp($_SESSION['parseData']['user']->get('type'), $abo->getObjectId()) == 0) { ?>
                                              <div class="text-center">
                                                  <button class="btn btn-info btn-bordred btn-rounded waves-effect waves-light">Abonné</button>
                                              </div>
                                            <?php }else{ ?>
                                              <form method = "post" action = "./index.php?act=updatedPremium&c=utilisateur">
                                                <input type = "hidden" name = "type" value = "<?php echo $abo->get('type');?>">
                                                <div class="text-center">
                                                    <input type = "submit" value = "Demander l'abonnement" onclick = "return confirm('Êtes-vous bien sûr de votre demande ?')" class="btn btn-success btn-bordred btn-rounded">
                                                </div>
                                              </form>
                                            <?php } ?>
                                  </article>
                          <?php }
                          }?>
                        </div>
                    </div>
                </div>
