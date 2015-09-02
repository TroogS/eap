<?php

/**
 * Controls view operations, renders views
 *
 * @author Andre Beging
 *        
 */
class View {

	function __construct() {

		if (DEBUG === 1) {
			var_dump ( "Inside " . get_class () );
		}
	
	}

	/**
	 * Includes all files needed for the actual page
	 *
	 * @param string $name
	 *        	Name of the view
	 */
	public function render($name) {

		global $nav;
		
		require 'views/header.php';
		require 'models/navigation.php';
		require 'views/navigation.php';
		require 'views/' . $name . '.php';
		require 'views/footer.php';
	
	}

}