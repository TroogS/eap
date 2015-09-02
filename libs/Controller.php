<?php

/**
 * Controller super class
 *
 * @author Andre Beging
 *        
 */
class Controller {

	function __construct() {

		if (DEBUG === 1) {
			var_dump ( "Inside " . get_class () );
		}
		
		$this->view = new View ();
	
	}

	public function __call($name, $args) {

		if (! method_exists ( $this, $this->defaultMethod )) {
			header ( "Location: " . PROJECT_ROOT );
		}
		
		call_user_func_array ( array (
				$this,
				$this->defaultMethod 
		), $args );
	
	}

	/**
	 * Calls the default method based on the defaultMethod-Variable
	 *
	 * @param unknown $args        	
	 */
	public function defaultMethod($args) {

		call_user_func_array ( array (
				$this,
				$this->defaultMethod 
		), $args );
	
	}

}