<?php

    class ModelUtilisateur {

      /* private $objectId;
    	private $username;
    	private $email;
    	private $password;
    	private $form_number;
    	private $admin;
      private $active;

    	public static $object = 'User';

    	public function get($attribut) {
    	  return $this->$attribut;
    	}

    	public function set($attribut, $valeur) {
    	  $this->$attribut = $valeur;
    	}

    	public function __construct($objectId, $username, $email, $password, $form_number, $admin = NULL) {
    	  $this->username = $username;
    	  $this->email = $email;
    	  $this->password = $password;
    	  $this->objectId = $objectId;
    	  $this->admin = $admin;
    	} */

      public static function detruire($userId) {
        $query = Parse\ParseUser::query();
        $query->equalTo("objectId", $userId);
        try {
          $result = $query->find();
          if (!empty($result) && !is_null($result)) {
            $result[0]->destroy();
            return true;
          }else
            return false;
        } catch (ParseException $ex) {
    	    echo 'Tentative de suppression de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
    	    return false;
    	  }
      }
    	public static function envoyerMail($email) {
    	   Parse\ParseUser::requestVerificationEmail($email);
    	}

    	public static function existeDeja($email) {
    	   $query = Parse\ParseUser::query();
    	   $query->equalTo("email", $email);
    	   try {
    	    $result = $query->find();
    	    if (!empty($result) && !is_null($result))
    	   	return true;
    	     else
    	   	return false;
    	  } catch (ParseException $ex) {
    	    echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
    	    return false;
    	  }
    	}

      public static function getFormulaires($user_ID) {
        $query = new Parse\ParseQuery("Form");
        $query->equalTo("user_ID", $user_ID);
        try {
          $results = $query->find();
          if (!empty($results) && !is_null($results))
            return $results;
          else
           return false;
        } catch (ParseException $ex) {
          echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
          return false;
        }
      }

    	public static function select($attribut, $valeur) {
    	  $query = Parse\ParseUser::query();
    	  $query->equalTo($attribut, $valeur);
    	  try {
    	    $result = $query->find();
    	    if (!empty($result) && !is_null($result))
    	      return $result;
          else return false;
    	  } catch (ParseException $ex) {
    	    echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
    	    return false;
    	  }
    	}

    	public static function save($data) {
        $user = new Parse\ParseUser();
    	  foreach ($data as $cle => $valeur) {
    	     if (!is_array($valeur)) // s'il ne s'agit pas d'une liste
    		     $user->set($cle, $valeur);
    	     else { // s'il s'agit d'une liste
        		foreach($valeur as $val) { // on insère chaque valeur dans la colonne correspondante
        		   $user->addUnique($cle, $val);
        		 }
    	     }
    	   }
    	  try {
    	    $user->signUp();
    	    // echo 'Nouvel objet crée avec pour objectId: ' . $gameScore->getObjectId();
    	    return true;
    	  } catch (ParseException $ex) {
    	    // Execute any logic that should take place if the save fails.
    	    // error is a ParseException object with an error code and message.
    	    echo 'Tentative de création de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
    	    return false;
    	  }
    	}

    	public static function checkVerified($email) {
    	   $query = Parse\ParseUser::query();
               $query->equalTo("email", $email);
               try {
    	    $result = $query->find();
    	    if (!empty($result) && !is_null($result))
    	   	return $result[0]->get("emailVerified");
    	  } catch (ParseException $ex) {
    	    echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
    	    return false;
    	  }
    	}

      public static function is_active($email) {
         $query = Parse\ParseUser::query();
         $query->equalTo("email", $email);
         try {
            $result = $query->find();
            if (!empty($result) && !is_null($result))
            return $result[0]->get("active");
         } catch (ParseException $ex) {
            echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
            return false;
        }
      }

      public static function update($data, $objectId = NULL) {

        if (isset($objectId) && !is_null($objectId) && !empty($objectId)) {
           $object = self::select('objectId', $objectId);
        }else{
           $object = self::select('objectId', $data['objectId']);
        }
        // Si le résultat n'est pas vide
        if($object) {
          $object = $object[0];
          foreach ($data as $cle => $valeur) {
            if (strcmp($cle, 'objectId') != 0) {
              if (!is_array($valeur)) { // s'il ne s'agit pas d'une liste
                $object->set($cle, $valeur);
              }else { // s'il s'agit d'une liste
               foreach($valeur as $val) { // on insère chaque valeur dans la colonne correspondante
                 $object->addUnique($cle, $val);
                }
              }
             }
           }
          try {
            $object->save();
            // echo 'Nouvel objet crée avec pour objectId: ' . $gameScore->getObjectId();
            return true;
          } catch (ParseException $ex) {
            // Execute any logic that should take place if the save fails.
            // error is a ParseException object with an error code and message.
            echo 'Tentative de mise à jour de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
            return false;
          }
        }else{
          return false;
        }
      }


}
