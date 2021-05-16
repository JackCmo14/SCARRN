<div class="alert alert-info">Please Enter The Details Below</div>
<div class="lgoin_terry">
<form method="post" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="inputPassword">Username</label>
			<div class="controls">
			<input type="text" name="username"  placeholder="Username" required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Password</label>
			<div class="controls">
			<input type="password" name="password" placeholder="Password" required>
			</div>
		</div>
		<div class="control-group">

			<div class="controls">
			<div class="please">Please fill in the fields</div>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
			<button name="submit1" type="submit" class="btn btn-info"><i class="icon-signin icon-large"></i>&nbsp;Login</button>
			</div>
		</div>

<?php
session_start();
if (isset($_POST['submit1'])){
global $username;
global $password;
$username = $_POST['username'];
$password = $_POST['password'];

	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}

		return mysql_real_escape_string($str);
	}

$username='"'.$username.'"';

include 'sqlcm_filter.php';

//SQL countermeasure.
include 'sqlcm.php';

//user enumeration...
include 'username.php';

if($stmt = $con->prepare("select * from members WHERE username=?")) {
  $stmt->bind_param('s', $_POST['username']);
  $stmt->execute();
  $stmt->store_result();
  if($stmt->num_rows>0){
    $stmt->bind_result($id, $password);
    $stmt->fetch();
    if(password_verify($_POST['password'],$password)){
      session_regenerate_id();
			$_SESSION['id']=$row['member_id'];
			$_SESSION['username']=$username;
			$_SESSION['password']=$password;
    }
  }
  $stmt->close();
}
?>
	<script>
	window.location="dasboard.php";
	</script>
	<?php	}
		else{ ?>
		<div class="alert alert-danger"><strong>Login Error!</strong>&nbsp;Please check your Username and Password</div>
	<?php
	}
		}
?>
	</form>
	</div>
