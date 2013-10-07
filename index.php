<?php
$pageTitle = 'Логин';
$message = '';
require_once 'includes'.DIRECTORY_SEPARATOR.'header.php';
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
	header('Location: messages.php');
	exit;
}
else {
	$connection = mysqli_connect('localhost', 'gatakka', 'qwerty', 'PHP_HomeWork_03');
	if (!$connection) {
		header('error.php?message=connectionerror');
		exit;
	}
	else {
		if ($_POST) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$q = mysqli_query($connection, 'SELECT * FROM users');
			if (!q) {
				header('error.php?message=databaseerror');
				echo mysqli_error($connection);
				exit;
			}
			if ($username == trim($q) && $password == $q) {
				$_SESSION['isLogged'] = true;
				$_SESSION['username'] = $username;
				header('Location: messages.php');
				exit;
			}
			else {
				$message = 'Невалидно потребителско име или парола.';
			}
		}
	}
?>
	<form method="POST">
		<div>Потребител:<input type="text" name="username" /></div>
		<div>Парола:<input type="password" name="password" /></div>
		<div>
			<a href="register.php">Регистрирай се</a>
			<input type="submit" value="Влез" />
		</div>
	</form>
<?php 
	echo $message;
	include_once 'includes'.DIRECTORY_SEPARATOR.'footer.php';
}
