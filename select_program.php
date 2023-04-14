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


if (isset($_POST['id']))
{
	$id = $_POST['id'];
	$res = mysqli_query($conn,'SELECT program.NAME FROM user_registration join program join user_program on user_registration.EMAIL = user_program.EMAIL AND program.PID = user_program.PID AND user_program.EMAIL IN (SELECT EMAIL FROM user_registration WHERE ID = '.$id.')');
	
	while($row = $res->fetch_assoc()) {
	echo '<option style="width: 100%; background-color: black;
	background-color:hsl(0, 0%, 24%); color: orange;" >'.$row['NAME'].'</option>';
  }
	
	
}
?>