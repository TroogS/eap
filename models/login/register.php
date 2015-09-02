<?php
global $helper;
global $google;
global $userProfile;
global $db;

if ($google->isUserConnected ()) {
	
	$openLead = $db->getLead ( $userProfile->identifier );
	
	if ($openLead) {
	}
	else {
		$verificationCode = null;
		$errorMsg = "";
		if (isset ( $_POST ["action"] ) && $_POST ["action"] == "performRegister") {
			
			if (! isset ( $_POST ["agentLevel"] ) || $_POST ["agentLevel"] == "") {
				$errorMsg .= "Level invalid";
			}
			
			if (! isset ( $_POST ["agentName"] ) || $_POST ["agentName"] == "") {
				$errorMsg .= "Agentname invalid";
			}
			
			if (! isset ( $_POST ["agentArea"] ) || $_POST ["agentArea"] == "") {
				$errorMsg .= "Area invalid";
			}
			
			if ($errorMsg == "") {
				if ($google->isUserConnected ()) {
					
					$verificationCode = $helper->createVerificationCode ( $_POST ["agentName"] );
					
					$db->createLead ( $userProfile->identifier, $userProfile->displayName, $userProfile->email, $userProfile->photoURL, @$_POST ["agentArea"], @$_POST ["agentReference"], $verificationCode, @$_POST ["agentName"], 0, @$_POST ["agentLevel"] );
				}
			}
		}
	}
}

/**
 * Gets a lead by the users google id
 */
function leadExists() {

	global $db;
	global $userProfile;
	
	return $db->getLead ( $userProfile->identifier );

}

?>