<?php
function mytitle_option($mytitles) {
	foreach ($mytitles as $mytitle) {
		echo '<option value="' . $mytitle['id'] . '">' . $mytitle['title'] . '</option>' . PHP_EOL;
	}
}

function mystation_checboxes($mystations, $name) {
	$nrows  = ceil(count($mystations)/4);
	$ncount = 0;
	foreach ($mystations as $mystation) {
		$html = '';
		if (($ncount/$nrows) == intval($ncount/$nrows)) {
			$html .= '<div class="col-md-3">'. PHP_EOL;
		}
		++$ncount;
		$html .= '<label class="checkbox"><input value="' . $mystation['id'] . '" type="checkbox" name="'. $name . '">';
		$html .= $mystation['station_name'] . '</label>'. PHP_EOL;
		if (($ncount/$nrows) == intval($ncount/$nrows)) {
			$html .= '</div>'. PHP_EOL;
		}
		echo $html;
	}
	//echo '</div>'. PHP_EOL;
}

function myuser_checboxes($myusers, $default) {
	$nrows  = ceil(count($myusers)/4);
	$ncount = 0;
	foreach ($myusers as $myuser) {
		$html = '';
		if (($ncount/$nrows) == intval($ncount/$nrows)) {
			$html .= '<div class="col-md-3">'. PHP_EOL;
		}
		++$ncount;
		$checked =  $default && (($myuser['id'] == $_SESSION['id']) || ($myuser['default_notice'] == 1)) ? ' checked="checked"' : '';
		$html .= '<label class="checkbox"><input value="' . $myuser['id'] . '" type="checkbox"';
		$html .= $checked .'>';
		$html .= $myuser['full_name'] . '</label>'. PHP_EOL;
		if (($ncount/$nrows) == intval($ncount/$nrows)) {
			$html .= '</div>'. PHP_EOL;
		}
		echo $html;
	}
	echo '</div>'. PHP_EOL;
}


function mycheck_empty_data($date) {
	return (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') ? 1 : 0;
}

function myget_project_status_name($project_status_id) {
	$rt = '';
	switch ($project_status_id) {
		case '1':
			$rt='Otwarty';
			break;	
		case '2':
			$rt='Zrealizowany';
			break;
		case '3':
			$rt='Zamknięty';
			break;
	}
	return $rt;
}

function myget_product_button($product_name, $product_date_of_beta) {
	$rt = '';
	if ($product_name != '') {
		$rt = $product_name . '<br/>' .  'Beta: ' . $product_date_of_beta;
	}
	return $rt;
}

function myget_empty_button($product_group, $product_group_id, $product_type_id, $project_row, $empty) {
	$rt = '';
	if ($project_row['status_id'] == 1) {
		$rt = ($empty == true) ? '' :
			' type="button"' .
			' data-product="0" ' . 'data-project-id="' . $project_row['id'] . '"' .
			' data-product-type-id="' . $product_type_id . '"' . 
			' data-product-group-id="' . $product_group_id . '"' . 
			' data-product-group="' . $product_group . '"' .
			' class="btn btn-default addProduct glyphicon glyphicon-plus ' . $product_group . '"' . 
			' data-toggle="tooltip" data-placement="bottom" title="' . 'Dodaj ' . $product_group .
			'">';	}	
	return $rt;
}

function myget_color_button($product_group, $date_diff, $stage_opended, $stage_closed) {
	$rt = ' data-product-group="' . $product_group . '" ' . ' class="btn btn-sm editProduct ';

	switch(true) {

		case (($date_diff < 0) && ($stage_opended != 0)):
			$button = 'btn-danger';
			break;
		case (($date_diff == 0) && ($stage_opended != 0)):
			$button = 'btn-warning';
			break;
		case ($stage_closed == 0):
			$button = 'btn-default';
			break;
		case ($stage_opended == 0):
			$button = 'btn-success';
			break;
		default:
			$button = 'btn-primary';
	}

	return $rt . $button . '"';
}

function myget_button($product_group_id, $myproject, $button) {
	$rt = '';
	switch($product_group_id) {
		case 1:
			$rt=($myproject['spot_id'] != 0) 
				? ' type="button" data-product="' . $myproject['spot_id'] . '"' . ' data-project-id="' . $myproject['id'] . '"'
				. ' data-product-group-id="1" data-product-type-id="1"' 
				. myget_color_button('spot', $myproject['spot_date_diff'], $myproject['spot_stage_opended'], $myproject['spot_stage_closed']) . '>' 
				. myget_product_button($myproject['spot_product'], $myproject['spot_product_date_of_beta'])
				: myget_empty_button('spot', $product_group_id, 1, $myproject, false);
			break;	
		case 2:
			$rt=($myproject['billboard_id'] != 0) 
				? ' type="button" data-product="' . $myproject['billboard_id'] . '"' . ' data-project-id="' . $myproject['id'] . '"'
				. ' data-product-group-id="2" data-product-type-id="3"'
				. myget_color_button('billboard', $myproject['billboard_date_diff'], $myproject['billboard_stage_opended'], $myproject['billboard_stage_closed']) . '>'
				. myget_product_button($myproject['billboard_product'], $myproject['billboard_product_date_of_beta'])
				: myget_empty_button('billboard', $product_group_id, 3, $myproject, ($myproject['youtube_id'] != 0));
			break;
		case 3:
			$rt=($myproject['youtube_id'] != 0) 
				? ' type="button" data-product="' . $myproject['youtube_id'] . '"' . ' data-project-id="' . $myproject['id'] . '"'
				. ' data-product-group-id="3" data-product-type-id="5"'
				. myget_color_button('film YouTube', $myproject['youtube_date_diff'], $myproject['youtube_stage_opended'], $myproject['youtube_stage_closed']) . '>'
				. myget_product_button($myproject['youtube_product'], $myproject['youtube_product_date_of_beta'])
				: myget_empty_button('film YouTube', $product_group_id, 5,  $myproject, ($myproject['billboard_id'] != 0));
			break;

	}
	return (($button == true) ? '<button' : '') . $rt . (($button == true) ? '</button>' : '');
}

?>