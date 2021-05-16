<?php
Global $username;
Global $password;
Global $rows;
session_start();

if(isset($_POST['user_login']))
{
    $username=$_POST['user_email'];
    $password=$_POST['user_password'];

$con=mysql_connect("localhost","root","Hacklab1") or die ("DOWN!");
mysql_select_db("edgedata",$con);

include 'sqlcm_filter.php';
include 'sqlcm.php';
include 'username.php';
include 'cookie.php';

if($stmt = $con->prepare("select * from users WHERE user_email=?")) {
  $stmt->bind_param('s', $_POST['user_email']);
  $stmt->execute();
  $stmt->store_result();
  if($stmt->num_rows>0){
    $stmt->bind_result($id, $password);
    $stmt->fetch();
    if(password_verify($_POST['user_password'],$password)){
      session_regenerate_id();
      $_SESSION['user_email']=$rows['user_email'];
      echo "<script>alert('You're successfully logged in!')</script>";
    	echo "<script>window.open('customers/index.php','_self')</script>";
    }
    else{
      echo "<script>alert('Email or password is incorrect!')</script>";
    echo "<script>window.open('index.php','_self')</script>";
    }
  }
  $stmt->close();
}
		 exit();

}
?>
