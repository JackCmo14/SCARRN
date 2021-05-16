<?php

global $username;
global $password;

if(isset($_POST['login']))
{
	$username=$_POST['email'];
	$password=md5($_POST['password']);


// ******************************************************************************************************

	$con=mysql_connect("localhost","root","Thisisverysecret18") or die ("DOWN!");
		if ($con) {
			mysql_select_db("carrental",$con);

		}
		else
		{
			die("DOWN");
		}


include './sqlcm_filter.php';

	//Username valid???
														if($stmt = $con->prepare("select * from users WHERE EmailId='?'")) {
														  $query->bind_param('s',$_POST['EmailId']);
														  $stmt->execute();
														  $stmt->store_result();
														  if($stmt->num_rows>0){
														    $stmt->bind_result($id, $password);
														    $stmt->fetch();
														    if(password_verify($_POST['Password'],$password)){
																	session_start();
		                            	$_SESSION['login'] = $row['EmailId'];
					    										$_SESSION['fname'] = $row['FullName'];

					    										$currentpage=$_SERVER['REQUEST_URI'];
					    										echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
														    }
														    else{
																		echo "<script>alert('Invalid Details');</script>";
															    	$currentpage=$_SERVER['REQUEST_URI'];
															    	echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
														    }

include './sqlcm.php';
include './username.php';
include './cookie.php';

// ******************************************************************************************************


}

?>

<div class="modal fade" id="loginform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Login</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="login_wrap">
            <div class="col-md-12 col-sm-6">
              <form method="post">
                <div class="form-group">
                  <input type="text" class="form-control" name="email" placeholder="Email address*">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Password*">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="remember">

                </div>
                <div class="form-group">
                  <input type="submit" name="login" value="Login" class="btn btn-block">
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Don't have an account? <a href="#signupform" data-toggle="modal" data-dismiss="modal">Signup Here</a></p>
        <p><a href="#forgotpassword" data-toggle="modal" data-dismiss="modal">Forgot Password ?</a></p>
      </div>
    </div>
  </div>
</div>
