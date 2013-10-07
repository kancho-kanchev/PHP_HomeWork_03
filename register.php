<?php 
$pageTitle = 'Форма за регистрация';
require_once 'includes'.DIRECTORY_SEPARATOR.'header.php';
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
	header('Location: messages.php');
	exit;
}
if ($_POST) {
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$error = false;
		$password = trim($_POST['password']);
		if (mb_strlen($password, 'UTF-8') < 4) {
			echo 'Паролата е къса';
			$error = true;
		}
		$username = trim($_POST['username']);
		if (mb_strlen($username, 'UTF-8') < 4) {
			echo 'Името е късо';
			$error = true;
		}
		else if (!(!preg_match('/[^A-Za-z0-9]/', $username) && (ctype_alpha($username[0])))) {
			echo 'Името трябва да започва с буква и може да съсържа букви и цифри';
			$error = true;
		}
	}
	if (file_exists('data.txt')) {
		$result = file('data.txt');
		foreach ($result as $value) {
			$value = trim($value);
			$columns = explode(';', $value);
			if ($username == trim($columns[0])) {
				echo 'Този потребител вече съществува.';
				$error = true;
			}
		}
	}
	if (!$error) {
		$result=$username.';'.$password."\n";
		if (file_put_contents('data.txt', $result, FILE_APPEND)) {
			echo 'Записа е успешен';
			if (!file_exists($username)) {
				mkdir($username);
			}
			$_SESSION['isLogged'] = true;
			$_SESSION['username'] = $username;
			header('Location: index.php');
			exit;
		}
	}
	else {
		echo "\n".'Неуспешен вход';
	}
}
?>
	<form method="POST" action="register.php">
		<div>Потребителско име:<input type="text" name="username" value="<?= (isset($username)) ? $username : '';?>"/></div>
		<div>Парола:<input type="password" name="password" value="<?= (isset($password)) ? $password : '';?>"/></div>
		<div><input type="submit" name="submit" value="Регистрирай" /></div>
	</form>
	<form method="POST" action="destroy.php">
	    <input type="submit" value="Отказ">
	</form>
<?php 
include_once 'includes'.DIRECTORY_SEPARATOR.'footer.php';
