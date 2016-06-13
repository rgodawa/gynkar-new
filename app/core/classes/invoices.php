<?php
class Invoices{
 	
	private $db;
	private $log;

	public function __construct($database, $logfile) {
	    $this->db = $database;
	    $this->log = $logfile;
	}

	public function insert_invoice($id
		, $date_of_issue
		, $date_of_sale
		, $date_termin
		, $unit_price
		, $description) {
		
		$query = $this->db->prepare("CALL simple_invoices.sp_invoice_insert(:p_project_id
			, :p_date_of_issue
			, :p_date_of_sale
			, :p_date_termin
			, :p_unit_price
			, :p_description)");

		$query->bindValue(':p_project_id', $id);
		$query->bindValue(':p_date_of_issue', $date_of_issue);
		$query->bindValue(':p_date_of_sale', $date_of_sale);
		$query->bindValue(':p_date_termin', $date_termin);
		$query->bindValue(':p_unit_price', $unit_price);
		$query->bindValue(':p_description', $description);

		try {
			$query->execute();
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);

	}

	public function update_invoice($id
		, $invoice_number
		, $date_of_issue
		, $date_of_sale
		, $date_termin
		, $unit_price
		, $description) {
		
		$query = $this->db->prepare("CALL sp_invoice_update(:p_id
			, :p_invoice_number
			, :p_date_of_issue
			, :p_date_of_sale
			, :p_date_termin
			, :p_unit_price
			, :p_description)");

		$query->bindValue(':p_id', $id);
		$query->bindValue(':p_invoice_number', $invoice_number);		
		$query->bindValue(':p_date_of_issue', $date_of_issue);
		$query->bindValue(':p_date_of_sale', $date_of_sale);
		$query->bindValue(':p_date_termin', $date_termin);
		$query->bindValue(':p_unit_price', $unit_price);
		$query->bindValue(':p_description', $description);

		try {
			$query->execute();
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC);

	}



	public function fetch_invoice_project_item($id) {

	$query = $this->db->prepare("CALL sp_invoice_project_item(:p_project_id)");
	$query->bindValue(':p_project_id', $id);

		try {
			$query->execute();
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC); 
	}

	public function fetch_invoice_data($id) {

	$query = $this->db->prepare("CALL sp_invoice_data(:p_id)");
	$query->bindValue(':p_id', $id);

		try {
			$query->execute();
		} catch(PDOException $e){
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetch(PDO::FETCH_ASSOC); 
	}

	public function get_invoices() {
		
		$query = $this->db->prepare('CALL sp_invoice_browse()');

		try {
			$query->execute();
		} catch(PDOException $e) {
			$this->log->lwrite($e->getMessage());
			die();
		}

		return $query->fetchAll();

	}

	public function delete_invoice($id) {

		$rt = -1;
		$query = $this->db->prepare("UPDATE simple_invoices.si_invoices SET deleted = 1 WHERE (id = :p_id)");

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