<?php
class Products {
 	
	private $db;
	private $log;

	public function __construct($database, $logfile) {
	    $this->db  = $database;
	    $this->log = $logfile;
	}

public function get_stages() {
		
		$query = $this->db->prepare('CALL sp_stages');

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die($e->getMessage());
		}

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}	

public function get_produkt_stages($product_id) {
		
		$query = $this->db->prepare('CALL sp_product_stages(:product_id)');

		$query->bindValue(':product_id', $product_id);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die($e->getMessage());
		}

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

public function get_produkt_audit($product_id) {
		
		$query = $this->db->prepare('CALL sp_product_audit_browse(:p_product_id)');

		$query->bindValue(':p_product_id', $product_id);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll(PDO::FETCH_ASSOC);

	}	

public function update_produkt_stage($id, $stage_done, $planned_closing_date, $closing_date) {

		$query = $this->db->prepare('CALL sp_product_stages_update(:p_id, :p_stage_done, :p_planned_closing_date, :p_closing_date, :p_user_id)');

		$query->bindValue(':p_id', $id);
		$query->bindValue(':p_stage_done', $stage_done);
		$query->bindValue(':p_planned_closing_date', $planned_closing_date);
		$query->bindValue(':p_closing_date', $closing_date);
		$query->bindValue(':p_user_id', $_SESSION['id']);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}

public function update_product($id
		, $type_id
		, $date_of_issue
		, $date_of_beta
		, $length
		, $comments
		, $stations) {

		$query = $this->db->prepare('CALL sp_product_update(:p_product_id
			, :p_type_id
			, :p_date_of_issue
			, :p_date_of_beta
			, :p_length
			, :p_comments
			, :p_stations
			, :p_user_id
			)');

		$query->bindValue(':p_product_id', $id);
		$query->bindValue(':p_type_id', $type_id);
		$query->bindValue(':p_date_of_issue', $date_of_issue);
		$query->bindValue(':p_date_of_beta', $date_of_beta);
		$query->bindValue(':p_length', $length);
		$query->bindValue(':p_comments', $comments);
		$query->bindValue(':p_stations', $stations);
		$query->bindValue(':p_user_id', $_SESSION['id']);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}
		return $query->fetch(PDO::FETCH_ASSOC);
	}	

public function fetch_product($id) {
		
		$query = $this->db->prepare(
			"CALL sp_product_data(:p_product_id)"
			);

		$query->bindValue(':p_product_id', $id);

		try {

			$query->execute();

		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);
	}


public function delete_product($id) {
		$rt = -1;
		$query = $this->db->prepare("CALL sp_product_delete(:p_product_id, :p_user_id)");

		$query->bindValue(':p_product_id', (int)$id, PDO::PARAM_INT);
		$query->bindValue(':p_user_id', (int)$_SESSION['id'], PDO::PARAM_INT);


		try {
			$query->execute();
			$this->log->lwrite('deleted product:' . $id . ' user:' . $_SESSION['id']);
			$rt = 1;
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $rt;
	}

public function insert_product($project_id, $product_type_id) {
		$query = $this->db->prepare("CALL sp_product_insert(:p_project_id, :p_product_type_id, :p_user_id)");

		$query->bindValue(':p_project_id', (int)$project_id, PDO::PARAM_INT);
		$query->bindValue(':p_product_type_id', (int)$product_type_id, PDO::PARAM_INT);
		$query->bindValue(':p_user_id', (int)$_SESSION['id'], PDO::PARAM_INT);

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

