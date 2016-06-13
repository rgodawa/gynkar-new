<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  } 

$id  = isset($_POST['id']) ? $_POST['id'] : 0;
$update = isset($_POST['update']) ? $_POST['update'] : 0;

if (($update == 0) && ($id != 0)) {
	$rt  = $invoices->insert_invoice($_POST['id']
				, $_POST['date_of_issue']
				, $_POST['date_of_sale']
				, $_POST['date_termin']
				, $_POST['unit_price']
				, $_POST['description']);
}

if (($update == 1) && ($id != 0)) {	
	$rt  = $invoices->update_invoice($_POST['id']
				, $_POST['invoice_number']
				, $_POST['date_of_issue']
				, $_POST['date_of_sale']
				, $_POST['date_termin']
				, $_POST['unit_price']
				, $_POST['description']);
}	

header('Content-type: application/json');
print json_encode(array($rt));
?>