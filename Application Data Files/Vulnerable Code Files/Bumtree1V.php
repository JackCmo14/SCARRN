<?php
	ob_start();
	session_start();
	$pageTitle = 'Login';
	if (isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	include 'init.php';

global $username;
global $password;

	// Check If Coming From HTTP Post Request
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['login'])) {

			$username= $_POST['username'];
			$password = $_POST['password'];

		$con=mysql_connect("localhost","root","Hacklab1") or die ("DOWN!");
		if ($con) {
			mysql_select_db("shop",$con);
		}
		else
		{
			die("DOWN");
		}

	$query = mysql_query("select * from users where Username='$username' ") or die(mysql_error());
	$rows = mysql_num_rows($query);
	$row = mysql_fetch_array($query);

	$query = mysql_query("select * from users where Username='$username' and Password='$password'") or die(mysql_error());
	$rows = mysql_num_rows($query);
	$row = mysql_fetch_array($query);


			if ($rows > 0) {
				$_SESSION['user'] = $username; // Register Session Name
				$_SESSION['uid'] = $row['UserID']; // Register User ID in Session
				header('Location: index.php'); // Redirect To Dashboard Page
				exit();
			}

		} else {
		#This is registration stuff.....
			$formErrors = array();
			$username 	= $_POST['username'];
			$password 	= $_POST['password'];
			$password2 	= $_POST['password2'];
			$email 		= $_POST['email'];

			if (isset($username)) {
				$filterdUser = $username;
				if (strlen($filterdUser) < 4) {
					$formErrors[] = 'Username Must Be Larger Than 4 Characters';
				}
			}

			if (isset($password) && isset($password2)) {
				if (empty($password)) {
					$formErrors[] = 'Sorry Password Cant Be Empty';
				}
				if (($password) !== ($password2)) {
					$formErrors[] = 'Sorry Password Is Not Match';
				}
			}

			// Check If There's No Error Proceed The User Add
			if (empty($formErrors)) {
				// Check If User Exist in Database
				$check = checkItem("Username", "users", $username);
				if ($check == 1) {
					$formErrors[] = 'Sorry This User Is Exists';
				} else {
					// Insert Userinfo In Database
					$stmt = $con->prepare("INSERT INTO
											users(Username, Password, Email, RegStatus, Date)
										VALUES(:zuser, :zpass, :zmail, 0, now())");
					$stmt->execute(array(

						'zuser' => $username,
						'zpass' => $password,
						'zmail' => $email
					));
					// Echo Success Message
					$succesMsg = 'Congrats You Are Now Registerd User';
				}
			}
		}
	}
?>

<div class="container login-page">
	<h1 class="text-center">
		<span class="selected" data-class="login">Login</span> |
		<span data-class="signup">Signup</span>
	</h1>
	<!-- Start Login Form -->
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
			<input
				class="form-control"
				type="text"
				name="username"
				autocomplete="off"
				placeholder="Type your username"
				required />
		</div>
		<div class="input-container">
			<input
				class="form-control"
				type="password"
				name="password"
				autocomplete="new-password"
				placeholder="Type your password"
				required />
		</div>
		<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
	</form>
	<!-- End Login Form -->
	<!-- Start Signup Form -->
	<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
			<input
				pattern=".{4,}"
				title="Username Must Be Between 4 Chars"
				class="form-control"
				type="text"
				name="username"
				autocomplete="off"
				placeholder="Type your username"
				required />
		</div>
		<div class="input-container">
			<input
				minlength="4"
				class="form-control"
				type="password"
				name="password"
				autocomplete="new-password"
				placeholder="Type a Complex password"
				required />
		</div>
		<div class="input-container">
			<input
				minlength="4"
				class="form-control"
				type="password"
				name="password2"
				autocomplete="new-password"
				placeholder="Type a password again"
				required />
		</div>
		<div class="input-container">
			<input
				class="form-control"
				type="email"
				name="email"
				placeholder="Type a Valid email" />
		</div>
		<input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
	</form>
	<!-- End Signup Form -->
	<div class="the-errors text-center">
		<?php
			if (!empty($formErrors)) {
				foreach ($formErrors as $error) {
					echo '<div class="msg error">' . $error . '</div>';
				}
			}
			if (isset($succesMsg)) {
				echo '<div class="msg success">' . $succesMsg . '</div>';
			}
		?>
	</div>
</div>
<?php
	include $tpl . 'footer.php';
	ob_end_flush();
?>
