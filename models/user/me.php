<?php
global $db;
global $helper;

if (isset ( $_POST ["action"] ) && $_POST ["action"] == "updateAgent") {
	$error = false;
	
	// Check for valid agent level
	if (! isset ( $_POST ["agentLevel"] ) || ! ($_POST ["agentLevel"] >= 1 && $_POST ["agentLevel"] <= 16)) {
		$error == true;
	}
	
	// Check if the agents ap was submitted, must be numeric
	if (! isset ( $_POST ["agentAp"] ) || ! is_numeric ( $_POST ["agentAp"] )) {
		$error = true;
	}
	
	// Check if a valid agent id was submitted
	if (! isset ( $_POST ["agentId"] ) || $_POST ["agentId"] == "") {
		$error = true;
	}
	
	// Check if the users area was submitted
	if (! isset ( $_POST ["userArea"] )) {
		$error = true;
	}
	
	if (! $error) {
		$db->updateUserProfile ( $_POST ["agentId"], $_POST ["agentLevel"], $_POST ["agentAp"], $_POST ["userArea"] );
		$helper->redirectToSelf ();
	}
}

if (isset ( $_POST ["action"] ) && $_POST ["action"] == "createAgent") {
	$error = false;
	
	// Check if an agent name was submitted
	if (! isset ( $_POST ["agentName"] ) || $_POST ["agentName"] == "") {
		$error = true;
	
	}
	
	// Check for valid agent level
	if (! isset ( $_POST ["agentLevel"] ) || ! ($_POST ["agentLevel"] >= 1 && $_POST ["agentLevel"] <= 16)) {
		$error == true;
	
	}
	
	// Check if the agents ap was submitted, must be numeric
	if (! isset ( $_POST ["agentAp"] ) || ! is_numeric ( $_POST ["agentAp"] )) {
		$error = true;
	
	}
	
	// Check if the users area was submitted
	if (! isset ( $_POST ["userArea"] )) {
		$error = true;
	}
	
	// If all of the checks above succeeded
	if (! $error) {
		$db->createUserProfile ( $_POST ["agentName"], $_POST ["agentLevel"], $_POST ["agentAp"], $_POST ["userArea"] );
		$helper->redirectToSelf ();
	}
}

/**
 * Get the first agent associated with a user
 *
 * @return Ambigous <>|boolean
 */
function getAgent() {

	global $db;
	global $userProfile;
	
	$agentList = $db->getAgentByGoogleId ( $userProfile->identifier );
	
	if (isset ( $agentList [0] )) {
		return $agentList [0];
	}
	return false;

}

