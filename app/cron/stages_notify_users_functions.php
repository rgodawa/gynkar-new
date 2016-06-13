<?php

function get_email_product_stage_headers() {
	$htm  = '<thead><tr style="padding:1px 7px;">' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('right') . '>Lp</th>' . PHP_EOL;
	//$htm .= '<th ' . get_stage_th('left') . '>Tytuł</th>' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('left') . '>Produkt</th>' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('left') . '>Etap</th>' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('center') . '>Planowana data zamknięcia</th>' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('center') . '>Dni opóźnienia</th>' . PHP_EOL;
	$htm .= '</thead></tr>';
	return $htm;
}

function get_email_product_stage($mylp, $mystage) {
	$danger = '';
	$warning = '';
	$htm   = '<tr style="padding:1px 7px;">' . PHP_EOL;
	$htm  .= '<td ' . get_stage_td('right', $mystage) . '>' . $mylp . '.' . '</td>' . PHP_EOL;
	//$htm  .= '<td ' . get_stage_td('left', $mystage) . '>' .  $mystage['project_title'] . '</td>' . PHP_EOL;
	$htm  .= '<td ' . get_stage_td('left', $mystage) . '>' .  $mystage['product_name'] . '</td>' . PHP_EOL;
	$htm  .= '<td ' . get_stage_td('left', $mystage) . '>' .  $mystage['stage_name'] . '</td>' . PHP_EOL;
	$htm  .= '<td ' . get_stage_td('center', $mystage) . '>' .  $mystage['planned_closing_date'] . '</td>' . PHP_EOL;
	$htm  .= '<td ' . get_stage_td('center', $mystage) . '>' .  $mystage['stage_date_diff'] . '</td>' . PHP_EOL;
	$htm  .= '</tr>' . PHP_EOL;
	return $htm;
}

function get_stage_th($align) {
	return  'style="text-align:' . $align . ';' .
			'padding:3px 6px;' .
			'border: 1px solid black;"';
}

function get_stage_td($align, $mystage) {
	$danger = '#D9534F';
	$warning = '#FF9800';	
	return  'style="text-align:' . $align . ';' .
			'padding:3px 6px;' .
			'color:' . (($mystage['stage_date_diff'] == 0) ? $warning : $danger) . ';' .
			'border: 1px solid black;"';
}
?>