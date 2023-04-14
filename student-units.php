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
$pid = $_GET['pid'];
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
	<?php include('header.php') ?>
</head>

<body style="margin:0; width: 100%;
	height: 100%;
	background-color: white;
	font-family: Arial;
	font-size: 15px;
	color: orange;">
<div id="side-menu" class="sidebar" style="width: 250px">

			
			<div style="margin-left: 25px;float: ; margin-top: 0;" class="popup" onclick="func()"><p><?php echo '👤'. $name,' ',$surname ?></p>
	<span class="popuptext" id="myPopup">
	<li><?php echo '👤'.$name,' ',$surname ?></li>
	<li><?php echo '👥'.$type ?></li>
	<li><?php echo '@'.$email ?></li>
	<li><a href="logout.php">Logout</a></li>
	</span></div>
	
			<div class="menu-items">
			
			<li><a href="student-home.php"></i>Home</a></li>
			<li><a href="student-courses.php"></i>Programs</a></li>
			<li><a href="student-unit-assignment-listing.php">Assignments</a></li>
			<li><a href="student-listing-forums.php?">Discussion Forums</a></li>
			<li><a href="student-listing-sessions.php">Sessions</a></li>
			</div>
	
	
</div>


	<section class="displa" id="main" style="margin-left: 50px;float: left; width: 60%;">
	

	
		<div class="container-fluid admin" style=" width: 75%;
	height: ;
	background-color: white;
	font-family: Arial;
	font-size: 15px;
	color: orange; float: right;
	margin
	">
	<h2 style="font-size: 30px; color: blue;"><?php echo $pname?></h2>
	
		<div class="card">
			<div class="card-body">
				<table class="table table-bordered" id='table'>
					
					<thead>
						<tr>
							<th width="" align="center">NAME</th>
					<th align="center">ACTION</th>
						</tr>
					</thead>
					<tbody>

<?php
$stmt = $conn->prepare('SELECT unit.NAME, unit.UID FROM program,unit WHERE program.PID = unit.PID AND program.PID = ?');

$stmt->bind_param('s', $pid);
$stmt->execute();
$stmt->bind_result($uname,$uid);
while($stmt->fetch()) {
	?>
<tr>
						<td style="font-size: 20px; color: blue;">
					<?php echo $uname;?>
				</td>
			<td>
				<center>
					
					<a class="btn btn-sm btn-outline-primary edit_quiz" href="./student-listingass.php?uid=<?php echo $uid?>&pid=<?php echo $pid?>"><i class="fa fa-task">
					</i> Assignments</a>
					<a class="btn btn-sm btn-outline-primary edit_quiz" href="./student-notes.php?uid=<?php echo $uid?>&pid=<?php echo $pid?>"><i class="fa fa-task">
					</i> Notes</a>
					<a class="btn btn-sm btn-outline-primary edit_quiz" href="./student-sessions.php?uid=<?php echo $uid?>&pid=<?php echo $pid?>"><i class="fa fa-task">
					</i> Sessions</a>
					<a class="btn btn-sm btn-outline-primary edit_quiz" href="./student-files.php?uid=<?php echo $uid?>&pid=<?php echo $pid?>"><i class="fa fa-task">
					</i> Files</a>
					<a class="btn btn-sm btn-outline-primary edit_quiz" href="./student-forums.php?uid=<?php echo $uid?>&pid=<?php echo $pid?>"><i class="fa fa-task">
					</i> Forums</a>
					<a class="btn btn-sm btn-outline-primary edit_quiz" href="./student-quiz.php?uid=<?php echo $uid?>&pid=<?php echo $pid?>"><i class="fa fa-task">
					</i> Quiz</a>
				
					
				</center>
				</td>
					</tr>
<?php
					}
					?>
									</tbody>
				</table>
			</div>
		</div>
	</div>



</a></span></div>


</section>

<div class="categories">
	<iframe src="https://calendar.google.com/calendar/embed?src=nblnoi81c1rum8nr6i7e8ndluc%40group.calendar.google.com&ctz=Africa%2FJohannesburg" 
	style="border: 1px solid orange; float: left;" width="500px" height="250px" frameborder="0" scrolling="no"></iframe>
	
	
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
