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
$email = $_SESSION['email'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$type = $_SESSION['type'];
$user_type = $_SESSION['user_type'];
$id = $_SESSION['id'];

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
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
<div>
<div id="side-menu" class="sidebar">

			<a href="staff-home.php" id="img-lnk"><img src="logo.png" alt="logo"/></a>
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
<div style="width: 100%;">
	<div style="margin-left: 25px;float: right;" class="popup" onclick="func()"><p><?php echo '👤'. $name,' ',$surname ?></p>
	<span class="popuptext" id="myPopup">
	<li><?php echo '👤'.$name,' ',$surname ?></li>
	<li><?php echo '👥'.$type ?></li>
	<li><?php echo '@'.$email ?></li>
	<li><a href="logout.php">Logout</a></li>
	</span></div><p style="float: right; margin-right: px; ">Recent posts</p>
	</div>
	
	<hr style="border: 1px solid transparent;">	
	
	
	<button class="btn btn-sm btn-outline-primary manage" style="background-color: orange; color: black; " data-id="<?php echo $row['EMAIL']?>" type="button">
					<i class="fa fa-edit"></i> Add program</button>
					<button class="btn btn-sm btn-outline-primary " style="background-color: orange; color: black; "  data-id="<?php echo $row['EMAIL']?>" type="button">
					<i class="fa fa-edit"></i> Update Program</button>
					<button class="btn btn-sm btn-outline-danger remove_quiz" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"></i> Delete</button>
					
		<div class="modal fade" id="manage_quiz" tabindex="-1" role="dialog" >

	<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title" id="myModallabel">Add program</h4>
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='quiz-frm'  style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
			<div class ="modal-body">
							
								<div id="msg"></div>
								
								<div class="form-group">
								
			<label>Program Name</label>
									
									<input type="text" name="name" required="required" class="form-control" />
								</div>
                
             <div class="form-group">
									<label>Module</label>
									<input type="nember" name= "module_name[]" id="module" required="" class="form-control" />
								</div>
				<div class="form-group">
				
				<div class="addedfields"></div>
				
             <input type="File" name="file" id="file" />
			 	</div>
				
			 <div class="modal-footer ">
			 <input type="button"  style = "background-color: black; color: orange; float: right; "  value="+1 module" class="addbutton btn btn-primary">
			 <input type="submit" id="new_program" style = "background-color: orange; color: black; float: right; position: "value="Add Program" name="new_program" class="btn btn-primary">
			
							</div>
			 </div>
			 </form>
			 	</div>
				</div>
			</div>
			
			<?php		$qry = $conn->query("SELECT DISTINCT program.NAME, program.PID, program.IMG FROM user_program join program join unit on user_program.PID = program.PID AND
		program.PID = unit.PID AND user_program.EMAIL = '$email' order by program.NAME asc");



while($row= $qry->fetch_assoc())
		{
			echo '<div class="">';
			echo '<a href=\'staff-units.php?pid='.$row['PID'].'\'>
			<img src="'.$row['IMG'].'" alt="logo" width="60%" height="200px" /><h5 style="color: orange;">'.$row['NAME'].'</h5></a>';
		echo '</div>';
		echo '<p style="font-size=4px;"><em>modules</em></p>';
			$qryq = $conn->query("SELECT unit.NAME FROM program join unit on
		program.PID = unit.PID AND unit.PID = ".$row['PID']."");
			
			while($ro = $qryq->fetch_assoc())
			{
			echo '<div >';
			
			echo '<h7 style="margin: 0; padding: 0;">',$ro['NAME'], '</h7><br>';
			echo '</div';
			echo '<br>';
			}
			echo '<br>';
			
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
			<td><div contenteditable="false"><strong>Module</strong></div></td>
      <td><div contenteditable="false"><strong>Activity</strong></div></td>
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
		$('#table').DataTable();
	$(".addbutton").click(function(){
	$('.addedfields').prepend(
		  '<label>Module</label><input type="nember" name= "module_name[]" required="" class="form-control" />'
       );
     
  })
 
		
		$('.manage').click(function(){
			$('#msg').html('')
			$('#manage_quiz .modal-title').html('Add New program')
			$('#manage_quiz #quiz-frm').get(0).reset()
			$('#manage_quiz').modal('show')
		})

  	$('#new_program').click(function(){
		var name = $('#name').val();
		var module = $('#module').val();
		var fd = new FormData();
        var file = $('#file').file;
		fd.append('file',file);
		$.ajax ({
			url: 'save-program.php',
			method: 'post',
			data: fd,
			contentType: false,
          
			success: function(resp){
			
				console.log(resp);
				alert('New Program Added');
				
		}
		
		});
	
	
	});

		
	})
	
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
</body>
</html>
