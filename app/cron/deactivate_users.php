<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/gynkar-new/app/core/classes/';
$interval = 1;

require_once $path . 'database.php';
require_once $path . 'logging.php';

$db = Database::connect();

$log = new Logging();
$log->lfile($_SERVER['DOCUMENT_ROOT'] . '/gynkar-new/app/log/mylog.txt');

$query = $db->prepare("CALL sp_users_inactive(:p_interval)");
$query->bindValue(':p_interval', $interval);


try {
	$query->execute();
	$log->lwrite('Wykonano');
	
} catch(PDOException $e) {
	$log->lwrite($e->getMessage());
	die();
}


Database::disconnect();
?>