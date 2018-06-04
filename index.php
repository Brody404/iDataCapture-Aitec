<?php
    require 'autoload.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'File.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Session.php';
    $routeur = File::build_path(array("controller", "routeur.php"));
    require_once $routeur;
