<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
}

$id  = isset($_POST['id']) ? $_POST['id'] : -1;

if ($id == 0) {
	$rt  = $titles->insert_title($_POST['title']);
    $row = array('id' => $rt['id']);
}

if ($id != 0) {
	$rt  = $titles->update_title($_POST['id'], $_POST['title']);
    $row = array('id' => $rt['id']);
    if ($rt['id'] > 0) {
		$row = $titles->fetch_title($rt['id']);
	}
}

header('Content-type: application/json');
print json_encode(array($row));

?>