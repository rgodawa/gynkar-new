<?php
class Stations {
 	
	private $db;
	private $log;

	public function __construct($database, $logfile) {
	    $this->db = $database;
	    $this->log = $logfile;
	}

	public function browse_stations() {
		
		$query = $this->db->prepare("CALL sp_station_browse()");
		try{
			$query->execute();
		}catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll();

	}	

	public function get_stations() {
		
		$query = $this->db->prepare("CALL sp_station_list()");
		try{
			$query->execute();
		}catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll();

	}

	public function fetch_station_name($id){

		
		$query = $this->db->prepare(
			"SELECT id, station_name FROM stations WHERE (id = :id)"
			);

		$query->bindValue(':id', $id);

		try{
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function insert_station($station) {
		$query = $this->db->prepare("CALL sp_station_insert(:p_station_name, :p_user_id)");

		$query->bindValue(':p_station_name', $station);
		$query->bindValue(':p_user_id', $_SESSION['id']);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}


	public function update_station($id, $station_name) {

		$query = $this->db->prepare("CALL sp_station_update(:p_id, :p_station_name, :p_user_id)");
		    		
		$query->bindValue(':p_id', $id);
		$query->bindValue(':p_station_name', $station_name);
		$query->bindValue(':p_user_id', $_SESSION['id']);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function delete_station($id) {

		$rt = -1;
		$query = $this->db->prepare("UPDATE stations SET deleted = 1 WHERE (id = :p_id)");

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

