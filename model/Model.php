<?php

    require_once File::build_path(array("config", "Conf.php"));
    Model::Init();

    class Model {

        public static function Init() {
           // On initialise les variables
           $application_id = Conf::get_APP(); // récupération de l'application serveur
	         $master_key = Conf::get_MASTER(); // récupération de la master_key
	         $adresse_ip = Conf::get_IP(); // récupération de l'adressee IP du serveur
	         $port = Conf::get_PORT(); // récupération du port du serveur
	         Parse\ParseClient::initialize($application_id, null, $master_key); // Initialisation du client
	         $ServeurURL = 'http://'.$adresse_ip.':'.$port; // Construction de l'url du serveur
	         Parse\ParseClient::setServerURL($ServeurURL, 'parse'); // connection au serveur
        }

      	public static function verifConnnection() {
      	   $health = Parse\ParseClient::getServerHealth();
      	   if($health['status'] == 200)
      		return true;
      	   else
      		return false;
      	}

      	public static function select($objectId) {
      	  $object_name = static::$object;
      	  $query = new Parse\ParseQuery($object_name);
          try {
            $result = $query->get($objectId);
        	  if (!empty($result) && !is_null($result))
        	    return $result;
        	  else return false;
          } catch (ParseException $ex) {
      	    echo 'Tentative de récupération de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
      	    return false;
      	  }
      	}

      	public static function save($data) {
      	  $object_name = static::$object;
      	  $object = new Parse\ParseObject($object_name);
      	  foreach ($data as $cle => $valeur) {
        		if (!is_array($valeur)) // s'il ne s'agit pas d'une liste
        		  $object->set($cle, $valeur);
        		else { // s'il s'agit d'une liste
        		  foreach($valeur as $val) { // on insère chaque valeur dans la colonne correspondante
                $array = array();
                array_push($array, $val);
        		  }
              $object->addUnique($cle, $array);
        		}
      	  }
      	  try {
      	    $object->save();
      	    // echo 'Nouvel objet crée avec pour objectId: ' . $gameScore->getObjectId();
      	    return $object->getObjectId();
      	  } catch (ParseException $ex) {
      	    // Execute any logic that should take place if the save fails.
      	    // error is a ParseException object with an error code and message.
      	    echo 'Tentative de création de l\'objet échoué avec pour code d\'erreur : ' . $ex->getMessage();
      	    return false;
      	  }
      	}

      	public static function update($data, $objectId = NULL) {
      	  $object_name = static::$object;

      	  if (isset($objectId) && !is_null($objectId) && !empty($objectId)) {
      	     $object = self::select($objectId);
      	  }else{
      	     $object = self::select($data['objectId']);
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

      	public static function delete($objectId) {
      	  $object = self::select($objectId);
      	  $object->destroy();
      	}

      	public static function selectAll() {
      	  $object_name = static::$object;
      	  $query = new Parse\ParseQuery($object_name);
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
      	}


        /*static public function selectAll() {
            $table_name = static::$object;
            $class_name = 'Model'.ucfirst($table_name);
            try {
                $rep = Model::$pdo->query("SELECT * FROM $table_name");
                $rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
                $tab = $rep->fetchAll();
                if (!empty($tab)) return $tab;
                else return false;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                  echo $e->getMessage();
                } else {
                    echo 'Une erreur est survenue lors de la récupération des données, veuillez réessayer plus tard.';
                }
                return false;
            }
        }

        static public function select($primary_value) {
            $table_name = static::$object;
            $primary_key = static::$primary;
            $class_name = 'Model'.ucfirst($table_name);
            $sql = "SELECT * FROM $table_name WHERE $primary_key = :value";
            try {
                $rep = Model::$pdo->prepare($sql);
                $values = array (
                    'value' => $primary_value,
                );
                $rep->execute($values);

                $rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
                $tab = $rep->fetchAll();
                if(empty($tab))
                    return false;
                else
                    return $tab[0];
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                  echo $e->getMessage(); // affiche un message d'erreur
                } else {
                  echo "Une erreur lors de la récupération du model $class_name, veuillez réessayer plus tard.";
                }
                return false;
            }
        }

        static public function delete($primary) {
            // primary représente la valeur de la clé primaire dans la table de la ligne l'on souhaite supprimer
            $table_name = static::$object;  // récupération du nom de la table de la bdd
            $primary_key = static::$primary; // récupération de la clé primaire de la table
            $class_name = 'Model'.ucfirst($table_name); // on concatène Model au nom de la table dont l'on met le premier terme en majuscule
            $sql = "DELETE FROM $table_name WHERE $primary_key =:value"; // on prépare la requête
            try {
                $rep = Model::$pdo->prepare($sql); // préparation de la requête
                $values = array( // création d'un tableau
                    'value' => $primary, // on met la valeur primaire insérée en paramètre
                );
                $rep->execute($values); // on exécute ensuite la requête préparée avec la valeur de la clé primaire stocké dans le tableau values
                return true; // on renvoie true quand l'opération s'est déroulé correctement
            }
            catch (PDOException $e) { // si l'on trouve une exception
                if (Conf::getDebug()) {
                  echo $e->getMessage(); // affiche un message d'erreur
                } else {
                  echo "Une erreur lors de la suppression de $primary, veuillez réessayer plus tard.";
                }
                return false;
            }
        }

        public static function update($data) {
            // data un tableau de données à insérer avec les champs correspondants
            $table_name = static::$object;  // récupération du nom de la table de la bdd
            $primary_key = static::$primary; // récupération de la clé primaire de la table
            $set = ""; // la variable set prend une valeur vide au début
            foreach($data as $champ_id => $champ){ // pour chaque valeur du tableau
                if(strcmp($primary_key, $champ_id) == 0) {  // si la colonne se trouve être la colonne de la clé primaire
                    $values['primary_value'] = $champ; // on récupère la clé primaire
                }else{ // si l'on n'est pas tombé sur la clé primaire
                    $set = $set . $champ_id . "=:" . $champ_id . ","; // on récupère les champs que l'on concatène à la variable set
                    $values[$champ_id] = $champ;  // on met la valeur correspondant à la colonne dans un tableau à l'index qu'on nommeras au même nom que la colonne
                }
              }
            $set = rtrim($set, ','); // on supprime la dernière virgule
            $sql = "UPDATE $table_name SET $set WHERE $primary_key = :primary_value;"; // on prépare la requête
            try {
                $req_prep = Model::$pdo->prepare($sql); // préparation de la requête
                $req_prep->execute($values); // on éxécute la requête avec les valeurs présentes dans le tableau
                return true;
            }
            catch (PDOException $e) { // si l'on trouve une exception
                if (Conf::getDebug()) {
                  echo $e->getMessage(); // affichage d'un message d'erreur
                } else {
                  echo "Une erreur est survenue lors de la mise à jour, veuillez réessayer plus tard.";
                }
                return false;
            }
        }

        public static function save($data) {
            // data un tableau de données à insérer avec les champs correspondants
            $table_name = static::$object; // récupération du nom de la table de la bdd
            $class_name = 'Model'.$table_name; // concatenation de Model avec le nom de la table dans laquelle ou souhaite insérer
            $set = ""; // la variable set prend une valeur vide au début
            $colonnes = ""; // la variable colonnes prend elle aussi une valeur vide au début
            foreach ($data as $cle => $value) { // pour chaque valeur du tableau
                    $colonnes = $colonnes . $cle . ","; // on concatene la chaine de caractère colonnes avec le nom de la colonne du tableau et l'on sépare la suite d'une virgule
                    $set = $set .":" . $cle . ","; // on concatene la chaine de caractère set avec le nom des colonnes du tableau également mais l'on sépare différements les colonnes (:)
                    $values[$cle] = $value; // on met la valeur correspondant à la colonne dans un tableau à l'index qu'on nommeras au même nom que la colonne
            }
            $colonnes = rtrim($colonnes, ','); // on supprime la dernière virgule
            $set = rtrim($set, ',');
            $sql = "INSERT INTO $table_name ($colonnes) VALUES ($set)"; // on prépare la requête
            try {
                $req_prep = Model::$pdo->prepare($sql); // préparation de la requête pour la bdd
                $req_prep->execute($values); // on exécutes la requête préparée avec les valeurs correspondantes présentent dans le tableau values
                return true;
            }
            catch (PDOException $e) { // si l'on trouve une exception
                if (Conf::getDebug()) {
                    return $e->getCode(); // affiche un message d'erreur
                } else {
                    echo "Une erreur est survenue lors de la sauvegarde de l'objet $table_name, veuillez réessayer plus tard.";
                }
                return false;
            }
        }

        public static function getSecteurs() {
            try {
                $rep = Model::$pdo->query("SELECT * FROM secteurdispo WHERE etat=1");
                $rep->setFetchMode(PDO::FETCH_ASSOC);
                $tab = $rep->fetchAll();
                return $tab;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                    echo $e->getMessage();
                } else {
                    echo 'Une erreur est survenue lors de la récupération des données, veuillez réessayer plus tard.';
                }
                return false;
            }
        }

        public static function getSecteursNonValide() {
            try {
                $rep = Model::$pdo->query("SELECT * FROM secteurdispo WHERE etat=0");
                $rep->setFetchMode(PDO::FETCH_ASSOC);
                $tab = $rep->fetchAll();
                return $tab;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                    echo $e->getMessage();
                } else {
                    echo 'Une erreur est survenue lors de la récupération des données, veuillez réessayer plus tard.';
                }
                return false;
            }
        }

        public static function getUnSecteur($secteur, $etat) {
            try {
                $rep = "SELECT * FROM secteurdispo WHERE nomSecteur=:tag_nomsecteur AND etat=:etat";
                $values = array(
                    'tag_nomsecteur' => $secteur,
                    'etat' => $etat,
                );
                $req_prep = Model::$pdo->prepare($rep);
                $req_prep->execute($values);
                $req_prep->setFetchMode(PDO::FETCH_ASSOC);
                $tab = $req_prep->fetchAll();
                return $tab;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                    echo $e->getMessage();
                } else {
                    echo 'Une erreur est survenue lors de la récupération des données, veuillez réessayer plus tard.';
                }
                return false;
            }
        }

        public static function addSecteur($secteur) {
            $sql = "INSERT INTO secteurdispo VALUES (:tag_secteur, 0)";
            try {
                $values = array(
                    'tag_secteur' => $secteur
                );
                $req_prep = Model::$pdo->prepare($sql);
                $req_prep->execute($values);
                return true;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
                } else {
                    echo "Une erreur est survenue lors de la sauvegarde de l'objet $secteur, veuillez réessayer plus tard.";
                }
                return false;
            }
        }

        public static function valideSecteur($secteur) {
            $sql = "UPDATE secteurdispo SET etat=1 WHERE nomSecteur=:tag_secteur AND etat=0";
            try {
                $values = array(
                    'tag_secteur' => $secteur
                );
                $req_prep = Model::$pdo->prepare($sql);
                $req_prep->execute($values);
                return true;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
                } else {
                    echo "Une erreur est survenue lors de la sauvegarde de l'objet $secteur, veuillez réessayer plus tard.";
                }
                return false;
            }
        }

        public static function supprimeSecteur($secteur) {
            $sql = "DELETE FROM secteurdispo WHERE nomSecteur=:tag_secteur";
            try {
                $values = array(
                    'tag_secteur' => $secteur
                );
                $req_prep = Model::$pdo->prepare($sql);
                $req_prep->execute($values);
                return true;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
                } else {
                    echo "Une erreur est survenue lors de la sauvegarde de l'objet $secteur, veuillez réessayer plus tard.";
                }
                return false;
            }
        }


        public static function estAffectePro($login) {
            $sql = "SELECT * FROM assignations_valide WHERE login = :login";
            try {
                $rep = Model::$pdo->prepare($sql);
                $values['login'] = $login;
                $rep->execute($values);
                $tab = $rep->fetchAll();
                if (!empty($tab)) return true;
                else return false;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                  echo $e->getMessage();
                } else {
                    echo 'Une erreur est survenue lors de la vérification des données, veuillez réessayer plus tard.';
                }
                return false;
            }
        }

        public static function select_RSS() {
            try {
                $rep = Model::$pdo->query("SELECT * FROM lienRSS");
                $rep->setFetchMode(PDO::FETCH_ASSOC);
                $tab = $rep->fetchAll();
                return $tab;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                    echo $e->getMessage();
                } else {
                    echo 'Une erreur est survenue lors de la récupération des données, veuillez réessayer plus tard.';
                }
                return false;
            }
        }

        public static function select_specific_RSS($idRSS) {
            $sql = "SELECT * FROM lienRSS WHERE id=:tag_idRSS";
            try {
                $values = array(
                    'tag_idRSS' => $idRSS
                );
                $req_prep = Model::$pdo->prepare($sql);
                $req_prep->execute($values);
                $tab = $req_prep->fetchAll();
                return $tab;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                    echo $e->getMessage();
                } else {
                    echo 'Une erreur est survenue lors de la récupération des données, veuillez réessayer plus tard.';
                }
                return false;
            }
        }

        public static function modify_RSS($new, $idRSS) {
            $sql = "UPDATE lienRSS SET lien=:tag_new WHERE id=:tag_idRSS";
            try {
                $values = array(
                    'tag_new' => $new,
                    'tag_idRSS' => $idRSS
                );
                $req_prep = Model::$pdo->prepare($sql);
                $req_prep->execute($values);
                return true;
            }
            catch (PDOException $e) {
                if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
                } else {
                    echo "Une erreur est survenue lors de la sauvegarde de l'objet $secteur, veuillez réessayer plus tard.";
                }
                return false;
            }
        }*/

    }
