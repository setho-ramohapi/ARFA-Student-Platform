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
$email = $_SESSION['email'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$type = $_SESSION['type'];
$uid =100;
$stmt->bind_param('s', $pid);
$stmt->execute();
$stmt->bind_result($uname, $pname, $uid);
$stmt->fetch();
$stmt->close();


extract($_POST);

if(empty($id)){
	$data .=  ", title='".$title."'";
	$data .=  ", user_id='".$user_id."'";
	$data .=  ", email='".$email."'";
	$data .=  ", qpoints='".$qpoints."'";
	$insert_user = $conn->query('INSERT INTO quiz_list VALUES  '.$data);

	if($insert_user){
			echo json_encode(array('status'=>1,'id'=>$conn->insert_id));
		
	}
}else{
	$data=  " title='".$title."'";
	$data .=  ", user_id='".$user_id."'";
	$data .=  ", qpoints='".$qpoints."'";
	$update = $conn->query('UPDATE quiz_list set  '.$data.' where id= '.$id);

	if($update){
			echo json_encode(array('status'=>1,'id'=>$id));
		
	}
}