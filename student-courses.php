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
$stmt = $conn->prepare("SELECT unit.NAME, program.NAME, unit.UID FROM unit, program WHERE unit.PID = program.PID AND program.PID = ? ");
$email = $_SESSION['email'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$type = $_SESSION['type'];
$stmt->bind_param('s', $pid);
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

	<a href="student-home.php" id="img-lnk"><img src="logo.png" alt="logo"/></a>
	 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
		<div class="menu-items">
<li><a href="student-courses.php"></i>Programs</a></li>
<li><a href="student-assignments.php">Assignments</a></li>
<li><a href="student-forums.php">Discussion Forums</a></li>
<li><a href="student-sessions.php">Sessions</a></li>
</div></div>


		<section class="display" id="main">
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo"/></button>  
	<div style="width: 100%;">
	<div style="margin-left: 25px;float: right;" class="popup" onclick="func()"><p><?php echo '👤'. $name,' ',$surname ?></p>
	<span class="popuptext" id="myPopup">
	<li><?php echo '👤'.$name,' ',$surname ?></li>
	<li><?php echo '👥'.$type ?></li>
	<li><?php echo '@'.$email ?></li>
	<li><a href="logout.php">Logout</a></li>
	</span></div><p style="float: right; margin-right: px; ">Recent posts</p>
	</div>
	<hr style="border: 1px solid transparent;">
		<div >

		<?php
		$qry = $conn->query("SELECT DISTINCT program.NAME, program.PID, program.IMG FROM user_program join program join unit on user_program.PID = program.PID AND
		program.PID = unit.PID AND user_program.EMAIL = '$email' order by program.NAME asc");

$x = '';

while($row= $qry->fetch_assoc())
		{
			echo '<div class="">';
			echo '<a href=\'student-units.php?pid='.$row['PID'].'\'>
			<img src="'.$row['IMG'].'" alt="logo" width="60%" height="300px" /><h5 style="font-size= ">'.$row['NAME'].'</h5></a>';
		echo '</div>';
		echo '<p style="font-size=4px;"><em>modules</em></p>';
			$qryq = $conn->query("SELECT unit.NAME FROM program join unit on
		program.PID = unit.PID AND unit.PID = ".$row['PID']."");
			
			while($ro = $qryq->fetch_assoc())
			{
			echo '<div >';
			
			echo '<h7 style="margin: 0; padding: 0;">',$ro['NAME'], '</h7><br>';
			echo '</div';
			echo '<br>';
			}
			echo '<br>';
			
		}

		?>
	</section>
	
	<div class="categories">

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
