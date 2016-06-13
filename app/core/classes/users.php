<?php
DEFINE('WEBSITE_URL', 'http://localhost/gynkar-new'); 
class Users {
 	
	private $db;
	private $log;
	private $mailer;

	public function __construct($database, $logfile, $mymailer) {
	    $this->db = $database;
	    $this->log = $logfile;
	    $this->mailer = $mymailer;
	}

	public function user_login($user_id, $ip_address, $remote_host) {
		$query = $this->db->prepare("CALL sp_user_login(:user_id, :ip_address, :remote_host)");
		$query->bindValue(':user_id', $user_id);
		$query->bindValue(':ip_address', $ip_address);
		$query->bindValue(':remote_host', $remote_host);

		try {
			$query->execute();
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		$rows = $query->fetchAll();
		return $rows[0]['user_session_id'];
	}

	public function user_logout($session_id, $user_id) {
		$query = $this->db->prepare("CALL sp_user_logout(:session_id, :user_id)");
		$query->bindValue(':session_id', $session_id);
		$query->bindValue(':user_id', $user_id);

		try {
			$query->execute();
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		Database::disconnect();
	}

		
	public function login($username, $password) {

		global $bcrypt;  // Again make get the bcrypt variable, which is defined in init.php, which is included in login.php where this function is called

		$query = $this->db->prepare("SELECT password, id FROM users WHERE (deleted = 0) AND (username = ?)");
		$query->bindValue(1, $username);

		try {
			
			$query->execute();
			$data 				= $query->fetch();
			$stored_password 	= $data['password']; // stored hashed password
			$id   				= $data['id']; // id of the user to be returned if the password is verified, below.
			
			if($bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
				return $id;	// returning the user's id.
			} else {
				return false;	
			}

		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}
	
	}

	public function user_exists($username) {
	
		$query = $this->db->prepare("SELECT COUNT(id) FROM users WHERE (deleted = 0) AND (username = ?)");
		$query->bindValue(1, $username);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			return ($rows == 1);

		} catch (PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

	}

	public function email_confirmed($username) {

		$query = $this->db->prepare("SELECT COUNT(id) FROM users WHERE (deleted = 0) AND (username = ?) AND (confirmed = ?)");
		$query->bindValue(1, $username);
		$query->bindValue(2, 1);
		
		try {
			
			$query->execute();
			$rows = $query->fetchColumn();

			return ($rows == 1);

		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}
	}

	public function userdata($id) {

		$query = $this->db->prepare("CALL sp_user_data(:p_id)");
		$query->bindValue(':p_id', $id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

	}

	public function fetch_user($id) {

		$query = $this->db->prepare("CALL sp_user_data(:p_id)");
		$query->bindValue(':p_id', $id);

		try {

			$query->execute();

		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);

	}
	  	  	 
	public function get_users() {

		$query = $this->db->prepare("CALL sp_users_browse");
		
		try{
			$query->execute();
		}catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll();

	}	

	public function get_users_notification() {

		$query = $this->db->prepare(
			"SELECT id
			, username
			, first_name
			, last_name
			, CONCAT_WS(' ', first_name, last_name) AS full_name
			, default_notice
			FROM users WHERE (active = 1) AND (deleted = 0)
			ORDER BY first_name"
		);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll();

	}

	public function delete_user($id) {

		$rt = -1;
		$query = $this->db->prepare("UPDATE users SET deleted = 1 WHERE (id = :p_id)");

		$query->bindValue(':p_id', $id);

		try{
			$query->execute();
			$rt = 1;
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $rt;
	}


	public function update_user($id
		, $username
		, $first_name
		, $last_name
		, $email
		, $role_id
		, $default_notice
		, $change_password
		, $password_old
		, $password_new
		) {

		$query = $this->db->prepare("CALL sp_user_update(:p_id
									, :p_username
									, :p_first_name
									, :p_last_name
									, :p_email
									, :p_role_id
									, :p_default_notice
									, :p_change_password
									, :p_password_old
									, :p_password_new
									)");

		$query->bindValue(':p_id', $id);
		$query->bindValue(':p_username', $username);
		$query->bindValue(':p_first_name', $first_name);
		$query->bindValue(':p_last_name', $last_name);
		$query->bindValue(':p_email', $email);
		$query->bindValue(':p_role_id', $role_id);
		$query->bindValue(':p_default_notice', $default_notice);
		$query->bindValue(':p_change_password', $change_password);
		$query->bindValue(':p_password_old', $password_old);
		$query->bindValue(':p_password_new', $password_new);
		
		try {
			$query->execute();
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}
		return $query->fetch(PDO::FETCH_ASSOC);	
	}

public function confirm($id, $psw_old, $psw_new) {
	$query = $this->db->prepare("CALL sp_user_confirm(:p_id
									, :p_psw_old
									, :p_psw_new
									)");

	$query->bindValue(':p_id', $id);
	$query->bindValue(':p_psw_old', $psw_old);
	$query->bindValue(':p_psw_new', $psw_new);

	try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

	$rt = $query->fetch();
	$this->log->lwrite( 'Return: ' . $rt['rt']);
	return ($rt['rt'] == 1);
}

public function insert_user($username
		, $first_name
		, $last_name
		, $email
		, $role_id
		, $default_notice
		) {

		$query = $this->db->prepare("CALL sp_user_insert(:p_username
									, :p_first_name
									, :p_last_name
									, :p_email
									, :p_role_id
									, :p_default_notice
									)");

		$query->bindValue(':p_username', $username);
		$query->bindValue(':p_first_name', $first_name);
		$query->bindValue(':p_last_name', $last_name);
		$query->bindValue(':p_email', $email);
		$query->bindValue(':p_role_id', $role_id);
		$query->bindValue(':p_default_notice', $default_notice);
		
		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		$rt = $query->fetch(PDO::FETCH_ASSOC);
		

		if ($rt['rt'] == 1) {
			$this->log->lwrite($rt['psw']);
			$this->mailer->AddAddress($rt['email'],$rt['full_name']);
			$this->mailer->Subject = 'login/hasło do systemu';
			$this->mailer->Body = $this->generuj_email_haslo($rt['username'], $rt['psw']);
			try {
				$this->mailer->Send();
				$this->log->lwrite('Hasło dla użytkownika: '.$rt['username'].' wysłano na adres: '.$rt['email']);
			} 
     		catch (phpmailerException $e) {
        		$this->log->lwrite($e->errorMessage());
        		$rt['rt'] = -3;  
     		} 
     		catch (Exception $e) {
          		$this->log->lwrite($e->getMessage()); 
          		$rt['rt'] = -4; 
     		}	
		}
		return $rt;	
	}	

public function get_login_audit($id) {
		
		$query = $this->db->prepare('CALL sp_user_audit_browse(:p_id)');

		$query->bindValue(':p_id', $id);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll(PDO::FETCH_ASSOC);

	}

function generuj_email_haslo($login, $pass) {
	$msg ="
		<body>
			<div class=\"email\">Dzień dobry,</div>
			<br>
			<div class=\"email\">Zostało utworzone dla Ciebie konto w systemie GynKar:</div>
			<br>
			<div class=\"email\">Uruchom proszę link poniżej, zaloguj się do systemu i zmień hasło.</div>
			<div class=\"email-link\"><a href=\"http://" . $_SERVER['SERVER_NAME'] ."/app/confirm.php\">
			http://" . $_SERVER['SERVER_NAME'] ."/app/confirm.php</a>
			</div>
			<br>
			<div class=\"email\">Login: <b>". $login ."</b></div>
			<div class=\"email\">Hasło: <b>". $pass  ."</b> </div>
			<div class=\"description\">Jednorazowe hasło do zmiany przy pierwszym logowaniu</div>
			<br>
		 
		</body>
		";
	return $msg;
}	


}