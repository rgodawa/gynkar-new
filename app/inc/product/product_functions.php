<?php
function get_stages($stages, $user) {
	//$disable = ($user['role_id'] == 4) ? 'disabled' : '';
	$disable = '';
	$stage_order = 0;
	$nRow = 0;
	$nRows = count($stages) - 1;
	while ($nRow <= $nRows) {
		$stage_order = $stages[$nRow]['stage_order'];
		$html = '';
		$html .= '<div class="row">' . PHP_EOL;
		$html .= '<div class="col-md-12">' . PHP_EOL;
		$html .= '<div id="panel_stage_'  . $stage_order . '" class="panel panel-default panel-stage">' . PHP_EOL;
		$html .= '<div class="panel-heading text-center"><h3 class="panel-title">' . $stages[$nRow]['stage_name'] . '</h3></div>' . PHP_EOL;
		$html .= '<div class="panel-body">' . PHP_EOL;

		$html .= '<div class="col-md-1"></div>' . PHP_EOL;

		$html .= '<div id="stage_done_' . $stage_order . '" class="col-md-4 radio">' . PHP_EOL;
		
		while (($nRow <= $nRows) && ($stage_order == $stages[$nRow]['stage_order'])) 
		{
			$html .= '<label class="radio">' . PHP_EOL;
			$html .= '<input name="stage_' . $stage_order . '"';
			$html .= ' stage-order="' . $stage_order . '"';
			$html .= ' value="' . $stages[$nRow]['stage_option_value'] . '"';
			$html .= ' type="radio">' . $stages[$nRow]['stage_option_name'] . PHP_EOL;
			$html .= '</label>' . PHP_EOL;
			$nRow++;	
		}	
		
		$html .= '</div>' . PHP_EOL;

		$html .= '<div class="col-md-5">' . PHP_EOL;
		$html .= '<div class="form-group">' . PHP_EOL;
		$html .= '<label class="col-md-7 control-label date" >Planowana data zamknięcia:</label>' . PHP_EOL;
		$html .= '<div id="planned_closing_date_'. $stage_order . '" class="col-md-5 input-group date">' . PHP_EOL;
		$html .= '<input placeholder="RRRR-MM-DD" type="text" class="form-control" ' . $disable . ' >' . PHP_EOL;
		$html .= '<div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;		
		$html .= '</div>' . PHP_EOL;

		$html .= '<div class="form-group">' . PHP_EOL;
		$html .= '<label class="col-md-7 control-label date" >Data zamknięcia:</label>' . PHP_EOL;
		$html .= '<div id="closing_date_'. $stage_order . '" class="col-md-5 input-group date">' . PHP_EOL;
		$html .= '<input placeholder="RRRR-MM-DD" type="text" class="form-control" ' . $disable . ' >' . PHP_EOL;
		$html .= '<div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;		
		$html .= '</div>' . PHP_EOL;


		$html .= '</div>' . PHP_EOL;

		$html .= '<div class="col-md-2">' . PHP_EOL;
		$html .= '<button id="save_'. $stage_order . '" type="button" stage-id=""' . PHP_EOL; 
		$html .= 'class="btn btn-default saveStageButton glyphicon glyphicon-save blue-tooltip"' . PHP_EOL; 
		$html .= 'data-toggle="tooltip" data-placement="bottom" title="Zapisz" style="display: none;">' . PHP_EOL;
		$html .= '</button>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;	    		
		$html .= '</div>' . PHP_EOL;

		$html .= '</div>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;
		echo $html;
	}
}
?>