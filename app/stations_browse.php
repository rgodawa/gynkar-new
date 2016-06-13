<?php 
require_once 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  }
require_once 'core/functions.php';
$mystations = $stations->browse_stations();

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
  		<div class="panel-heading">Statcje telewizyjne</div>
  		<div class="panel-body">
		<button id="addStation" class="btn btn-primary">Nowa stacja</button>
		<br /><br />
		<div class="table-responsive">
		<table id="stations" class="table table-striped table-bordered table-vcenter" style="display:none">
		<thead>
			<tr>
				<th class="text-right">#</th>
				<th class="text-left">Stacja</th>
				<th class="text-center">Otwarte</th>
				<th class="text-center">Zrealizowane</th>
				<th class="text-center">Zamknięte</th>
				<th class="text-center">Akcja</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$station_order = 0;
		foreach ($mystations as $mystation) {
			$html_table  = '<tr>'.PHP_EOL;
			
			$html_table .= '<td class="text-right">' . ++$station_order . '.' . '</td>' . PHP_EOL;
			$html_table .= '<td class="station-name">' . $mystation['station_name'] .'</td>' . PHP_EOL;

			$html_table .= '<td class="text-center">' . $mystation['state_opened'] .'</td>' . PHP_EOL;
			$html_table .= '<td class="text-center">' . $mystation['state_executed'] .'</td>' . PHP_EOL;
			$html_table .= '<td class="text-center">' . $mystation['opened_closed'] .'</td>' . PHP_EOL; 
			
			$html_table .=  '<td>' . PHP_EOL;
			$html_table .=  '<button type="button" data-id="' . $mystation['id'] . '" class="btn btn-default editStation glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="bottom" title="Edytuj"';
			$html_table .=  '></button>'.PHP_EOL;
			$html_table .=  '<button type="button" data-id="' . $mystation['id'] . '" class="btn btn-default deleteStation glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="bottom" title="Usuń"';
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
  	<script src="inc/js/functions.js"></script>  	
  	<script src="inc/station/station_browse.js"></script>
  	<script src="inc/station/station_new.js"></script>
  	<script src="inc/station/station_edit.js"></script>
  	<script src="inc/station/station_delete.js"></script>
</body>
</html>