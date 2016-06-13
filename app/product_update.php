<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  }

$id = isset($_POST['id']) ? $_POST['id'] : 0;

if ($id != 0) {
	$rt = $products->update_product( $id
			, $_POST['type_id']
        	, $_POST['date_of_issue']            
        	, $_POST['date_of_beta']
        	, $_POST['length']
            , $_POST['comments']
           	, $_POST['stations']
	);
}

$row = $products->fetch_product($id);

header('Content-type: application/json');
print json_encode(array($row));

?>