<?php
if(!isset($_GET['execute'])) { die(); }
 
$path = $_SERVER['DOCUMENT_ROOT'] . '/gynkar-new/app/core/classes/';
$host = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . '/gynkar-new/app/';
$day_of_week = date('w');
$days = 0;

require_once $path . 'database.php';
require_once $path . 'logging.php';
require_once $path . 'phpmailer.php';
require_once 'stages_notify_users_functions.php';

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

$query = $db->prepare("CALL sp_stages_delayed( :p_days )");
$query->bindValue(':p_days', $days);



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
			$htm .= get_email_product_stage_headers();
			$htm .= '<tbody>';


			while (($nRow <= $nRows) && ($user_id == $rows[$nRow]['notice_user_id']) && ($project_id == $rows[$nRow]['project_id'])) {
			
				$htm .= get_email_product_stage($nlp, $rows[$nRow]);
				$nlp++;
				$nRow++;

			}

			$htm .= '</tbody>';
			$htm .= '</table>';
			$htm .= '<p>Przejdź do: <a href="' . $host . 'projekty-otwarte' . '" target="_blank">' . 'Projekty otwarte' . '</a></p>';
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

function mySendMail($db, $myMailer, $mylog, $myBody, $user_full_name, $user_email, $project_title) {
	$myMailer->ClearAllRecipients();
	//$myMailer->AddAddress($user_email, $user_full_name);

	$myMailer->AddAddress('rgodawa@gmail.com', 'Rafał Godawa');
	$myMailer->Subject = 'Projekt: ' . $project_title . ' - lista opóźnionych etapów.';
	$myMailer->Body = $myBody;
	try {
		$myMailer->Send();
		$mylog->lwrite('Listę opóźnień ' . 
						' wysłano do: ' .  $user_full_name .
						' na adres: ' .   $user_email);
	} 
    catch (phpmailerException $e) {
      		$mylog->lwrite($e->errorMessage());
      		die();  
    } 
}	
?>