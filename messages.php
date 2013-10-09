<?php
$pageTitle = 'Messages';
$message = '';
$messageForDel = '';
require_once 'includes'.DIRECTORY_SEPARATOR.'header.php';
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
	$username = trim($_SESSION['username']);
	echo 'Добре дошъл '.$username.'!';
?>
	<div>
		<a href="destroy.php">Изход</a>
	</div>
	<div>
		<a href="new_message.php">Ново съобщение</a>
	</div>
<?php

}
else {
	header('Location: index.php');
	exit;
}