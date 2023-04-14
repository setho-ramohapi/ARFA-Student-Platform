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
<html lang="en">
<head>
	</head>
	<?php include('header.php') ?>

	<title>Quiz List</title>
</head>
<body>
	<?php include('nav_bar.php') ?>
	
	<div class="container-fluid admin">
		<div class="col-md-12 alert alert-primary">Quiz List</div>
		<button class="btn btn-primary bt-sm" id="new_quiz"><i class="fa fa-plus"></i>	Add New</button>
		<br>
		<br>
		<div class="card">
			<div class="card-body">
				<table class="table table-bordered" id='table'>
					
					<thead>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th>Items</th>
							<th>Point per Items</th>
							<?php if($_SESSION['user_type'] ==1): ?>
							<th>Faculty</th>
							<?php endif; ?>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$where = '';
					if($_SESSION['user_type'] == 1){
						$where = " where user_registration.ID = ".$id." ";
					}
					$qry = $conn->query("SELECT * from quiz_list q left join user_registration u on q.user_id = u.ID ".$where." order by q.TITLE asc ");
					$i = 1;
					if($qry->num_rows > 0){
						while($row= $qry->fetch_assoc()){
							$items = $conn->query("SELECT count(QID) as item_count from questions where QID = '".$row['QID']."' ")->fetch_array()['item_count'];
						?>
					<tr>
						<td><?php echo $i++ ?></td>
						<td><?php echo $row['TITLE'] ?></td>
						<td><?php echo $items ?></td>
						<td><?php echo $row['QPOINTS'] ?></td>
							<?php if($_SESSION['user_type'] ==1): ?>
						<td><?php echo $row['EMAIL'] ?></td>
							<?php endif; ?>
						<td>
							<center>
							 <a class="btn btn-sm btn-outline-primary edit_quiz" href="./quiz_view.php?id=<?php echo $row['QID']?>"><i class="fa fa-task"></i> Manage</a>
							 <button class="btn btn-sm btn-outline-primary edit_quiz" data-id="<?php echo $row['QID']?>" type="button"><i class="fa fa-edit"></i> Edit</button>
							<button class="btn btn-sm btn-outline-danger remove_quiz" data-id="<?php echo $row['QID']?>" type="button"><i class="fa fa-trash"></i> Delete</button>
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
							
							<h4 class="modal-title" id="myModallabel">Add New quiz</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='quiz-frm'>
							<div class ="modal-body">
								<div id="msg"></div>
								<div class="form-group">
									<label>Title</label>
									<input type="hidden" name="id" />
									<input type="text" name="title" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Points per question</label>
									<input type="nember" name ="qpoints" required="" class="form-control" />
								</div>
								<?php if($_SESSION['user_type'] == 1): ?>
								<div class="form-group">
									<label>Faculty</label>
									<select name="user_id" required="required" class="form-control" />
									<option value="" selected="" disabled="">Select Here</option>
									<?php
										$qry = $conn->query("SELECT * from user_registration where user_type = 1 order by name asc");
										while($row= $qry->fetch_assoc()){
									?>
										<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
									<?php } ?>
									</select>
								</div>
								<?php else: ?>
									<input type="hidden" name="user_id" />
								<?php endif; ?>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
</body>
<script>
	$(document).ready(function(){
		$('#table').DataTable();
		$('#new_quiz').click(function(){
			$('#msg').html('')
			$('#manage_quiz .modal-title').html('Add New quiz')
			$('#manage_quiz #quiz-frm').get(0).reset()
			$('#manage_quiz').modal('show')
		})
		$('.edit_quiz').click(function(){
			var id = $(this).attr('data-id')
			$.ajax({
				url:'./get_quiz.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						$('[name="id"]').val(resp.id)
						$('[name="title"]').val(resp.title)
						$('[name="qpoints"]').val(resp.qpoints)
						$('[name="user_id"] ').val(resp.user_id)
						$('#manage_quiz .modal-title').html('Edit Quiz')
						$('#manage_quiz').modal('show')

					}
				}
			})

		})
		$('.remove_quiz').click(function(){
			var id = $(this).attr('data-id')
			var conf = confirm('Are you sure to delete this data.');
			if(conf == true){
				$.ajax({
				url:'./delete_quiz.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(resp == true)
						location.reload()
				}
			})
			}
		})
		$('#quiz-frm').submit(function(e){
			e.preventDefault();
			$('#quiz-frm [name="submit"]').attr('disabled',true)
			$('#quiz-frm [name="submit"]').html('Saving...')
			$('#msg').html('')

			$.ajax({
				url:'./save_quiz.php',
				method:'POST',
				data:$(this).serialize(),
				error:err=>{
					console.log(err)
					alert('An error occured')
					$('#quiz-frm [name="submit"]').removeAttr('disabled')
					$('#quiz-frm [name="submit"]').html('Save')
				},
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						if(resp.status == 1){
							alert('Data successfully saved');
							location.replace('./quiz_view.php?id='+resp.id)
						}else{
						$('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')

						}
					}
				}
			})
		})
	})
</script>
</html>