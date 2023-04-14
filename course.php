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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="ARFAEL.css"/>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body style="margin:0;">
<div>
<div id="side-menu" class="sidebar">

			<a href="staff-home.php" id="img-lnk"><img src="logo.png" alt="logo"/></a>
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
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo" width="10px" height="10px" /></button>  
	
	<div style="margin-left: 25px;float: right;" class="popup" onclick="func()"><p><?php echo '👤'. $name,' ',$surname ?></p>
	<span class="popuptext" id="myPopup">
	<li><?php echo '👤'.$name,' ',$surname ?></li>
	<li><?php echo '👥'.$type ?></li>
	<li><?php echo '@'.$email ?></li>
	<li><a href="logout.php">Logout</a></li>
	</span></div>
	<h2 style = "color: orange;">New program</h2>
            <form action= "" class="addedfields" method = "POST" style="margin-left: ;" enctype = "multipart/form-data">
	
			
			<input type="submit"  style = "background-color: orange; float: right; position: "value="Add Program" name="register" >
			<input type="button"  style = "background-color: white; float: right; " value="+1 module" class="addbutton">
                
                <input type="text" name= "program_name" style="width: 300px; height: 35px; border: 4px solid orange;" placeholder="Program Name"><br>
				<br><input type="text" name= "module_name[]" style="width: 300px; height: 30px; border: 2px solid gold;"  placeholder="Module Name"><br>
             <input style = "background-color: orange; float: right; position:; color: black; " type="File" name="file" />
			 </form>
            
 </section>
 
 <?php 
 if ( isset($_POST['register'])) { 
	$url = 'staff-units.php?';
	$program_name = $_POST['program_name'];
	#uploead directory path
		#file name with a random number so that similar dont get replaced
		$pname = rand(1000,10000)."-".$_FILES["file"]["name"];
		
		
		#uploead directory path
		$uploads_dir = './';
		$ext = pathinfo($pname, PATHINFO_EXTENSION);
		
		
		#temporary file name to store file
		$tname = $_FILES["file"]["tmp_name"];
		if (!in_array($ext,['png','jpg']) && empty($_FILES['file']['name'])) {
			
		echo 'error';} else {
			#to move uploaded file to destination
		move_uploaded_file($tname,$uploads_dir.$pname);
	mysqli_query($conn, "INSERT program (NAME,IMG) VALUES ('$program_name','$pname')");
	$last_id = $conn->insert_id;
	mysqli_query($conn, "INSERT user_program (EMAIL, PID) VALUES ('$email','$last_id')");
    $checkbox1=$_POST['module_name'];
		}

    foreach($checkbox1 as $chk1) {      
        mysqli_query($conn,"INSERT unit (NAME, PID) VALUES ('$chk1','$last_id')");
    }
		header('Location:'.$url.'pid='.$last_id);
}
 
 ?>
	
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
			<td><strong>Module</strong></td>
      <td><strong>Activity</strong></td>
    </tr>';
			while($row= $qry->fetch_assoc() ){
				
    echo '<tr>
	 <td>'.$row['a'].'</td>
      <td>'.$row['b'].'</td>
    </tr>';
			
			}
	echo '</table></div>';
				
	?>
	
	
	
	</div>

<script>
$(document).ready(function(){
  $(".addbutton").click(function(){
       $(".addedfields").append(
         '<br><input type="text" name= "module_name[]" style="width: 300px; height: 30px; border: 2px solid gold;"  placeholder="Module Name"><br>'
       );
     
  })
});


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
