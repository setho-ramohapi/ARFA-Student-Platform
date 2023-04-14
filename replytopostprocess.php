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
$pid = $_SESSION['pid'];
$_POST['op'] = '';
$topic_id = $_SESSION['topic_id'];
$post_text = $_POST['post_text'];
$post_owner = $_POST['post_owner'];
$url1 = 'showtopic.php?topic_id=';

$url2 = 'student-showtopic.php?topic_id=';
//check to see if we're showing the form or adding the post
  if ($_POST['op'] != "addpost") {


	
		$add_post = "insert into forum_posts(topic_id,post_text,post_create_time,post_owner) values ('$topic_id','$post_text', now(), '$post_owner')";
		$conn->query($add_post);
		if ($type == 'STAFF')
		{
		header('Location:'.$url1.$topic_id.'&uid='.$uid.'&pid='.$pid);
		} else {
			header('Location:'.$url2.$topic_id.'&uid='.$uid.'&pid='.$pid);
		}









} else {
	header("Location: showtopic.php");
}