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


			$qry = $conn->query("select * from assignments where assignments.AID = '".$_GET['aid']."' AND STATUS = 'OPEN' ORDER BY AID DESC ");
	if($qry){
		echo json_encode($qry->fetch_array());
	}
				

		?>