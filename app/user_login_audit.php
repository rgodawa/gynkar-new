<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  } 
$id  = isset($_GET['id']) ? $_GET['id'] : 0;
$row = $users->get_login_audit($id);

header('Content-type: application/json');
print json_encode(array($row));
?>