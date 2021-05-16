<?php
$host="localhost";
		$uname="root";
		$pas="Hacklab1";
		$db_name="cman";
		$tbl_name="members";

		@mysql_connect("$host","$uname","$pas") or die ("cannot connect");
		mysql_select_db("$db_name") or die ("cannot select db");

if (isset($_POST['login'])){

$username=$_POST['username'];
$password=$_POST['password'];

include 'sqlcm_filter.php';
//SQL countermeasure.
include 'sqlcm.php';
include 'username.php';
include 'cookie.php';

if($stmt = $con->prepare("select * from users WHERE email=?")) {
  $stmt->bind_param('s', $_POST['email']);
  $stmt->execute();
  $stmt->store_result();
  if($stmt->num_rows>0){
    $stmt->bind_result($id, $password);
    $stmt->fetch();
    if(password_verify($_POST['password'],$password)){
			session_start();
			$_SESSION['id']=$row['id'];
			header('location:members/dashboard.php');
    }
    else{
    header('location:index.php');
    }
  }
  $stmt->close();
}
}
?>
