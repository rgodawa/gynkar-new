<?php
class Projects {
 	
	private $db;
	private $log;
	private $date;

	public function __construct($database, $logfile, $default_date) {
	    $this->db = $database;
	    $this->log = $logfile;
	    $this->date = $default_date;
	}

	public function get_projects($project_status_id) {
		
		$query = $this->db->prepare('CALL sp_project_browse(:project_status_id)');

		$query->bindValue(':project_status_id', $project_status_id);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll();

	}

public function get_project_audit($id) {
		
		$query = $this->db->prepare('CALL sp_project_audit_browse(:p_project_id)');

		$query->bindValue(':p_project_id', $id);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll(PDO::FETCH_ASSOC);

	}		


public function update_project($id, $title_id, $title_number, $status_id, $users_notice) {

		$rt = -1;
		$query = $this->db->prepare("CALL sp_project_update(:p_project_id
			, :p_title_id
			, :p_title_number
			, :p_status_id
			, :p_users_notice
			, :p_user_id)");

		$query->bindValue(':p_project_id', $id);
		$query->bindValue(':p_title_id', $title_id);
		$query->bindValue(':p_title_number', $title_number);
		$query->bindValue(':p_status_id', $status_id);
		$query->bindValue(':p_users_notice', $users_notice);
		$query->bindValue(':p_user_id', $_SESSION['id']);
		

		try {
			$query->execute();
			$rt = $query->rowCount();
		} catch(PDOException $e){
			$this->log->lwrite();
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}

public function insert_project(
			$title_id,
        	$title_number,
        	$spot_type_id,
        	$spot_date_of_issue,            
        	$spot_date_of_beta,
        	$spot_length,
        	$spot_comments,

        	$spot_stations,
        	$billboard_type_id,
        	$billboard_date_of_issue,            
        	$billboard_date_of_beta,
        	$billboard_length,
        	$billboard_comments,

        	$billboard_stations,
        	$youtube_type_id,
        	$youtube_date_of_issue,            
        	$youtube_date_of_beta,
        	$youtube_length,
        	$youtube_comments
	) {
	$rt = -1;
	$user_id = $_SESSION['id'];
	$query = $this->db->prepare(
		"CALL sp_project_insert(
         	:p_title_id,
        	:p_title_number,
        	:spot_type_id,
        	:spot_date_of_issue,            
        	:spot_date_of_beta,
        	:spot_length,
        	:spot_comments,
        	:spot_stations,

        	:billboard_type_id,
        	:billboard_date_of_issue,            
        	:billboard_date_of_beta,
        	:billboard_length,
        	:billboard_comments,
        	:billboard_stations,

        	:youtube_type_id,
        	:youtube_date_of_issue,            
        	:youtube_date_of_beta,
        	:youtube_length,
        	:youtube_comments,

        	:stage_planned_closing_date,
        	:user_id)");

			$query->bindValue(':p_title_id', (int)$title_id, PDO::PARAM_INT);
        	$query->bindValue(':p_title_number', $title_number);
        	$query->bindValue(':spot_type_id', (int)$spot_type_id, PDO::PARAM_INT);
        	$query->bindValue(':spot_date_of_issue', $spot_date_of_issue);
        	$query->bindValue(':spot_date_of_beta', $spot_date_of_beta);
        	$query->bindValue(':spot_length', (int)$spot_length, PDO::PARAM_INT);
        	$query->bindValue(':spot_comments', $spot_comments);
        	$query->bindValue(':spot_stations', $spot_stations);

        	$query->bindValue(':billboard_type_id', (int)$billboard_type_id, PDO::PARAM_INT);
        	$query->bindValue(':billboard_date_of_issue', $billboard_date_of_issue);
        	$query->bindValue(':billboard_date_of_beta', $billboard_date_of_beta);
        	$query->bindValue(':billboard_length', (int)$billboard_length, PDO::PARAM_INT);
        	$query->bindValue(':billboard_comments', $billboard_comments);
        	$query->bindValue(':billboard_stations', $billboard_stations);

        	$query->bindValue(':youtube_type_id', (int)$youtube_type_id, PDO::PARAM_INT);
        	$query->bindValue(':youtube_date_of_issue', $youtube_date_of_issue);
        	$query->bindValue(':youtube_date_of_beta', $youtube_date_of_beta);
        	$query->bindValue(':youtube_length', (int)$youtube_length, PDO::PARAM_INT);
        	$query->bindValue(':youtube_comments', $youtube_comments);

        	$query->bindValue(':stage_planned_closing_date', $this->date);
        	$query->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);

		try {
			$rt = $query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
}





public function delete_project($id) {
		$rt = -1;
		$query = $this->db->prepare("CALL sp_project_delete(:p_project_id, :p_user_id)");

		$query->bindValue(':p_project_id', (int)$id, PDO::PARAM_INT);
		$query->bindValue(':p_user_id', (int)$_SESSION['id'], PDO::PARAM_INT);


		try {
			$query->execute();
			$rt = 1;
			$this->log->lwrite('deleted project:' . $id . ' user:' . $_SESSION['id']);
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $rt;
	}

public function empty_project() {

		$rt = array('id' => 0
			,'title_id' => 0
			,'title_number' => ''
	       	,'spot_type_id' => 0
        	,'spot_date_of_issue' => $this->date           
        	,'spot_date_of_beta' => $this->date
        	,'spot_length' => 10
        	,'spot_stations' => ''
        	,'billboard_type_id' => 0
        	,'billboard_date_of_issue' => $this->date          
        	,'billboard_date_of_beta' => $this->date
        	,'billboard_length' => 10
        	,'billboard_stations' => ''
        	,'youtube_type_id' => 0
        	,'youtube_date_of_issue' => $this->date            
        	,'youtube_date_of_beta' => $this->date
        	,'youtube_length' => 10
			);
		
		return $rt;
	}		


public function fetch_project($id) {
		
		$query = $this->db->prepare(
			"CALL sp_project_data(:project_id)"
			);

		$query->bindValue(':project_id', $id);

		try {

			$query->execute();

		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}

public function exist_project($title_id, $title_number) {
		
		$query = $this->db->prepare(
			"CALL sp_project_exist(:p_title_id, :p_title_number)"
			);

		$query->bindValue(':p_title_id', $title_id);
		$query->bindValue(':p_title_number', $title_number);

		try {

			$query->execute();

		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}	

}

?>

