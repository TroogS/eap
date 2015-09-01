<?php

function getAgent() {

	global $db;
	global $userProfile;
	
	var_dump($userProfile);
	
	return $db->getAgentByGoogleId($userProfile->identifier);
	
}