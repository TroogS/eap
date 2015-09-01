<?php
global $google;

if (isset ( $_POST ['action'] ) && $_POST ['action'] == "connectGoogle") {
	
	if (! $google->isUserConnected ()) {
		$google->login ();
	}
}

?>