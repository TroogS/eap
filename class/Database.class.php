<?php

/**
 * Controls database connection and operations
 *
 * @author Andre Beging
 *        
 */
class Database extends Mysqli {

	public function __construct() {

		parent::__construct ( DB_HOST, DB_USER, DB_PASS, DB_NAME, NULL, NULL );
	
	}

	/**
	 * Get a single user by id from database
	 *
	 * @param int $userId
	 *        	User ID
	 * @return Array with user data
	 */
	public function getUser($googleId) {

		$query = "SELECT * FROM `user` WHERE googleid = '{$googleId}'";
		$result = $this->query ( $query );
		
		return $result->fetch_array ( MYSQL_ASSOC );
	
	}

	/**
	 * Get a user by his id
	 *
	 * @param int $userId        	
	 */
	public function getUserById($userId) {

		$query = "SELECT * FROM `user` WHERE id = '{$userId}'";
		$result = $this->query ( $query );
		
		return $result->fetch_array ( MYSQL_ASSOC );
	
	}

	/**
	 * Get the users group
	 *
	 * TODO DB Changes
	 *
	 * @param int $userId        	
	 */
	public function getGroupByUserId($userId) {

		$query = "
			SELECT g.name
			FROM `user` u
			INNER JOIN `group` g ON u.group_id = g.id
			WHERE u.id = '{$userId}'";
		$result = $this->query ( $query );
		
		return $result->fetch_array ( MYSQL_ASSOC );
	
	}

	/**
	 * Writes a login into the login table
	 * Called when a user logs in
	 *
	 * @param string $googleId        	
	 */
	public function writeLogin($googleId) {

		$query = "INSERT INTO logins (googleid) VALUES ('{$googleId}');";
		
		if ($stmt = $this->prepare ( $query )) {
			$stmt->execute ();
			
			if ($this->error == '') {
				return $stmt->insert_id;
			}
			else {
				return $this->error;
			}
		}
	
	}

	/**
	 * Removes a user from database
	 *
	 * @param int $userId        	
	 * @return mixed
	 */
	public function deleteUser($googleId) {

		$query = "DELETE FROM user WHERE googleid = {$googleId};";
		$result = $this->query ( $query );
		
		return $result;
	
	}

	/**
	 * TODO DB Changes
	 *
	 * Removes a user from a group
	 *
	 * @param int $groupId        	
	 * @param int $userId        	
	 * @return mixed
	 */
	public function removeUserFromGroup($groupId, $userId) {

		$query = "DELETE FROM user_group WHERE user_id = {$userId} AND group_id = {$groupId}";
		$result = $this->query ( $query );
		
		return $result;
	
	}

	/**
	 * TODO DB Changes
	 *
	 * Adds a user to a group
	 *
	 * @param int $groupId        	
	 * @param int $userId        	
	 */
	public function addUserToGroup($groupId, $userId) {

		$query = "
				INSERT INTO user_group (id, user_id, group_id)
				VALUES (NULL, '{$userId}', '{$groupId}');
				";
		
		if ($stmt = $this->prepare ( $query )) {
			$stmt->execute ();
			
			if ($this->error == '') {
				return $stmt->insert_id;
			}
			else {
				return $this->error;
			}
		}
	
	}

	/**
	 * Get all users
	 *
	 * @param int $limit
	 *        	Limit users in response
	 * @return array User list
	 */
	public function getUsers() {

		$query = "SELECT * FROM user";
		$result = $this->query ( $query );
		$tmpresult = array ();
		
		while ( $row = $result->fetch_array ( MYSQL_ASSOC ) ) {
			array_push ( $tmpresult, $row );
		}
		
		return $tmpresult;
	
	}

	/**
	 * TODO DB Changes
	 *
	 * Gets users not in a certain group
	 *
	 * @param int $groupId        	
	 * @return multitype:
	 */
	public function getUsersNotInGroup($groupId) {

		$query = "
			SELECT *
			FROM user
			WHERE id NOT IN (
				SELECT user_id
				FROM user_group
				WHERE group_id = {$groupId}
			)
				";
		$result = $this->query ( $query );
		$tmpresult = array ();
		
		while ( $row = $result->fetch_array ( MYSQL_ASSOC ) ) {
			array_push ( $tmpresult, $row );
		}
		
		return $tmpresult;
	
	}

