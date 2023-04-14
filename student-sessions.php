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
$stmt->bind_param('ss', $pid, $uid);
$stmt->execute();
$stmt->bind_result($uname, $pname, $uid);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $name, ' ', $surname;?> ¬ ARFA-EL</title>
	<link rel="stylesheet" href="ARFAEL.css"/>
	<link href="https://vjs.zencdn.net/7.14.3/video-js.css" rel="stylesheet" />
	


</head>

<body style="margin:0;">
	<div id="side-menu" class="sidebar">

			<a href="staff-home.php" id="img-lnk"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="200px" height="100px" /></a>
			 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
			<div class="menu-items">
			<li><a href="staff-home.php"></i>Home</a></li>
			<li><a href="staff-courses.php"></i>Programs</a></li>
			<li><a href="students.php">Users</a></li>
			<li><a href="staff-unit-listing-assignments.php">Assignments</a></li>
			<li><a href="staff-forums.php?">Discussion Forums</a></li>
			<li><a href="staff-sessions.php">Sessions</a></li>
			</div>
	
			
</div>

	<section class="display" id="main">
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo"/></button>  
	<h2 style="color: orange"><?php echo $uname?></h2>


   
	<?php 
	
	
	$stmt1 = $conn->prepare('SELECT DISTINCT LINK, SSID, UID FROM embed_sessions 
			WHERE UID = ?');
			$stmt1->bind_param('s',$uid);
			$stmt1->execute();
			$stmt1->bind_result($lnk1,$ssid1, $suid1);
			echo '<div id="sess" style="float: left; width: 80%; height: 400px; overflow: auto;">';
			echo '<h2>Embedded</h2>';
			echo '<hr style="width: 80%">';
			while ($stmt1->fetch())
			{
			
			
			echo '<div style="padding-top: -10px">'.$lnk1.'</div><br>';
			
			
			}
			
			echo '<br></div>';
			
	?>
	

		<?php
		
			$stmt = $conn->prepare('SELECT DISTINCT sessions.NAME,LINK, sessions.SSID, sessions.UID FROM sessions 
			WHERE sessions.UID = ?');
			$stmt->bind_param('s',$uid);
			$stmt->execute();
			$stmt->bind_result($aname,$lnk,$ssid, $suid);
		
			
			
			
			
			echo '<div id="sess2" style="float: left; width: 16%; height: 400px; overflow: auto; padding-right: 30px;">';
			echo '<h2>Uploads</h2>';
				echo '<hr style="width: 16%">';
			while($stmt->fetch()) {
				echo '<div class="" style="float: right; border: 1px solid orange; margin-left: 100px; margin-bottom: 10px;width: 70%; height: 100px">';
				echo '<a href="student-session.php?ssid='.$ssid.'&uid='.$suid.'" style="text-colour: orange; text-align: center; width: 2%">
				<img src="video-play-button-icon-.png" style=" background: black; width: 90%; height: 80px">'.$aname.'</a>';
				echo '<br></div>';
			}
			echo '</div>';

		?>
		



		
		



</section>

<div class="categorie" style="width: 30%; float: right; position: ; height: 100%">
	<iframe src="https://calendar.google.com/calendar/embed?src=nblnoi81c1rum8nr6i7e8ndluc%40group.calendar.google.com&ctz=Africa%2FJohannesburg" 
	style="border: 1px solid orange; float: right;" width="300px" height="250px" frameborder="0" scrolling="no"></iframe>
	
	
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
<script src="https://vjs.zencdn.net/7.14.3/video.min.js"></script>

</body>
</html>

