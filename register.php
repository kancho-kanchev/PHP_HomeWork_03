<?php 
$pageTitle = 'Форма за регистрация';
require_once 'includes'.DIRECTORY_SEPARATOR.'header.php';
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
	header('Location: messages.php');
	exit;
}
if ($_POST) {
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nickname'])) {
		$error = false;
		$password = trim($_POST['password']);
		if (mb_strlen($password, 'UTF-8') < 5 || mb_strlen($password, 'UTF-8') > 20) {
			echo 'Паролата трябва да е между 5 и 20 символа</br>'."\n";
			$error = true;
		}
		else if (!(!preg_match('/[^A-Za-z0-9]/', $password))) {
			echo 'Паролата може да съдържа букви и цифри</br>'."\n";
			$error = true;
		}
		$username = trim($_POST['username']);
		if (mb_strlen($username, 'UTF-8') < 5 || mb_strlen($username, 'UTF-8') > 20) {
			echo 'Името трябва да е между 5 и 20 символа</br>'."\n";
			$error = true;
		}
		else if (!(!preg_match('/[^A-Za-z0-9]/', $username) && (ctype_alpha($username[0])))) {
			echo 'Името трябва да започва с буква и може да съдържа букви и цифри</br>'."\n";
			$error = true;
		}
		$nickname = trim($_POST['nickname']);
		if (mb_strlen($nickname, 'UTF-8') < 5 || mb_strlen($nickname, 'UTF-8') > 20) {
			echo 'Прякора трябва да е между 5 и 20 символа</br>'."\n";
			$error = true;
		}
		else if (!(!preg_match('/[^A-Za-z0-9]/', $nickname) && (ctype_alpha($nickname[0])))) {
			echo 'Прякора трябва да започва с буква и може да съсържа букви и цифри</br>'."\n";
			$error = true;
		}
		
		
		$firstname = trim($_POST['firstname']);
		if (mb_strlen($firstname, 'UTF-8') < 5 || mb_strlen($firstname, 'UTF-8') > 20) {
			echo 'Името трябва да е между 5 и 20 символа</br>'."\n";
			$error = true;
		}
		else if (!(!preg_match('/[^A-Za-z]/', $firstname))) {
			echo 'Името трябва да започва с буква и може да съсържа букви и цифри</br>'."\n";
			$error = true;
		}
		
		$lastname = trim($_POST['lastname']);
		if (mb_strlen($lastname, 'UTF-8') < 5 || mb_strlen($lastname, 'UTF-8') > 20) {
			echo 'Името трябва да е между 5 и 20 символа</br>'."\n";
			$error = true;
		}
		else if (!(!preg_match('/[^A-Za-z]/', $lastname))) {
			echo 'Името трябва да започва с буква и може да съсържа букви и цифри</br>'."\n";
			$error = true;
		}
		
		$email = trim($_POST['email']);
		if (mb_strlen($email, 'UTF-8') < 5 || mb_strlen($email, 'UTF-8') > 50) {
			echo 'Мейлът трябва да е между 5 и 50 символа</br>'."\n";
			$error = true;
		}
		else if (!(!preg_match('/[^A-Za-z0-9]/', $email) && (ctype_alpha($email[0])))) {
			echo 'Мейлът не е валиден</br>'."\n";
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
		<div>Прякор:<input type="nickname" name="nickname" value="<?= (isset($nickname)) ? $nickname : '';?>"/></div>
		<div>Име:<input type="firstname" name="firstname" value="<?= (isset($firstname)) ? $firstname : '';?>"/></div>
		<div>Фамилия:<input type="lastname" name="lastname" value="<?= (isset($lastname)) ? $lastname : '';?>"/></div>
		<div>e-mail:<input type="email" name="email" value="<?= (isset($email)) ? $email : '';?>"/></div>
		<div><input type="submit" name="submit" value="Регистрирай" /></div>
	</form>
	<form method="POST" action="destroy.php">
	    <input type="submit" value="Отказ">
	</form>
<?php 
include_once 'includes'.DIRECTORY_SEPARATOR.'footer.php';
