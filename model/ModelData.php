<?php

	class ModelData extends Model {

	public static function select($userId, $formId, $objectId) {
	  $data = 'Data_'.$userId.'_'.$formId;
	  $query = new Parse\ParseQuery($data);
	  $result = $query->get($objectId);
	  if (!empty($result) && !is_null($result))
		return $result;
	  else  return false;
	}

	public static function selectAll($userId, $formId) {
	  $data = 'Data_'.$userId.'_'.$formId;
	  $query = new Parse\ParseQuery($data);
	  $results = $query->find();
	  $object_list = array();
	  if(count($results) != 0) {
	    for($i = 0; $i < count($results); $i++) {
	      $object = $results[$i];
	      array_push($object_list, $object);
	    }
	    return $object_list;
	  }else{
	    return false;
	  }
	}

	public static function save($userId, $formId, $data) {
	  $data_object = 'Data_'.$userId.'_'.$formId;
	  $object = new Parse\ParseObject($data_object);
	  foreach ($data as $cle => $valeur) {
			if (!is_array($valeur)) // s'il ne s'agit pas d'une liste
			  $object->set($cle, $valeur);
			else { // s'il s'agit d'une liste
			  foreach($valeur as $val) { // on insère chaque valeur dans la colonne correspondante
				$object->addUnique($cle, $val);
			  }
			}
	  }
	  try {
	    $object->save();
	    return true;
	  } catch (ParseException $ex) {
	    // Execute any logic that should take place if the save fails.
	    // error is a ParseException object with an error code and message.
	    echo 'Tentative de création de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
	    return false;
	  }
	}

	public static function update($userId, $formId, $data, $objectId = NULL) {

	  if (isset($objectId) && !is_null($objectId) && !empty($objectId)) {
	     $object = self::select($userId, $formId, $objectId);
	  }else{
	     $object = self::select($userId, $formId, $data['objectId']);
	  }

	  foreach ($data as $cle => $valeur) {
		if (strcmp($cle, 'objectId') != 0) {
		  if (!is_array($valeur)) // s'il ne s'agit pas d'une liste
		     $object->set($cle, $valeur);
		  else { // s'il s'agit d'une liste
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
	}

	public static function delete($userId, $formId, $objectId) {
	  $object = self::select($userId, $formId, $objectId);
	  $object->destroy();
	}

	public static function create($userId, $formId) {
		$data_name = 'Data_'.$userId.'_'.$formId;
		$object = new $data_name();
	}
}
