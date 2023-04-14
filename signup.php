<?php require_once 'controllers/authController.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>ARFA-EL</title>
		<link rel="stylesheet" type="text/css" href="ARFAEL.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
	</head>
	<body style="margin:0;">
	<section class="main">
            <div class="center">
                <form action = "signup.php" method = "post">

                    <h1>ARFA-EL</h1>

                    <?php if (count($errors) > 0): ?>
                    <div class = "alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                        <li> <?php echo $error; ?></li>
                        <?php endforeach; ?>

                    </div>
                    <?php endif; ?>

                   <div class = "txt_field">
						<label for= "Name"> Name</label>
                        <input type = "text" name = "name" class = "form-control form-control-lg">
						<span></span>
                    </div>
					<div class = "txt_field">
                        <label for= "Name"> Surname</label>
                        <input type ="text" name = "surname"  class = "form-control form-control-lg">
                    </div>
                    <div class = "txt_field">
                        <label for= "email"> Email</label>
                        <input type ="email" name = "email" value = "<?php echo $email;?>" class = "form-control form-control-lg">
                    </div>
					
                   <div class = "txt_field">
                        <label for= "password"> Password</label>
                        <input type = "password" name = "password" class = "form-control form-control-lg">
                    </div>
                    <div class = "txt_field">
                        <label for= "passwordConf"> Confirm Password</label>
                        <input type = "password" name = "passwordConf" class = "form-control form-control-lg">
                    </div>
					<div class = "txt_field">
                       <label>Account Type</label>
			<select name="account" required="required" style="float: right; background: orange; color: black;" />
			<option value="STUDENT">Student</option>
			<option value="FACULTY">Faculty</option>
			</select>
                    </div>

                    <div class = "txt_field">
                        <p><input id="login" type ="submit" name="signup-btn" value= "Sign Up"></p>
						<p><a href="index.php">Already have an account? Login here</a></p>
                    </div>
					
                
            </div>
			<div class="w3-content w3_section" id= "right" style=";">
		<img class="w3-animate-right" src="logo.png" alt="logo">
	</div>
			</form>
	</section>
	<footer>
	<img src="logo.png" alt="logo" width="100px" height="138px">
	</footer>
    </body>
</html>