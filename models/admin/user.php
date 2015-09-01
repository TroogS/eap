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

function getUsers() {

	global $db;
	return $db->getUsers ();

}

function getAgentsByUser($userId) {

	global $db;
	return $db->getAgentsByUser ( $userId );

}
?>