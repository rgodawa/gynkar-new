<?php 
require 'app/core/init.php';
$general->logged_in_protect();
Header("Location: app/login.php");
?>
