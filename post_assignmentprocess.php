 <?php
//check for required fields from the form
session_start();
if (!isset($_SESSION['loggedin'])) {
header('Location: index.php');
exit;
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'arfa';
 
 //connect to server and select database
 $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME)
     or die(mysql_error());
$pid = $_POST['pid'];
$uid = $_POST['uid'];
$txt = $_POST['txt'];
$title = $_POST['title'];
$url = 'staff-assignments.php?';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$sql = "INSERT into posted_assignments(NAME,UID,TEXT)VALUES('$title','$uid','$txt')";
		$conn->query($sql) or die(mysql_error());
		header('Location:'.$url.'uid='.$uid.'&pid='.$pid);
}
?>
