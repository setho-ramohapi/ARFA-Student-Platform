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
$aid = $_GET['aid'];
$uid = $_POST['uid'];
$pid = $_SESSION['pid'];
$topic_id = $_SESSION['topic_id'];
$post_text = $_POST['post_text'];
$post_owner = $_POST['post_owner'];

$url2 = 'student-showtopic.php?topic_id=';
//check to see if we're showing the form or adding the post

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$txt = $_POST['txt'];
	$title = $_POST['title'];
	$due = $_POST['due'];
	$url = 'staff-assignments.php?';
		#file name with a random number so that similar dont get replaced
		$pname = rand(1000,10000)."-".$_FILES["file"]["name"];
		
		
		#uploead directory path
		$uploads_dir = 'assignments/';
		$ext = pathinfo($pname, PATHINFO_EXTENSION);
		
		
		#temporary file name to store file
		$tname = $_FILES["file"]["tmp_name"];
		
		if (!in_array($ext,['pdf','doc','docx','xlsx','xls','csv','jpg']) && empty($_FILES['file']['name'])) {

				#sql query to insert into database
				$sql1 = "INSERT into received-assignments(NAME,LINK,UID,TITLE, TEXT, DUE_DATE)VALUES('$title','--','$uid','$title','$txt','$due')";
				$conn->query($sql1);
				
				echo "Posted";
		} else{
		#to move uploaded file to destination
		move_uploaded_file($tname,$uploads_dir.$pname);
		#sql query to insert into database
		$sql = "INSERT into recieved-assignments(NAME,LINK,UID,TITLE, TEXT,DUE_DATE)VALUES('$pname','$ext','$uid','$title','$txt','$due')";
		$conn->query($sql);
 
    echo "Posted";
	

		
    }
	


	
		$sql = "UPDATE assignments SET STATUS = 'SUBMITTED' WHERE AID = '$aid'";
		$conn->query($sql);
		
			header('Location:'.$url2.$topic_id.'&uid='.$uid.'&pid='.$pid);
		








}

?>