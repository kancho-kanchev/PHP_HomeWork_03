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
		//echo mysqli_error($connection);
		header('error.php?message=connectionerror');
		exit;
	}
	mysqli_set_charset($connection, 'UTF8');
	if ($_POST) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		$stmt = mysqli_prepare($connection, 'SELECT username, password FROM users WHERE username=? AND password=?');
		if (!$stmt) {
			//echo mysqli_error($connection);
			header('error.php?message=databaseerror');
			exit;
		}
		else {
			mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
			mysqli_stmt_execute($stmt);
			$rows = mysqli_stmt_result_metadata($stmt);
			while ($field = mysqli_fetch_field($rows)) {
				$fields[] = &$row[$field->name];
			}
			call_user_func_array(array($stmt, 'bind_result'), $fields);
			while (mysqli_stmt_fetch($stmt)) {
				//echo '<pre>'.print_r($row, true). '</pre>';
				$_SESSION['isLogged'] = true;
				$_SESSION['username'] = $row['user_id'];
				header('Location: messages.php');
				exit;  
			}
			$message = 'Невалидно потребителско име или парола.';
		}
	}
?>
	<form method="POST" action="index.php">
		<div>Потребител:<input type="text" name="username" /></div>
		<div>Парола:<input type="password" name="password" /></div>
		<div>
			<a href="register.php">Регистрирай се</a>
			<input type="submit" name="submit" value="Влез" />
		</div>
	</form>
<?php 
	echo $message;
	include_once 'includes'.DIRECTORY_SEPARATOR.'footer.php';
}
