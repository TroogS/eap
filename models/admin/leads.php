<?php
global $db;

if (isset ( $_POST ["action"] ) && $_POST ["action"] == "removeLead") {
	
	if (isset ( $_POST ["leadId"] ) && is_numeric ( $_POST ["leadId"] )) {
		global $helper;
		$db->removeLead ( $_POST ["leadId"] );
		$helper->redirectToSelf ();
	}

}

if (isset ( $_POST ["action"] ) && $_POST ["action"] == "approveLead") {
	var_dump ( $_POST ["action"] );
	
	if (isset ( $_POST ["leadId"] ) && is_numeric ( $_POST ["leadId"] )) {
		var_dump ( $_POST ["leadId"] );
		global $helper;
		echo $db->approveLead ( $_POST ["leadId"] );
		// $helper->redirectToSelf ();
	}

}

/**
 * Gets active leads
 *
 * @return multitype:
 */
function getActiveLeads() {

	global $db;
	return $db->getActiveLeads ();

}

/**
 * Gets inactive leads
 *
 * @return multitype:
 */
function getInactiveLeads() {

	global $db;
	return $db->getInactiveLeads ();

}
?>