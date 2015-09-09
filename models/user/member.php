<?php
global $db;
global $helper;

/**
 * Gets the member list
 * 
 * @return Ambigous <multitype:, multitype:>
 */
function getMemberList() {

	global $db;
	
	return $db->getMemberList ();

}

