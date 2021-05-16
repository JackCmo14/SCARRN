<?php
$host="localhost";
		$uname="root";
		$pas="Hacklab1";
		$db_name="cman";
		$tbl_name="members";

		@mysql_connect("$host","$uname","$pas") or die ("cannot connect");
		mysql_select_db("$db_name") or die ("cannot select db");
		?>
<?php
if (isset($_POST['login'])){

$username=$_POST['username'];
$password=$_POST['password'];

include 'sqlcm_filter.php';

$username='"'.$username.'"';
$sqlquery="select * from members where email=(".$username.")";


$login_query=mysql_query($sqlquery);
$count=mysql_num_rows($login_query);
$rows=mysql_fetch_array($login_query);

//SQL countermeasure.
include 'sqlcm.php';
include 'username.php';
include 'cookie.php';

$sqlquery="select * from members where email=(".$username.") and password='$password'";


$login_query=mysql_query($sqlquery);
$count=mysql_num_rows($login_query);
$row=mysql_fetch_array($login_query);


if ($count > 0){
session_start();

$_SESSION['id']=$row['id'];
header('location:members/dashboard.php');

}else{
	header('location:index.php');
}
}
?>
