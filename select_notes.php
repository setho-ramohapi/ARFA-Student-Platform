<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
header('Location: index.php');
exit;
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'arfa';

$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);


if (isset($_POST['aid']))
{
	$aid = $_POST['aid'];
	$res = mysqli_query($conn,"SELECT DISTINCT notes.NAME FROM notes 
			WHERE notes.NID = '$aid'");
	$row = $res->fetch_assoc();

	echo '<embed src="notes/'.$row['NAME'].'" frameborder="0" width="100%" height="400px">';

	
}
?>