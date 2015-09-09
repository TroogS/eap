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

		/**
		 * Gets active leads
		 *
		 * @return multitype:
		 */
		function getActiveLeads() {

			global $db;
			return $db->getActiveLeads ();
		
		}

		/**
		 * Gets inactive leads
		 *
		 * @return multitype:
		 */
		function getInactiveLeads() {

			global $db;
			return $db->getInactiveLeads ();
		
		}

		/**
		 * Get all users
		 *
		 * @return multitype:
		 */
		function getUsers() {

			global $db;
			return $db->getUsers ();
		
		}
	
	}

}