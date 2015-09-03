<?php
$GLOBALS ["userId"] = $userId;
global $db;
global $helper;

if (isset ( $_POST ["action"] ) && $_POST ["action"] == "updateUser") {
	
	$error = false;
	if (! isset ( $_POST ["userArea"] )) {
		$error = true;
	}
	
	#if (! isset ( $_POST ["userGroup"] ) || ! in_array ( $_POST ["userGroup"], $helper->groups )) {
	if (! isset ( $_POST ["userGroup"] )) {
		$error = true;
	}
	
	if (! $error) {
		$db->updateUserAdmin ( $userId, $_POST ["userGroup"], $_POST ["userArea"] );
		$helper->redirectToSelf ();
	}

}

/**
 * Get the user to edit
 *
 * @return multitype:
 */
function getUser() {

	global $db;
	global $userId;
	
	return $db->getUserById ( $userId );

}

/**
 * Get the users group
 */
function getGroup() {

	global $db;
	global $userId;
	
	return $db->getGroupByUserId ( $userId );

}