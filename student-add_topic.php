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

$email = $_SESSION['email'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$type = $_SESSION['type'];
$uid = $_GET['uid'];
$pid = $_GET['pid'];
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
<li><a href="student-assignments.php">Assignments</a></li>
<li><a href="student-forums.php">Discussion Forums</a></li>
<li><a href="student-sessions.php">Sessions</a></li>
</div></div>


	<section class="display" id="main">
	<button class="openbtn" onclick="openNav()"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="10px" height="10px" /></button> 
	<h1 style="margin-left: 55px;">Add a Topic</h1>
<form method="post" action="student-do_addtopic.php">
 <input type="hidden" name="topic_owner" value="<?php echo $email?>" size=40 maxlength=150>
 <p><strong>Topic Title:</strong><br>
 <input type="text" name="topic_title" size=40 maxlength=150>
 <P><strong>Post Text:</strong><br>
  <textarea name="post_text" rows=8 cols=40 wrap=virtual></textarea>
  <input type="hidden" name="uid" value="<?php echo $uid ?>">
  <input type="hidden" name="pid" value="<?php echo $pid ?>">
 <P><input type="submit" name="submit" value="Add Topic"></p>
 </form>
		
		<?php
		
		
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
function openNav() {
  document.getElementById("side-menu").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("side-menu").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>

<script>
function func() {
var popup = document.getElementById("myPopup");
popup.classList.toggle("show");
}
</script>
</body>
</html>
