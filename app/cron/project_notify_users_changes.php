<?php

require_once 'config.php';

if ($day_of_week > 0 && $day_of_week < 6) {

$query = $db->prepare("CALL sp_project_notify_users_changes()");

try {
	$query->execute();
	$rows = $query->fetchAll();
	unset( $query);
	$nRow = 0;
	$nRows = count($rows) - 1;
	while ($nRow <= $nRows) {
		$user_id = $rows[$nRow]['notice_user_id'];
		$user_full_name = $rows[$nRow]['notice_user_full_name'];
		$user_email = $rows[$nRow]['notice_user_email'];
			
		while (($nRow <= $nRows) && ($user_id == $rows[$nRow]['notice_user_id'])) {
			$project_id = $rows[$nRow]['project_id'];
			$project_title = $rows[$nRow]['project_title'];

			$nlp = 1;
			$htm  = '<html lang="pl"><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" ></head>';
			$htm .= '<body style="background:white;font-family:Verdana;">';
			$htm .= '<table style="border-collapse: collapse;border: 1px solid black;">';
			$htm .= get_email_project_change_headers();
			$htm .= '<tbody>';


			while (($nRow <= $nRows) && ($user_id == $rows[$nRow]['notice_user_id']) && ($project_id == $rows[$nRow]['project_id'])) {
			
				$htm .= get_email_project_change($nlp, $rows[$nRow]);
				$nlp++;
				$nRow++;

			}

			$htm .= '</tbody>';
			$htm .= '</table>';
			$htm .= '<p>Dzień tygodnia: ' . date('w') . '</p>';
			$htm .= '</body></html>';
			//mySendMail($db, $mailer, $log, $htm, $user_full_name, $user_email, $project_title);
			print_r($user_full_name . '[' . $project_title . ']');
			print_r($htm);
		}
}	

} catch(PDOException $e) {
	$log->lwrite($e->getMessage());
	die();
}


Database::disconnect();

}

function mySendMail($db, $myMailer, $mylog, $myBody, $user_full_name, $user_email, $project_title) {
	$myMailer->ClearAllRecipients();
	//$myMailer->AddAddress($user_email, $user_full_name);

	$myMailer->AddAddress('rgodawa@gmail.com', 'Rafał Godawa');
	$myMailer->Subject = 'Projekt: ' . $project_title . ' - lista zmian.';
	$myMailer->Body = $myBody;
	try {
		$myMailer->Send();
		$mylog->lwrite('Listę zmian ' . 
						' wysłano do: ' .  $user_full_name .
						' na adres: ' .   $user_email);
	} 
    catch (phpmailerException $e) {
      		$mylog->lwrite($e->errorMessage());
      		die();  
    } 
}	
?>