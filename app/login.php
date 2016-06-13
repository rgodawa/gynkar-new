<?php
require_once 'core/init.php';
$general->logged_in_protect();

function get_client_ip_address()
{
    $remote_address = $_SERVER['REMOTE_ADDR'];

    if (isset($_SERVER['HTTP_X_REAL_IP'])) {
        $remote_address = $_SERVER['HTTP_X_REAL_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $remote_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $remote_address = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $remote_address = $_SERVER['HTTP_CLIENT_IP'];
    }

    return $remote_address;
}


if (empty($_POST) === false) {

	$username = trim(strip_tags($_POST['username']));
	$password = trim(strip_tags($_POST['password']));

	if (empty($username) === true || empty($password) === true) {
		$errors[] = 'Wymagana jest nazwa użytkownika i hasło.';
	} else if ($users->user_exists($username) === false) {
		$errors[] = 'Nazwa użytkownika nie istnieje.';
	} else if ($users->email_confirmed($username) === false) {
		$errors[] = 'Przepraszamy, ale musisz aktywować swoje konto. 
					 Prosimy o sprawdzenie e-mail.';
	} else {
		if (strlen($password) > 18) {
			$errors[] = 'Hasło powinno być mniejsze niż 18 znaków, bez spacji.';
		}
		$login = $users->login($username, $password);
		if ($login === false) {
			$errors[] = 'Nazwa użytkownika / hasło jest nieprawidłowe';
		}else {
			session_regenerate_id(true);// destroying the old session id and creating a new one
            $ip_address = get_client_ip_address();
			$remote_host = gethostbyaddr($ip_address);
			$_SESSION['REMOTE_ADDR'] = $ip_address;
			$_SESSION['id'] =  $login;
			$_SESSION['session_id'] = $users->user_login($login, $ip_address, $remote_host);
			header('Location: projekty-otwarte');
			exit();
		}
	}
} 
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <?php include 'inc/head.inc'; ?>
</head>
<body>

<div class="container-fluid">
    <div class="row-fluid">
      <div class="centering text-center">
        <div class="col-xs-12 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">System Zarządzania Produkcjami Media Service Zawada</h1>
            <?php 
          		if(empty($errors) === false){
          			echo '<p style="color:red;">' . implode('</p><p>', $errors) . '</p>';	
          		}
        	?>
            <div class="account-wall">
                <img class="profile-img" src="css/img/logo.gif" alt="">
                <form class="form-signin" method="post" action="">
                <input type="text" name="username" class="form-control" placeholder="Login" required autofocus>
                <input type="password" name="password" class="form-control" placeholder="Hasło" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">
                    Zaloguj się</button>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>

</body>
</html>

