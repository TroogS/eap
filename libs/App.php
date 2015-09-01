<?php

/**
 * Bootstrap class for project
 *
 * @author Andre Beging
 *        
 */
class App {

	protected $controller = 'Public_Controller'; // default controller
	protected $method = 'landing';

	protected $params = array ();

	function __construct() {

		$GLOBALS ['google'] = false;
		$GLOBALS ['userProfile'] = false;
		$GLOBALS ['user'] = false;
		
		$url = $this->parseUrl ();
		if ($url [0] == "public") {
			return $this->regularCall ( $url );
			exit ();
		}
		
		// Bridge for public controller, no login required
		global $hybrid;
		global $db;
		
		if (! $hybrid) {
			$this->loginCall ();
			return;
		}
		// At this point, the user is authenticated with his google account
		
		// Logout has to be available
		if (isset ( $url [0] ) && $url [0] == "login") {
			if (isset ( $url [1] ) && $url [1] == "logout") {
				return $this->logoutCall ();
			}
		}
		
		$GLOBALS ['google'] = $hybrid->getAdapter ( "Google" );
		$google = $GLOBALS ['google'];
		
		// Is User connected?
		if (! $google->isUserConnected ()) {
			$this->loginCall ();
		}
		else {
			try {
				// Try to retrieve data
				// If this fails, the user could have deauthorized the app
				$GLOBALS ['userProfile'] = $google->getUserProfile ();
				$GLOBALS ['user'] = $db->getUser ( $GLOBALS ['userProfile']->identifier );
				
				if (! $GLOBALS ['user']) {
					return $this->registerCall ();
				
				}
				
				return $this->regularCall ( $url );
			}
			catch ( Exception $e ) {
				// On possible deauthorization, automated logout
				$this->logoutCall ();
			}
		}
	
	}

	/**
	 * Called if app is connected but not a registered user
	 */
	private function registerCall() {

		$this->controller = 'Login_Controller';
		$this->method = 'register';
		
		require 'controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller ();
		
		$this->controller->{$this->method} ();
	
	}

	/**
	 * Called if app is not connected to users google account
	 */
	private function loginCall() {

		$this->controller = 'Login_Controller';
		$this->method = 'login';
		
		require 'controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller ();
		
		$this->controller->{$this->method} ();
	
	}

	/**
	 * Called when the user has possibly deauthorized the app
	 */
	private function logoutCall() {

		$this->controller = 'Login_Controller';
		$this->method = 'logout';
		
		require 'controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller ();
		
		$this->controller->{$this->method} ();
	
	}

	/**
	 * Called if the app is connected to a google account
	 */
	private function regularCall($url) {

		global $helper;
		
		$controllerName = strtoupper ( substr ( $url [0], 0, 1 ) ) . strtolower ( substr ( $url [0], 1 ) );
		
		if (file_exists ( 'controllers/' . $controllerName . '_Controller.php' )) {
			$this->controller = $controllerName . "_Controller";
			unset ( $url [0] );
		
		}
		
		require 'controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller ();
		
		if (isset ( $url [1] )) {
			
			$this->method = $url [1];
			unset ( $url [1] );
			
			$this->params = $url ? array_values ( $url ) : array ();
			
			call_user_func_array ( array (
					$this->controller,
					$this->method 
			), $this->params );
		}
		else {
			$this->controller->{$this->method} ();
		}
	
	}

	/**
	 * Parses the url given via GET and returns an array
	 *
	 * Returns false is no url was set
	 *
	 * @return multitype: boolean
	 */
	private function parseUrl() {

		if (isset ( $_GET ['url'] )) {
			$urlParams = rtrim ( $_GET ['url'], '/' );
			$urlParams = filter_var ( $urlParams, FILTER_SANITIZE_URL );
			$urlParams = explode ( '/', $urlParams );
			
			return $urlParams;
		}
		return false;
	
	}

}