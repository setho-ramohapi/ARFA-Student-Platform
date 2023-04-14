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

$topic_title = $_POST['topic_title'];
$topic_owner = $_POST['topic_owner'];
$post_text = addslashes($_POST['post_text']);
$uid = $_POST['uid'];
$pid = $_POST['pid'];

 
 //connect to server and select database
 $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME)
     or die(mysql_error());
	 

 //create and issue the first query
  $add_topic = "insert into forum_topics(topic_title,topic_create_time,topic_owner,UID) values ('$topic_title',
      now(), '$topic_owner','$uid')";
  $conn->query($add_topic);
  
 //get the id of the last query
$topic_id = $conn->insert_id; 
 
  //create and issue the second query
  $add_post = "insert into forum_posts(topic_id,post_text,post_create_time,post_owner) values ('$topic_id','$post_text', now(), '$topic_owner')";
  $conn->query($add_post);
  echo mysqli_error($conn);
  
  //create nice message for user
  $msg = "<P>The <strong>$topic_title</strong> topic has been created.</p>";
  ?>
   <!DOCTYPE html>
<html>
<head>
	<title><?php echo $name, ' ', $surname;?> ¬ ARFA-EL</title>
	<link rel="stylesheet" href="ARFAEL.css"/>
</head>

<body style="margin:0;">

<div id="side-menu" class="sidebar">

			<a href="staff-home.php" id="img-lnk"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="200px" height="100px" /></a>
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
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo"/></button>  
	<div style="">

  <h1 style="margin-left: 55px;">>New Topic Added</h1>
  <?php echo $msg; ?><br>
  <?php 
  
  if ($type == 'STAFF'){
  
  echo '<a href="staff-forums.php?uid='.$uid.'&pid='.$pid.'">Back to Topics</a>';
  }
  
  else {
	  echo '<a href="student-forums.php?uid='.$uid.'&pid='.$pid.'">Back to Topics</a>';
  }
  
  
  
  ?>
  
   </div>
	</section>
	
<div class="categories">
		<span><form style="float:; ">
 <input type="button" style="background: transparent; border: 0.5px solid orange; padding: 0; margin: 0; position: ; color: orange; font-size:20px" value="←" onclick="history.back()">
</form><div class="popup" onclick="func()"><p style="font-size: 18px;color: ;font-weight: 700;border: none;"><?php echo $name,' ',$surname ?></p>
	<span class="popuptext" id="myPopup">
	<li><?php echo $name,' ',$surname ?></li>
	<li><?php echo $type ?></li>
	<li><?php echo $email ?></li>
	<li><a href="logout.php">Logout</a></li>
	</span></div>
	</span>
	</div>
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
 </body>
  </html>