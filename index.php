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
		echo mysqli_error($connection);
		header('error.php?message=connectionerror');
		exit;
	}
	mysqli_set_charset($connection, 'UTF8');
	if ($_POST) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$q = mysqli_query($connection, 'SELECT username, password FROM users');
		if (!$q) {
			echo mysqli_error($connection);
			header('error.php?message=databaseerror');
			echo mysqli_error($connection);
			exit;
		}
		else {
			while ($row = $q->fetch_assoc()) {
				if ($username == $row['username'] && $password == $row['password']) {
					$_SESSION['isLogged'] = true;
					$_SESSION['username'] = $row['user_id'];
					header('Location: messages.php');
					exit;
				}
			}
			$message = 'Невалидно потребителско име или парола.';
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
