<?php

require_once 'config.php';

if ($day_of_week > 0 && $day_of_week < 6) {

$query = $db->prepare("CALL sp_project_notify_users_changes_new()");

try {
	$query->execute();
	$rows = $query->fetchAll();
	unset( $query);
	$nRow = 0;
	$nRows = count($rows) - 1;
	while ($nRow <= $nRows) {
		$project_id = $rows[$nRow]['project_id'];
			$project_title = $rows[$nRow]['project_title'];
			$list_full_name = $rows[$nRow]['list_full_name'];
			$list_email_notice = $rows[$nRow]['list_email_notice'];
			$nlp = 1;
			$htm  = '<html lang="pl"><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" ></head>';
			$htm .= '<body style="background:white;font-family:Verdana;">';
			$htm .= '<table style="border-collapse: collapse;border: 1px solid black;">';
			$htm .= get_email_project_change_headers();
			$htm .= '<tbody>';
			
			while (($nRow <= $nRows) && ($project_id == $rows[$nRow]['project_id'])) {	
				
					$htm .= get_email_project_change($nlp, $rows[$nRow]);
					$nlp++;
					$nRow++;
				
			}

		$htm .= '</tbody>';
		$htm .= '</table>';
		$htm .= '<p>Dzień tygodnia: ' . date('w') . '</p>';
		$htm .= '</body></html>';
		//mySendMail($db, $mailer, $log, $htm, $list_full_name, $list_email_notice, $project_title);
		
		print_r('<p>Projekt: ' . $project_title . '</p>');
		print_r('<p>Adresaci: ' . $list_full_name . '</p>');
		print_r('<p>Email: ' . $list_email_notice . '</p>');
		print_r($htm);
		

}	

} catch(PDOException $e) {
	$log->lwrite($e->getMessage());
	die();
}


Database::disconnect();

}

function mySendMail($db, $myMailer, $mylog, $myBody, $list_full_name, $list_email_notice, $project_title) {
	$myMailer->ClearAllRecipients();
	//$myMailer->AddAddress($user_email, $user_full_name);

	$addresses = explode(',', $list_email_notice);
	$names = explode(',', $list_full_name);

	$nb = count($addresses);
	for ($i=0;$i<$nb;$i++) {
    	$myMailer->AddAddress($addresses[$i], $names[$i]);
	}

	$myMailer->AddAddress('rgodawa@gmail.com', 'Rafał Godawa');
	$myMailer->Subject = 'Projekt: ' . $project_title . ' - lista zmian.';
	$myMailer->Body = $myBody;
	try {
		$myMailer->Send();
		$mylog->lwrite('Listę zmian ' . 
						' wysłano do: ' .  $list_full_name .
						' na adres: ' .   $list_email_notice);
	} 
    catch (phpmailerException $e) {
      		$mylog->lwrite($e->errorMessage());
      		die();  
    } 
}	
?>