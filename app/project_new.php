<?php 
require 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
 }
require 'core/functions.php';
$mytitles = $titles->get_titles();
$mystations = $stations->get_stations();
$myusers = $users->get_users_notification();
 ?>
<!DOCTYPE html>
<html lang="pl">
<head>
 	<?php include 'inc/head.inc'; ?>
 	<script src="inc/project/project-calendar.js"></script>
 	<link href='css/projects.css' rel='stylesheet'>
</head>
<body>
	<?php include 'inc/nav.inc'; ?>
  	<div class="row">
		<?php include 'inc/project/project_form.html'; ?>
	</div>
	<script src="inc/js/functions.js"></script>	
	<script src="inc/js/jquery.dirrty.js"></script>
	<script src="inc/js/jquery.validate.min.js"></script>
	<script src="inc/js/messages_pl.js"></script>
	<script src="inc/project/project_functions.js"></script>
  	<script src="inc/project/project_new.js"></script>
</body>
</html>