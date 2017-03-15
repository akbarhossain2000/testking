<?php
session_start();
if(isset($_SESSION['login']) && $_SESSION['user_type'] !="U"){
	header("location: member_area.php");
}
$_SESSION['isLogin'];
$_SESSION['user_type'];
$_SESSION['isActive'];
$user_id = $_SESSION['user_id'];

include_once("dbconnect.php");
$base = new Dmodel();



if(isset($_POST['btn-reset-pass'])) {

	$cur_pass = sha1($_POST['cur_pass']);
	$new_pass = sha1($_POST['new_pass']);
	$re_new_pass = sha1($_POST['re_new_pass']);
	
	echo $sql_count = "SELECT * FROM login_info WHERE user_name='$user_id' AND password='$cur_pass'";
	if($base->getCountId($sql_count)) {
		if($new_pass==$re_new_pass) {
			echo $sql = "UPDATE login_info SET password='$new_pass' WHERE user_name='$user_id'";
			if($base->_updateData($sql)==1) {
				$err = "Password changed successfully!!";
			}
		} else {
			$err = "Password Missmatched!!";
		}
	} else {
		$err = "Invalid current password!!";
	}
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Password Reset</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body id="login">
    <div class="container">
    	<div class='alert alert-success'>
			<strong>Hello !</strong>  <?php echo $user_id; ?> you are here to reset your forgetton password.
		</div>
        <form class="form-signin" method="post" action="">
        <h3 class="form-signin-heading">Password Reset.</h3><hr />
        <?php
        if(isset($err))
		{
			echo "<p>$err</p>";
		}
		?>
        <div class="form-group">
			<input type="password" class="form-control" placeholder="Curren Password" name="cur_pass" required />
		</div>
        <div class="form-group">
			<input type="password" class="form-control" placeholder="New Password" name="new_pass" required />
		</div>
        <div class="form-group">
		<input type="password" class="form-control" placeholder="Confirm New Password" name="re_new_pass" required />
		</div>
     	<hr />
        <input class="btn btn-large btn-primary" type="submit" name="btn-reset-pass" value="Reset Your Password"/>        
      </form>

    </div> <!-- /container -->
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>