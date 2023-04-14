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
	<?php include('header.php') ?>
	
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
<script>
	
	$(document).ready(function(){
		$('#table').DataTable();
	$(document).on('click','a[data-role=view]',function(){
		var aid = $(this).data('id');
		
		$.ajax({
			url: 'select_notes.php',
			method: 'post',
			data: {aid : aid},
			success: function(resp){
				$('#manage_quiz').modal('toggle');
				$('#file').html(resp);
				console.log(resp);
				location.reload();
		}
		})
	
	
	});
	});
	
</script>
</head>

<body style="margin:0; width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
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
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo"  /></button>  
		<div style="margin-left: 25px;float: right;" class="popup" onclick="func()"><p><?php echo '👤'. $name,' ',$surname ?></p>
	<span class="popuptext" id="myPopup">
	<li><?php echo '👤'.$name,' ',$surname ?></li>
	<li><?php echo '👥'.$type ?></li>
	<li><?php echo '@'.$email ?></li>
	<li><a href="logout.php">Logout</a></li>
	</span></div>	
	<h2 style=""><?php echo $uname ,' ' , 'notes'?></h2>
	
		<div class="container-fluid admin" style=" width: 100%;
	height: ;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange; float: left;">
		<div class="card">
			<div class="card-body" style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
				<table class="table table-bordered" id='table'>
					
					<thead>
						<tr>
							<th width="" align="center">NAME</th>
					<th align="center">ACTION</th>
						</tr>
					</thead>
					<tbody>


		<?php
			$qry = 'SELECT DISTINCT notes.NAME,LINK, notes.NID FROM notes join unit on unit.UID = notes.UID AND notes.UID = '.$uid.'';
		$res = mysqli_query($conn, $qry);
			if (mysqli_num_rows($res) > 0){
			while($row = mysqli_fetch_assoc($res))
		{


		?>
<tr  id="<?php echo $row['NID'];?>">
						<td>
					<?php echo $row['NAME'];?>
				</td>
			<td>
				<center>
					
					<a class="btn btn-sm btn-outline-primary edit_quiz" href="#" id="read" data-role="view" data-id="<?php echo $row['NID'];?>">Read</a>
				
					
				</center>
				</td>
					</tr>
<?php
		}
					}
					?>
									</tbody>
				</table>
			</div>
		</div>
	</div>
	
	
	<div class="modal fade" id="manage_quiz" tabindex="-1" role="dialog" >

	<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title" id="myModallabel">Notebook</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>

							<div class ="modal-body" style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
							
								
								<div class="form-group" id="file">
								
								
								</div>
								
						
								
								
							
							</div>
					</div>
				</div>
			</div>
	
	
	
		
<h1 style="text-align: center;">Add Notes</h1>

<h2></h2>
<form enctype="multipart/form-data" method="post" style="margin-left: 35%">
<input type="File" name="file" /><br />
<input type="submit" value="Add" /></p>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$url = 'staff-notes.php?';
		#file name with a random number so that similar dont get replaced
		$pname = rand(1000,10000)."-".$_FILES["file"]["name"];
		
		
		#uploead directory path
		$uploads_dir = 'notes/';
		$ext = pathinfo($pname, PATHINFO_EXTENSION);
		
		
		#temporary file name to store file
		$tname = $_FILES["file"]["tmp_name"];
		
		if (!in_array($ext,['pdf','doc','docx','xlsx','xls','csv','jpg'])) {
			echo "File extension invalid";
		} else
		#to move uploaded file to destination
		move_uploaded_file($tname,$uploads_dir.$pname);
		#sql query to insert into database
		$sql = "INSERT into notes(NAME,LINK,UID)VALUES('$pname','$ext','$uid')";
		
    if(mysqli_query($conn,$sql)){
 
    echo "File Sucessfully uploaded";


	}
	else{
		print mysqli_error($conn);
        echo "Error";
    }

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
	</div>
	
	
	




</body>
</html>

