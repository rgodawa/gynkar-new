<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/gynkar-new/app/core/classes/';
$interval = 1;

require_once $path . 'database.php';
require_once $path . 'logging.php';
require_once $path . 'phpmailer.php';
require_once 'project_notify_users_functions.php';

$db = Database::connect();

$log = new Logging();
$log->lfile($_SERVER['DOCUMENT_ROOT'] . '/gynkar-new/app/log/mylog.txt');

$mailer 	= new PHPMailer(true);
$mailer->CharSet = 'UTF-8';
$mailer->FromName = 'Gynkar system test';
//$mailer->From = 'postmaster@mszsystem-new.rall.pl'; // na serwerze
//$mailer->Port = 587; // na serwerze
$mailer->AddReplyTo('postmaster@mszsystem-new.rall.pl', 'Gynkar system test');
$mailer->IsHTML(true);

$query = $db->prepare("CALL sp_project_notify_users_new");



try {
	$query->execute();
	$rows = $query->fetchAll();
	unset( $query);
	$nRow = 0;
	$nRows = count($rows) - 1;
	while ($nRow <= $nRows) {
		$htm = '<html lang="pl"><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" ></head>';
		$htm .= '<body style="background:#cce3f1;font-family:Verdana;">';
		$user_id = $rows[$nRow]['notice_user_id'];
		$user_full_name = $rows[$nRow]['notice_user_full_name'];
		$user_email = $rows[$nRow]['notice_user_email'];
	
		while (($nRow <= $nRows) && ($user_id == $rows[$nRow]['notice_user_id'])) {
			$htm .= get_email_project_title($rows[$nRow]);
			$project_id = $rows[$nRow]['project_id'];
			$project_title = $rows[$nRow]['project_title'];
			$nlp = 1;
			$htm .= '<table width="600">';
			while (($nRow <= $nRows) && ($user_id == $rows[$nRow]['notice_user_id']) && ($project_id == $rows[$nRow]['project_id'])) {
				
				$htm .= get_email_project_product($nlp, $rows[$nRow]);
				$nlp++;
				$nRow++;

			}
			$htm .= '</table>';
			$htm .= '</body></html>';
			mySendMail($db, $mailer, $log, $htm, $project_id, $user_id, $user_full_name, $user_email, $project_title);
			//print_r($htm);
		}
		
	}
	
} catch(PDOException $e) {
	$log->lwrite($e->getMessage());
	die();
}


Database::disconnect();

function mySendMail($db, $myMailer, $mylog, $myBody, $project_id, $user_id, $user_full_name, $user_email, $project_title) {
	$myMailer->ClearAllRecipients();
	//$myMailer->AddAddress($user_email, $user_full_name);
	$myMailer->AddAddress('rgodawa@gmail.com', 'Rafał Godawa');
	$myMailer->Subject = 'Test - Nowy projekt <' . $project_title . '> utworzono w systemie.';
	$myMailer->Body = $myBody;
	try {
		$myMailer->Send();
		$query = $db->prepare("CALL sp_project_notify_history_insert(:p_project_id
			, :p_notice_user_id
			, :p_notice_user_full_name
			, :p_notice_user_email)");

		$query->bindValue(':p_project_id', $project_id);
		$query->bindValue(':p_notice_user_id', $user_id);
		$query->bindValue(':p_notice_user_full_name', $user_full_name);
		$query->bindValue(':p_notice_user_email', $user_email);

		try {
			$query->execute();
		} catch(PDOException $e) {
			$mylog->lwrite($e->getMessage());
		}

		$mylog->lwrite('Projekt: '. $project_title . 
						' wysłano do: ' .  $user_full_name .
						' na adres: ' .   $user_email);
	} 
    catch (phpmailerException $e) {
      		$mylog->lwrite($e->errorMessage());
      		die();  
    } 
}	
?>