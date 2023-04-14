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
	 
$topic_id = $_GET['topic_id'];
$uid = $_GET['uid'];
$pid = $_GET['pid'];

//verify the topic exists
  $verify_topic = "select topic_title from forum_topics where
      topic_id = $topic_id limit 1";
  $verify_topic_res = $conn->query($verify_topic);
 
  if (mysqli_num_rows($verify_topic_res) < 1) {
     //this topic does not exist
    $display_block = "<P><em>You have selected an invalid topic.
     Please <a href=\"topiclist.php\">try again</a>.</em></p>";
  } else {
      //get the topic title
     $topic_title = $verify_topic_res->fetch_assoc()['topic_title'];
  
     //gather the posts
     $get_posts = "select post_id, post_text, date_format(post_create_time,
          '%b %e %Y at %r') as fmt_post_create_time, post_owner from
         forum_posts where topic_id = $topic_id
          order by post_create_time asc";
  
    $get_posts_res = $conn->query($get_posts) or die(mysqli_error());
 
     //create the display string
     $display_block = "
     <P>Showing posts for the <strong>$topic_title</strong> topic:</p>
  
     <table width=100% cellpadding=3 cellspacing=1 border=1>
     <tr>
     <th>AUTHOR</th>
     <th>POST</th>
     </tr>";
  
     while ($posts_info = mysqli_fetch_array($get_posts_res)) {
         $post_id = $posts_info['post_id'];
         $post_text = nl2br($posts_info['post_text']);
         $post_create_time = $posts_info['fmt_post_create_time'];
         $post_owner = $posts_info['post_owner'];
		 
		 
  
         //add to display
         $display_block .= "
        <tr>
         <td width=35% valign=top>$post_owner<br>[$post_create_time]</td>
         <td width=65% valign=top>$post_text<br><br>
          <a href=\"replytopost.php?post_id=$post_id&uid=$uid&pid=$pid\"><strong>REPLY TO
          POST</strong></a></td>
        </tr>";
    }
 
     //close up the table
    $display_block .= "</table>";
  }
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
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo" /></button>  
	<div style="">
  <h1 style="margin-left: 55px;">Posts in <?php echo $topic_title ?></h1>
  <?php print $display_block; ?>
  <?php 
  if ($type == "STAFF")
  {
  
  echo '<a href="staff-forums.php?uid='.$uid.'&pid='.$pid.'">Back to Topics</a>';
  } else{
	  
  echo '<a href="student-forums.php?uid='.$uid.'&pid='.$pid.'">Back to Topics</a>';
  }
  
  
  ?>
  </div>
	</section>
	
<div class="categories">
		<span><form style="float:; ">
 <input type="button" style="background: transparent; border: 0.5px solid orange; padding: 0; margin: 0; position: ; color: orange; font-size:20px" value="←" onclick="history.back()">
</form><div class="popup" onclick="func()"><p style="font-size: 18px;font-weight: 700;border: none;"><?php echo $name,' ',$surname ?></p>
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