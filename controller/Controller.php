<?php

    require_once File::build_path(array("lib", "Session.php"));

     class Controller {

    	public static function retourAccueil() {
    	  $pagetitle = 'Accueil';
    	  $view = '';
    	  require_once File::build_path(array('view','view.php'));
    	}

    	public static function error($err = NULL) {
    	   $pagetitle = 'Erreur 404';
         $folder = "errors"; $view = "error";
    	   require_once File::build_path(array('view', 'view.php'));
    	}

      public static function deconnected($erreur = NULL) {
        if (Session::is_connected()) {
          Parse\ParseUser::logOut();
          if (isset($erreur)) {
            $msg = $erreur;
          }else{
            $msg = "Déconnexion réusie !";
          }
          $pagetitle = 'Accueil';
          require_once File::build_path(array('view','view.php'));
        }else{
          self::error("Vous n'êtes pas encore connecté à un compte !");
        }
      }

      public static function connect($erreur = NULL) {
        $pagetitle = 'Connexion';
        $view = 'login'; $folder = "user";
        if (isset($erreur))
          $err = $erreur;
        require_once File::build_path(array("view","view.php"));
      }

}
