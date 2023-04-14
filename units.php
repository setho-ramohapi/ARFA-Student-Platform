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
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$pid = mysqli_real_escape_string($conn, $_POST['pid']);
}
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

<body>
	<aside class="menu">
		
			<a href="staff-home.php" id="img-lnk"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="200px" height="100px" /></a>
		
			<a href="logout.php">Logout</a>
		<div class="menu-items">
			<li><a href="staff-profile.php">Profile</a></li>
			<li><a href="staff-courses.php"></i>Programs</a></li>
			<li><a href="students.php">Students</a></li>
			<li><a href="staff-assignments.php">Assignments</a></li>
			<li><a href="staff-assignments.php">Discussion Forums</a></li>
			<li><a href="staff-sessions.php">Sessions</a></li>
		</div>
	</aside>
		

	<section class="display">

<?php
$stmt = $conn->prepare('SELECT unit.NAME FROM program,unit WHERE program.PID = unit.PID AND program.PID = ?');
echo '<h2 style="text-align: center;">'.$pname.'</h2>';
$stmt->bind_param('s', $pid);
$stmt->execute();
$stmt->bind_result($uname);
echo '<h2>';
echo '<br>';
echo '</h2>';
$x = 1;
while($stmt->fetch()) {
	echo '<div class="display-boxes">';
echo'<img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="200px" height="100px" />
<span><div class="popup" onclick="func'.$x.'()"><p style="background: transparent;font-size: 18px;color: black;font-weight: 700;border: none;">'. $uname.'</p><span class="popuptext" id="myPopup'.$x.'"><li>
<a href="staff-assignments.php?" >ASSIGNMENTS</a></li><li>
<a href="staff-notes.php?" >NOTES</a></li><li>
<a href="staff-files.php?" >FILES</a></li><li>
<a href="staff-sessions.php?" >SESSIONS</a></li></span></div> <br>';
echo '</div>';

$x++;
}

		$_SESSION['name'] = $name;
		$_SESSION['surname'] = $surname;
		$_SESSION['pid'] = $pid;
		$_SESSION['type'] = $type;
		$_SESSION['email'] = $email;

?>


</a></span></div>


</section>
<script>
function func1() {
var popup = document.getElementById("myPopup1");
popup.classList.toggle("show");
}

function func2() {
var popup = document.getElementById("myPopup2");
popup.classList.toggle("show");
}

function func3() {
var popup = document.getElementById("myPopup3");
popup.classList.toggle("show");
}

function func4() {
var popup = document.getElementById("myPopup4");
popup.classList.toggle("show");
}

function func5() {
var popup = document.getElementById("myPopup5");
popup.classList.toggle("show");
}

function func6() {
var popup = document.getElementById("myPopup6");
popup.classList.toggle("show");
}

function func7() {
var popup = document.getElementById("myPopup7");
popup.classList.toggle("show");
}

</script>
	<div class="categories">
		<p class="selection" style="text-align: center;"><?php echo $name,' ',$surname ?></p>
	</div>

</body>
</html>
