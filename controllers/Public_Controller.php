<?php

/**
 *
 * @author Andre Beging
 *        
 */
class Public_Controller extends Controller {

	protected $defaultMethod = "landing";

	function __construct() {

		parent::__construct ();
		
		if (DEBUG === 1) {
			var_dump ( "Inside " . get_class () );
		}
	
	}

	public function landing() {

		require 'models/public/landing.php';
		if (file_exists ( "views/public/landing.php" )) {
			$this->view->render ( "public/landing" );
		}
	
	}

}