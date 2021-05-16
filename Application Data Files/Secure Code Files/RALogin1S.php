<?php
session_start();
global $username;
global $password;

include "includes/connection.php";

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
	$str = @trim($str);
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysql_real_escape_string($str);
}

include 'sqlcm_filter.php';

if($stmt = $con->prepare("select * from users WHERE txtusername=?")) {
  $stmt->bind_param('s', $_POST['txtusername']);
  $stmt->execute();
  $stmt->store_result();
  if($stmt->num_rows>0){
    $stmt->bind_result($id, $password);
    $stmt->fetch();
    if(password_verify($_POST['txtpassword'],$password)){
      session_regenerate_id();
      $_SESSION['txtusername']=$rows['txtusername'];
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

	//Store values in the tblChatUsers
	$dbconnect = new DbConnect();
	$dbconnect->open();
	$sql = "SELECT * FROM `users` WHERE username = '?'";
	$sql->bind_param('s', $_POST['username'])
	$numrecs = 0;
	$dbquery = new DbQuery($sql);
	$result = $dbquery->query();
	$rows=$dbquery->numrows();
	$dbquery->freeresult();
	$dbquery->close();

echo $username;

//SQL countermeasure.
include 'sqlcm.php';
include 'username.php';
include 'cookie.php';

	//Store values in the tblChatUsers
	$dbconnect = new DbConnect();
	$dbconnect->open();
	$sql = "SELECT user_id, username, password, ac_type, user_status, thumbnail FROM `users` WHERE username = '?' AND password = '?'";
	$sql->bind_param('s', $_POST['username'])
	$numrecs = 0;
//	$username=$form_user;
	$dbquery = new DbQuery($sql);
	$result = $dbquery->query();



	$numrecs=$dbquery->numrows();
	while ($row = $dbquery->fetcharray())
	{
		$user_id = $row['user_id'];
		$username = $row['username'];
		$pass = $row['password'];
		$ac_type = $row['ac_type'];
		$status = $row['user_status'];
		$thumbnail = $row['thumbnail'];

		if(($status == "0") AND ($ac_type == "Administrator"))
		{
			$_SESSION['status'] = "admin";

			echo "<script>alert('Welcome Back Webmaster Redirecting to personal home page')</script>";
			echo "<script>window.location.href='adminarea/adminhome.php';</script>";
		}

		else if(($status == "1") AND ($ac_type == "user"))
		{
			$user_id = $row[0];
			$username = $row[1];
			echo "<script>alert('Welcome Back')</script>";
			echo "<script>window.location.href='index.php';</script>";
		}

		else
		{
			echo "<script>window.location.href='index.php';</script>";
		}
	}

	$dbquery->freeresult();
	$dbquery->close();


	if($numrecs==0)
	{
		echo '<script>alert("Password not found! \n\n");</script>';
		session_unset();
		session_destroy();
		echo "<script>window.location.href='default.php';</script>";
		//exit;
	}
	else
	{
		//store login information to trace user
		$_SESSION['username'] = $form_user;
		$User = $_SESSION['username'];
		$_SESSION['user_id'] = $user_id;
		$userid = $_SESSION['user_id'];
		//$status = $_SESSION['status'];
		$_SESSION['thumbnail'] = $thumbnail;
		$_SESSION['code'] = rand();

		//echo "<script>parent.reloadUsers();</script>";
		echo "<script>window.location.href='index.php';</script>";
		//exit;
	}

	//instantiate object of query class
	$dbquery = new DbQuery($sql);
	$dbquery->query();
	$dbquery->freeresult();
	$dbquery->close();
