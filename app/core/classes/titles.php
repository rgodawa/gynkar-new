<?php
class Titles{
 	
	private $db;
	private $log;

	public function __construct($database, $logfile) {
	    $this->db = $database;
	    $this->log = $logfile;
	}

	public function get_titles() {
		
		$query = $this->db->prepare("CALL sp_title_list");

		try {
			$query->execute();
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll();

	}	

	public function browse_titles() {
		
		$query = $this->db->prepare("CALL sp_title_browse");

		try {
			$query->execute();
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll();

	}


	public function fetch_title($id){

		
		$query = $this->db->prepare("CALL sp_title_data(:p_id)");

		$query->bindValue(':p_id', $id);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function insert_title($title) {
		$query = $this->db->prepare("CALL sp_title_insert(:p_title, :p_user_id)");

		$query->bindValue(':p_title', $title);
		$query->bindValue(':p_user_id', $_SESSION['id']);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function update_title($id, $title) {

		$query = $this->db->prepare("CALL sp_title_update(:p_id, :p_title, :p_user_id)");
    		
		$query->bindValue(':p_id', $id);
		$query->bindValue(':p_title', $title);
		$query->bindValue(':p_user_id', $_SESSION['id']);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function delete_title($id) {

		$rt = -1;
		$query = $this->db->prepare("UPDATE titles SET deleted = 1 WHERE (id = :p_id)");

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

}
?>

