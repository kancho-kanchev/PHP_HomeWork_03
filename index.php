<?php
$pageTitle = 'Логин';
$message = '';
require_once 'includes'.DIRECTORY_SEPARATOR.'header.php';
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
	header('Location: messages.php');
	exit;
}
else {
	if ($_POST) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		if ($username == 'user' && $password == 'qwerty') {
			$_SESSION['isLogged'] = true;
			$_SESSION['username'] = $username;
			header('Location: files.php');
			exit;
		}
		elseif (file_exists('data.txt')) {
			$result = file('data.txt');
			foreach ($result as $value) {
				$value = trim($value);
				$columns = explode(';', $value);
				if ($username == trim($columns[0]) && $password == $columns[1]) {
					$_SESSION['isLogged'] = true;
					$_SESSION['username'] = $username;
					header('Location: files.php');
					exit;
				}
			}
		}
		else {
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
