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

if (isset($_POST['new_program'])) {
	$name = $_POST['name'];
	$module = $_POST['module'];
	
		#file name with a random number so that similar dont get replaced
		$pname = rand(1000,10000)."-".$_FILES["file"]["name"];
		
		
		#uploead directory path
		$uploads_dir = 'sessions/';
		$ext = pathinfo($pname, PATHINFO_EXTENSION);
		
		
		#temporary file name to store file
		$tname = $_FILES["file"]["tmp_name"];
		
		if (!in_array($ext,['png','jpg']) && empty($_FILES['file']['name'])) {
		return 'image format invalid';
			echo 'in first if';
	
	
		} else{
			
			
		#to move uploaded file to destination
		move_uploaded_file($tname,$uploads_dir.$pname);
		#sql query to insert into database
	$res = mysqli_query($conn, "INSERT INTO program (NAME, IMG) VALUES ('$name', '$pname') ");
	$pid = $conn->insert_id;
	foreach ( $module as $mname)
	{
	
	$sql2 = "INSERT INTO unit (NAME, PID) VALUES (?,?)"; 
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param('ss', $mname,$pid);
	$stmt2->execute();
	}
	
	if($res){
		return 'New program added';
		echo 'in esconf if';
	}
	

		
    }
	echo 'something went wrong';
	
}
?>
