<?php 
require_once 'core/init.php';
if (!$general->logged_in()) {
  Header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <?php include 'inc/head.inc'; ?>
</head>
<body>
  <?php include 'inc/nav.inc'; ?>
</body>
</html>
