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
$pid = $_SESSION['pid'];
$uid = $_GET['uid'];

?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $name, ' ', $surname;?> ¬ ARFA-EL</title>
	<link rel="stylesheet" href="ARFAEL.css"/>
</head>

<body style="margin:0;">
	<div id="side-menu" class="sidebar">

			<a href="staff-home.php" id="img-lnk"><img src="logo.png" alt="logo" /></a>
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
	<button class="openbtn" onclick="openNav()"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="10px" height="10px" /></button>  
	<h2 style="text-align: center;"><?php echo $uid?></h2>
	<div id="ass-blocks">
<h1 style="text-align: center;">Unit Docs</h1>

		<?php
			$stmt = $conn->prepare('SELECT DISTINCT notes.NAME, assignments.NAME FROM notes, assignments WHERE notes.UID = ? AND assignments.UID = ?');
			$stmt->bind_param('ss', $uid, $uid);
			$stmt->execute();
			$stmt->bind_result($nname, $aname);
			$x = 1;
			while($result[$x] = $stmt->fetch()) {
				
				echo '<h2 style="text-colour: black; text-align: center;">'..'</h2>';
				$x++;
			}

		?>
		</div>
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
	<iframe src="https://calendar.google.com/calendar/embed?src=nblnoi81c1rum8nr6i7e8ndluc%40group.calendar.google.com&ctz=Africa%2FJohannesburg" 
	style="border: 1px solid orange; margin-top: 358px; margin-bottom: 0px; margin-right: 15px; float: left;" width="405px" height="250px" frameborder="0" scrolling="no"></iframe>
	
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

