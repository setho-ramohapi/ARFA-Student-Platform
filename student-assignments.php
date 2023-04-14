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
$stmt->bind_param('ss', $pid,$uid);
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
</head>

<body style="margin:0;">
<div id="side-menu" class="sidebar">

	<a href="student-home.php" id="img-lnk"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="200px" height="100px" /></a>
	 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
<div class="menu-items">
<li><a href="student-courses.php"></i>Programs</a></li>
<li><a href="student-unit-assignment-listing.php">Assignments</a></li>
<li><a href="student-forums.php">Discussion Forums</a></li>
<li><a href="student-listing-sessions.php">Sessions</a></li>
</div></div>

	<section class="display" id="main">
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo"/></button>  
	<h2 style="text-align: center;"><?php echo $uname?></h2>
	<div id="ass-blocks">
<h1 style="text-align: center;">Open Assignments</h1>

		<?php
		
			$stmt = $conn->prepare('select NAME,AID, DUE_DATE from assignments where assignments.AID = ?');
			$stmt->bind_param('s', $aid);
			$stmt->execute();
			$stmt->bind_result($aname,$aid,$due);
			$x = 1;
			while($stmt->fetch()) {
				
				echo '<iframe src="assignments/'.$aname.'" width="100%" height="500px"></iframe>';
				echo '<a href="download.php?file=assignments\\'.$aname.'" target="_new"><h2>'.$aname.'</h2><h2>Due Date '.$due.'</h2></a> HAND IN';
				
			}

		?>
		</div>
		
		<br>
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

