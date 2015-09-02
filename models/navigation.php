<?php
// SETUP //
global $hybrid;
if ($hybrid) {
	$google = $GLOBALS ['google'];
	$userProfile = $GLOBALS ['userProfile'];
}

// LOGIC //
if (isLoggedIn ()) {
	$nav->addItem ( new NavBarItem ( "Mein Profil", PROJECT_ROOT . "/me", "" ) );
	
	// ADMIN
	$leadNotificationCount = getLeadCount ();
	$leadNotification = ($leadNotificationCount == 0 ? "" : " (" . $leadNotificationCount . ")");
	
	$adminNotificationCount = $leadNotificationCount;
	$adminNotification = ($adminNotificationCount == 0 ? "" : " (" . $adminNotificationCount . ")");
	
	$dropDown = new NavBarDropDown ( "Admin" . $adminNotification );
	$dropDown->addItem ( new NavBarItem ( "Anfragen" . $leadNotification, PROJECT_ROOT . "/admin/leads", "" ) );
	$dropDown->addItem ( new NavBarItem ( "Benutzer", PROJECT_ROOT . "/admin/user", "" ) );
	$nav->addItem ( $dropDown );
	
	$nav->addItem ( new NavBarItem ( "Logout", PROJECT_ROOT . "/login/logout", "" ) );
}
else {
	$nav->addItem ( new NavBarItem ( "Info", PROJECT_ROOT . "/public", "" ) );
	$nav->addItem ( new NavBarItem ( "Login", PROJECT_ROOT . "/login", "" ) );
}

/**
 * Checks if the user is logged in
 */
function isLoggedIn() {

	global $hybrid;
	global $google;
	
	if ($hybrid && $google) {
		return $google->isUserConnected ();
	}
	return false;

}

/**
 * Get the name to display in the top right of the navigation bar
 *
 * @param number $maxLength        	
 * @return string
 */
function getName($maxLength = 15) {

	global $userProfile;
	
	$displayName = "";
	if ($userProfile) {
		$displayName = $userProfile->email;
	}
	
	$displayName = trunc ( $displayName, $maxLength );
	
	return $displayName;

}

/**
 * Trunctates a string by a given length
 * Used to shorten a name for responsive navigation bar
 *
 * @param string $string        	
 * @param int $maxLength        	
 * @return string
 */
function trunc($string, $maxLength) {

	if (strlen ( $string ) > $maxLength) {
		$string = substr ( $string, 0, ($maxLength - 3) ) . "...";
	}
	
	return $string;

}

/**
 * Gets the users profile picture
 */
function getPicture() {

	global $userProfile;
	
	if ($userProfile) {
		return $userProfile->photoURL;
	}
	return false;

}

/**
 * Gets count of the active leads
 *
 * @return number
 */
function getLeadCount() {

	global $db;
	return $db->getLeadCount ();

}

?>