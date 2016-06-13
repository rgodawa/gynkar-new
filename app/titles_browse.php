<?php 
require_once 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  }
require_once 'core/functions.php';
$mytitles = $titles->browse_titles();

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
  		<div class="panel-heading">Kategorie projektów</div>
  		<div class="panel-body">
		<button id="addTitle" class="btn btn-primary">Nowa kategoria</button>
		<br /><br />
		<div class="table-responsive">
		<table id="titles" class="table table-striped table-bordered table-vcenter" style="display:none">
		<thead>
			<tr>
				<th class="text-right">#</th>
				<th class="text-left">Tytuł</th>
				<th class="text-center">Otwarte</th>
				<th class="text-center">Zrealizowane</th>
				<th class="text-center">Zamknięte</th>
				<th class="text-center">Akcja</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$title_order = 0;
		foreach ($mytitles as $mytitle) {
			$html_table  = '<tr>'.PHP_EOL;
			
			$html_table .= '<td class="text-right">' . ++$title_order . '.' . '</td>' . PHP_EOL;
			$html_table .= '<td class="title">' . $mytitle['title'] .'</td>' . PHP_EOL;

			$html_table .= '<td class="text-center">' . $mytitle['state_opened'] .'</td>' . PHP_EOL;
			$html_table .= '<td class="text-center">' . $mytitle['state_executed'] .'</td>' . PHP_EOL;
			$html_table .= '<td class="text-center">' . $mytitle['opened_closed'] .'</td>' . PHP_EOL; 
			
			$html_table .=  '<td>' . PHP_EOL;
			$html_table .=  '<button type="button" data-id="' . $mytitle['id'] . '" class="btn btn-default editTitle glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="bottom" title="Edytuj"';
			$html_table .=  '></button>'.PHP_EOL;
			$html_table .=  '<button type="button" data-id="' . $mytitle['id'] . '" class="btn btn-default deleteTitle glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="bottom" title="Usuń"';
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
  	<script src="inc/title/title_browse.js"></script>
  	<script src="inc/js/functions.js"></script>
</body>
</html>