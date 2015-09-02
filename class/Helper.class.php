<?php

/**
 * Static helper class operations
 *
 * @author Andre Beging
 */
class Helper {

	/**
	 * Generates a 32 character long UUID
	 *
	 * @return string UUID
	 */
	public function generateUUID() {

		return sprintf ( '%04x%04x%04x%04x', mt_rand ( 0, 0xffff ), mt_rand ( 0, 0xffff ), mt_rand ( 0, 0xffff ), mt_rand ( 0, 0x0fff ) | 0x4000 );
	
	}

	/**
	 * Creates a verification code with the pattern VER-NAM-dn34sag, where NAM is the first 3 letters to uppercase and 8 random characters
	 *
	 * @param string $agentName        	
	 * @return string
	 */
	public function createVerificationCode($agentName = null) {

		$code = strtoupper ( $agentName );
		$code = substr ( $code, 0, 3 );
		$code .= "-" . substr ( md5 ( microtime () ), rand ( 0, 23 ), 8 );
		
		return "VER-" . $code;
	
	}

	/**
	 * Redirects to the current page to prevent multiple POST form submissions
	 */
	public function redirectToSelf() {

		$protocol = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? 'https://' : 'http://';
		header ( 'Location: ' . $protocol . $_SERVER ["HTTP_HOST"] . $_SERVER ["REQUEST_URI"] );
		exit ( "Redirection: This should never be displayed" );
	
	}

	/**
	 *
	 * @param string $file        	
	 * @return unknown boolean
	 */
	public function file_exists_ci($file) {

		if (file_exists ( $file )) {
			return $file;
		}
		$lowerfile = strtolower ( $file );
		foreach ( glob ( dirname ( $file ) . '/*' ) as $file ) {
			if (strtolower ( $file ) == $lowerfile) {
				return $file;
			}
		}
		return FALSE;
	
	}
	
	/**
	 * Returns a DateTime-String formattet to YYYY-MM-DD HH:MM:SS
	 */
	public function now() {
		$dateTime = new DateTime('NOW');
		return $dateTime->format("Y-m-d H:i:s");
		
	}

}