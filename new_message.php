<?php
$pageTitle = 'New message';
$message = '';
$messageForDel = '';
require_once 'includes'.DIRECTORY_SEPARATOR.'header.php';
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
	$username = trim($_SESSION['username']);
	echo 'Добре дошъл '.$username.'!';
	if ($_POST) {
		require_once 'includes'.DIRECTORY_SEPARATOR.'conection.php';
		if (isset($_POST['title']) && isset($_POST['message'])) {
			$error = false;
			$title = trim($_POST['title']);
			if (mb_strlen($title, 'UTF-8') < 1 || mb_strlen($title, 'UTF-8') > 50) {
				echo 'Заглавието трябва да е между 1 и 50 символа</br>'."\n";
				$error = true;
			}
			else {
				mysqli_real_escape_string($connection, $title);
			}
			$message = trim($_POST['message']);
			if (mb_strlen($message, 'UTF-8') < 1 || mb_strlen($message, 'UTF-8') > 250) {
				echo 'Съобщението трябва да е между 1 и 250 символа</br>'."\n";
				$error = true;
			}
			else {
				mysqli_real_escape_string($connection, $message);
			}
		}
		if (!$error) {
			if (!($stmt = mysqli_prepare($connection, 'INSERT INTO messages(user_id, group, title, message) VALUES (?, ?, ?, ?)'))) {
				//echo mysqli_error($connection);
				//echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				header('error.php?message=databaseerror');
				exit;
			}
			if (!$stmt->bind_param("iiss", $user_id, $group, $title, $message)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			echo 'Записа е успешен';
//Запис в базата данни
			header('Location: messages.php');
			exit;
		}
	}
?>
	<div>
		<a href="destroy.php">Изход</a>
	</div>
	<div>
		<a href="messages.php">Обратно към съобщенията</a>
	</div>
	<form method="POST" action="new_message.php" id="new_message">
		<div>Заглавие:<input type="text" name="title" value="<?= (isset($title)) ? $title : '';?>"/></div>
		<textarea rows="4" cols="50" name="message" form="new_message"><?= (isset($message)) ? $message : '';?></textarea>
		<div><input type="submit" name="submit" value="Запис" /></div>
	</form>
<?php
}
else {
	header('Location: index.php');
	exit;
}