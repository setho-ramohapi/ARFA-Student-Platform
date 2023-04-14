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
			$qry = $conn->query("SELECT DISTINCT LINK, SSID, UID FROM embed_sessions 
			WHERE SSID = '".$_GET['ssid']."'");
	if($qry){
		echo json_encode($qry->fetch_array());
	}
				

		?>