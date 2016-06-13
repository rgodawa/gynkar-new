<?php 
require_once 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  }
require_once 'core/functions.php';
$myusers = $users->get_users();

?>
<!DOCTYPE html>
<html lang="pl">
<head>
 	<?php include 'inc/head.inc'; ?>
</head>
<body>
	<?php include 'inc/nav.inc'; ?>

	<div class="container-fluid">
  		<div class="row">
  		<div class="col-sm-12">

  		<div class="panel panel-default">
  		<div class="panel-heading">Użytkownicy systemu</div>
  		<div class="panel-body">
  		<button id="addUser" class="btn btn-primary">Nowy użytkownik</button>
  		<br /><br />
		<div class="table-responsive">
		<table id="users" class="table table-striped table-bordered table-vcenter" style="display:none">
		<thead>
			<tr>
				<th class="text-right">#</th>
				<th class="text-left">Login</th>
				<th class="text-left">Nazwisko</th>
				<th class="text-left">Imię</th>
				<th class="text-left">Email</th>
				<th class="text-center">Rola</th>
				<th class="text-center">Ostatnia</br>aktywność</th>
				<th class="text-center">Akcja</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$user_order = 0;
		foreach ($myusers as $myuser) {
			$html_table  = '<tr>'.PHP_EOL;
			
			$html_table .= '<td class="text-right">' . ++$user_order . '.' . '</td>' . PHP_EOL;
			$html_table .= '<td class="username">' . $myuser['username'] .'</td>' . PHP_EOL; 
			$html_table .= '<td>' . $myuser['last_name'] .'</td>' . PHP_EOL;
			$html_table .= '<td>' . $myuser['first_name'] .'</td>' . PHP_EOL;
			$html_table .= '<td>' . $myuser['email'] .'</td>' . PHP_EOL;
			$html_table .= '<td class="text-center">' . $myuser['role_name'] .'</td>' . PHP_EOL;
			$html_table .= '<td class="text-center">'; 
			$html_table .= $myuser['last_visit_date'] . '</br>' . $myuser['last_visit_time']; 
			$html_table .= '</td>' . PHP_EOL;

			$html_table .=  '<td>' . PHP_EOL;
			
			$html_table .=  '<button type="button" data-id="' . $myuser['id'] . '" class="btn btn-default editUser glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="bottom" title="Edytuj"';
			$html_table .=  '></button>'.PHP_EOL;
			
			$html_table .=  '<button type="button" data-id="' . $myuser['id'] . '" class="btn btn-default deleteUser glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="bottom" title="Usuń"';
			$html_table .=  '></button>'.PHP_EOL;
			
			$html_table .=  '<button type="button" data-id="' . $myuser['id'] . '" class="btn btn-default infoLoginUser glyphicon glyphicon-log-in" data-toggle="tooltip" data-placement="bottom" title="Historia logowania"';
			$html_table .=  '></button>'.PHP_EOL;

			$html_table .=  '</td>' . PHP_EOL;

			$html_table .= '</tr>'.PHP_EOL;

			echo $html_table;
		};
		?>
		</tbody>
		</table>
		</div>	
  		</div>

  		</div>
  		</div>
  		</div>
  	</div>
  	<?php include 'inc/user/user_form.html'; ?>
  	<?php include 'inc/user/user_form_edit.html'; ?>
  	<script src="inc/js/functions.js"></script>
  	<script src="inc/js/jquery.dirrty.js"></script>
  	<script src="inc/js/jquery.validate.min.js"></script>
  	<script src="inc/js/messages_pl.js"></script>
  	<script src="inc/user/user_browse.js"></script>
  	<script src="inc/user/user_edit.js"></script>
  	<script src="inc/user/user_delete.js"></script> 
  	<script src="inc/user/user_info_login.js"></script>	
</body>
</html>