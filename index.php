<?php require_once 'controllers/authController.php'; ?>
<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'arfa';

$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);


?>
<!DOCTYPE html>
<html style="margin:0; height: 100%;">
	<head>
		<title>ARFA-EL</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="text/html; charset=iso-8859-2" http-equiv="Content-Type">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body style="margin:0; height: 100%; width: 100%; padding: 0;">
	
	<div class="w3-content w3-section" id= "container1"  style="background: white; height: 100%; width: 75%; margin: 0; position: fixed; padding-top:0; border:; margin-bottom: 0px;">
	
	<?php		$qry = $conn->query("SELECT DISTINCT program.NAME, program.PID, program.IMG FROM program join unit on 
		program.PID = unit.PID order by program.NAME asc");



while($row= $qry->fetch_assoc())
		{
			echo '
			<img class="mySlides" src="'.$row['IMG'].'" alt="logo" style="width: 100%; padding: 0; height: 100%; margin-top: -18px; margin-left: -2px;  margin-right: -3px; border: 1px solid green ;"/>';
		
	
	
			
				$qryq = $conn->query("SELECT unit.NAME FROM program join unit on
		program.PID = unit.PID AND unit.PID = ".$row['PID']."");
			echo '<div class="overlay">';
			while($ro = $qryq->fetch_assoc())
			{
		
			
	
			}
			echo '</div>';
		
			
			
			
			
			}
			

		?>
		</div>
	</div>
	
	<div class= "right" style="margin: 0;float: right; height: 100%; background: orange; width: 28.3%; padding: 0px; position: relative;">
		<div  style="margin: 0; height: 35%; background: white; padding-top: 10px;" >
		<div style="float: left; margin: 0; padding-right: 0; padding-left: 10px;">
		<img src="logo.png" alt="logo" width="50px" height="50px"/><h5>ARFA-EL</h5>
		<?php if (count($errors) > 0): ?>
                    <div class = "alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                        <li> <?php echo $error; ?></li>
                        <?php endforeach; ?>

                    </div>
                    <?php endif; ?>
		</div>
		
		<form method ="POST" style="height: 250px; width: 70%; margin-right: 0px; margin-top: 0; float: right; padding-right: 0;; padding-top: 0; position: relative; border: ;">
			<div class = "txt_field" style="padding-top: 0px; margin: 0; text-align: left;">
				<input  style="width: 70%" type = "text" placeholder="Email" name="email" >
				
			</div>
			<div class = "txt_field" style="padding-top: 0px; margin: 0 text-align: left;">
				<input style="width: 70%" type ="password" placeholder="Password" name="password"  >
				<p style="margin: 10px 49px 0px 0px;"><input id="login" type ="submit" name="login-btn" value= "Sign In"></p>
				<p style="float: right; margin: 10px 118px 0px 0px;"><a href="signup.php">Don't have an account? Register here</a></p>
			<p style="float: right; margin: 0px 161px 0px 0px;"><a href="forgot_password.php">Forgot password?</a></p>
			</div>
			
			
		</form>
		</div>
		
		<div  style=" margin: 0; height: 30%; background: white; padding-left: 10px;">
		<h1>About<h1>
		<p style="font-size: 18px; margin: 0; ">ARFA-EL is Arielle For Africa's online learning platform. Login to get the study materials for your enrolled programs.</p>
		</div>
		
		<div class="socials" style="height: 30%; background: white ; margin: 0; padding-left: 10px;">
		<h1>Socials<h1>
		
					<a href= "https://web.facebook.com/arielleforafrica?_rdc=1&_rdr" class="fa fa-facebook"></a>
					<a href= "https://twitter.com/arielleltd?lang=en"><i class="fa fa-twitter"></i></a>
					<a href= "https://ke.linkedin.com/company/arielle-for-africa-ltd" class="fa fa-linkedin"></a>
					<a href= "https://www.instagram.com/arielleforafrica/" class="fa fa-instagram" ></a>
					<a href="https://www.youtube.com/channel/UCm1OPwnZNIj6TPEn9NrukjQ" class="fa fa-youtube"> </a>
		
		</div>
		<div style="height: 2%; background: white ; margin: 0; padding: 0;">
		<p style="font-size: 10px; margin: 0; color: orange; text-align: right;">ARFA-EL v.prototype</p>
		<div>
	</div>
	
	<script>
var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) 
  {myIndex = 1}    
  x[myIndex-1].style.display = "block";  
  setTimeout(carousel, 5000); // Change image every 2 seconds
}
</script>
    </body>
</html>

