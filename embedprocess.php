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

$email = $_SESSION['email'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$type = $_SESSION['type'];
$post_id = $_GET['post_id'];
$uid = $_POST['uid'];
$lnk = $_POST['link'];
$pid = $_POST['pid'];
$url1 = 'staff-sessions.php?';
		if (isset($_POST['embed'])) {
			
	mysqli_query($conn, "INSERT embed_sessions (UID,LINK) VALUES ('$uid', '$lnk')");
	header('Location:'.$url1.'uid='.$uid.'&pid='.$pid);
		}
		
		
		
		?>