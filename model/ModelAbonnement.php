<?php

    require_once 'Model.php';

    class ModelAbonnement extends Model {

      public static $object = "Abonnement";

      public static function getAbonnementBasic() {
        $query = new Parse\ParseQuery('Abonnement');
        $query->equalTo('type','Client');
        try {
            $result = $query->find();
            if (!empty($result) && !is_null($result))
              return $result[0]->getObjectId();
            else
              return false;
        }catch (ParseException $ex) {
          echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
          return false;
        }
      }

      public static function getInfoAbo($type) {
        $query = new Parse\ParseQuery('Abonnement');
        $query->equalTo('objectId', $type);
        try {
            $result = $query->find();
            if (!empty($result) && !is_null($result))
              return $result[0];
            else
              return false;
        }catch (ParseException $ex) {
          echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
          return false;
        }
      }

      public static function getId($type) {
        $query = new Parse\ParseQuery('Abonnement');
        $query->equalTo('type',$type);
        try {
          $result = $query->find();
          if (!empty($result) && !is_null($result))
            return $result[0]->getObjectId();
          else
            return false;
        }catch (ParseException $ex) {
          echo "Tentative de récupération de l'objet échoué avec pour code d'erreur : " . $ex->getMessage();
          return false;
        }
      }
      
      public static function getAboList($attribut) {
          $query = new Parse\ParseQuery('Abonnement');
          $query->exists($attribut);
          try {
            $result = $query->find();
            if (!empty($result) && !is_null($result)) {
              $liste = array();
              foreach ($result as $abonnement) {
                array_push($liste, $abonnement->get($attribut));
              }
              return $liste;
            }else{
              return false;
            }
          }catch (ParseException $ex) {
            echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
            return false;
          }
      }

    }
