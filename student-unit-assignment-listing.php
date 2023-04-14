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


	<section class="displa" id="main" style="margin-top: 0;margin-left: 50px;float: left; width: 60%;">
	

	
		<div class="container-fluid admin" style=" width: 75%;
	height: ;
	background-color: white;
	font-family: Arial;
	font-size: 15px;
	color: orange; float: right;
	margin-top: 0;
	">
	<h2 style="font-size: 30px; color: blue;">Navigate to assignments by module</h2>
	
		<div class="card">
			<div class="card-body">
				<table class="table table-bordered" id='table'>
					
					<thead>
						<tr>
							<th width="" align="center">MODULE</th>
					<th align="center">ACTION</th>
						</tr>
					</thead>
					<tbody>

<?php
$stmt = $conn->prepare('SELECT DISTINCT NAME, unit.UID, unit.PID FROM unit join user_program on unit.PID = user_program.PID and user_program.EMAIL = ?');
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->bind_result($aname, $uid, $pid);
		 
			
			while($stmt->fetch()) {
	?>
<tr>
						<td style="font-size: 20px; color: blue;">
					<?php echo $aname;?>
				</td>
			<td>
				
					
					<a style="width: 300px;" class="btn btn-sm btn-outline-primary edit_quiz" href="./student-listingass.php?uid=<?php echo $uid?>&pid=<?php echo $pid?>"><i class="fa fa-task">
					Open <?php echo $aname?> assignments</a>
				
				
					
				
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
