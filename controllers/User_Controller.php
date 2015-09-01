<?php
/**
 * @author Andre Beging
 *
 */
class User_Controller extends Controller {
	
	protected $defaultMethod = "me";
	
	function __construct() {
		parent::__construct ();
		

		
		if (DEBUG === 1) {
			var_dump ( "Inside " . get_class () );
		}
	}

	public function me() {
		require 'models/user/me.php';
		if (file_exists ( "views/user/me.php" )) {
			$this->view->render ( "user/me" );
		}
	}
}