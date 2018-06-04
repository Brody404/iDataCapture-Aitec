<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php if (isset($pagetitle) && !empty($pagetitle)) echo $pagetitle; else echo "Page Utilisateur";?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="Site iDataCapture" name="description" />
        <meta content="AitecServices" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="./assets/images/favicon.ico">

        <?php if (Session::is_connected() && isset($_GET['c']) && strcmp($_GET['c'],"form") == 0 && isset($_GET['act']) && strcmp($_GET['act'], 'etape3') == 0) { ?>
          <link href="./assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <?php } ?>

        <!-- App css -->
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="./assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />
        <?php if (Session::is_connected() && isset($_GET['act']) && isset($_GET['c']) && strcmp($_GET['act'],'etape3') == 0 && strcmp($_GET['c'],'form') == 0)
          echo "<script src=\"assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js\"></script>"; ?>
        <script src="./assets/js/modernizr.min.js"></script>

    </head>

    <body>

        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo container-->
                    <div class="logo">
                        <!-- Text Logo -->
                        <!--<a href="index.html" class="logo">-->
                            <!--<span class="logo-small"><i class="mdi mdi-radar"></i></span>-->
                            <!--<span class="logo-large"><i class="mdi mdi-radar"></i> Adminto</span>-->
                        <!--</a>-->
                        <!-- Image Logo -->
                        <a href="index.html" class="logo">
                            <img src="./assets/images/logo-sm.png" alt="" height="26" class="logo-small">
                            <img src="./assets/images/logo.png" alt="" height="24" class="logo-large">
                        </a>

                    </div>
                    <!-- End Logo container-->


                    <div class="menu-extras topbar-custom">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">

                            <li class="menu-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>
                            <li class="hide-phone">
                                <form class="app-search">
                                    <input type="text" placeholder="Rechercher..."
                                           class="form-control">
                                    <button type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </li>

                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="./assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">
                                </a>

                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                  <?php if (Session::is_connected()) { ?>
                                        <!-- item-->
                                        <a href="./index.php?act=details&c=utilisateur" class="dropdown-item notify-item">
                                            <i class="ti-user m-r-5"></i> Mon compte
                                        </a>

                                        <!-- item-->
                                        <a href="./index.php?act=update&c=utilisateur" class="dropdown-item notify-item">
                                            <i class="ti-settings m-r-5"></i> Modifier mon compte
                                        </a>

                                        <!-- item-->
                                        <a href="./index.php?act=abonnement&c=utilisateur" class="dropdown-item notify-item">
                                            <i class="ti-lock m-r-5"></i> Mon abonnement
                                        </a>

                                        <!-- item-->
                                        <a href="./index.php?act=deconnected&c=utilisateur" class="dropdown-item notify-item">
                                            <i class="ti-power-off m-r-5"></i> Me déconnecter
                                        </a>
                                  <?php }else{ ?>
                                        <!-- item-->
                                        <a href="./index.php?act=connect&c=utilisateur" class="dropdown-item notify-item">
                                            <i class="ti-user m-r-5"></i> Me connecter
                                        </a>

                                        <!-- item-->
                                        <a href="./index.php?act=create&c=utilisateur" class="dropdown-item notify-item">
                                            <i class="ti-plus m-r-5"></i> Créer un compte
                                        </a>

                                        <!-- item-->
                                        <a href="./index.php?c=utilisateur&act=recuperation" class="dropdown-item notify-item">
                                            <i class="ti-key m-r-5"></i> Oublie de mot de passe
                                        </a>

                                  <?php } ?>

                                </div>
                            </li>

                        </ul>
                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <div class="navbar-custom">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">

                          <li class="has-submenu">
                              <a href="./index.php"><i class="mdi mdi-home"></i> <span> Acceuil </span></a>
                          </li>
                            <!-- Début du menu des utilisateurs connectés -->
                          <?php if (Session::is_connected()) { ?>
                              <li class="has-submenu">
                                  <a href="./index.php?act=menu&c=utilisateur"><i class="mdi mdi-airplay "></i> <span> Tableau de bord </span> </a>
                              </li>

                              <li class="has-submenu">
                                  <a href="#"><i class="mdi mdi-sitemap"></i> <span> Mes formulaires </span> </a>
                                  <ul class="submenu">
                                    <li><a href="./index.php?c=form&act=selectAll">Voir mes formulaires</a></li>
                                    <li><a href="./index.php?c=form&act=create">Créer un nouveau formulaire</a></li>
                                  </ul>
                              </li>

                              <li>
                                <a href="./index.php?act=menu&c=utilisateur"><i class="mdi mdi-animation"></i> <span> Formulaires partagés </span> </a>
                                <?php if (isset($formulaires_partages) && !empty($formulaires_partages)) { ?>
                                  <ul class="submenu">
                                  <?php foreach ($formulaires_partages as $form) { ?>
                                    <li><a href="./index.php?c=form&act=select&id=<?php echo $form->getObjectId();?>"><?php echo $form->get('nom');?></a></li>
                                 <?php } ?>
                                </ul>
                              <?php } ?>
                              </li>
                          <?php } ?>
                            <!-- Fin du menu des utilisateurs connectés -->
                            <li class="has-submenu">
                                <a href="./index.php?act=premium&c=utilisateur"><i class="mdi mdi-trophy-award"></i><span> Abonnements </span></a>
                            </li>
                            <li class="has-submenu">
                                <a href="#"><i class="mdi mdi-help"></i> <span> A propos </span> </a>
                                <ul class="submenu">
                                    <li><a href="./index.php?act=help">Aide</a></li>
                                    <li><a href="./index.php?act=FAQ">FAQ</a></li>
                                    <li><a href="./index.php?act=descripton">Notre entreprise</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <?php if (Session::is_connected() && isset($_GET['c']) && strcmp($_GET['c'],"form") == 0 && isset($_GET['act']) && strcmp($_GET['act'], 'create') == 0) { ?>
          <div class="wrapper" id = "formulaire">
        <?php }else{ ?>
        <div class="wrapper">
        <?php } ?>
            <div class="container-fluid">

              <?php if (isset($folder) && !empty($folder) && !is_null($folder) && isset($view) && !empty($view) && !is_null($view))
                        require_once File::build_path(array('view', $folder, $view.'.php'));
                    else{
                      if (isset($view) && !empty($view) && !is_null($view))
                        require_once File::build_path(array("view","panel",$view.'.php'));
                    } ?>

            </div>
            <!-- container-fluid -->
        </div>
        <!-- end wrapper -->

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        2018 © AitecServices
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->

        <!-- jQuery  -->
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/popper.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
        <script src="./assets/js/waves.js"></script>
        <script src="./assets/js/jquery.slimscroll.js"></script>

        <?php if (Session::is_connected() && isset($_GET['act']) && isset($_GET['c']) && strcmp($_GET['act'],'etape3') == 0 && strcmp($_GET['c'],'form') == 0)
          echo "<script src=\"./assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js\"></script>"; ?>
        <!-- App js -->
        <script src="./assets/js/jquery.core.js"></script>
        <script src="./assets/js/jquery.app.js"></script>


    </body>
</html>
