<?php
$pageTitle = 'Web server';
$message = '';
$messageForDel = '';
require_once 'includes'.DIRECTORY_SEPARATOR.'header.php';
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
	$username = trim($_SESSION['username']);
?>
	<div>
		<a href="destroy.php">Изход</a>
	</div>
<?php
}
