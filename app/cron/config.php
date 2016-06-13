<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/gynkar-new/app/core/classes/';
$host = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . '/gynkar-new/app/';
$day_of_week = date('w');

require_once $path . 'database.php';
require_once $path . 'logging.php';
require_once $path . 'phpmailer.php';
require_once 'project_notify_users_changes_function.php';


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
?>