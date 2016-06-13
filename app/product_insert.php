<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
}
require_once 'core/functions.php';

$id  = isset($_POST['project_id']) ? $_POST['project_id'] : 0;
$rt = array('button' => '');

if ($id != 0) {
	$rt  = $products->insert_product($_POST['project_id'], $_POST['product_type_id']);
	//$rt   = myget_button($_POST['product_group_id'], $row, true);
    //$row = array('product_id' => $rt['product_id']);
}

header('Content-type: application/json');
print json_encode(array($rt));

?>