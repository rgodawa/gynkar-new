<?php
require_once 'core/init.php';
$general->logged_in_protect();

if (empty($_POST) === false) {

	$username = trim(strip_tags($_POST['username']));
	$password = trim(strip_tags($_POST['password']));
  $password_new_1 = trim(strip_tags($_POST['password_new_1']));
  $password_new_2 = trim(strip_tags($_POST['password_new_2']));


	if (empty($username) === true || empty($password) === true) {
		$errors[] = 'Wymagana jest nazwa użytkownika i hasło.';
	} else if (!($password_new_1 === $password_new_2)) {
		$errors[] = 'Powtórzone nowe hasło jest inne.';
  } else if ($users->user_exists($username) === false) {
    $errors[] = 'Nazwa użytkownika nie istnieje.';
	} else {
		if (strlen($password_new_1) > 8) {
			$errors[] = 'Hasło powinno być mniejsze niż 9 znaków, bez spacji.';
		}
		$login = $users->login($username, $password);
		if ($login === false) {
			$errors[] = 'Nazwa użytkownika / hasło jest nieprawidłowe';
		} else {
      $confirm = $users->confirm($login, $password, $password_new_1);
      if ($confirm === false) {
         $errors[] = 'Zmiana hasła się nie udała.';  
      } else {
         session_regenerate_id(true);
			   header('Location: login.php');
			   exit();
      }
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
                <input type="password" name="password" class="form-control" placeholder="Hasło otrzymane pocztą" required>
                <input type="password" name="password_new_1" class="form-control" placeholder="Nowe hasło" required>
                <input type="password" name="password_new_2" class="form-control" placeholder="Powtórz nowe hasło" required>
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

