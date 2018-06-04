<?php

	require_once 'Model.php';

	class ModelForm extends Model {

			/* private $objectId;
			private $nom;
			private $description;
			private $Data_number;
			private $bg_pic;
			private $Secti_number;
			private $user_ID;



			public function get($attribut) {
			  return $this->$attribut;
			}

			public function set($attribut, $valeur) {
			  $this->$attribut = $valeur;
			}

			public function __construct($objectId = NULL, $description = NULL, $Data_number = NULL, $Secti_number = NULL, $user_ID = NULL) {
			  $this->objectId = $objectId;
			  $this->description = $description;
			  $this->Data_number = $Data_number;
			  $this->Secti_number = $Secti_number;
			  $this->user_ID = $user_ID;
			  $this->bg_pic = $bg_pic;
			} */

			public static $object = "Form";

			public static function recupType() {
				$query = new Parse\ParseQuery("Field_Type");
				try {
					$results = $query->find();
					$object_list = array();
					if (count($results) != 0) {
						for ($i = 0; $i < count($results); $i++) {
							$object = $results[$i];
							array_push($object_list, $object);
						}
						return $object_list;
					}else{
						return false;
					}
				}catch (ParseException $ex) {
					echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
					return false;
				}
			}

			public static function recupTypeName() {
				$field_type = self::recupType();
				if ($field_type) {
					$liste = array();
					foreach ($field_type as $field) {
						array_push($liste, $field->get('type_name'));
					}
					return $liste;
				}else{
					return false;
				}
			}
			public static function monFormulaire($formId, $user_ID) {
				$formulaire = self::select($formId);
				if ($formulaire) {
					$query = new Parse\ParseQuery('Form');
					$query->equalTo('user_ID', $user_ID);
					try {
						$results = $query->find();
						if (count($results) != 0) {
							$OK = false;
							for ($x = 0; $x < count($results); $x++) {
								if (strcmp($results[$x]->getObjectId(), $formulaire->getObjectId()) == 0)
									$OK = true;
							}
							return $OK;
						}else{
							return false;
						}
					}catch (ParseException $ex) {
      	    echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
      	    return false;
      	  }
				}else{
					return false;
				}
			}

	}
