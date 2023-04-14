<?php 
session_start();
require 'config/db.php';
require_once 'controllers/emailController.php';

$errors= array();
$username  = "";
$email = "";

//if user clicks the sign up button

if (isset ($_POST['email'])){

    $name = $_POST['name'];
	$surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
	$account = $_POST['account'];
	$program = $_POST['program'];

	$t = '';
	if ($account == 'STUDENT')
	{
		$t = 2;
	} elseif ($account == 'STAFF') {
		$t = 1;
	} else {
		$t = 3;
	}

    //validation
    if (empty($name)){
        $errors['name']= "name required";
   }
   
    if (empty($surname)){
        $errors['surname']= "surname required";
   }

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email']= "Entered Email address is invalid";
	
    }

   if (empty($email)){
        $errors['email']= "Email required";
    }

 
  if (empty ($password)){
            $errors['password']= "The password is required";
       }
    if ($password !== $passwordConf){
    $errors['password']= "The two passwords did not match";
    }
  

   $emailQuery = "SELECT * FROM user_registration WHERE email=? LIMIT 1";

   $stmt = $conn->prepare($emailQuery);
   $stmt->bind_param('s', $email);
   $stmt->execute();
   $result = $stmt->get_result();
   $userCount = $result->num_rows;
   $stmt->close();

   if ($userCount > 0){

        $errors['email'] = "Email already exists";
   }

   if (count($errors) === 0){

    $password = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(50));
	$verified = 1;
    $sql = "INSERT INTO user_registration (NAME, SURNAME, EMAIL, PASSWORD, TOKEN,TYPE_OF_USER,USER_TYPE,VERIFIED) VALUES (?,?,?,?,?,?,?,1)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssss', $name, $surname,$email, $password, $token,$account,$t);
	
	foreach ( $program as $pid)
	{
	
	$sql2 = "INSERT INTO user_program (EMAIL, PID) VALUES (?,?)"; 
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param('ss', $email,$pid);
	$stmt2->execute();
	}
	

    if ($stmt->execute() && $stmt2->execute()){

	
		 

        //login user
        $user_id = $conn-> insert_id;
        $_SESSION['id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['verified'] = $verified;

          //send email
         sendVerificationEmail($email, $token);

        //set flash message
        $_SESSION ['message'] = "Check email for verification";
        $_SESSION ['alert-class'] ="alert-success";
        header ('location: confirm.php');
        exit();

    }else{

        $errors['db_error'] = "Database error: failed to register";
    }
}


}
?>