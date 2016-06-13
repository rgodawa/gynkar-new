<?php
function _get_email_project_title_new($myproject) {
	
	$kolor_zmiana = '#40cfff;';
	$kolor_alarm = '#FF0000;';
	$kolor_prawie_alarm = '#ff9e9e;';
	$kolor_naglowek = '#000078;';

	$htm = '<body style="background:#cce3f1;font-family:Verdana;">
		<table width="440"><tr><td>
		<h2>'. $tytul .'</h2>Autor: ' . $myproject['project_author'] . '</td><td align="right">';
		
		$htm .= '</td></tr></table>
			<h3>Informacje ogólne:</h3> 
			<table> 
			<tr style="padding:1px 7px;"> 
				<td style="padding:3px 6px;">Kategoria:</td> 
				<td style="padding:3px 6px;color:".$kolor_naglowek."font-weight:bold;" >';
				$htm .= $myproject['project_title'].'</td><td width="120">&nbsp;</td>  
				<td style="padding:3px 6px;">Data dostarczenia bet:</td> 
				<td style="padding:3px 6px;color:'. $kolor_naglowek . ' font-weight:bold;">';
				$htm .= $myproject['data_bety'] . '</td> 
			</tr> 
			<tr style="padding:1px 7px;"> 
				<td style="padding:3px 6px;">Emisja w:</td> 
				<td style="padding:3px 6px;color:' . $kolor_naglowek . ' font-weight:bold;" >';			
				$htm .= $myproject['emisja'] . '</td><td width="120">&nbsp;</td>  				
				<td style="padding:3px 6px;">Data emisji:</td> 
				<td style="padding:3px 6px;color:' .$kolor_naglowek . ' font-weight:bold;" >';
				$htm .= $myproject['data_emisji'] . '</td> 
			<tr style="padding:1px 7px;"> 
				<td style="padding:3px 6px;">Długość spotu:</td> 
				<td style="padding:3px 6px;color:".$kolor_naglowek."font-weight:bold;" >';
				$htm .= $myproject['dlugosc'] . ' sekund</td><td width="120">&nbsp;</td>  
				<td style="padding:3px 6px;">Status projektu:</td> 
				<td style="padding:3px 6px;color:' . $kolor_naglowek . ' font-weight:bold;" >';
				$htm .= $myproject['status'] . '</td> 
			</tr>'; 
			
			
	//if ($mail) $htm .= "<p>Strona projektu: <a href="http://" . $_SERVER['SERVER_NAME'] ."/".$plik_projekty . "?projekt=". $tytul ."">".$tytul."</a></p>';
	//if ($mail) $htm .= "<p>Strona projektu: <a href="http://" . $WWW_ROOT ."/".$plik_projekty . "?projekt=". $tytul ."">".$tytul."</a></p>';
	
$htm .= '</body>';
return $htm;
}

function get_email_project_title($myproject) {
	$htm  = '<table width="600">';
	$htm .= '<tr><td>';
	$htm .= '<h2>' . $myproject['project_title'] . '</h2>';
	$htm .= '</td></tr>';
	$htm .= '<tr><td>';
	$htm .= 'Autor: ' . $myproject['project_author'];
	$htm .= '</td></tr>';
	$htm .= '<tr><td>';
	$htm .= 'Status projektu: ' . $myproject['project_status_name']; 
	$htm .= '</td></tr>';
	$htm .= '<tr><td>';
	$htm .= '<h3>Informacje szczegółowe:</h3>';
	$htm .= '</td></tr>';
	$htm .= '</table>';
	return $htm;
}

function get_email_project_product($mylp, $myproject) {
	$kolor_naglowek = '#000078;';
	
	$htm  = '<tr style="padding:1px 7px;"> 
				<td style="padding:3px 6px;">' . $mylp . '. Produkt:</td> 
				<td style="padding:3px 6px;color:'. $kolor_naglowek. ' font-weight:bold;" >';
				$htm .= $myproject['product'].'</td> 
			</tr>';

	$htm  .= '<tr style="padding:1px 7px;"> 
				<td style="padding:3px 26px;">Data dostarczenia materiałów:</td> 
				<td style="padding:3px 6px;color:'. $kolor_naglowek . ' font-weight:bold;">';
				$htm .= $myproject['product_date_of_beta'] . '</td> 
			</tr>';

	$htm  .= '<tr style="padding:1px 7px;"> 
				<td style="padding:3px 26px;">Data emisji:</td> 
				<td style="padding:3px 6px;color:'. $kolor_naglowek . ' font-weight:bold;">';
				$htm .= $myproject['product_date_of_issue'] . '</td> 
			</tr>';

	$htm  .= '<tr style="padding:1px 7px;"> 
				<td style="padding:3px 26px;">Emisja w:</td> 
				<td style="padding:3px 6px;color:'. $kolor_naglowek . ' font-weight:bold;">';
				$htm .= $myproject['product_list_stations'] . '</td> 
			</tr>';

	$htm  .= '<tr style="padding:1px 7px;"> 
				<td style="padding:3px 26px;">Długość spotu:</td> 
				<td style="padding:3px 6px;color:'. $kolor_naglowek . ' font-weight:bold;">';
				$htm .= $myproject['product_length'] . '</td> 
			</tr>';		
	
	return $htm;
	}


?>