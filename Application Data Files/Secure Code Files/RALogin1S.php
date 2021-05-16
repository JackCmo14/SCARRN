<?php
session_start();
global $username;
global $password;

include "includes/connection.php";

//$msg = "";
$form_user = $_POST['txtusername'];
$form_password = $_POST['txtpassword'];

	if($form_user  == "" || $form_password == "")
	{
		echo '<script>alert("Please Fill up all fields!");</script>';
		echo "<script>window.location.href='default.php';</script>";	
		exit;
	}
	
$username = $_POST['txtusername'];
$password = $_POST['txtpassword'];


	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}

include 'sqlcm_filter.php';

	//Store values in the tblChatUsers
	$dbconnect = new DbConnect();
	$dbconnect->open();
	$sql = "SELECT user_id, username, password, ac_type, user_status, thumbnail FROM `users` WHERE username = '$username';";
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
	$sql = "SELECT user_id, username, password, ac_type, user_status, thumbnail FROM `users` WHERE username = '$username' AND password = '$password';";
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