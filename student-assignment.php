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
$aid = $_GET['aid'];
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
	
	<h2 style="text-align: center;  background-image: url); color: orange;"><?php echo $uname?></h2>

<div id="ass-blocks">


		<?php
		
			$stmt = $conn->prepare('select NAME,TEXT,AID, DUE_DATE from assignments where assignments.AID = ?');
			$stmt->bind_param('s', $aid);
			$stmt->execute();
			$stmt->bind_result($aname,$txt,$aid,$due);
			$x = 1;
			while($stmt->fetch()) {
						echo '<a href="download.php?file=assignments\\'.$aname.'"<h1>'.$aname.'</h1></a><br>';
						echo '<em>Due date: '.$due.'</em><br>';
				echo '<p style="font-size: 12px; margin-bottom: 0;">Instructions:</p> <br><p style="margin-top: 0; ">'.$txt.'</p><br>';
				
				 
				
				
				echo '<iframe src="assignments/'.$aname.'" width="100%" height="200px"></iframe>';
				echo '
		<form style="float: left;" action="submit-assignments.php" enctype="multipart/form-data" method="post">
		<table>
		<tr><td><input type="hidden" value="'.$pid.'" name="pid"></td></tr>
		<tr><td><input type="hidden" value="'.$uid.'" name="uid"></td></tr>
		<tr><td><input type="hidden" value="'.$aid.'" name="aid"></td></tr>
		<tr><td><input type="file" placeholder="Attach" value="+Attachement" /></p></td></tr>
		<tr><td><input type="submit" value="Upload" /></p></td></tr>
		</table>
		</form>';
		
				
			}

		?>
		</div>

</section>

<div class="categories">
		<span><form style="float:; ">
 <input type="button" style="background: transparent; border: 0.5px solid orange; padding: 0; margin: 0; position: ; color: orange; font-size:20px" value="←" onclick="history.back()">
</form><div class="popup" onclick="func()"><p style="font-size: 18px;color: ;font-weight: 700;border: none;"><?php echo '👤'. $name,' ',$surname ?></p>
	<span class="popuptext" id="myPopup">
	<li><?php echo '👤'.$name,' ',$surname ?></li>
	<li><?php echo '👥'.$type ?></li>
	<li><?php echo '@'.$email ?></li>
	<li><a href="logout.php">Logout</a></li>
	</span></div>
	</span>
	<iframe src="https://calendar.google.com/calendar/embed?src=nblnoi81c1rum8nr6i7e8ndluc%40group.calendar.google.com&ctz=Africa%2FJohannesburg" 
	style="border: 1px solid orange; margin-top: 317px; margin-bottom: 0px; margin-right: 15px; float: left;" width="355px" height="250px" frameborder="0" scrolling="no"></iframe>
	</div>

<script>

function func() {
var popup = document.getElementById("myPopup");
popup.classList.toggle("show");
}

function pop() {
    var popup = document.getElementById('myPopup1');
    popup.classList.toggle('show');
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

