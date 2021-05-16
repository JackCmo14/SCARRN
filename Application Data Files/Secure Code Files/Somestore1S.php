<?php
GLobal $username;
Global $password;
Global $rows;

//include config.php to connect to the database
	include("config.php");

	//start session
    session_start();

		// Define $myusername and $mypassword
$username=$_POST['magaca'];
$password=$_POST['furaha'];

include 'sqlcm_filter.php';
//SQL countermeasure.
include 'sqlcm.php';
include 'username.php';
include 'cookie.php';

if($stmt = $con->prepare("select * from users WHERE Email=?")) {
  $stmt->bind_param('s', $_POST['magaca']);
  $stmt->execute();
  $stmt->store_result();
  if($stmt->num_rows>0){
    $stmt->bind_result($id, $password);
    $stmt->fetch();
    if(password_verify($_POST['furaha'],$password)){
      session_regenerate_id();
      $_SESSION['magaca']=$rows['magaca'];
      header("location: index.php");
    }
    else{
      header('Location: login.php');
    }
  }
  $stmt->close();
}
?>
