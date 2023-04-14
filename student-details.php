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
	
	$qry = $conn->query("SELECT user_registration.NAME as u, user_registration.SURNAME, user_registration.EMAIL, user_registration.DATE_CREATED, program.NAME as p from user_registration join user_program join 
	program on user_registration.EMAIL = user_program.EMAIL AND user_program.PID = program.PID AND user_program.EMAIL='".$_GET['email']."' ");
	if($qry){
		echo json_encode($qry->fetch_array());
	}
?>