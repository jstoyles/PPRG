<?php
ini_set('display_errors', 'on'); //enabled for debugging and should be commented out in a production environment
error_reporting(E_ALL ^ E_NOTICE); //enabled for debugging and should be commented out in a production environment
//ini_set('display_errors', 'off'); //disabled for debugging and should be uncommented in a production environment
//error_reporting(0); //disabled for debugging and should be uncommented in a production environment

require_once('../app/config.php');
require_once('../app/app.php');
require_once('../app/routes.php');

$view = 'home.phtml'; //default
$controller = 'home.php'; //default
$model = 'repos.php'; //default

$app = new App();
$app->init();
?>