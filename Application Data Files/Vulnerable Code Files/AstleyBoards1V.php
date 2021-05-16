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

$username='"'.$username.'"';

    $sql=mysql_query("select * from users WHERE user_email=(".$username.")");

    $rows= mysql_fetch_array($sql);

    $sql=mysql_query("select * from users WHERE user_email=(".$username.") AND user_password='$password'");

    $rows=mysql_fetch_array($sql);

if($rows>0)
    {
	echo "<script>alert('You're successfully logged in!')</script>";
	echo "<script>window.open('customers/index.php','_self')</script>";
	$_SESSION['user_email']=$rows['user_email'];
    }
    else
    {
        echo "<script>alert('Email or password is incorrect!')</script>";
		  echo "<script>window.open('index.php','_self')</script>";

		 exit();

    }
}
?>
