<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  } 
$id  = isset($_POST['id']) ? $_POST['id'] : 0;

if ($id != 0) {
	$rt  = $products->update_produkt_stage( $id
		, $_POST['stage_done']
		, $_POST['planned_closing_date']
		, $_POST['closing_date']
	);
}
header('Content-type: application/json');
print json_encode(array($rt));
?>