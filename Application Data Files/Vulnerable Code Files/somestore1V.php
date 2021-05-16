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
    $sql="select Cust_Id from customer where Email=('$username')";
    $row=mysqli_query($mysqli,$sql);
    $rows= mysqli_num_rows($row);
    $sql="select * from customer where Email=('$username') and Password='$password'";
    $row=mysqli_query($mysqli,$sql);
    $rows= mysqli_num_rows($row);
$rowarray=mysqli_fetch_array($row);
    if($rows>0)
    {
    $_SESSION['login_username']=$rowarray['Email'];
	 header("location: index.php");
    } else  {
	   header('Location: login.php');
    }
?>
