<?php

// Inclusion des differents controllers
require_once File::build_path(array('controller','Controller.php'));
require_once File::build_path(array('controller', 'ControllerUtilisateur.php'));
require_once File::build_path(array('controller', 'ControllerForm.php'));

//  Récupération des données liée  au controller et à l'action
if(isset($_GET['c'])){ // si le controller est dans l'URL
    $controller = htmlspecialchars($_GET['c']); // on attribue la valeur contenue dans l'URL à la variable controller
}else{ // s'il n'est pas dans controller
    $controller = ""; // on définit la variable controller comme une variable vide
}
if(isset($_GET['act'])){ // si l'on a une action dans l'URL
    $action = htmlspecialchars($_GET['act']); // la variable action prend celle contenue dans l'URL
}else{ // si l'on a pas d'action dans l'URL
    if(!isset($_GET['c'])){ // si l'on a pas de controller
        $action = 'retourAccueil'; // la variable action prend la valeur retourAccueil afin de rediriger l'utilisateur vers l'accueil
    }else { // si l'on a cependant un controller
        $action = 'readAll'; // la variable action prend la valeur readAll, on amène donc l'utilisateur à lister le contenu du controller en question s'il en possède les droits
    }
}

// Initialisation de la variable de classe du controller
$controller_class = 'Controller' . ucfirst($controller); 
// on concatène la chaine de caractère Controller avec celle présente dans la variable controller dont on met en majuscule sont premier caractère

//  Vérification de l'existence de la classe et du controlleur et appel de celui ci
if(class_exists($controller_class)){ // on vérifie que la classe du controller existe
    $allActions = get_class_methods($controller_class); // récupère tous les noms de fonctions que possède ce dernier dans un tableau
    if(in_array($action, $allActions)){ // si l'action saisis dans l'URL est présente dans ce tableau de fonctions
        $controller_class::$action(); // on appel alors le controller avec l'action souhaité par l'utilisateur
    }else{ // si l'action n'est pas dans le tableau de fonctions du controller
        Controller::retourAccueil(); // on renvoit l'utilisateur à l'accueil
    }
}else{ // si le controller ne possède pas la classe demandée
    Controller::error("Controller introuvable"); // on affiche une erreur
}
