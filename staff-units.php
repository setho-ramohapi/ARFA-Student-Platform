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
$user_type = $_SESSION['user_type'];
$id = $_SESSION['id'];
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
</head>

<body style="margin:0;">
	<div id="side-menu" class="sidebar">

			<a href="staff-home.php" id="img-lnk"><img src="logo.png" alt="logo" /></a>
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
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo" width="10px" height="10px" /></button>  
	
	<div style="margin-left: 25px;float: right;" class="popup" onclick="func()"><p><?php echo '👤'. $name,' ',$surname ?></p>
	<span class="popuptext" id="myPopup">
	<li><?php echo '👤'.$name,' ',$surname ?></li>
	<li><?php echo '👥'.$type ?></li>
	<li><?php echo '@'.$email ?></li>
	<li><a href="logout.php">Logout</a></li>
	</span></div><p style="float: right; margin-right: px; ">Recent posts</p>
	
	
	

<?php



$stmt = $conn->prepare('SELECT unit.NAME, unit.UID, program.IMG FROM program,unit WHERE program.PID = unit.PID AND program.PID = ?');
echo '<h5 style="color: orange; margin-left: 50px; ">'.$pname.'</h5> <hr style="border: 1px solid transparent;">	';
$stmt->bind_param('s', $pid);
$stmt->execute();
$stmt->bind_result($uname,$uid,$img);
$x = 1;
while($stmt->fetch()) {
	echo '<div class="">';
	echo'<img src="'.$img.'" alt="logo" width="350px" height="100px" />
	<span><div class="popup" onclick="func'.$x.'()"><h6 style="font-size: 15px;color: ;font-weight: 700;border: none;">'. $uname.'</h6>
	<span class="popuptext" id="myPopup'.$x.'"><li>
	<a href=\'staff-assignments.php?uid='.$uid.'&pid='.$pid.'\'>Assignments</a></li><li>
	<a href=\'staff-notes.php?uid='.$uid.'&pid='.$pid.'\'>Notes</a></li>
	<a href=\'staff-sessions.php?uid='.$uid.'&pid='.$pid.'\'>Sessions</a></li><li>
	<a href=\'quiz.php?id='.$user_type.'\'>Quizzes</a></li><li>
	<a href=\'staff-forums.php?uid='.$uid.'&pid='.$pid.'\'>Forums</a></li>
	</span></div>';
	echo '</div>';

	$x++;
}

		$email = $_SESSION['email'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$type = $_SESSION['type'];
$user_type = $_SESSION['user_type'];
$id = $_SESSION['id'];

?>


</a></span></div>


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
		
			<select name="unit" required="required" />
			<option value="" selected="" disabled="">Select Module</option>
			
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
