<?php

/**
 * Provides global functions
 *
 * @author Andre Beging
 *        
 */
class Functions {

	public function __construct() {

		function getSelf() {

			global $db;
			global $userProfile;
			
			return $db->getUser ( $userProfile->identifier );
		
		}
	
	}

}