	/**
	 * Get group names
	 *
	 * @return multitype:
	 */
	public function getGroups() {

		$result = $this->processSelectQuery ( "
				SELECT `name` FROM `group`
				" );
		
		$groupNames = array ();
		foreach ( $result as $r ) {
			array_push ( $groupNames, $r ["name"] );
		}
		
		return $groupNames;
	
	}

	/**
	 * TODO geht noch nicht
	 *
	 * @param unknown $groupId        	
	 * @return multitype:
	 */
	public function getUsersByGroup($groupId) {

		$query = "
			SELECT DISTINCT(u.id) as id, u.firstname, u.lastname, u.email
			FROM users_groups ug
			INNER JOIN users u ON ug.user_id = u.id
			WHERE ug.group_id = {$groupId}
				";
		$result = $this->query ( $query );
		$tmpresult = array ();
		
		while ( $row = $result->fetch_array ( MYSQL_ASSOC ) ) {
			array_push ( $tmpresult, $row );
		}
		
		return $tmpresult;
	
	}

	/**
	 * TODO geht noch nicht
	 *
	 * @param unknown $userId        	
	 * @return multitype:
	 */
	public function getGroupsByUser($userId) {

		$query = "
			SELECT DISTINCT(group_id) as id, name, description 
			FROM users_groups ug
			INNER JOIN groups g 
			ON g.id = ug.group_id
			WHERE user_id = {$userId}
		";
		$result = $this->query ( $query );
		$tmpresult = array ();
		
		while ( $row = $result->fetch_array ( MYSQL_ASSOC ) ) {
			array_push ( $tmpresult, $row );
		}
		
		return $tmpresult;
	
	}

	/**
	 *
	 * @todo UEBERARBEITEN
	 *       Creates a new user
	 *      
	 * @param string $firstname
	 *        	First name
	 * @param string $lastname
	 *        	Last name
	 * @param string $profile_image
	 *        	Profile Image
	 * @param int $type
	 *        	User type
	 * @param string $email
	 *        	E-Mail
	 * @param string $salt
	 *        	Salt
	 * @param string $hash
	 *        	Password hash
	 */
	public function createUser($firstname, $lastname, $profile_image = "path", $type, $email, $salt, $hash) {

		$query = "
        INSERT INTO `users` (
            `lastname`,
            `firstname`,
            `profil_image`,
            `create_date`,
            `type`,
            `email`,
            `salt`,
            `hash_password`)
        VALUES (
            '{$lastname}',
            '{$firstname}',
            '{$profile_image}',
            CURRENT_TIMESTAMP,
            '{$type}',
            '{$email}',
            '{$salt}',
            '{$hash}'
        );
        ";
		
		if ($stmt = $this->prepare ( $query )) {
			$stmt->execute ();
			
			if ($this->error == '') {
				return $stmt->insert_id;
			}
			else {
				return $this->error;
			}
		}
	
	}

	/**
	 * Sets the group_id flag of a user to 0
	 *
	 * @param int $userId        	
	 * @return mixed
	 */
	public function freezeUser($userId) {

		$query = "UPDATE `user` SET `group_id` = '0' WHERE `id` = {$userId};";
		$result = $this->query ( $query );
		
		return $result;
	
	}

	/**
	 * Sets the group_id of a user to 0 (=frozen)
	 *
	 * @param int $userId        	
	 * @return mixed
	 */
	public function unfreezeUser($userId) {

		$query = "
			UPDATE `user`
			SET `group_id` = (
				SELECT id
				FROM `group` g
				WHERE `name` = 'user'
				LIMIT 1
				)
			WHERE `id` = '{$userId}'";
		$result = $this->query ( $query );
		
		return $result;
	
	}

	/**
	 * Gets all agents associated with a user
	 *
	 * @param int $userId        	
	 * @return multitype:
	 */
	public function getAgentsByUser($userId) {

		$agentList = $this->processSelectQuery ( "
			SELECT a.* FROM user_agent ua
			INNER JOIN user u ON u.id = ua.user_id
			INNER JOIN agent a ON a.id = ua.agent_id		
			WHERE ua.user_id = {$userId}
		" );
		
		return $agentList;
	
	}

	/**
	 * Gets agents associated with a user by his user id
	 *
	 * @param string $googleId        	
	 * @return multitype:
	 */
	public function getAgentByGoogleId($googleId) {

		$agentList = $this->processSelectQuery ( "
				SELECT a.* FROM user_agent ua
				INNER JOIN user u ON u.id = ua.user_id
				INNER JOIN agent a ON a.id = ua.agent_id
				WHERE u.googleid = {$googleId}
				" );
		
		return $agentList;
	
	}

	/**
	 * Creates a user lead
	 *
	 * @param string $googleId        	
	 * @param string $displayName        	
	 * @param string $email        	
	 * @param string $pictureUrl        	
	 * @param string $agentArea        	
	 * @param string $agentReference        	
	 * @param string $verificationCode        	
	 * @param string $agentName        	
	 * @param int $agentAP        	
	 * @param int $agentLevel        	
	 */
	public function createLead($googleId, $displayName, $email, $pictureUrl, $agentArea, $agentReference = "", $verificationCode, $agentName, $agentAP = 0, $agentLevel) {

		$query = "INSERT INTO `leads`
				(`id`, `googleid`, `name`, `email`, `photo`, `area`, `reference`, `verification`, `agent_name`, `agent_ap`, `agent_level`, `created`)
				VALUES (NULL, '{$googleId}', '{$displayName}', '{$email}', '{$pictureUrl}', '{$agentArea}', '{$agentReference}', '{$verificationCode}', '{$agentName}', '{$agentAP}', '{$agentLevel}', CURRENT_TIMESTAMP);";
		
		if ($stmt = $this->prepare ( $query )) {
			$stmt->execute ();
			
			if ($this->error == '') {
				return $stmt->insert_id;
			}
			else {
				return $this->error;
			}
		}
	
	}

	/**
	 * Gets a lead by the users google id
	 *
	 * @param string $googleId        	
	 */
	public function getLead($googleId) {

		$query = "SELECT * FROM `leads` WHERE googleid = '{$googleId}'";
		$result = $this->query ( $query );
		
		return $result->fetch_array ( MYSQL_ASSOC );
	
	}

	/**
	 * Gets the count of active leads
	 *
	 * @return int
	 */
	public function getLeadCount() {

		$query = "SELECT COUNT(*) as count FROM leads WHERE `active` = 1";
		$result = $this->query ( $query );
		
		$leadCount = $result->fetch_array ( MYSQL_ASSOC );
		$leadCount = $leadCount ["count"];
		
		return $leadCount;
	
	}

	/**
	 * Gets active leads
	 *
	 * @return array
	 */
	public function getActiveLeads() {

		$query = "SELECT * FROM `leads` WHERE `active` = 1 ORDER BY `created`";
		$result = $this->query ( $query );
		$tmpresult = array ();
		
		while ( $row = $result->fetch_array ( MYSQL_ASSOC ) ) {
			array_push ( $tmpresult, $row );
		}
		
		return $tmpresult;
	
	}

	/**
	 * Gets inactive leads
	 *
	 * @return array
	 */
	public function getInactiveLeads() {

		$query = "SELECT * FROM `leads` WHERE `active` = 0 ORDER BY `created`";
		$result = $this->query ( $query );
		$tmpresult = array ();
		
		while ( $row = $result->fetch_array ( MYSQL_ASSOC ) ) {
			array_push ( $tmpresult, $row );
		}
		
		return $tmpresult;
	
	}

	public function getMemberList() {

		$result = $this->processSelectQuery ( "
				SELECT u.name user_name, u.photo, u.area, a.name agent_name, a.ap, a.level, a.modified
				FROM `user` u
				INNER JOIN `user_agent` ug
				ON ug.user_id = u.id
				INNER JOIN `agent` a
				ON ug.agent_id = a.id" );
		
		return $result;
	
	}

	/**
	 * Sets the active flag of a lead to 0
	 *
	 * @param int $leadId        	
	 * @return mixed
	 */
	public function removeLead($leadId) {

		$query = "UPDATE `leads` SET `active` = '0' WHERE `id` = {$leadId};";
		$result = $this->query ( $query );
		
		return $result;
	
	}

	/**
	 * Creates the user and the agent from a lead and connects agent to user
	 *
	 * @param int $leadId        	
	 * @return boolean
	 */
	public function approveLead($leadId = -1) {

		$createUser = $this->processInsertQuery ( "
			INSERT INTO `user` (googleid, name, email, area, photo)
				SELECT `googleid`, `name`, `email`, `area`, `photo`
				FROM `leads`
				WHERE `id` = '{$leadId}'
		" );
		
		$createAgent = $this->processInsertQuery ( "
			INSERT INTO `agent` (`name`, `ap`, `level`)
				SELECT `agent_name`, `agent_ap`, `agent_level`
				FROM `leads`
				WHERE id = '{$leadId}'
		" );
		
		if (is_int ( $createUser ) && is_int ( $createAgent )) {
			
			// Connect User and Agent
			$this->processInsertQuery ( "
				INSERT INTO `user_agent`
				SELECT NULL, {$createAgent}, {$createUser};
			" );
			
			// Update lead
			$updateLead = $this->processInsertQuery ( "
				UPDATE `leads`
				SET `active` = 0, `accepted` = 1
				WHERE `id` = '{$leadId}';
			" );
			
			if ($updateLead) {
				return true;
			}
			return false;
		
		}
		return false;
	
	}

	/**
	 * Calls the function to update the agents level, ap and the users area
	 * Called if the user updates his information from /me
	 *
	 * @param int $agentId        	
	 * @param int $agentLevel        	
	 * @param int $agentAp        	
	 * @param string $userArea        	
	 */
	public function updateUserProfile($agentId, $agentLevel, $agentAp, $userArea) {

		global $user;
		
		$this->updateUserArea ( $userArea );
		$this->updateAgent ( $agentId, $agentLevel, $agentAp );
	
	}

	/**
	 * Update user group and area
	 * Called from admin useredit view
	 *
	 * @param int $userId        	
	 * @param string $userGroup        	
	 * @param string $userArea        	
	 */
	public function updateUserAdmin($userId, $userGroup, $userArea) {

		$this->processInsertQuery ( "
				UPDATE `user`
				SET `area` = '{$userArea}',
					`group_id` = 
						(
						SELECT IFNULL
							(
					    		(
					    		SELECT id FROM `group`
					        	WHERE `name` = '{$userGroup}'
					    		),
					    	'0'
							) AS id
						FROM `group`
						LIMIT 1
						)
				WHERE `id` = '{$userId}';
				" );
	
	}

	/**
	 * Calls the functions to update the users area and creates an agent
	 * Called if the user updates his information from /me and there was no agent found
	 *
	 * @param string $agentName        	
	 * @param int $agentLevel        	
	 * @param int $agentAp        	
	 * @param string $userArea        	
	 */
	public function createUserProfile($agentName, $agentLevel, $agentAp, $userArea) {

		global $user;
		
		$this->updateUserArea ( $userArea );
		$this->createAgent ( $user ["id"], $agentName, $agentLevel, $agentAp );
	
	}

	/**
	 * Creates a new agent and connects it to a user
	 *
	 * @param int $userId        	
	 * @param string $agentName        	
	 * @param int $agentLevel        	
	 * @param int $agentAp        	
	 */
	private function createAgent($userId, $agentName, $agentLevel, $agentAp) {

		global $helper;
		$now = $helper->now ();
		
		$agentId = $this->processInsertQuery ( "
				INSERT INTO `agent` (`name`, `ap`, `level`, `created`)
				SELECT '{$agentName}', '{$agentAp}', '{$agentLevel}', '{$now}'
				" );
		
		$this->processInsertQuery ( "
				INSERT INTO `user_agent`
				SELECT NULL, {$agentId}, {$userId};
				" );
	
	}

	/**
	 * Updates an agents level and ap
	 *
	 * @param int $agentId        	
	 * @param int $agentLevel        	
	 * @param int $agentAp        	
	 */
	private function updateAgent($agentId, $agentLevel, $agentAp) {

		$this->processInsertQuery ( "
				UPDATE `agent`
				SET `ap` = '{$agentAp}', `level` = '{$agentLevel}'
				WHERE `id` = '{$agentId}';
				" );
	
	}

	/**
	 * Updates the users area
	 *
	 * @param string $userArea        	
	 */
	private function updateUserArea($userArea) {

		global $user;
		
		$this->processInsertQuery ( "
				UPDATE `user`
				SET `area` = '{$userArea}'
				WHERE `id` = '{$user["id"]}';
				" );
	
	}

	/**
	 * Generic function to process insert and update queries
	 *
	 * @param string $query        	
	 * @return boolean
	 */
	public function processInsertQuery($query) {

		if ($stmt = $this->prepare ( $query )) {
			$stmt->execute ();
			
			if ($this->error == '') {
				return $stmt->insert_id;
			}
			else {
				return $this->error;
			}
		}
		return false;
	
	}

	/**
	 * Generic function to process select queries
	 *
	 * @param string $query        	
	 * @return multitype:
	 */
	private function processSelectQuery($query) {

		$result = $this->query ( $query );
		$tmpresult = array ();
		
		while ( $row = $result->fetch_array ( MYSQL_ASSOC ) ) {
			array_push ( $tmpresult, $row );
		}
		
		return $tmpresult;
	
	}

}

?>