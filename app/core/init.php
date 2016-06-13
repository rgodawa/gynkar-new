<?php 
session_start();

require_once 'classes/database.php';
require_once 'classes/users.php';
require_once 'classes/projects.php';
require_once 'classes/titles.php';
require_once 'classes/stations.php';
require_once 'classes/products.php';
require_once 'classes/invoices.php';
require_once 'classes/logging.php';
require_once 'classes/general.php';
require_once 'classes/bcrypt.php';
require_once 'classes/phpmailer.php';

// error_reporting(0);

$log = new Logging();
$log->lfile($_SERVER['DOCUMENT_ROOT'] . '/gynkar-new/app/log/mylog.txt');
//$log->lfile($_SERVER['DOCUMENT_ROOT'] . '/app/log/mylog.txt'); // na serwerze

$date = new DateTime();
$date->add(new DateInterval('P30D'));

$mymailer 	= new PHPMailer(true);
$mymailer->CharSet = 'utf-8';
$mymailer->FromName = 'Gynkar system test';
//$mymailer->From = 'postmaster@mszsystem-new.rall.pl'; // na serwerze
//$mymailer->Port = 587; // na serwerze
$mymailer->AddReplyTo('postmaster@mszsystem-new.rall.pl', 'Gynkar system test');
$mymailer->IsHTML(true);

$db       	= Database::connect();
$users 		= new Users($db, $log, $mymailer);
$general 	= new General();
$bcrypt 	= new Bcrypt(12);
$projects 	= new Projects($db, $log, date_format($date,'Y-m-d'));
$titles   	= new Titles($db, $log);
$stations	= new Stations($db, $log);
$products	= new Products($db, $log);
$invoices	= new Invoices($db, $log);


$errors = array();

if ($general->logged_in() === true)  {
	$user_id 	= $_SESSION['id'];
	$user 		= $users->userdata($user_id);
	$host	 	= isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'].'/';
	if ($user['online'] == 0) {
		unset($_SESSION['id']);
		header('Location: login.php');
	}
}

ob_start(); 