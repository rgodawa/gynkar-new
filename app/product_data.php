<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  }

$id = isset($_POST['id']) ? $_POST['id'] : 0;

$row = $products->fetch_product($id);

header('Content-type: application/json');
print json_encode(array($row));
?>