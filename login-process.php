<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'arfa';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ($stmt = $con->prepare('SELECT PASSWORD, NAME, SURNAME, TYPE_OF_USER, STATUS, EMAIL, USER_TYPE, ID FROM user_registration WHERE EMAIL = ?')) {
$userid = $_POST['email'];
$stmt->bind_param('s', $userid);
$stmt->execute();
$stmt->store_result();
echo $userid;
if ($stmt->num_rows > 0) {
$stmt->bind_result($password, $name, $surname, $type, $status, $email, $user_type, $id);
$stmt->fetch();
if ($_POST['password'] === $password ) {
if ( $status == 'ACTIVE') {
session_regenerate_id();
$_SESSION['loggedin'] = TRUE;
$_SESSION['name'] = $name;
$_SESSION['surname'] = $surname;
$_SESSION['type'] = $type;
$_SESSION['email'] = $email;

if ($type === 'STUDENT') {
header('Location: student-home.php');

} elseif ($type === 'STAFF') {
header('Location: staff-home.php');

}
} else {

echo '<script type="text/javascript"> alert("YOU ARE BLOCKED, CONTACT SKHAFTINI FOR MORE INFO"); window.location = "index.php";</script>';

}
} else {

echo '<script type="text/javascript"> alert("PASSWORD INCORRECT"); window.location = "index.php";</script>';

}
} else {
echo '<script> alert("PHONE_NUMBER INCORRECT");  window.location = "index.php";</script>';

}


$stmt->close();
}
?>
