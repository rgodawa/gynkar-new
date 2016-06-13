<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  } 
$id  = isset($_POST['id']) ? $_POST['id'] : -1;

if ($id == 0) {
	$rt = $projects->insert_project(
			$_POST['title_id'],
        	$_POST['title_number'],
        	$_POST['spot_type_id'],
        	$_POST['spot_date_of_issue'],            
        	$_POST['spot_date_of_beta'],
        	$_POST['spot_length'],
            $_POST['spot_comments'],
        	$_POST['spot_stations'],

        	$_POST['billboard_type_id'],
        	$_POST['billboard_date_of_issue'],            
        	$_POST['billboard_date_of_beta'],
        	$_POST['billboard_length'],
            $_POST['billboard_comments'],
        	$_POST['billboard_stations'],
            
        	$_POST['youtube_type_id'],
        	$_POST['youtube_date_of_issue'],            
        	$_POST['youtube_date_of_beta'],
        	$_POST['youtube_length'],
            $_POST['youtube_comments']
	);
	$row = $rt;
}

if ($id != 0) {
	$rt  = $projects->update_project( $id
		, $_POST['title_id']
		, $_POST['title_number']
        , $_POST['status_id']
        , $_POST['users_notice']
	);
    if ($rt['rt'] == 1) {
        $row = $projects->fetch_project($id);
    }
    if ($rt['rt'] == -1) {
        $row = array('id' => -1);
    }
}

//$log->lwrite(json_encode(array($row)));
	
header('Content-type: application/json');
print json_encode(array($row));

?>