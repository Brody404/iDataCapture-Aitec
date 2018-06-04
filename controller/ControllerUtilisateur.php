<?php

     require_once File::build_path(array('model','ModelUtilisateur.php'));
     require_once File::build_path(array('model','ModelAbonnement.php'));

     require_once File::build_path(array("lib","Session.php"));

     class ControllerUtilisateur extends Controller {

      	public static function menu() {
          if (Session::is_connected()) {
            $pagetitle = 'Menu Utilisateur';
        	  $view = 'dashboard';
        	  require_once File::build_path(array("view","view.php"));
          }else{
            self::error("Vous devez vous connecter pour accéder à cette page");
          }
      	}

      	public static function create($erreur = NULL) {
      	  $pagetitle = 'Création de compte';
      	  $view = 'register'; $folder = "user";
          if (isset($erreur))
            $err = $erreur;
      	  require_once File::build_path(array("view","view.php"));
      	}

        public static function recuperation() {
          $pagetitle = "Récupération de mot de passe";
          $view = 'forgot-password'; $folder = "user";
          require_once File::build_path(array("view","view.php"));
        }

        public static function update($erreur = NULL) {
          if (Session::is_connected()) {
            $pagetitle = "Mise à jour du compte";
            $liste = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());
            if (count($liste) == 1 && $liste[0]->get('active') != false) {
              if (isset($erreur))
                $err = $erreur;
              $utilisateur = $liste[0];
              $email = $utilisateur->get('email');
              $nom = $utilisateur->get('Nom');
              $prenom = $utilisateur->get('Prenom');
              $telephone = $utilisateur->get('telephone');
              $adresse = $utilisateur->get('adresse');
              $view = "update";
              require_once File::build_path(array("view", "view.php"));
            }else{
              self::deconnected("Votre compte n'est pas disponible pour le moment car il a été supprimé ou désactivé.");
            }
          }else{
             self::connect("Veuillez vous connecter pour effectuer cette action.");
          }
        }


       public static function created() {
         // Si l'utilisateur n'est pas déjà connecté
         if (!Session::is_connected()) {
            // Vérification de la présence des données
            if(isset($_POST['email']) && isset($_POST['nom']) && isset($_POST['prenom'])
            && isset($_POST['mdp1']) && isset($_POST['mdp2'])) {
                // Vérification du contenu non vide des données et des mot de passe egaux
                if (!empty($_POST['email']) && !empty($_POST['nom']) && !empty($_POST['prenom'])
                    && !empty($_POST['mdp1']) && !empty($_POST['mdp2']) && $_POST['mdp1'] == $_POST['mdp2']) {
                    // Si l'adresse mail est correcte
                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) != false) {
                        $data = array(
                            'username' => htmlspecialchars($_POST['email']),
                            'email' => htmlspecialchars($_POST['email']),
                            'Nom' => htmlspecialchars($_POST['nom']),
                            'Prenom' => htmlspecialchars($_POST['prenom']),
                            'password' => htmlspecialchars($_POST['mdp1']),
                            'type' => ModelAbonnement::getAbonnementBasic(),
                            'active' => true );
                        if (isset($_POST['telephone']) && !empty($_POST['telephone']))
                            $data['telephone'] = htmlspecialchars($_POST['telephone']);
                        if (isset($_POST['adresse']) && !empty($_POST['adresse']))
                            $data['adresse'] = htmlspecialchars($_POST['adresse']);
                        if (!ModelUtilisateur::existeDeja($data['email'])) {
                          if (ModelUtilisateur::save($data)) {
                              /* $message = "Bonjour et bienvenu(e) sur notre site ".$data['email'].", veuillez activez votre compte à l'adresse ci-jointe : ";
                              mail($data['email'], 'Confirmation d\'inscription', $message); */
                              $view = 'created'; $folder = 'user';
                              $pagetitle = 'Création de compte terminée';
                              require_once File::build_path(array("view","view.php"));
                          }else{
                              self::create('Création de compte indisponible pour le moment... réessayez plus tard.');
                          }
                        }else{
                          $err = "Cette adresse email existe déjà ... veuillez en saisir une autre avec laquel vous inscrire.";
                          $view = 'register'; $pagetitle = 'Création de Compte'; $folder = 'user';
                          $nom = htmlspecialchars($_POST['nom']);
                          $prenom = htmlspecialchars($_POST['prenom']);
                          if (isset($_POST['telephone']) && !empty($_POST['telephone']))
                              $telephone = htmlspecialchars($_POST['telephone']);
                          if (isset($_POST['adresse']) && !empty($_POST['adresse']))
                              $adresse = htmlspecialchars($_POST['adresse']);
                          require_once File::build_path(array("view","view.php"));
                        }
                    }else{
                      $err = "L'adresse email choisie n'est pas une adresse email valide";
                      $view = 'register'; $pagetitle = 'Création de Compte'; $folder = 'user';
                      $nom = htmlspecialchars($_POST['nom']);
                      $prenom = htmlspecialchars($_POST['prenom']);
                      if (isset($_POST['telephone']) && !empty($_POST['telephone']))
                          $telephone = htmlspecialchars($_POST['telephone']);
                      if (isset($_POST['adresse']) && !empty($_POST['adresse']))
                          $adresse = htmlspecialchars($_POST['adresse']);
                      require_once File::build_path(array("view","view.php"));
                    }
                }else{
                    $err = "Les mots de passe ne correspond pas";
                    $view = 'register'; $pagetitle = 'Création de Compte';
                    $email = htmlspecialchars($_POST['email']);
                    $nom = htmlspecialchars($_POST['nom']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    if (isset($_POST['telephone']) && !empty($_POST['telephone']))
                        $telephone = htmlspecialchars($_POST['telephone']);
                    if (isset($_POST['adresse']) && !empty($_POST['adresse']))
                        $adresse = htmlspecialchars($_POST['adresse']);
                    require_once File::build_path(array("view","view.php"));
                }
            }else{
                self::error("Il manque des informations pour parvenir à la création de votre compte.");
            }
          }else{
            self::error("Vous êtes déjà connecté à un compte, inutile d'en créer un nouveau !");
          }
        }

      public static function connected() {
         if (!Session::is_connected()) {
          if (isset($_POST['email']) && isset($_POST['mdp'])) { // si le login et le mot de passe ont été saisis
            $email = htmlspecialchars($_POST['email']); // on échappe les valeurs html du login saisis pour éviter des erreurs
            $mdp = htmlspecialchars($_POST['mdp']); // pareil pour le mot de passe
            // Si l'utilisateur à déjà validé son compte et que son compte est actif
            if (ModelUtilisateur::checkVerified($email) && ModelUtilisateur::is_active($email)) {
              // On essaie de connecter l'utilisateur
              try {
		             $user = Parse\ParseUser::logIn($email, $mdp);
            		  if ($user) {
            		    self::details();
            		  }else{
            		    self::connect("Une erreur d'authentification est survenue lors de la connexion à votre compte");
            		  }
            	} catch (ParseException $error) {
                self::connect("Erreur lors de la tentative de connexion : " . $error>getMessage());
             }
            }else{
              self::error("Vous devez d'abord vérifier votre adresse mail et activer votre compte !");
            }
          }else{
             self::connect("Vous n'avez pas saisis toute les informations nécéssaires pour vous connecter à votre compte");
          }
        }else{
           self::details("Vous êtes déjà connecté à un compte, inutile de vous connecté de nouveau");
        }
      }

      public static function details($message = NULL) {
        if (Session::is_connected()) {
           $view = 'details';
           $pagetitle = "Détails du compte";
           if (!isset($_GET['userId'])) {
             // on sait que les données de l'utilisateur (stockées une fois ce dernier connecté) sont stockées dans $_SESSION['parseData']['user']
             $liste = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());
             if (count($liste) == 1 && $liste[0]->get("active") != false) {
               if (isset($message))
                  $msg = $message;
               $utilisateur = $liste[0]; // On définit l'utilisateur comme le premier
               $formulaires = ModelUtilisateur::getFormulaires($utilisateur->getObjectId());
               $email = $utilisateur->get('email'); // on récupère son adresse email
               if (empty($formulaires))
                  $nb_form = 0;
               else
                  $nb_form = count($formulaires); // on compte le nombre de formulaires déjà créés
               $nom = $utilisateur->get('Nom');
               $prenom = $utilisateur->get('Prenom');
               $telephone = $utilisateur->get('telephone');
               $adresse = $utilisateur->get('adresse');
               $Abonnement = ModelAbonnement::getInfoAbo($utilisateur->get('type'));
               if (!empty($Abonnement)) {
                  $form_number = $Abonnement->get('form_number');
                  $type = $Abonnement->get('type');
               }

               //// Convertion des dates en string  ////
               $date_i = $utilisateur->getCreatedAt();
               $date_i = $date_i->format('Y-m-d');
               $date_maj = $utilisateur->getUpdatedAt();
               $date_maj = $date_maj->format('Y-m-d');
               ////////////////////////////////////////
               require_once File::build_path(array("view","view.php"));
             }else{
                self::deconnected("Votre compte n'est pas disponible pour le moment car il a été supprimé ou désactivé.");
             }
           }else{
             if (Session::is_admin()) {
               $liste = ModelUtilisateur::select("objectId", $_GET['userId']);
               if (count($liste) == 1) {
                 if (isset($message))
                    $msg = $message;
                 $utilisateur = $liste[0];
                 $formulaires = ModelUtilisateur::getFormulaires($utilisateur->getObjectId());
                 $email = $utilisateur->get('email');
                 if (empty($formulaires))
                    $nb_form = 0;
                 else
                    $nb_form = count($formulaires);
                 $nom = $utilisateur->get('Nom');
                 $prenom = $utilisateur->get('Prenom');
                 $telephone = $utilisateur->get('telephone');
                 $adresse = $utilisateur->get("adresse");
                 $Abonnement = ModelAbonnement::getInfoAbo($utilisateur->get('type'));
                 if (!empty($Abonnement)) {
                    $form_number = $Abonnement->get('form_number');
                    $type = $Abonnement->get('type');
                 }
                 //// Convertion des dates en string  ////
                 $date_i = $utilisateur->getCreatedAt();
                 $date_i = $date_i->format('Y-m-d');
                 $date_maj = $utilisateur->getUpdatedAt();
                 $date_maj = $date_maj->format('Y-m-d');
                 ////////////////////////////////////////
                 require_once File::build_path(array("view","view.php"));
               }else{
                 if (count($liste) == 0)
                  self::error("Aucun utilisateur ne possède cet id.");
                 else
                  self::error("Plusieurs utilisateurs possèdent cet id, veuillez vérifier et opérer à travers le tableau de bord de parse afin de corriger ce problème..");
               }
             }else{
               unset($_GET['userId']);
               self::details();
             }
           }
        }else{
           self::error("Veuillez vous connecter pour accéder à cette page");
        }
      }

      public static function updated() {
        if (Session::is_connected()) {
          if (isset($_POST['prenom']) && isset($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['nom'])) {
            $data = array (
              'Nom' => htmlspecialchars($_POST['nom']),
              'Prenom' => htmlspecialchars($_POST['prenom']),
            );
            if (isset($_POST['telephone']) && !empty($_POST['telephone']))
              $data['telephone'] = intval(htmlspecialchars($_POST['telephone']));
            else
              $data['telephone'] = null;
            if (isset($_POST['adresse']) && !empty($_POST['adresse']) && sizeof($_POST['adresse']) < 100)
              $data['adresse'] = htmlspecialchars($_POST['adresse']);
            else
              $data['adresse'] = null;

            $liste = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());
            if (count($liste) == 1 && $liste[0]->get('active') != false) {
              if (ModelUtilisateur::update($data, $_SESSION['parseData']['user']->getObjectId())) {
                self::details('Votre compte à été mise à jour correctement !');
              }else{
                self::update("Erreur lors de la mise à jour de votre compte");
              }
            }else{
              self::deconnected("Votre compte n'est pas disponible pour le moment car il a été supprimé ou désactivé.");
            }
          }else{
            self::update('Il manque des informations importantes pour parvenir à la modification de votre compte...');
          }
        }else{
          self::error("Veuillez vous connecter pour pouvoir modifier votre compte.");
        }
      }

    //////// FONCTIONS PERMETTANT LA MISE A JOUR DU NOMBRE DE FORMULAIRE MAXIMUM AUTORISE ////////
    public static function premium($erreur = NULL) {
      if(Session::is_connected())
      if (isset($erreur))
        $err = $erreur;
      $abonnements = ModelAbonnement::selectAll();
      $view = 'espacePremium';
      $pagetitle = "Espace premium";
      require_once File::build_path(array("view","view.php"));
    }

    public static function demandeAbo($err) {

    }
    ///////////////////// Fonction permettant de mettre à jour vers différent types d'abonnements ///////////
    public static function updatedPremium($type = NULL) {
      if (Session::is_connected()) {
        if (isset($_POST['type']) || (isset($type) && !empty($type))) {
          if (isset($_POST['type']))
            $typechoisi = htmlspecialchars($_POST['type']);
          else
            $typechoisi = $type;
          if (in_array($typechoisi, ModelAbonnement::getAboList('type'))) {
            if (!isset($_GET['userId'])) {
              $liste = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());
              $data['type'] = ModelAbonnement::getId($typechoisi);
              if (count($liste) == 1 && $liste[0]->get('active') != false) {
                if (ModelUtilisateur::update($data, $_SESSION['parseData']['user']->getObjectId())) {
                  $_SESSION['parseData']['user']->set('type', $data['type']);
                  self::details('La mise à jour de votre compte a bien été effectué, veuillez vérifier que vos informations ci-dessous ont bien été effectuées');
                }else{
                  self::premium("Erreur lors de la mise à jour de vos données.");
                }
              }else{
                self::deconnected("Votre compte n'est pas disponible pour le moment car il a été supprimé ou désactivé.");
              }
            }else{
              if (Session::is_admin()) {
                if (!empty($_GET['userId'])) {
                  if (ModelUtilisateur::update(ModelUtilisateur::getId($typechoisi), $_GET['userId'])) {
                    // A CHANGER
                    self::details('Mise à jour correctement effectué.');
                  }else{
                    // A CHANGER
                    self::premium("Erreur lors de la mise à jour des données.");
                  }
                }else{
                  self::error("Il semble que l'id de l'utilisateur n'a pas été correctement compris..");
                }
              }else{
                unset($_GET['userId']);
                self::updatedPremium();
              }
            }
          }else{
            self::premium("L'abonnement désiré n'est pas dans la liste d'abonnement possible.");
          }
        }else{
          self::premium("Le nombre de formulaire n'a pas été envoyé correctement.");
        }
      }else{
        self::error("Veuillez vous connecter pour pouvoir modifier votre compte");
      }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public static function delete() {
      // Fonction de désactivation du compte
      if (Session::is_connected()) {
        $data['active'] = false;
        if (isset($_POST['mdp']) && !empty($_POST['mdp'])) {
          if (isset($_GET['userId'])) {
            if (Session::is_admin()) {
              $utilisateur = ModelUtilisateur::select($_GET['userId']);
              if ($utilisateur != false && count($utilisateur) == 1) {
                if (ModelUtilisateur::detruire($utilisateur[0]->getObjectId())) {
                  $msg = "Compte supprimé avec succès !";
                }else{
                  self::error("Erreur lors de la destruction de ce compte utilisateur.");
                }
              }else{
                self::error("Erreur dans l'interaction avec la base de données OU avec les id des objets.");
              }
            }else{
              unset($_GET['userId']);
              self::delete();
            }
          }
          else
            $utilisateur = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());

          if ($utilisateur != false && count($utilisateur) == 1) {
              if(strcmp(htmlspecialchars($_POST['mdp']), $utilisateur[0]->get('password')) == 0) {
                if(ModelUtilisateur::update($data, $_SESSION['parseData']['user']->getObjectId())) {
                  $msg = "Compte supprimé avec succès";
                  Parse\ParseUser::logOut();
                  $pagetitle = 'Accueil';
                  require_once File::build_path(array('view','view.php'));
                }else{
                  self::error("Erreur lors de la tentative de suppression de votre compte, veuillez réessayer plus tard ou contacter l'administrateur.");
                }
              }else{
                self::details("Le mot de passe saisi est incorrect.");
              }
          }else{
            self::error("Votre compte utilisateur n'a pas été trouvé dans notre base de données.");
          }
        }else{
          self::details("Vous n'avez pas saisie de mot de passe !");
        }
      }else{
        self::connect("Veuillez vous connecter pour pouvoir supprimer votre compte.");
      }
    }

    public static function abonnement() {
      if (Session::is_connected()) {
        $liste = ModelUtilisateur::select("objectId", $_SESSION['parseData']['user']->getObjectId());
        if (count($liste) == 1 && $liste[0]->get("active") != false) {
          $pagetitle = "Mon abonnement"; $view = "abonnement";
          $utilisateur = $liste[0]; // On définit l'utilisateur comme le premier
          $Abonnement = ModelAbonnement::getInfoAbo($utilisateur->get('type'));
          if (!empty($Abonnement)) {
             $form_number = $Abonnement->get('form_number');
             $type = $Abonnement->get('type');
             $data_number = $Abonnement->get("data_number");
             $field_number = $Abonnement->get("field_number");
             $secti_number = $Abonnement->get("secti_number");
          }
          require_once File::build_path(array("view","view.php"));
        }else{
           self::deconnected("Votre compte n'est pas disponible pour le moment car il a été supprimé ou désactivé.");
        }
      }else{
        self::error("Vous devez vous connecter pour pouvoir accéder à cette page.");
      }
    }

    public static function about() {
      // Fonction de redirection vers la page about.php (avec formulaire)
      // TO DO
    }
    public static function reinit() {
      // Fonction de récupération de mot de passe
      // TO DO
    }

}
