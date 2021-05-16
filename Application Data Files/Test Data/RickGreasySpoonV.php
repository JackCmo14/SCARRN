<?php
	ob_start();

include '../includes/connect.php';
$success=false;

global $username;
global $password;

$username = $_POST['username'];
$password = $_POST['password'];

	$con2=mysql_connect("localhost","root","Hacklab1") or die ("DOWN!");
		if ($con2) {
			mysql_select_db("greasy",$con2);
		}
		else
		{
			die("DOWN");
		}


	$query = mysql_query("SELECT * FROM users WHERE username='$username' AND role='Customer';");
	$rows = mysql_num_rows($query);
	$row = mysql_fetch_array($query);

	$result = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='Customer';");

	while($row = mysqli_fetch_array($result))
	{
	$success = true;
	$user_id = $row['id'];
	$name = $row['name'];
	$role= $row['role'];
	$userimage= $row['image'];
	}

	if($success == true)
	{
		session_start();
		$_SESSION['customer_sid']=session_id();
		$_SESSION['user_id'] = $user_id;
		$_SESSION['role'] = $role;
		$_SESSION['name'] = $name;
		$_SESSION['userimage'] = $userimage;
		header("location: ../index.php");
	}
	else
	{
		header("location: ../login.php");
	}

?>
