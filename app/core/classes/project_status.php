<?php
class Projects_status {
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}

	public function select_status() {
		
		$query = $this->db->prepare(
			"SELECT id, product_status_name FROM product_status"
			);

		try {
			$query->execute();
		} catch(PDOException $e) {
			die($e->getMessage());
		}

		return $query->fetchAll();

	}	

}
?>