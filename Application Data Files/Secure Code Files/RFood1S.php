<?php
	//Start session
	session_start();
	global $username;
	global $password;
	//Include database connection details
	require_once('connection/config.php');
	//Array to store validation errors
	$errmsg_arr = array();
	//Validation error flag
	$errflag = false;
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
//Must use $username....
	//Sanitize the POST values
	$login = ($_POST['login']);
	$password = ($_POST['password']);
	$username=$login;
include 'sqlcm_filter.php';
$username='"'.$username.'"';
	$sql = "SELECT * FROM members WHERE login=("?")";
$sql->bind_param('s',$_POST['.username.'])
//SQL countermeasure.
include 'sqlcm.php';
include 'cookie.php';
include 'username.php';
ob_flush();
	//Create query
	$qry="SELECT * FROM members WHERE login=('?') AND passwd='?'";
	$qry->bind_param('s',$_POST['username'])
	$result=mysql_query($qry);
$login=$username;
	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result)!= 0) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['member_id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['firstname'];
			$_SESSION['SESS_LAST_NAME'] = $member['lastname'];
			$_SESSION['SESS_THUMBNAIL'] = $member['thumbnail'];
			session_write_close();
			header("location: member-index.php");
			exit();
		}else {
			//Login failed
			header("location: login-failed.php");
			exit();
		}
	}else {
		die("Query failed");
	}
?>
