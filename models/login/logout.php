<?php
global $hybrid;
$google = $hybrid->getAdapter("Google");

	if($google->isUserConnected()) {
		$google->logout();
	}
	
header("Location: ".PROJECT_ROOT);
?>