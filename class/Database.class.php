<?php
// define ( 'DB_HOST', 'troogs.de' );
// define ( 'DB_USER', 'db1188164-lable' );
// define ( 'DB_PASS', 'enemenemiste' );
// define ( 'DB_NAME', 'db1188164-lablet' );
define ( 'DB_HOST', 'localhost' );
define ( 'DB_USER', 'root' );
define ( 'DB_PASS', '' );
define ( 'DB_NAME', 'eap' );

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

	public function removeUserFromGroup($groupId, $userId) {

		$query = "DELETE FROM user_group WHERE user_id = {$userId} AND group_id = {$groupId}";
		$result = $this->query ( $query );
		
		return $result;
	
	}

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
	 * TODO geht ncoh nicht
	 *
	 * @return multitype:
	 */
	public function getGroups() {

		$query = "
			SELECT g.id, g.name, g.description, g.create_date, COALESCE(projects,0) AS projects, COALESCE(users,0) AS users FROM groups g
			LEFT JOIN (
			    SELECT COUNT(*) as projects, group_id as id
			    FROM groups g
				INNER JOIN projects_groups pg 
			    ON pg.group_id = g.id
				GROUP BY g.id) ppg
			ON ppg.id = g.id
			LEFT JOIN (
			    SELECT COUNT(*) as users, group_id as id
			    FROM groups g
				INNER JOIN users_groups ug
			    ON ug.group_id = g.id
				GROUP BY g.id) upg
			ON upg.id = g.id
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

	public function freezeUser($userId) {

		$query = "UPDATE `user` SET `frozen` = '1' WHERE `id` = {$userId};";
		$result = $this->query ( $query );
		
		return $result;
	
	}

	public function unfreezeUser($userId) {

		$query = "UPDATE `user` SET `frozen` = '0' WHERE `id` = {$userId};";
		$result = $this->query ( $query );
		
		return $result;
	
	}

	public function getAgentsByUser($userId) {

		$agentList = $this->processSelectQuery ( "
			SELECT a.* FROM user_agent ua
			INNER JOIN user u ON u.id = ua.user_id
			INNER JOIN agent a ON a.id = ua.agent_id		
			WHERE ua.user_id = {$userId}
		" );
		
		return $agentList;
	
	}

	public function getAgentByGoogleId($googleId) {

		$agentList = $this->processSelectQuery ( "
				SELECT a.* FROM user_agent ua
				INNER JOIN user u ON u.id = ua.user_id
				INNER JOIN agent a ON a.id = ua.agent_id
				WHERE u.googleid = {$googleId}
				" );
		
		return $agentList;
	
	}

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

	public function getLead($googleId) {

		$query = "SELECT * FROM `leads` WHERE googleid = '{$googleId}'";
		$result = $this->query ( $query );
		
		return $result->fetch_array ( MYSQL_ASSOC );
	
	}

	public function getLeadCount() {

		$query = "SELECT COUNT(*) as count FROM leads WHERE `active` = 1";
		$result = $this->query ( $query );
		
		$leadCount = $result->fetch_array ( MYSQL_ASSOC );
		$leadCount = $leadCount ["count"];
		
		return $leadCount;
	
	}

	public function getActiveLeads() {

		$query = "SELECT * FROM `leads` WHERE `active` = 1 ORDER BY `created`";
		$result = $this->query ( $query );
		$tmpresult = array ();
		
		while ( $row = $result->fetch_array ( MYSQL_ASSOC ) ) {
			array_push ( $tmpresult, $row );
		}
		
		return $tmpresult;
	
	}

	public function getInactiveLeads() {

		$query = "SELECT * FROM `leads` WHERE `active` = 0 ORDER BY `created`";
		$result = $this->query ( $query );
		$tmpresult = array ();
		
		while ( $row = $result->fetch_array ( MYSQL_ASSOC ) ) {
			array_push ( $tmpresult, $row );
		}
		
		return $tmpresult;
	
	}

	public function removeLead($leadId) {

		$query = "UPDATE `leads` SET `active` = '0' WHERE `id` = {$leadId};";
		$result = $this->query ( $query );
		
		return $result;
	
	}

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