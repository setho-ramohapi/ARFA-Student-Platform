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
$stmt->bind_param('s', $pid);
$stmt->execute();
$stmt->bind_result($uname, $pname, $uid);
$stmt->fetch();
$stmt->close();


?>

<!DOCTYPE html>
<html style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
<head>
</head>
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
	</span></div>	
	
	<div class="container-fluid admin" style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
		<h2>USERS</h2>
		<button style="color: orange; background-color: black;
	background-color:hsl(0, 0%, 24%); border: none; " class="btn btn-primary bt-sm" id="new_student"><i class="fa fa-plus"></i>	Add User</button>
		<br>
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
					<th align="center">SURNAME</th>	
					<th align="center">EMAIL</th>
					<th align="center">DATE CREATED</th>
					<th align="center">ACTION</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$qry = ('SELECT * FROM user_registration');
			
			$res = mysqli_query($conn, $qry);
			if (mysqli_num_rows($res) > 0){
			while($row = mysqli_fetch_assoc($res)) {
						?>
					<tr id="<?php echo $row['ID'];?>">
						<td data-target="name">
					<?php echo $row['NAME'];?>
				</td>
				<td data-target="surname">
					<?php echo $row['SURNAME'];?>
				</td>
				<td data-target="email">
				<?php echo $row['EMAIL'];?>
				</td>
				<td data-target="dc">
				<?php echo $row['DATE_CREATED'];?>
				</td>
				<td>
				<center>
					<a href="#" style="color: orange;"data-role="manage" data-id="<?php echo $row['ID'];?>">Manage Profile</a>
					<a href="#" style="color: orange;" data-role="program" data-id="<?php echo $row['ID'];?>">Programs</a>
					
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
		


</div>

<div class="modal fade" id="manage_quiz1" tabindex="-1" role="dialog" >
	<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title" id="myModallabel">User Programs</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>

							<div class ="modal-body" style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
							
								
						
								<div class="form-group">
								<label>User's Programs</label>
								<select rows='1' name="program" id="user_program"  required="required" multiple class="form-control select1" style="width: 100%; background-color: black;
	background-color:hsl(0, 0%, 24%);">
									
									
								
								</select>
								</div>
								</div>
								
								
								
							<div class="modal-footer">
								<a href="#" class="btn btn-primary" id="update"> Update</a>
							</div>
							</div>
					</div>
				</div>
			</div>


<div class="modal fade" id="manage_quiz" tabindex="-1" role="dialog" >

	<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title" id="myModallabel">Manage User</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>

							<div class ="modal-body" style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">
							
								
								<div class="form-group">
								
									<label>Name</label>
									
									<input type="text" id="name" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Surname</label>
									<input type="text" id="surname" required="" class="form-control" />
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="text" id="email" required="" class="form-control" />
								</div>
								<div class="form-group">
									<label>Date Created</label>
									<input type="text" id="dc" required="" class="form-control" />
									<input id="id" type="hidden" required="" class="form-control" />
								</div>
								
								
								
							<div class="modal-footer">
								<a href="#" class="btn btn-primary" id="save"> Save</a>
							</div>
							</div>
					</div>
				</div>
			</div>
			
			
			<div class="modal fade" id="manage_student" tabindex="-1" role="dialog" >
			
			 <div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title" id="myModallabel">New User</h4>
					
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='student-frm'style="background-color: black;
	background-color:hsl(0, 0%, 24%);">
						<div class ="modal-body" style=" width: 100%;
	height: 100%;
	background-color: black;
	background-color:hsl(0, 0%, 24%);
	font-family: Arial;
	font-size: 15px;
	color: orange;">

                   <div class="form-group">
						<label for= "Name">Name</label>
                        <input type = "text" id = "nname" class = "form-control">
						<span></span>
                    </div>
					<div class="form-group">
                        <label for= "Name"> Surname</label>
                        <input type ="text" id = "nsurname"  class = "form-control">
                    </div>
                    <div class="form-group">
                        <label for= "email"> Email</label>
                        <input type ="email" id = "nemail" value = "<?php echo $email;?>" class = "form-control">
                    </div>
					
                  <div class="form-group">
                        <label for= "password"> Password</label>
                        <input type = "password" id = "password" class = "form-control">
                    </div>
                    <div class="form-group">
                        <label for= "passwordConf"> Confirm Password</label>
                        <input type = "password" id = "passwordConf" class = "form-control">
                    </div>
					<div class="form-group">
                       <label>Account Type</label>
			<select id="account" required="required" style="float: right; background: orange; color: black;">
			<option value="STUDENT">Student</option>
			<option value="STAFF">Staff/Admin</option>
			<option value="FACULTY">Faculty</option>
			</select>
                    </div>
					<div class="form-group">
									<label>Program/s</label>
								
									<select rows='1' name="program[]" id="program" required="required" multiple class="form-control select2" style="width: 100%; background-color: black;
	background-color:hsl(0, 0%, 24%);">
									<?php 
									$student = $conn->query('SELECT * FROM program ');
									while($row=$student->fetch_assoc()){

									?>	
									<option style="width: 100%; background-color: black;
	background-color:hsl(0, 0%, 24%);" value="<?php echo $row['PID'] ?>"><?php echo ucwords($row['NAME']) ?></option>
								<?php } ?>
								</select>
								</div>

                    <div class="modal-footer" style=" float: left; background-color: black;
	background-color:hsl(0, 0%, 24%);">
                        <p><input class="btn btn-primary" type="button" id="new" type ="submit" name="signup-btn" value= "Sign Up"></p>
					
                    </div>
					
                
            </div>
			</form>
			

</div>
				</div>
			</div>
			

	
	

			


</section>

<div class="categories">
	
	</div>
	
<script>
	$(document).ready(function(){
		$('.select2').select2({
			placeholder:"Add programs",
			width:"100%",
			background: "black"
		});
			$('.select1').select2({
			placeholder:"View",
			width:"100%",
			background: "black"
		});
	
		$('#table').DataTable();
	$(document).on('click','a[data-role=manage]',function(){
		var id = $(this).data('id');
		var name = $('#'+id).children('td[data-target=name]').text();
		var surname = $('#'+id).children('td[data-target=surname]').text();
		var email = $('#'+id).children('td[data-target=email]').text();
		var dc = $('#'+id).children('td[data-target=dc]').text();
		
		$('#name').val(name);
		$('#surname').val(surname);
		$('#email').val(email);
		$('#dc').val(dc);
		$('#id').val(id);
		$('#manage_quiz').modal('toggle');
	
	
	});
	
		$(document).on('click','a[data-role=program]',function(){
		var id = $(this).data('id');
		
		
		$.ajax({
			url: 'select_program.php',
			method: 'post',
			data: {id : id},
			success: function(resp){
				$('#manage_quiz1').modal('toggle');
				$('#user_program').html(resp);
				console.log(resp);
				
				
		}
		})
	
	
	});
	
	$('#new_student').click(function() {
		$('#manage_student').modal('toggle');
	});
	
	

	
	
	$('#new').click(function(){
		var name = $('#nname').val();
		var surname = $('#nsurname').val();
		var email =  $('#nemail').val();
		var password = $('#password').val();
		var passwordConf =  $('#passwordConf').val();
		var account =  $('#account').val();
		var program = $('#program').val();
		
	
		
		$.ajax ({
			url: 'save_new_user_details.php',
			method: 'post',
			data: {name : name, surname : surname, email : email, password : password, passwordConf : passwordConf, account : account, program : program},
			success: function(resp){
			
				console.log(resp);
				alert('User Added');
				location.reload();
		}
		
		});
	
	
	});
	
	
	$('#save').click(function(){
		var id = $('#id').val();
		var name = $('#name').val();
		var surname = $('#surname').val();
	
		
		$.ajax ({
			url: 'save_user_details.php',
			method: 'post',
			data: {name : name, surname : surname, id : id},
			success: function(resp){
			
				console.log(resp);
				alert('User updated');
				location.reload();
		}
		
		});
	
	
	});
	

	
	

	});
	
</script>
	
	<script>
function func() {
var popup = document.getElementById("myPopup");
popup.classList.toggle("show");
}

function pop() {
    var popup = document.getElementById('myPopup1');
    popup.classList.toggle('show');
}
	
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
