<?php
/**
 * @author Andre Beging
 *
 */
class Admin_Controller extends Controller {
	
	protected $defaultMethod = "config";
	
	function __construct() {
		parent::__construct ();
		

		
		if (DEBUG === 1) {
			var_dump ( "Inside " . get_class () );
		}
	}
	public function config($args = false) {
		require 'models/admin/config.php';
		if (file_exists ( "views/admin/config.php" )) {
			$this->view->render ( "admin/config" );
		}
	}

	public function leads() {
		require 'models/admin/leads.php';
		if (file_exists ( "views/admin/leads.php" )) {
			$this->view->render ( "admin/leads" );
		}
	}
	
	public function user() {
		
		$args = func_get_args();
		if(isset($args[0]) && strtolower($args[0]) == strtolower("edit")) {
			if(isset($args[1]) && is_numeric($args[1])) {
				return $this->editUser($args[1]);
			}
		}
		
		require 'models/admin/user.php';
		if (file_exists ( "views/admin/user.php" )) {
			$this->view->render ( "admin/user" );
		}
	}
	
	private function editUser($userId) {
		require 'models/admin/edituser.php';
		if (file_exists ( "views/admin/edituser.php" )) {
			$this->view->render ( "admin/edituser" );
		}
	}
	
	public function info($args = null) {
		$targetId = ( int ) $args;
		
		if ($targetId == null) {
			return $this->overview ();
		}
		require 'models/user/info.php';
		if (file_exists ( "views/user/info.php" )) {
			$this->view->render ( "user/info" );
		}
	}
	public function profile() {
		require 'models/user/profile.php';
		if (file_exists ( "views/user/profile.php" )) {
			$this->view->render ( "user/profile" );
		}
	}
	public function delete($args = null) {
		$targetId = ( int ) $args;
		
		if ($targetId == null) {
			return $this->overview ();
		}
		require 'models/user/delete.php';
		if (file_exists ( "views/user/delete.php" )) {
			$this->view->render ( "user/delete" );
		}
	}
	public function changepassword($args = null) {
		$targetId = ( int ) $args;
		
		if ($targetId == null) {
			return $this->overview ();
		}
		
		require 'models/user/changepassword.php';
		if (file_exists ( "views/user/changepassword.php" )) {
			$this->view->render ( "user/changepassword" );
		}
	}
}