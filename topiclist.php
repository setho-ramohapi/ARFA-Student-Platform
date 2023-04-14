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

?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $name, ' ', $surname;?> ¬ ARFA-EL</title>
	<link rel="stylesheet" href="ARFAEL.css"/>
</head>

<body>
<div>
<div id="side-menu" class="sidebar">

			<a href="staff-home.php" id="img-lnk"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="100px" height="50px" /></a>
			 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
			<a href="logout.php">Logout</a>
			<div class="menu-items">
			<li><a href="staff-profile.php">Profile</a></li>
			<li><a href="staff-courses.php"></i>Programs</a></li>
			<li><a href="students.php">Students</a></li>
			<li><a href="staff-assignments.php">Assignments</a></li>
			<li><a href="staff-forums.php">Discussion Forums</a></li>
			<li><a href="staff-sessions.php">Sessions</a></li>
		</div>
	
</div>
		

	<section class="display" id="main">
	<button class="openbtn" onclick="openNav()"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="10px" height="10px" /></button>  
	<h1>Add a Topic</h1>
<form method=post action="do_addtopic.php">
 <p><strong>Your E-Mail Address:</strong><br>
 <input type="text" name="topic_owner" size=40 maxlength=150>
 <p><strong>Topic Title:</strong><br>
 <input type="text" name="topic_title" size=40 maxlength=150>
 <P><strong>Post Text:</strong><br>
  <textarea name="post_text" rows=8 cols=40 wrap=virtual></textarea>
 <P><input type="submit" name="submit" value="Add Topic"></p>
 </form>
		
		<?php
		
		
		?>
	</section>
	
	<div class="categories">
		<p class="selection" style="text-align: right;"><?php echo $name,' ',$surname ?></p>
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
</body>
</html>
