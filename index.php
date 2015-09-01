<?php
header("Content-Type: text/html; charset=utf-8");
ini_set('display_errors', '1');
define("DEBUG", 0);


/**
 * Constants
 */
define("PROJECT_ROOT","/eap");


require 'hybrid/Hybrid/Auth.php';
$hybridConfig = dirname(__FILE__) . '/hybrid/config.php';

// Try to trigger authentication
// If this fails, the user has propably cancelled the authentication process
try {
	$hybrid = new Hybrid_Auth($hybridConfig);
} catch (Exception $e) {
	$hybrid = false;
}


require 'connect.php';
require 'class/Database.class.php';
require 'class/Helper.class.php';
#require 'class/Session.class.php';
require 'class/Navigation.php';

/**
 * Autoload libraries from /libs/
 *
 * @param $files
 */ 
function __autoload($files) {
	require 'libs/' . $files . '.php';
}
#spl_autoload_register('__autoload');

#session_start();
#$session = new Session();
$helper = new Helper();
$GLOBALS['helper'] = $helper;
$db = new Database();
$GLOBALS['db'] = $db;

$nav = new Navigation();
$app = new App();
$db->close();
