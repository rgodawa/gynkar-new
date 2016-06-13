<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
}

$id  = isset($_POST['id']) ? $_POST['id'] : -1;

if ($id == 0) {
	$rt  = $stations->insert_station($_POST['station_name']);
    $row = array('id' => $rt['id']);
}

if ($id != 0) {
	$rt  = $stations->update_station($_POST['id'], $_POST['station_name']);
    $row = array('id' => $rt['id']);
    if ($rt['id'] > 0) {
		$row = $stations->fetch_station_name($rt['id']);
	}
}

header('Content-type: application/json');
print json_encode(array($row));

?>