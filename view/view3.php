<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php if (isset($pagetitle) && !empty($pagetitle)) echo $pagetitle; else echo "Page Utilisateur";?></title>
  <!-- Bootstrap core CSS-->
  <link href="design2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="design2/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="design2/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="design2/css/sb-admin.css" rel="stylesheet">
   <link rel="shortcut icon" href="./aitec.png" type="image/x-icon">
</head>


<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="./index.php">Retour à l'accueil</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="./index.php?act=menu&c=utilisateur">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Tableau de bord</span>
          </a>
        </li>

         <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Mon Compte">
          <a class="nav-link" href="./index.php?act=details&c=utilisateur">
            <i class="fa fa-fw fa-drivers-license"></i>
            <span class="nav-link-text">Mon compte</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Mes formulaires">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-sitemap"></i>
            <span class="nav-link-text">Mes formulaires</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti">

            <li>
              <a href="#">Informations générales</a>
            </li>
            <?php if (Session::is_connected() && isset($formulaires) && !empty($formulaires)) {
              $j  = 0;
              foreach ($formulaires as $form) { ?>
                <li>
                  <a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti<?=$j?>"><?php echo $form->get('nom')?></a>
                  <ul class="sidenav-third-level collapse" id="collapseMulti<?=$j?>">
                    <li>
                      <a href="./index.php?c=form&act=details&id=<?php echo $form->getObjectId();?>">Détails</a>
                    </li>
                    <li>
                      <a href="./index.php?c=form&act=reponses&id=<?php echo $form->getObjectId();?>">Réponses</a>
                    </li>
                    <li>
                      <a href="./index.php?c=form&act=update&id=<?php echo $form->getObjectId();?>">Modifier / Supprimer</a>
                    </li>
                  </ul>
                </li>
              <?php
               $j++;
              }
            }?>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Graphiques">
          <a class="nav-link" href="./index.php?act=create&c=form">
            <i class="fa fa-fw fa-rocket"></i>
            <span class="nav-link-text">Créer un formulaire</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Graphiques">
          <a class="nav-link" href="#">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Graphiques</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Premium">
          <a class="nav-link" href="./index.php?act=premium&c=utilisateur">
            <i class="fa fa-fw fa-trophy"></i>
            <span class="nav-link-text">Espace premium</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="A propos">
          <a class="nav-link" href="#">
            <i class="fa fa-fw fa-bookmark"></i>
            <span class="nav-link-text">A propos</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>

      <!-- fin de la navigation latérale gauche -->

      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-envelope"></i>
            <span class="d-lg-none">Messages
              <span class="badge badge-pill badge-primary">12 New</span>
            </span>
            <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <h6 class="dropdown-header">New Messages:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>David Miller</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>Jane Smith</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>John Doe</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all messages</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Alerts
              <span class="badge badge-pill badge-warning">6 New</span>
            </span>
            <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">New Alerts:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-danger">
                <strong>
                  <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all alerts</a>
          </div>
        </li>
        <li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for...">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
        <li class="nav-item">
          <a class="nav-link" href = "./index.php?act=deconnected&c=utilisateur">
            <i class="fa fa-fw fa-sign-out"></i>Me déconnecter</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Fin de la navigation -->


<?php
if (isset($folder) && !empty($folder) && !is_null($folder) && isset($view) && !empty($view) && !is_null($view)) {
  require_once File::build_path(array('view', $folder, $view.'.php'));
}else{
  if (isset($view) && !empty($view) && !is_null($view)) {
  	require_once File::build_path(array("view","panel",$view.'.php'));
  }
}
?>

  </body>
    <script src="design2/vendor/jquery/jquery.min.js"></script>
    <script src="design2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="design2/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="design2/js/sb-admin.js"></script>
</html>
