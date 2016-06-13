<?php

function get_email_project_change_headers() {
	$htm  = '<thead><tr style="padding:1px 7px;">' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('right') . '>Lp</th>' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('left') . '>Dotyczy</th>' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('left') . '>Pole</th>' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('center') . '>Data zmiany</th>' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('center') . '>Operator</th>' . PHP_EOL;
	$htm .= '<th ' . get_stage_th('center') . '>Zmiana</th>' . PHP_EOL;
	$htm .= '</thead></tr>';
	return $htm;
}

function get_email_project_change($mylp, $mystage) {
	$danger = '';
	$warning = '';
	$htm   = '<tr style="padding:1px 7px;">' . PHP_EOL;
	$htm  .= '<td ' . get_stage_th('right') . '>' . $mylp . '.' . '</td>' . PHP_EOL;
	$htm  .= '<td ' . get_stage_th('left') . '>' .  $mystage['type_item'] . '</td>' . PHP_EOL;
	$htm  .= '<td ' . get_stage_th('left') . '>' .  $mystage['type_of_change'] . '</td>' . PHP_EOL;
	$htm  .= '<td ' . get_stage_th('center') . '>' .  $mystage['update_date'] . '</td>' . PHP_EOL;
	$htm  .= '<td ' . get_stage_th('left') . '>' .  $mystage['user_name'] . '</td>' . PHP_EOL;
	$htm  .= '<td ' . get_stage_th('left') . '>' .  $mystage['changes'] . '</td>' . PHP_EOL;
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