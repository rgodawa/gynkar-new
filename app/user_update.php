<?php
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  }

$id = isset($_POST['id']) ? $_POST['id'] : 0;

if ($id != 0) {
	$rt = $users->update_user( $id
        	, $_POST['username']            
        	, $_POST['first_name']
        	, $_POST['last_name']
          , $_POST['email']
          , $_POST['role_id']
          , $_POST['default_notice']
          , $_POST['change_password']
          , $_POST['password_old']
          , $_POST['password_new']
	);

  if ($rt['id'] > 0) {
    $row = $users->fetch_user($rt['id']);
  }
  if ($rt['id'] <= 0) {
    $row = array('id' => $rt['id']);
  }

}

if ($id == 0) {
  $row = $users->insert_user( $_POST['username']
          , $_POST['first_name']
          , $_POST['last_name']
          , $_POST['email']
          , $_POST['role_id']
          , $_POST['default_notice']
  );
}

header('Content-type: application/json');
print json_encode(array($row));

?>