<?php 
include 'db_connect.php';
extract($_GET);
$get = $conn->query("SELECT * FROM questions where QID= ".$QID)->fetch_array();
$delete = $conn->query("DELETE FROM quiz_list where QID= ".$QID);
$delete1 = $conn->query("DELETE FROM questions where QID = ".$QID);
$delete2 = $conn->query("DELETE FROM question_opt where QID=".$get['QID']);
if($delete)
	echo true;
?>