<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  } 
$id  = isset($_POST['id']) ? $_POST['id'] : 0;
if ($id != 0) {
	$rt  = $stations->delete_station($id);
}	
if ($rt == 1) {
	$row = array('id' => $id);
}
header('Content-type: application/json');
print json_encode(array($row));
?>