<?php

     require_once File::build_path(array("model","ModelForm.php"));
     require_once File::build_path(array("model", "ModelData.php"));
     require_once File::build_path(array("model","ModelField.php"));
     require_once File::build_path(array("model", "ModelSection.php"));
     require_once File::build_path(array("model", "ModelAbonnement.php"));

     class ControllerForm extends Controller {

      public static function update() {
        require_once File::build_path(array("model","ModelUtilisateur.php"));
        if (Session::is_connected()) {
          if (isset($_GET['id']) && !empty($_GET['id'])) {
            $formId = htmlspecialchars($_GET['id']);
            $liste = ModelUtilisateur::getFormulaires($_SESSION['parseData']['user']->getObjectId());
            if ($liste || Session::is_admin()) {
              if (!Session::is_admin()) {
                $dansMaListe = false;
                $i = 0; $indice = 0;
                foreach ($liste as $formUser) {
                  if (strcmp($formUser->getObjectId(), $formId) == 0) {
                    $dansMaListe = true;
                    $indice = $i;
                  }
                    $i++;
                }
                if ($dansMaListe) {
                  $nom = $liste[$indice]->get("nom");
                  $description = $liste[$indice]->get("description");
                  $bg_pic = $liste[$indice]->get("bg_pic");
                  // TO DO
                }else{
                  self::error("Le formulaire que vous souhaitez modifier n'est pas dans votre liste...");
                }
              }else{
                $formUser = ModelForm::select($formId);
                $nom = $formUser->get('nom');
                $description = $formUser->get('description');
                $bg_pic = $formUser->get("bg_pic");
                // TO DO
              }
            }
          }else{
            self::error("Nous ne pouvons pas trouvé le formulaire que vous recherchez.");
          }
        }else{
          self::error("Veuillez vous connecter pour pouvoir modifier ce formulaire.");
        }
      }

      public static function create($err = NULL) {
        if (Session::is_connected()) {
          require_once File::build_path(array("model","ModelUtilisateur.php"));
          $formulaires = ModelUtilisateur::getFormulaires($_SESSION['parseData']['user']->getObjectId());
          // PARTIE NON ADMIN
          if (!Session::is_admin()) {
            $liste = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());
            if (count($liste) == 1 && $liste[0]->get("active") != false) {
              // On compte le nombre de formulaires déjà créés par l'utilisateur
              $nb_form = count(ModelUtilisateur::getFormulaires($_SESSION['parseData']['user']->getObjectId()));
              // Si l'utilisateur n'a pas atteint son maximum alors on le laisse accéder à la page de création
              $Abonnement = ModelAbonnement::getInfoAbo($liste[0]->get('type'));
              if ($nb_form < $Abonnement->get('form_number')) {
                $secti_number = $Abonnement->get('secti_number');
                $field_number = $Abonnement->get('field_number');
                $data_number = $Abonnement->get('data_number');
                $view = 'update'; $pagetitle = "Création d'un formulaire";
                $folder = "formulaire";
                require_once File::build_path(array('view','view.php'));
              }else self::selectAll("Vous ne pouvez plus créer de formulaire car vous avez atteint votre limite.");
            }else self::error("Votre compte n'est pas disponible pour le moment car il a été supprimé ou désactivé.");
          }else{
            $view = 'update'; $var = 1;
            $pagetitle = "Création d'un formulaire";
            $folder = "formulaire";
            require_once File::build_path(array('view','view3.php'));
          }
        }else self::connect("Veuillez vous connecter pour pouvoir créer un formulaire.");
      }

      public static function etape2($erreur = NULL) {
        if (Session::is_connected()) {
          if (isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['secti_number'])) {
            $data = array(
              'nom' => htmlspecialchars($_POST['titre']),
              'description' => htmlspecialchars($_POST['description']),
              'user_ID' => $_SESSION['parseData']['user']->getObjectId());
              // Attention problème de taille de fichier ! si fichier < à 1 Mo ça marche pas
              if(!empty($_FILES['background-image']) && is_uploaded_file($_FILES['background-image']['tmp_name'])) {
                $name = $_FILES['background-image']['name'].uniqid();
                $DS = DIRECTORY_SEPARATOR;
                $pic_path = '.' . $DS .'background_formulaire' . $name;
                $allowed_ext = array('jpg','jpeg','png');
                $extension = explode('.',$_FILES['background-image']['name']);
                if (!in_array(end($extension),$allowed_ext))
                  self::create('Mauvais type de fichier !');
                else{
                  if (!move_uploaded_file($_FILES['background-image']['tmp_name'], $pic_path)) {
                    self::create("L'upload de l'image d'arrière plan a échoué.");
                  }else{
                    $pic_path2 = './background_formulaire/'.$name;
                    $data['bg_pic'] = $pic_path2;
                    $formId = ModelForm::save($data);
                    if ($formId) {
                      $secti_number = htmlspecialchars($_POST['secti_number']);

                      require_once File::build_path(array("model","ModelUtilisateur.php"));
                      $liste = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());

                      if (count($liste) == 1 && $liste[0]->get('active') != false) {
                        if (isset($erreur))
                          $err = $erreur;
                        $field_number = ModelAbonnement::getInfoAbo($liste[0]->get('type'))->get("field_number");
                        $view = "etape2"; $folder = "formulaire";
                        $pagetitle = "Création de formulaire";
                        require_once File::build_path(array('view','view.php'));
                      }else self::deconnected("Votre compte a été supprimé ou désactivé, vous ne pouvez pas continuer à créer un formulaire.");
                    }else self::error("Erreur dans la sauvegarde du formulaire, contactez l'administrateur");
                  }
                }
              }else{
                $formId = ModelForm::save($data);
                if ($formId) {
                  $secti_number = htmlspecialchars($_POST['secti_number']);

                  require_once File::build_path(array("model","ModelUtilisateur.php"));
                  $liste = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());

                  if (count($liste) == 1 && $liste[0]->get('active') != false) {
                      if (isset($erreur))
                        $err = $erreur;
                      $field_number = ModelAbonnement::getInfoAbo($liste[0]->get('type'))->get("field_number");
                      $view = "etape2"; $folder = "formulaire";
                      $pagetitle = "Création de formulaire";
                      require_once File::build_path(array('view','view.php'));
                  }else self::deconnected("Votre compte a été supprimé ou désactivé, vous ne pouvez pas continuer à créer un formulaire.");
                }else self::error("Erreur dans la sauvegarde du formulaire, contactez l'administrateur.");
              }
          }else self::create("Vous n'avez pas remplit tout les champs nécéssaires pour passer à l'étape suivante.");
        }else self::connect('Vous devez vous connecter pour pouvoir accéder à cette page');
      }

      public static function test() {
        $view = 'test'; $pagetitle = "Aucune";
        require_once File::build_path(array("view","view.php"));
      }

      public static function etape3($erreur = NULL) {
        if (Session::is_connected()) {
          if (isset($_POST['secti_number']) && !empty($_POST['secti_number']) && isset($_POST['formId']) && !empty($_POST['formId'])) {
            if (ModelForm::select($_POST['formId']) && !ModelSection::selectAllSection($_POST['formId'])) {
              if (!Session::is_admin()) {
                if (ModelForm::monFormulaire($_POST['formId'], $_SESSION['parseData']['user']->getObjectId()))
                  self::etape3_bis();
                else self::error("Ce formulaire ne vous appartient pas..");
              }else self::etape3_bis();
            }else self::create("Le formulaire que vous avez souhaité créer vient de disparaitre de la base.");
          }else self::create("Vous n'avez pas remplit tout les champs.");
        }else self::connect('Vous devez vous connecter pour pouvoir accéder à cette page.');
      }

      private static function etape3_bis() {
        require_once File::build_path(array("model","ModelUtilisateur.php"));
        $liste = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());
        if (count($liste) == 1 && $liste[0]->get('active') != false) {
        if (ModelForm::monFormulaire($_POST['formId'], $liste[0]->getObjectId())) {
          $Abonnement = ModelAbonnement::getInfoAbo($liste[0]->get('type'));
          $secti_number = $Abonnement->get("secti_number");
          $field_number = $Abonnement->get("field_number");
          if ($secti_number >= $_POST['secti_number']) {
            $OK = true; $msg = '';
            for ($i = 1; $i <= $_POST['secti_number']; $i++) {
              if (!isset($_POST["titre".$i]) || empty($_POST['titre'.$i])) {
                $OK = false; $msg = "il manque le titre à la section $i";
              }
              if (!isset($_POST['description'.$i]) || empty($_POST['description'.$i])) {
                $OK = false; $msg = "il manque la description à la section $i";
              }
              if (!isset($_POST['field_number'.$i]) || empty($_POST['field_number'.$i]) || $_POST['field_number'.$i] > $field_number) {
                $OK = false; $msg = " le nombre de champs n'a pas été définit correctement à la section $i";
              }
            }
            if ($OK) {
              $tab_secti = array(); $tab_desc = array(); $tab_field = array(); $tab_id_section = array();
              for ($i = 1; $i <= $_POST['secti_number']; $i++) {
                $OK = true;
                $data = array(
                  'nom' => htmlspecialchars($_POST['titre'.$i]),
                  'Description' => htmlspecialchars($_POST['description'.$i]),
                  'formId' => $_POST['formId']);
                $tab_secti[$i] = $data['nom'];
                $tab_desc[$i] = $data['Description'];
                $tab_field[$i] = intval($_POST['field_number'.$i]);
                $save_section = ModelSection::save($data);
                if (!$save_section) {
                  $OK = false; break;
                }else $tab_id_section[$i] = $save_section;
              }
              if ($OK) {
                if (isset($_POST['titre']) && !empty($_POST['titre']))
                  $titre = htmlspecialchars($_POST['titre']);
                if (isset($_POST['description']) && !empty($_POST['description']))
                  $description = htmlspecialchars($_POST['description']);
                $formId = $_POST['formId'];
                $field_type = ModelForm::recupType();
                $view = "etape3"; $folder = "formulaire";
                $pagetitle = "Création de formulaire";
                require_once File::build_path(array('view','view.php'));
              }else self::error("Une erreur est survenue lors de la sauvegarde de la section $i");
            }else self::create("Impossible de passer à l'étape suivante, ".$msg);
          }else self::error("Erreur dans le nombre de sections");
          }else self::error("Ce formulaire ne vous appartient pas.");
        }else self::deconnected("Votre compte a été supprimé ou désactivé, vous ne pouvez pas continuer à créer un formulaire.");
      }

      public static function finalize($error = NULL) {
        if (Session::is_connected()) {
          require_once File::build_path(array("model","ModelUtilisateur.php"));
          $liste = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());
          if (count($liste) == 1 && $liste[0]->get('active') != false) {
            if (isset($_POST['formId'])) {
              if (ModelForm::select($_POST['formId'])) { // On vérifie que le formulaire existe
                $valid = true;
                if (!Session::is_admin()) { // Si l'utilisateur n'est pas administrateur
                  if (!ModelForm::monFormulaire($_POST['formId'], $liste[0]->getObjectId())) // on vérifie qu'il s'agit bien de son formulaire
                    $valid = false;
                }
                if ($valid) {
                  $p = 1; $tab_id_section = array();
                  // RECUPERATION DE TOUT LES ID DES SECTIONS
                  while (isset($_POST["secti".$p])) {
                    $tab_id_section[$p] = $_POST['secti'.$p];
                    $p++;
                  }
                  $p = 1; $tab_field = array();
                  while (isset($_POST['field'.$p])) {
                    $tab_field[$p] = $_POST['field'.$p];
                    $p++;
                  }
                  // VERIFICATION QUE TOUTE LES SECTIONS APPARTIENENT AU FORMULAIRE
                  $Form_Sections = ModelSection::selectAllSection($_POST['formId']);
                  for ($i = 1; $i <= count($tab_id_section); $i++) {
                    for ($y = 0; $y < count($Form_Sections); $y++) {
                      if ($Form_Sections[$y]->getObjectId() == $tab_id_section[$i])
                        unset($Form_Sections[$y]);
                        $Form_Sections = array_values($Form_Sections);
                    }
                  }
                  if (empty($Form_Sections)) {
                    $OK = true;
                    if (!Session::is_admin()) { // Si l'utilisateur n'est pas admin, on vérifie les sections
                      $Abonnement = ModelAbonnement::getInfoAbo($liste[0]->get('type'));
                      $secti_number = $Abonnement->get("secti_number");
                      $field_number = $Abonnement->get("field_number");
                      if (count($tab_id_section) > $secti_number && count($tab_field) > $field_number) {
                        $OK = false;
                      }
                    }
                    if ($OK) {
                      $data = array();
                      $field_type = ModelForm::recupTypeName(); // Liste des types possible
                      $champOk = true;
                      for ($i = 1; $i <= count($tab_id_section); $i++) {
                        for ($j = 1; $j <= count($tab_field); $j++) {
                          $champOk = true;

                          // NOM DU CHAMP //
                          if (isset($_POST[$i.$j.'nom']) && !empty($_POST[$i.$j.'nom']))
                            $data['nom'] = $_POST[$i.$j.'nom'];
                          else {
                            $OK = false; $champOk = false;
                            if (isset($msg) && !empty($msg)) $msg += '<br>Le titre du champ '. $j . ' de la section '. $i . ' n\'est pas correctement définit.';
                            else $msg = 'Le titre du champ '. $j . ' de la section '. $i . ' n\'est pas correctement définit.';
                          }

                          // CHAMP OBLIGATOIRE OU PAS //
                          if (isset($_POST[$i.$j.'required']))
                            $data['required'] = true;
                          else
                            $data['required'] = false;

                          // TYPE DU CHAMP //
                          // VERIFIER LES NEED_VALUES //
                          if (isset($_POST[$i.$j.'type']) && !empty($_POST[$i.$j.'type'])) {
                            if (in_array(htmlspecialchars($_POST[$i.$j.'type']), $field_type))
                              $data['type'] = htmlspecialchars($_POST[$i.$j.'type']);
                            else {
                              $OK = false; $champOk = false;
                              if (isset($msg) && !empty($msg)) $msg += "<br>Le type du champ ". $j ." de la section ".$j." n'est pas dans la liste des types disponibles.";
                              else $msg = 'Le type du champ ". $j ." de la section ".$j." n\'est pas dans la liste des types disponibles.';
                            }
                          }else{
                            $OK = false; $champOk = false;
                            if (isset($msg) && !empty($msg)) $msg += "<br>Le type du champ ". $j ." de la section ".$j." n'a pas été correctement définie.";
                            else $msg = "Le type du champ ". $j ." de la section ".$j." n'a pas été correctement définie";
                          }

                          // OPTION DU CHAMP //
                          // TO DO

                          // VALEUR PAR DEFAUT DU CHAMP //
                          if (isset($_POST[$i.$j.'defaut']) && !empty($_POST[$i.$j.'defaut']))
                            $data['default_value'] = $_POST[$i.$j.'defaut'];
                          else {
                            $OK = false; $champOk = false;
                            if (isset($msg) && !empty($msg)) $msg += '<br>La valeur par défaut du champ '. $j . ' de la section '. $i . ' n\'est pas correctement définit.';
                            else $msg = 'La valeur par défaut du champ '. $j . ' de la section '. $i . ' n\'est pas correctement définit.';
                          }

                          // TAILLE MAXIMAL DU CHAMP //
                          if (isset($_POST[$i.$j.'taille']) && !empty($_POST[$i.$j."taille"]))
                            $data['length'] = $_POST[$i.$j.'taille'];

                          // ORDRE DU CHAMP //
                          if (isset($_POST[$i.$j.'ordre']) && !empty($_POST[$i.$j.'taille']))
                            $data['order'] = $_POST[$i.$j.'ordre'];

                          if (isset($_POST[$i.$j.'valeurs']) && !empty($_POST[$i.$j.'valeurs']))
                            $data['valeurs'] = $_POST[$i.$j.'valeurs'];
                          else {
                            if(strcmp(htmlspecialchars($_POST[$i.$j.'type']), 'Compteur') == 0 || strcmp(htmlspecialchars($_POST[$i.$j.'type']), 'Sélecteur') == 0) {
                              $OK = false; $champOk = false;
                              if (isset($msg) && !empty($msg))
                                $msg += '<br>Les valeurs possibles ne sont pas définies pour le champ de type '.htmlspecialchars($_POST[$i.$j."type"]) . " dans le champ " . $j . " de la section " .$i;
                              else
                                $msg = 'Les valeurs possibles ne sont pas définies pour le champ de type '.htmlspecialchars($_POST[$i.$j."type"]) . " dans le champ " . $j . " de la section " .$i;
                            }
                          }

                          $data['section_id'] = $tab_id_section[$i];
                          if ($champOk) // Si le champ est ok
                            ModelField::save($data); // on le sauvegarde pour qu'il puisse compléter les autres plus tard
                        }
                      }
                      if ($OK) {
                        if (Session::is_admin() && isset($_GET['user_ID']))
                          ModelData::create(rawurldecode($_GET['user_ID']), htmlspecialchars($_POST['formId']));
                        else
                          ModelData::create($_SESSION['parseData']['user']->getObjectId(), htmlspecialchars($_POST['formId']));
                        self::retourAccueil();
                      }else self::error("Votre formulaire a été crée mais des erreurs sont survenues. Il n'est donc pas encore éligible à être utilisé par les utilisateurs car : <br>".$msg);
                    }else self::error("Erreur dans le nombre de section envoyées.");
                  }else self::error('Toutes les sections n\'ont pas été envoyés correctement.');
                }else self::error("Ce formulaire ne vous appartient pas");
              }else self::create("Le formulaire que vous avez souhaité créer vient de disparaitre de la base.");
            }else self::error("L'id de votre formulaire est introuvable. Ne tentez pas d'intervenir dans le code HTML au risque de perdre votre formulaire.");
          }else self::deconnected("Votre compte a été supprimé ou désactivé, vous ne pouvez pas continuer à créer un formulaire.");
        }else self::connect("Vous devez vous connecter pour pouvoir accéder à cette page.");
      }

      public static function delete() {
        // TO DO
        // Fonction de suppression de formulaire
      }

      public static function details() {
        // TO DO
        // Affiche les détails d'un formulaire
      }

      public static function complete() {
        // TO DO
        // Fonction de remplissage de formulaire
      }

      public static function selectAll($erreur = NULL) {
        // TO DO
        // Fonction de listage de formulaire
      }

    }
