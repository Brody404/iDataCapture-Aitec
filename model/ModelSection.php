<?php

    require_once 'Model.php';

    class ModelSection extends Model {
      /* private $nom;
      private $Description;
      private $formId; */

      public static $object = "Section";

      public static function selectAllSection($formId) {
        $query = new Parse\ParseQuery("Section");
        $query->equalTo('formId', $formId);
        try {
          $results = $query->find();
          if (!empty($results)) {
            return $results;
          }
          else
            return false;
        } catch (ParseException $ex) {
         echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
         return false;
       }
     }

    }
 ?>
