<?php
$pageTitle = 'Messages';
$message = '';
$messageForDel = '';
require_once 'includes'.DIRECTORY_SEPARATOR.'header.php';
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
	$username = trim($_SESSION['username']);
	echo 'Добре дошъл '.$username.'!';
	require_once 'includes'.DIRECTORY_SEPARATOR.'conection.php';
	$result = mysqli_query($connection,"SELECT * FROM groups");
	while($row = mysqli_fetch_array($result))
	{
		$groups [$row['groups_id']]=$row['group'];
	}
	$query = 'SELECT user_id FROM users WHERE username="'.$username.'"';
	$result = mysqli_query($connection, $query);
	$user_id=mysqli_fetch_array($result)['user_id'];
	$query = 'SELECT * FROM messages';
	$result = mysqli_query($connection, $query);
	echo '<table border="1"><tr><td>Заглавие</td><td>Съобщение</td></tr>';
	while($row = mysqli_fetch_array($result))
	{
		echo '<tr><td>'.$row['title'].'</td><td>'.$row['message'].'</td></tr>';
	}
	echo '</table>';
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