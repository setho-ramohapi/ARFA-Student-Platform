<?php

session_start();
require 'config/db.php';
require_once 'emailController.php';

$errors= array();
$username  = "";
$email = "";

//if user clicks the sign up button

if (isset ($_POST['signup-btn'])){

    $name = $_POST['name'];
	$surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
	$account = $_POST['account'];
	$t = '';
	if ($account == 'STUDENT')
	{
		$t = 2;
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
    $verified = false;

    $sql = "INSERT INTO user_registration (NAME, SURNAME, EMAIL, PASSWORD, TOKEN, VERIFIED,TYPE_OF_USER,STATUS,USER_TYPE) VALUES (?,?,?,?,?,?,?,'ACTIVE',?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssbss', $name, $surname,$email, $password, $token,$verified,$account,$t);


    if ($stmt->execute()){

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


//when user clicks login button
if (isset ($_POST['login-btn'])){

    $email = $_POST['email'];
    $password = $_POST['password'];


    //validation
    if (empty($email)){
        $errors['username']= "email required";
   }
 
  if (empty ($password)){
            $errors['password']= "The password is required";
       }

    

    if (count ($errors) === 0 ){

        $sql = 'SELECT * FROM user_registration WHERE EMAIL = ? LIMIT 1';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

    
        if (password_verify($password, $user['PASSWORD'])){
    
            //login the user
             
            
              $_SESSION['name'] = $user['NAME'];
			  $_SESSION['surname'] = $user['SURNAME'];
              $_SESSION['email'] = $user['EMAIL'];
              $_SESSION['verified'] = $user['VERIFIED'];
			  $_SESSION['type'] = $user['TYPE_OF_USER'];
			  $_SESSION['type'] = $user['TYPE_OF_USER'];
			  $_SESSION['user_type'] = $user['USER_TYPE'];
			  $_SESSION['id'] = $user['ID'];
			  $_SESSION['loggedin'] = true;
			if ($user['TYPE_OF_USER'] == "STUDENT")
			{
           
              header ('location: student-home.php');
              exit();
			} elseif ($user['TYPE_OF_USER'] == "STAFF") {
				header ('location: staff-home.php');
              exit();
			} else {
				header('location: faculty-home.php');
			}
			

            
    
        }else{
    
            $errors['login_fail'] = "Wrong credentials";
        }
    }


} 

//verify user by token

function verifyUser($token){




    global $conn;
    $sql = "SELECT * FROM user_registration Where token='$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);
        $update_query = "UPDATE user_registration SET verified=1 WHERE token='$token'";

        if (mysqli_query ($conn, $update_query)){

            //log user in
            //login the user
             
             $_SESSION['name'] = $user['NAME'];
			  $_SESSION['surname'] = $user['SURNAME'];
              $_SESSION['email'] = $user['EMAIL'];
   
            $_SESSION['verified'] = 1;
    
          
            header ('location: confirm.php');
            exit();
        }
        else{

            echo 'User not found';
        }
    }
}

//if user clicks on the forgot password button

if (isset ($_POST['forgot-password'])){

    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email']= "Entered Email address is  invalid";
        
        }
    
       if (empty($email)){
            $errors['email']= "Email required";
        }

        if (count($errors)== 0){

            $sql = "SELECT FROM user_registration WHERE email='$email' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_assoc($results);
            $token = $user['token'];
            sendPasswordResetLink ($email, $token);

            header('location: password_message.php');
            exit(0);
        }
}

//if user clicks the reset password button
if (isset($_POST['reset-password-btn'])){

    $password = $_POST ['password'];
    $passwordConf = $_POST['passwordConf'];

if (empty ($password) || empty ($passwordConf)){
        $errors['password']= "The password is required";
   }
if ($password !== $passwordConf){
$errors['password']= "The two passwords did not match";
}
$password = password_hash($password, PASSWORD_DEFAULT);
$email = $_SESSION['email'];

if (count($errors) == 0){

    $sql = "UPDATE user_registration SET password ='$password' WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result){

        header('location: confirm.php');
        exit(0);
    }
}


}

function resetPassword($token){


    global $conn;
    $sql = "SELECT * FROM user_registration WHERE token = '$token' LIMIT 1";

    $results = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $_SESSION['email']= $user['email'];

    header ('location:reset_password.php');
    exit(0);
}

?>