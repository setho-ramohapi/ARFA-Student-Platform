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
$stmt = $conn->prepare("SELECT unit.NAME, PROGRAM_NAME, unit.UID FROM unit, program WHERE unit.PID = program.PID AND program.PID = ? ");
$email = $_SESSION['email'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$type = $_SESSION['type'];
$uid = $_GET['uid'];
$pid = $_GET['pid'];
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
	<link href="https://vjs.zencdn.net/7.14.3/video-js.css" rel="stylesheet" />
</head>

<body style="margin:0;">
	<div id="side-menu" class="sidebar">

			<a href="staff-home.php" id="img-lnk"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="200px" height="100px" /></a>
			 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
			<div class="menu-items">
			<li><a href="staff-home.php"></i>Home</a></li>
			<li><a href="staff-courses.php"></i>Programs</a></li>
			<li><a href="students.php">Students</a></li>
			<li><a href="staff-unit-listing-assignments.php">Assignments</a></li>
			<li><a href="staff-forums.php?">Discussion Forums</a></li>
			<li><a href="staff-sessions.php">Sessions</a></li>
			</div>
	
	
</div>

	<section class="display" id="main">
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo"/></button>  
	<h2 style="text-align: center;"><?php echo $uname?></h2>
	<div id="ass-blocks">
<h1 style="text-align: center;"><?php echo $uname?> Sessions</h1>

		<?php
		
			$stmt = $conn->prepare('SELECT DISTINCT sessions.NAME,LINK, sessions.SSID FROM sessions 
			WHERE sessions.UID = ?');
			$stmt->bind_param('s',$uid);
			$stmt->execute();
			$stmt->bind_result($aname,$lnk,$aid);
			$x = 1;
			while($stmt->fetch()) {
				echo '<h2 style="text-colour: black; text-align: center;">'.$aname.'</h2>';
			}

		?>
		</div>

		<br>
		<div id="ass-blocks">
<h1 style="text-align: center;">Add Session</h1>

<form enctype="multipart/form-data" method="post" style="margin-left: 35%">
<input type="file" name="file" /><br />
<input type="submit" value="Add" /></p>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // =============  File Upload Code d  ===========================================
    $target_dir = 'sessions/';

    $target_file = rand(1000,10000)."-".basename($_FILES["file"]["name"]);
	#temporary file name to store file
	$tname = $_FILES["file"]["tmp_name"];
	
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

     // Check file size -- Kept for 500Mb
    if ($_FILES["file"]["size"] > 500000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "png" && $imageFileType != "mp4" && $imageFileType != "avi" && $imageFileType != "MP4") {
        echo "Sorry, only wmv, mp4 & avi files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else 
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$target_file);
            echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
    }

    // ===============================================  File Upload Code u  ==========================================================


    // =============  Connectivity for DATABASE d ===================================
  

    $vidname = $target_file;
    $vidsize = $_FILES["file"]["size"] . "";
    $vidtype = $_FILES["file"]["type"] . "";

    $sql = "INSERT INTO sessions (NAME,UID,LINK) VALUES ('$vidname','$uid','$imageFileType')";

    if ($conn->query($sql) === TRUE){}
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }

    $conn->close();
    // =============  Connectivity for DATABASE u ===================================



}
?>

</div>
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
<script src="https://vjs.zencdn.net/7.14.3/video.min.js"></script>

</body>
</html>

