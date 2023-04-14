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
$stmt = $conn->prepare("SELECT unit.NAME, program.NAME, unit.UID FROM unit, program WHERE unit.PID = program.PID AND program.PID = ? and unit.UID = ?");
$email = $_SESSION['email'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$type = $_SESSION['type'];
$uid = $_GET['uid'];
$pid = $_GET['pid'];
$stmt->bind_param('ss', $pid,$uid);
$stmt->execute();
$stmt->bind_result($uname, $pname, $uid);
$stmt->fetch();
$stmt->close();


//gather the topics
$get_topics = "select topic_id, topic_title,
 date_format(topic_create_time, '%b %e %Y at %r') as fmt_topic_create_time,
 topic_owner from forum_topics where UID = $uid order by topic_create_time desc";
 $get_topics_res = $conn->query($get_topics);
 if (mysqli_num_rows($get_topics_res) < 1) {
    //there are no topics, so say so
    $display_block = "<P><em>No topics exist.</em></p>";
 } else {
     //create the display string
    $display_block = "
    <table cellpadding=3 cellspacing=1 border=1>
    <tr>
    <th>TOPIC TITLE</th>
   <th># of POSTS</th>
   </tr>";

    while ($topic_info = mysqli_fetch_array($get_topics_res)) {
      $topic_id = $topic_info['topic_id'];
      $topic_title = stripslashes($topic_info['topic_title']);
     $topic_create_time = $topic_info['fmt_topic_create_time'];
     $topic_owner = stripslashes($topic_info['topic_owner']);
  //get number of posts
  $get_num_posts = "select count(post_id) as total from forum_posts
          where topic_id = '$topic_id'";
        $get_num_posts_res = $conn->query($get_num_posts);
		$num_posts = $get_num_posts_res->fetch_array(MYSQLI_ASSOC);
		
  //add to display
     $display_block .= "     <tr>
     <td><a href=\"student-showtopic.php?topic_id=$topic_id&uid=$uid&pid=$pid\">
     <strong>$topic_title</strong></a><br>
      Created on $topic_create_time by $topic_owner</td>
     <td align=center>$num_posts[total]</td>
      </tr>";
   }
 
 
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
<a href="student-home.php" id="img-lnk"><img src="logo.png" alt="logo" /></a>
	 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
		<div class="menu-items">

<li><a href="student-courses.php"></i>Programs</a></li>
<li><a href="student-unit-assignment-listing.php">Assignments</a></li>
<li><a href="student-listing-forums.php">Discussion Forums</a></li>
<li><a href="student-listing-sessions.php">Sessions</a></li>
</div></div>

		

	<section class="display" id="main">
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo" width="10px" height="10px"/></button>  

 <h1 style="margin-left: 55px;">Topics in <?php echo $uname?> Forum</h1>
 <?php print $display_block; 
 echo '<P>Would you like to <a href=\'student-add_topic.php?uid='.$uid.'&pid='.$pid.'\'>add a topic</a>?</p>'
 ?>
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