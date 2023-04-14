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

$_POST['op'] = '';
$post_id = $_GET['post_id'];
$_SESSION['post_id'] = $post_id;
$uid = $_GET['uid'];
$pid = $_GET['pid'];

//check to see if we're showing the form or adding the post
  if ($_POST['op'] != "addpost") {
     // showing the form; check for required item in query string
  
       //still have to verify topic and post
     $verify = "select ft.topic_id, ft.topic_title from
      forum_posts as fp left join forum_topics as ft on
      fp.topic_id = ft.topic_id where fp.post_id = $post_id";
 
    $verify_res = $conn->query($verify) or die(mysql_error());
	$verify_res1 = $conn->query($verify) or die(mysql_error());
      if (mysqli_num_rows($verify_res) && mysqli_num_rows($verify_res1) < 1) {
         //this post or topic does not exist
         header("Location: staff-forums.php");
         exit;
     } else {
         //get the topic id and title
         $topic_id = $verify_res->fetch_assoc()['topic_id'];
			$topic_title = $verify_res1->fetch_assoc()['topic_title'];
			$_SESSION['topic_id'] = $topic_id;
			
  
         echo '
          <!DOCTYPE html>
<html>
<head>
	<title>'.$name. ' '. $surname. '¬ ARFA-EL</title>
	<link rel="stylesheet" href="ARFAEL.css"/>
</head>

<body style="margin:0;">

<div id="side-menu" class="sidebar">

			<a href="staff-home.php" id="img-lnk"><img src="logo.png" alt="logo"/></a>
			 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
			<div class="menu-items">
			<li><a href="staff-courses.php"></i>Programs</a></li>
			<li><a href="students.php">Students</a></li>
			<li><a href="staff-assignments.php">Assignments</a></li>
			<li><a href="staff-assignments.php">Discussion Forums</a></li>
			<li><a href="staff-sessions.php">Sessions</a></li>
			</div>
	
</div>
		

	<section class="display" id="main">
	<button class="openbtn" onclick="openNav()"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="10px" height="10px"/></button>  
	
         <h1 style="margin-left: 55px;">Post Your Reply in '.$topic_title.'</h1>
         <form method="post" action="replytopostprocess.php" width="65%">
         <input type="hidden" name="post_owner" value="'.$email.'" size=40 maxlength=150>
  
         <P><strong>Post Text:</strong><br>
         <textarea name="post_text" rows=13 cols=80 wrap=virtual></textarea>
  
         <input type="hidden" name="op" value="addpost">
         <input type="hidden" name="topic_id" value='.$topic_id.'>
		 <input type="hidden" name="uid" value='.$uid.'>
		<input type="hidden" name="pid" value='.$pid.'>
         <P><input type="submit" name="submit" value="Add Post"></p>
  
         </form>
          
	</section>
	
	<div class="categories">
		<span><form style="float:; ">
 <input type="button" style="background: transparent; border: 0.5px solid orange; padding: 0; margin: 0; position: ; color: orange; font-size:20px" value="←" onclick="history.back()"/>
</form>
<div class="popup" onclick="func()"><p style="font-size: 18px;color:;font-weight: 700;border: none;">'.$name.' '.$surname.'</p>
	<span class="popuptext" id="myPopup">
	<li>'.$name.' '.$surname.'</li>
	<li>'.$type.'</li>
	<li>'.$email.'</li>
	<li><a href="logout.php">Logout</a></li>
	</span></div>
	</span>
	</div>
	
 </body>
         </html>';
     }
  
  }
  ?>
  
  <script>
function func() {
var popup = document.getElementById("myPopup");
popup.classList.toggle("show");
}
</script>
	<script>
function openNav() {
  document.getElementById("side-menu").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("side-menu").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>