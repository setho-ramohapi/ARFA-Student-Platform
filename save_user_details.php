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
$stmt = $conn->prepare("SELECT unit.NAME, program.NAME, unit.UID FROM unit, program WHERE unit.PID = program.PID AND program.PID = ? ");

if (isset($_POST['id']))
{
	
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$id = $_POST['id'];
	
	$res = mysqli_query($conn, "UPDATE user_registration SET NAME ='$name',SURNAME ='$surname' WHERE id = '$id' ");
	if($res){
		return 'data updated';
	}
}
?>