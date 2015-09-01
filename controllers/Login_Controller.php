<?php

/**
 *
 * @author Andre Beging
 *        
 */
class Login_Controller extends Controller {

	protected $defaultMethod = "login";

	function __construct() {

		parent::__construct ();
		
		if (DEBUG === 1) {
			var_dump ( "Inside " . get_class () );
		}
	
	}

	public function login() {

		global $google;
		
		// if already logged in
		if ($google && $google->isUserConnected ()) {
			global $userProfile;
			
			if($userProfile) {
				header("Location: ".PROJECT_ROOT);
			}
			
			return $this->register ();
		}
		
		require 'models/login/login.php';
		if (file_exists ( "views/login/login.php" )) {
			$this->view->render ( "login/login" );
		}
	
	}

	public function register() {

		require 'models/login/register.php';
		if (file_exists ( "views/login/register.php" )) {
			$this->view->render ( "login/register" );
		}
	
	}

	public function logout() {

		require 'models/login/logout.php';
	
	}

}