<?php 
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
 }
$_SESSION['session_id'] = isset($_SESSION['session_id']) ? $_SESSION['session_id'] : '';
$_SESSION['id'] = isset($_SESSION['id']) ? $_SESSION['id'] : 0; 
$users->user_logout($_SESSION['session_id'], $_SESSION['id']);
session_start();
session_destroy();
header('Location: /gynkar-new');
?>