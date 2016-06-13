<?php 
require_once 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  }
require_once 'core/functions.php';
$status = isset($_GET['status']) ? $_GET['status'] : 0;

$mytitles = $titles->get_titles();
$mystations = $stations->get_stations();
$myusers = $users->get_users_notification();
$myprojects = $projects->get_projects($status);
$stages = $products->get_stages();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
 	<?php include './inc/head.inc'; ?>
 	<script src="./inc/project/project-calendar.js"></script> 	
 	<link href='./css/projects.css' rel='stylesheet'>

</head>
<body class="no-print">
	
	<?php include 'inc/nav.inc'; ?>

	<div class="container-fluid">
  		<div class="row">
  		<div class="col-sm-12">

  		<div class="panel panel-default">
  		<div class="panel-heading">Projekty o statusie: <?php echo myget_project_status_name($status) ?></div>
  		<div id="projects-panel" class="panel-body">

		<div class="table-responsive">
		<table id="projects" class="table table-striped table-bordered table-vcenter" style="display:none">
		<thead>
			<tr>
				<th class="text-right">#</th>
				<th class="text-left">Tytuł</th>
				<th class="text-center">Data<br/>wprowadzenia</th>
				<th class="text-center">Wprowadził</th>
				<th class="text-center">Spot</th>
				<th class="text-center">Billboard</th>
				<th class="text-center">YouTube</th>
				<?php if ($user['role_id'] != 4) : ?>
					<th class="text-center">Akcja</th>
				<?php endif; ?>
				<?php if ($user['role_id'] == 4) : ?>
					<th class="text-center" style="display:none"></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
		<?php
		$project_order = 0;
		foreach ($myprojects as $myproject) {
			$html_table  = '<tr>'.PHP_EOL;
			
			$html_table .= '<td class="text-right">' . ++$project_order . '.' . '</td>' . PHP_EOL;
			$html_table .= '<td class="title">' . $myproject['full_title'] .'</td>' . PHP_EOL; 

			$html_table .= '<td class="text-center">' . $myproject['inserted_date'] .'</td>' . PHP_EOL; 
			$html_table .= '<td class="text-center">' . $myproject['inserted_user'] .'</td>' . PHP_EOL; 

			$html_table .=  '<td class="text-center td-spot">' . PHP_EOL;
			$html_table .= myget_button(1, $myproject, true);
			$html_table .=  '</td>' . PHP_EOL;

			$html_table .=  '<td class="text-center td-billboard">' . PHP_EOL;
			$html_table .= myget_button(2, $myproject, true);
			$html_table .=  '</td>' . PHP_EOL;

			$html_table .=  '<td class="text-center td-youtube">' . PHP_EOL;
			$html_table .= myget_button(3, $myproject, true);
			$html_table .=  '</td>' . PHP_EOL;

			if ($user['role_id'] != 4) {
				$html_table .=  '<td>' . PHP_EOL;
				
				$html_table .=  '<button type="button" data-id="' . $myproject['id'] . '" class="btn btn-default editProject glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="bottom" title="Edytuj projekt"';
				$html_table .=  (($myproject['status_id']!='3') ? "" : "disabled") . '></button>'.PHP_EOL;
	
				
				$html_table .=  '<button type="button" data-id="' . $myproject['id'] . '" class="btn btn-default deleteProject glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="bottom" title="Usuń projekt"';
				$html_table .=  (($myproject['status_id']!='3') ? "" : "disabled") . '></button>'.PHP_EOL;
				
	
				$html_table .=  '<button type="button" data-id="' . $myproject['id'] . '" class="btn btn-default infoProject glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Historia zmian"';
				$html_table .=  '></button>'.PHP_EOL;
	
				if (($myproject['status_id'] >= 2) && ($user['role_id'] == 1)) {
					$html_table .=  '<button type="button" data-id="' . $myproject['id'];
					if ($myproject['invoice_id'] == 0) {
						$html_table .= '" class="btn btn-default invoiceProject glyphicon glyphicon-usd" data-toggle="tooltip" data-placement="bottom" title="Wystawienie faktury"';
					} else {
						$html_table .= '" invoice-id="' . $myproject['invoice_id'] . '"';
						$html_table .= '" class="btn btn-default invoicePrint glyphicon glyphicon-print" data-toggle="tooltip" data-placement="bottom" title="Wydruk faktury"';	
					}
					$html_table .=  '></button>'.PHP_EOL;
				}
	


				$html_table .=  '</td>' . PHP_EOL;
			} else {$html_table .= '<td style="display:none"></td>';}

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
  	<?php include 'inc/product/product_stages_form.html'; ?> 
  	<?php include 'inc/project/project_form_edit.html'; ?>
  	<?php include 'inc/invoice/invoice_edit.html'; ?>
  	<?php include 'inc/invoice/invoice.html'; ?>
  	<script src="inc/js/functions.js"></script>
  	<script src="inc/js/jquery.dirrty.js"></script>
  	<script src="inc/js/jquery.validate.min.js"></script>
  	<script src="inc/js/spin.min.js"></script>
  	<script src="inc/js/jquery.spin.js"></script>
  	<script src="inc/js/printThis.js"></script>
  	<script src="inc/js/BootstrapMenu.min.js"></script>
  	<script src="inc/invoice/invoice_new.js"></script>
  	<script src="inc/invoice/invoice_print.js"></script>
  	<script src="inc/project/project_info.js"></script>
  	<script src="inc/project/project_edit.js"></script>
  	<script src="inc/project/project_edit_submit.js"></script>
  	<script src="inc/project/project_delete.js"></script>
  	<script src="inc/project/project_browse.js"></script>
  	<script src="inc/project/project_functions.js"></script>
  	<script src="inc/product/product_functions.js"></script>
  	<script src="inc/product/product_delete.js"></script>
  	<script src="inc/product/product_add.js"></script>
  	<script src="inc/product/product_info.js"></script>
  	<script src="inc/product/product_edit.js"></script>
</body>
</html>