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
<div style="display: inline-block">
      <form enctype="multipart/form-data" style="float: left; margin-right: 10px" method="post">	
<div id="b">Select Session
<input type="file" name="file" class="hide_file">
</div>

<input  style="float:; color: orange; background-color: black;
	background-color:hsl(0, 0%, 24%); height: 30px; " type="submit" value="Upload">
</form>	<p style="float: left">or</p>  
      <form enctype="multipart/form-data" method="post" style="float: left; margin-left: 10px" action="embedprocess.php">
	  <input type="hidden" name="uid" value="<?php echo $uid?>">
	  <input type="hidden" name="pid" value="<?php echo $pid?>">
	<textarea placeholder="Embed Session" name="link" style="height: 15px; margin-left: 2px; color: orange; background-color: black;
	background-color:hsl(0, 0%, 24%);" rows=1 cols=15 wrap=virtual></textarea>
	<input  style="float:; color: orange; background-color: black;
	background-color:hsl(0, 0%, 24%); height: 30px; " type="submit" name="embed"  value="Embed">
		</form> </p>
</div>

   
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
				echo '<a href="staff-session.php?ssid='.$ssid.'&uid='.$suid.'" style="text-colour: orange; text-align: center; width: 2%">
				<img src="video-play-button-icon-.png" style=" background: black; width: 90%; height: 80px">'.$aname.'</a>';
				echo '<br></div>';
			}
			echo '</div>';

		?>
		
		<div id="secimg" style="width: 100%; height: 20%;">
		
		</div>


		<br>
		
		


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


</section>
<div class="categories">
	<h6>Post Assignment</h6>
	<form enctype="multipart/form-data" method="post">
		<table>
		<tr><td><input placeholder="Title" type="text" name="title"></td></tr>
		<tr><td><textarea placeholder="Intructions" name="txt" rows=13 cols=50 wrap=virtual></textarea></td></tr>
		<tr><td><input type="File" name="file" /><br /></td></tr>
		<tr><td><label>Due date</label></td></tr>
		<tr><td><input type="date" name="due"><input style="float: right;" type="submit" value="Add" /></td></tr>
		
			<label>Module</label>
			<select name="unit" required="required" />
			<option value="" selected="" disabled="">Select Here</option>
			
			<?php
			$qr = $conn->query("SELECT DISTINCT PROGRAM_NAME, program.PID FROM user_program join program join unit on user_program.PID = program.PID AND
		program.PID = unit.PID AND user_program.EMAIL = '$email' order by program.NAME asc");
				while($ro= $qr->fetch_assoc()){
					echo '<option value="" disabled="">'.$ro['NAME'].'</option>';
					
				$qry = $conn->query("SELECT unit.NAME, unit.UID FROM program join unit on
		program.PID = unit.PID AND unit.PID = ".$ro['PID']."");
				while($row= $qry->fetch_assoc()){
					
					
				
			?><option value="<?php echo $row['UID'] ?>"><?php echo $row['NAME'] ?></option>
				<?php }?>
				
				
				<?php } ?>
			</select>
		</table>
		</form>
		
		
		
		
		
		
		
		
		<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$txt = $_POST['txt'];
	$title = $_POST['title'];
	$due = $_POST['due'];
	$unit = $_POST['unit'];
	$url = 'staff-assignments.php?';
		#file name with a random number so that similar dont get replaced
		$pname = rand(1000,10000)."-".$_FILES["file"]["name"];
		
		
		#uploead directory path
		$uploads_dir = 'assignments/';
		$ext = pathinfo($pname, PATHINFO_EXTENSION);
		
		
		#temporary file name to store file
		$tname = $_FILES["file"]["tmp_name"];
		
		if (!in_array($ext,['pdf','doc','docx','xlsx','xls','csv','jpg']) && empty($_FILES['file']['name'])) {

				#sql query to insert into database
				$sql1 = "INSERT into assignments(NAME,LINK,UID,TITLE, TEXT, DUE_DATE)VALUES('$title','--','$unit','$title','$txt','$due')";
				$conn->query($sql1);
				
				echo "Posted";
		} else{
		#to move uploaded file to destination
		move_uploaded_file($tname,$uploads_dir.$pname);
		#sql query to insert into database
		$sql = "INSERT into assignments(NAME,LINK,UID,TITLE, TEXT,DUE_DATE)VALUES('$pname','$ext','$unit','$title','$txt','$due')";
		$conn->query($sql);
 
    echo "Posted", $unit;
	

		
    }
	
}
?>
	<br>
	<h6>Past Activities</h6>
	<?php
				$qry = $conn->query("SELECT DISTINCT unit.NAME a, assignments.NAME b FROM unit join assignments join user_program on unit.UID = assignments.UID 
				AND user_program.PID = unit.PID AND DATEDIFF(assignments.DATE_CREATED, NOW()) < 7 AND user_program.EMAIL = '$email' UNION 
				SELECT DISTINCT unit.NAME a, sessions.NAME b FROM unit join sessions join user_program on unit.UID = sessions.UID 
				AND user_program.PID = unit.PID AND DATEDIFF(sessions.DATE_CREATED, NOW()) < 7 AND user_program.EMAIL = '$email' LIMIT 4 ");
				echo '<div><table  border="4">';
			echo '<tr>
			<td><div contenteditable="false"><strong>Module</strong></td>
      <td><div contenteditable="false"><strong>Activity</strong></td>
    </tr>';
			while($row= $qry->fetch_assoc() ){
				
    echo '<tr>
	 <td><div contenteditable="false">'.$row['a'].'</td>
      <td><div contenteditable="false">'.$row['b'].'</td>
    </tr>';
			
			}
	echo '</table></div>';
				
	?>
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

