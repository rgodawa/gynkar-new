<?php 
require_once 'core/init.php';
if (!$general->logged_in()) {
  Header('Location: login.php');
  }

$myinvoices = $invoices->get_invoices();

function my_number_format($myNumber) {
	return number_format($myNumber,2,',', ' ');
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
 	<?php include './inc/head.inc'; ?>
</head>
<body class="no-print">
	<?php include 'inc/nav.inc'; ?>

	<div class="container-fluid">
  		<div class="row">
  		<div class="col-sm-12">

  		<div class="panel panel-default">
  		<div class="panel-heading">Faktury</div>
  		<div class="panel-body">

		<div class="table-responsive">
		<table id="invoices" class="table table-striped table-bordered table-vcenter" style="display:none">
		<thead>
			<tr>
				<th class="text-right">#</th>
				<th class="text-center">Numer</th>
				
				<th class="text-center">Data</br>wystawienia</th>
				<th class="text-center">Data</br>sprzedaży</th>
				<th class="text-center">Termin</br>płatności</th>

				<th class="text-center">Projekt zrealizowany</th>
				<th class="text-right">Wartość</br>netto</th>
				<th class="text-right">Kwota VAT</th>
				<th class="text-right">Wartość</br>brutto</th>
				<th class="text-center">Akcja</th>
			</tr>
		</thead>
    <tfoot>
      <tr>
        <th colspan="6">Razem na stronie:</th>
        <th style="text-align:right"></th>
        <th style="text-align:right"></th>
        <th style="text-align:right"></th>
        <th></th>
      </tr>
    </tfoot>
		<tbody>
		<?php
		$invoice_order = 0;
		foreach ($myinvoices as $myinvoice) {
			$html_table  = '<tr>'.PHP_EOL;
			
			$html_table .= '<td class="text-right">' . ++$invoice_order . '.' . '</td>' . PHP_EOL;
			$html_table .= '<td class="text-center invoice_number">' . $myinvoice['invoice_number'] .'</td>' . PHP_EOL; 

			$html_table .= '<td class="text-center">' . $myinvoice['date_of_issue'] .'</td>' . PHP_EOL; 
			$html_table .= '<td class="text-center">' . $myinvoice['date_of_sale'] .'</td>' . PHP_EOL; 
			$html_table .= '<td class="text-center">' . $myinvoice['date_termin'] .'</td>' . PHP_EOL;

			$html_table .= '<td class="text-center">' . $myinvoice['description'] .'</td>' . PHP_EOL;

			$html_table .= '<td class="text-right">' . my_number_format($myinvoice['gross_total']) .'</td>' . PHP_EOL;
			$html_table .= '<td class="text-right">' . my_number_format($myinvoice['tax_amount']) .'</td>' . PHP_EOL;
			$html_table .= '<td class="text-right">' . my_number_format($myinvoice['total']) .'</td>' . PHP_EOL;

			

			$html_table .=  '<td>' . PHP_EOL;
				
			$html_table .=  '<button type="button" invoice-id="' . $myinvoice['id'] . '" class="btn btn-default invoiceEdit glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="bottom" title="Edytuj fakturę"';
			$html_table .=  '></button>'.PHP_EOL;
	
				
			$html_table .=  '<button type="button" invoice-id="' . $myinvoice['id'] . '" class="btn btn-default invoiceDelete glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="bottom" title="Usuń fakturę"';
			$html_table .=  '></button>'.PHP_EOL;
				
	
			//$html_table .=  '<button type="button" data-id="' . $myinvoice['id'] . '" class="btn btn-default infoinvoice glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Historia zmian"';
			//$html_table .=  '></button>'.PHP_EOL;
	
			
			$html_table .=  '<button type="button" invoice-id="' . $myinvoice['id'];
			$html_table .=  '" class="btn btn-default invoicePrint glyphicon glyphicon-print" data-toggle="tooltip" data-placement="bottom" title="Wydruk faktury"';	
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
  	<?php include 'inc/invoice/invoice_edit.html'; ?>
  	<?php include 'inc/invoice/invoice.html'; ?>
  	<script src="inc/js/functions.js"></script>
  	<script src="inc/js/jquery.dirrty.js"></script>
  	<script src="inc/js/jquery.validate.min.js"></script>
  	<script src="inc/js/printThis.js"></script>
  	<script src="inc/invoice/invoice_new.js"></script>
  	<script src="inc/invoice/invoice_print.js"></script>
  	<script src="inc/invoice/invoice_delete.js"></script>
  	<script src="inc/invoice/invoice_edit.js"></script>
  	<script src="inc/invoice/invoice_browse.js"></script>
</body>
</html>