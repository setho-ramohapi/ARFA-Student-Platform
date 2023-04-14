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

<?php echo "<img src='logo1197c37250c3468907d3cfdb5fca91f6f.png' width='200px' height='135px' style='margin-left:20px;'>";?>
<p style="text-align: center;"><?php echo $type?>
<br>
First Name: <?php echo $name?> 
<br>
Surname: <?php echo $surname?>
<br>
Email: <?php echo $email?>
<br>
</p>
					
</section>
</body>
</html>