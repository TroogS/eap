<?php
/**
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
// HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------
return array (
		"base_url" => "http://".$_SERVER["HTTP_HOST"]."/eap/hybrid/",
		
		"providers" => array (
				// openid providers
				"OpenID" => array (
						"enabled" => true 
				),
				
				"Yahoo" => array (
						"enabled" => true,
						"keys" => array (
								"key" => "",
								"secret" => "" 
						) 
				),
				
				"AOL" => array (
						"enabled" => true 
				),
				
				"Google" => array (
						"enabled" => true,
						"keys" => array (
								"id" => "1054247305267-ila6plveliikoukavf1i8ljmomc9gqiu.apps.googleusercontent.com",
								"secret" => "e5C8WSGwpQsHnSVIUOifwhba" 
						),
						"scope" => 	"https://www.googleapis.com/auth/userinfo.profile " .
						"https://www.googleapis.com/auth/userinfo.email",
						"access_type" => "offline", // offline // optional
						"approval_prompt" => "auto"  // force // optional
												                                // "hd" => "domain.com" // optional
								),
				
				"Facebook" => array (
						"enabled" => true,
						"keys" => array (
								"id" => "",
								"secret" => "" 
						),
						"trustForwarded" => false 
				),
				
				"Twitter" => array (
						"enabled" => true,
						"keys" => array (
								"key" => "",
								"secret" => "" 
						) 
				),
				
				// windows live
				"Live" => array (
						"enabled" => true,
						"keys" => array (
								"id" => "",
								"secret" => "" 
						) 
				),
				
				"LinkedIn" => array (
						"enabled" => true,
						"keys" => array (
								"key" => "",
								"secret" => "" 
						) 
				),
				
				"Foursquare" => array (
						"enabled" => true,
						"keys" => array (
								"id" => "",
								"secret" => "" 
						) 
				) 
		),
		
		// If you want to enable logging, set 'debug_mode' to true.
		// You can also set it to
		// - "error" To log only error messages. Useful in production
		// - "info" To log info and error messages (ignore debug messages)
		"debug_mode" => false,
		
		// Path to file writable by the web server. Required if 'debug_mode' is not false
		"debug_file" => "" 
);
