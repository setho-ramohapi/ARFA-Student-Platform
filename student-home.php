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
	<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="text/html; charset=iso-8859-2" http-equiv="Content-Type">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
.container {
  position: relative;
 
}

.overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 55%;
  width: 100%;
  opacity: 0;
  transition: .5s ease;
  background-color: blue;
}

.container:hover .overlay {
  opacity: 1 ;
  border-radius: 30px 30px 0px 0px;
}

.text {
  color: white;
  font-size: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  text-align: center;
}
</style>

</head>

<body  onload="myFunction()" style="margin:0;">
<div id="loader"></div>
<div id="home" class="animate-bottom">
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
		

	<section class="display" style="margin-left: 250px;" id="main">
	
	
	
<div class="grid-container2">
			
			<?php		$qry = $conn->query("SELECT DISTINCT program.NAME, program.PID, program.IMG FROM user_program join program join unit on user_program.PID = program.PID AND
		program.PID = unit.PID AND user_program.EMAIL = '$email' order by program.NAME asc");



while($row= $qry->fetch_assoc())
		{
			echo '<div class="container box" >';
			echo '<a href=\'student-units.php?pid='.$row['PID'].'\'>
			<img src="'.$row['IMG'].'" class="image" alt="logo" style="border-radius: 30px;" width="100%" height="100%" />';
			echo '<div class="overlay">';
			echo '<div class="text"><p>'.$row['NAME'].'</p></div>';
			echo '</div></a>';
			
		echo '</div>';
		
			
		}

		?>
		
            
 </section>
	
	
	
	<div class="categories">
	<iframe src="https://calendar.google.com/calendar/embed?src=nblnoi81c1rum8nr6i7e8ndluc%40group.calendar.google.com&ctz=Africa%2FJohannesburg" 
	style="border: 1px solid orange; float: left;" width="500px" height="250px" frameborder="0" scrolling="no"></iframe>
	
	
	</div>
	
			<script>
var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) 
  {myIndex = 1}    
  x[myIndex-1].style.display = "block";  
  setTimeout(carousel, 5000); // Change image every 2 seconds
}
</script>
	<script>
var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 1000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("home").style.display = "block";
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

<script>
function func() {
var popup = document.getElementById("myPopup");
popup.classList.toggle("show");
}
</script>
</div>
</body>
</html>
