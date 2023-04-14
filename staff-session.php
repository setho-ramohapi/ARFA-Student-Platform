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
$ssid = $_GET['ssid'];
$uid = $_GET['uid'];
$stmt->bind_param('s',$uid);
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

		<?php
		
			$stmt = $conn->prepare('SELECT DISTINCT sessions.NAME,LINK, sessions.SSID FROM sessions 
			WHERE sessions.SSID = ?');
			$stmt->bind_param('s',$ssid);
			$stmt->execute();
			$stmt->bind_result($aname,$lnk,$ssid);
			while($stmt->fetch()) {
			
				echo '<div class="player" style="width: 800px;">
			 
  <video controls style="width: 800px;">

    <source src="sessions\\'.$aname.'" type="video/mp4">
    <source src="sessions\\'.$aname.'" type="video/webm">
    <!-- fallback content here -->
  </video>
  <div class="controls">
    <button class="play" data-icon="P" aria-label="play pause toggle"></button>
    <button class="stop" data-icon="S" aria-label="stop"></button>
    <div class="timer">
      <div></div>
      <span aria-label="timer">00:00</span>
    </div>
    <button class="rwd" data-icon="B" aria-label="rewind"></button>
    <button class="fwd" data-icon="F" aria-label="fast forward"></button>
  </div>
</div>';
			}
			
		?>
		<?php echo '<h2>'.$aname.'</h2' ?>;
	

		<br>
		
		
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
			$qr = $conn->query("SELECT DISTINCT program.NAME, program.PID FROM user_program join program join unit on user_program.PID = program.PID AND
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
	const media = document.querySelector('video');
const controls = document.querySelector('.controls');

const play = document.querySelector('.play');
const stop = document.querySelector('.stop');
const rwd = document.querySelector('.rwd');
const fwd = document.querySelector('.fwd');

const timerWrapper = document.querySelector('.timer');
const timer = document.querySelector('.timer span');
const timerBar = document.querySelector('.timer div');

media.removeAttribute('controls');
controls.style.visibility = 'visible';

play.addEventListener('click', playPauseMedia);

function playPauseMedia() {
  if(media.paused) {
    play.setAttribute('data-icon','u');
    media.play();
  } else {
    play.setAttribute('data-icon','P');
    media.pause();
  }
}


stop.addEventListener('click', stopMedia);
media.addEventListener('ended', stopMedia);

function stopMedia() {
  media.pause();
  media.currentTime = 0;
  play.setAttribute('data-icon','P');
}

rwd.addEventListener('click', mediaBackward);
fwd.addEventListener('click', mediaForward);

let intervalFwd;
let intervalRwd;

function mediaBackward() {
  clearInterval(intervalFwd);
  fwd.classList.remove('active');

  if(rwd.classList.contains('active')) {
    rwd.classList.remove('active');
    clearInterval(intervalRwd);
    media.play();
  } else {
    rwd.classList.add('active');
    media.pause();
    intervalRwd = setInterval(windBackward, 200);
  }
}

function mediaForward() {
  clearInterval(intervalRwd);
  rwd.classList.remove('active');

  if(fwd.classList.contains('active')) {
    fwd.classList.remove('active');
    clearInterval(intervalFwd);
    media.play();
  } else {
    fwd.classList.add('active');
    media.pause();
    intervalFwd = setInterval(windForward, 200);
  }
}


function windBackward() {
  if(media.currentTime <= 3) {
    rwd.classList.remove('active');
    clearInterval(intervalRwd);
    stopMedia();
  } else {
    media.currentTime -= 3;
  }
}

function windForward() {
  if(media.currentTime >= media.duration - 3) {
    fwd.classList.remove('active');
    clearInterval(intervalFwd);
    stopMedia();
  } else {
    media.currentTime += 3;
  }
}

media.addEventListener('timeupdate', setTime);

function setTime() {
  let minutes = Math.floor(media.currentTime / 60);
  let seconds = Math.floor(media.currentTime - minutes * 60);
  let minuteValue;
  let secondValue;

  if (minutes < 10) {
    minuteValue = '0' + minutes;
  } else {
    minuteValue = minutes;
  }

  if (seconds < 10) {
    secondValue = '0' + seconds;
  } else {
    secondValue = seconds;
  }

  let mediaTime = minuteValue + ':' + secondValue;
  timer.textContent = mediaTime;

  let barLength = timerWrapper.clientWidth * (media.currentTime/media.duration);
  timerBar.style.width = barLength + 'px';
}


rwd.classList.remove('active');
fwd.classList.remove('active');
clearInterval(intervalRwd);
clearInterval(intervalFwd);



	</script>
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

