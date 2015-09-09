<?php
global $db;

if (isset ( $_POST ["action"] ) && $_POST ["action"] == "freezeUser") {
	
	if (isset ( $_POST ["userId"] ) && is_numeric ( $_POST ["userId"] )) {
		global $helper;
		$db->freezeUser ( $_POST ["userId"] );
		$helper->redirectToSelf ();
	}

}

if (isset ( $_POST ["action"] ) && $_POST ["action"] == "unfreezeUser") {
	
	if (isset ( $_POST ["userId"] ) && is_numeric ( $_POST ["userId"] )) {
		global $helper;
		$db->unfreezeUser ( $_POST ["userId"] );
		$helper->redirectToSelf ();
	}

}

/**
 * Get all agents associated with a user
 *
 * @param int $userId        	
 * @return Ambigous <multitype:, multitype:>
 */
function getAgentsByUser($userId) {

	global $db;
	return $db->getAgentsByUser ( $userId );

}
?>