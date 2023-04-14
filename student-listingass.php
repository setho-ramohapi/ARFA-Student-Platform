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
	<?php include('header.php') ?>
</head>

<body style="margin:0; width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
<div id="side-menu" class="sidebar">

	<a href="student-home.php" id="img-lnk"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="200px" height="100px" /></a>
	 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
<div class="menu-items">
<li><a href="student-courses.php"></i>Programs</a></li>
<li><a href="student-assignments.php">Assignments</a></li>
<li><a href="student-forums.php">Discussion Forums</a></li>
<li><a href="student-sessions.php">Sessions</a></li>
</div></div>

	<section class="display" id="main">
	<button class="openbtn" onclick="openNav()"><img src="logo.png" alt="logo"/></button>  
	<div style="margin-left: 25px;float: right;" class="popup" onclick="func()"><p><?php echo '👤'. $name,' ',$surname ?></p>
	<span class="popuptext" id="myPopup">
	<li><?php echo '👤'.$name,' ',$surname ?></li>
	<li><?php echo '👥'.$type ?></li>
	<li><?php echo '@'.$email ?></li>
	<li><a href="logout.php">Logout</a></li>
	</span></div>	
	
	<div class="container-fluid admin" style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
		<h2><?php echo $uname?></h2>
		<br>
		<div class="card">
			<div class="card-body">
	
<button type="button" class="collapsible">Open Assignments</button>

<div class="content">
<div class="grid-container">
		<?php
		
			$stmt = $conn->prepare('select NAME, DUE_DATE,AID from assignments where assignments.UID = ? AND STATUS = "OPEN" ORDER BY AID DESC' );
			$stmt->bind_param('s', $uid);
			$stmt->execute();
			$stmt->bind_result($aname,$due, $aid);
	
			while($stmt->fetch() > 0 ) {
				
				
				echo '<button class="btn btn-sm btn-outline-primary manage" data-id="'.$aid.'" type="button">
					<i class="fa fa-edit"></i>'.$aid.'    '.$aname.'</button>
				
				';
				
				
	
 }

		?></div>
		</div>

<hr>
<button type="button" class="collapsible">Closed Assignments</button>

<div class="content">
<div class="grid-container">

		<?php
		
			$stmt = $conn->prepare('SELECT DISTINCT assignments.NAME,LINK, assignments.AID, DUE_DATE FROM assignments 
			WHERE assignments.UID = ? AND STATUS = "CLOSED" ORDER BY AID DESC');
			$stmt->bind_param('s', $uid);
			$stmt->execute();
			$stmt->bind_result($aname,$lnk,$aid,$due);
		 
			
			while($stmt->fetch()) {
				echo '<div class="box" style="">';
				echo '<a href="staff-assignment.php?aid='.$aid.'&uid='.$uid.'"<p style="color: orange; font-size: 18px;">'.$aname.'</p><p>Due Date '.$due.'</p><p>AID '.$aid.'</p></a><br>
				</div>';
			}
 

		?></div>
		</div>
	
<hr>
<button type="button" class="collapsible">Submitted</button>

<div class="content">
<div class="grid-container">


		<?php
		
			$stmt = $conn->prepare('SELECT DISTINCT assignments.NAME,LINK, assignments.AID, DUE_DATE FROM assignments 
			WHERE assignments.UID = ? AND STATUS = "SUBMITTED" ORDER BY AID DESC');
			$stmt->bind_param('s', $uid);
			$stmt->execute();
			$stmt->bind_result($aname,$lnk,$aid,$due);
		
			
			while($stmt->fetch()) {
				echo '<div class="box" style="">';
				echo '<a href="staff-assignment.php?aid='.$aid.'&uid='.$uid.'"<p style="color: orange; font-size: 18px;">'.$aname.'</p><p>Due Date '.$due.'</p><p>AID '.$aid.'</p></a><br>
				</div>';
				
			}

		?></div>
</div>

			</div>
		</div>
	</div>
	
	
<div class="modal fade" id="manage_quiz" tabindex="-1" role="dialog" >

	<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title" id="myModallabel">Assignment</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='quiz-frm' style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
							<div class ="modal-body">
							
								<div id="msg"></div>
								
								<div class="form-group">
								
									<label>Name</label>
									
									<input type="text" name="name" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Instructions</label>
									<textarea name="instructions" class="form-control"></textarea>
								</div>	


								</div>
								<div class="form-group">
									<label>Due Date</label>
									<input type="nember" name ="dd" required="" class="form-control" />
								</div>
							
	
							</div>
						</form>
					</div>
				</div>
			</div>

	
									<div class="modal fade" id="manage_quiz" tabindex="-1" role="dialog" >

	<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title" id="myModallabel">Assignment</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='quiz-frm' style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
							<div class ="modal-body">
							
								<div id="msg"></div>
								
								<div class="form-group">
								
									<label>Name</label>
									
									<input type="text" name="name" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Instructions</label>
									<textarea name="instructions" required="" class="form-control" ></textarea>
								</div>
								<div class="form-group">
									<label>Due Date</label>
									<input name ="dd" required="" class="form-control" />
								</div>
								
								<div class="form-group">
									<label>Attach file</label>
									<form enctype="multipart/form-data" method="post">
		<table>

		<tr><td><input type="File" name="file" /><br /></td></tr>

		<tr><td><input style="float: right;" type="submit" value="Add" /></td></tr>
		</table>
		</form>
								</div>
							
							
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>


</section>

<div class="categories">

	</div>


	

	
	<script>

	
	var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
	
function func() {
var popup = document.getElementById("myPopup");
popup.classList.toggle("show");
}
</script>
	<script>	
	
	$(document).ready(function(){
		
		$('.manage').click(function(){
			var aid = $(this).attr('data-id')
			$.ajax({
				url:'assignment-details.php?aid='+aid,
				error:err=>console.log(err),
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						$('[name="name"]').val(resp.NAME)
						$('[name="instructions"]').val(resp.TEXT)
					
						$('[name="dd"] ').val(resp.DUE_DATE)
				
						
						$('#manage_quiz .modal-title').html('Assignment')
						$('#manage_quiz').modal('show')

					}
				}
			})

		})
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

</body>
</html>

