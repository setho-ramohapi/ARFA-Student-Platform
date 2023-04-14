<?php require_once 'controllers/authController.php'; 


//verify the user using the token
if (isset($_GET['token'])){
    $token = $_GET['token'];
    verifyUser($token);
}

//Reset password
if (isset($_GET['password-token'])){
    $passwordToken = $_GET['password-token'];
    resetPassword($passwordToken);
}



?>

<!DOCTYPE html>
<html>
	<head>
		<title>ARFA-EL</title>
		<link rel="stylesheet" type="text/css" href="ARFAEL.css">
	
       <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
	</head>
	<body style="margin:0;">
	<section class="index-section">
	<div class = "center">
                

                 <?php if(isset($_SESSION['message'])): ?>
                     <div class= "alert <?php echo $_SESSION['alert-class']; ?>">
                        <?php
                         echo $_SESSION['message']; 
                         unset($_SESSION['message']);
                         unset($_SESSION['alert-class']);

                         ?>
                         
                    </div>
                    <?php endif ; ?>
                    <?php if(!$_SESSION['verified']): ?>
                    <div class = "alert alert-warning">
                        Email has been sent to the following email address for verification
                        <strong>  <?php echo $_SESSION['email'];?> </strong>
                    </div>
                    <?php endif ; ?>

                    <?php if($_SESSION['verified']): ?>
					<div class = "alert alert-warning">
                    Verified
                    <a href="index.php" class = "logout"> Login here</a>
					</div>
                    <?php endif ; ?>
          </div>    
	</section>
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