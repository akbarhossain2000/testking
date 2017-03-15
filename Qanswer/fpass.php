<?php
session_start();
if(isset($_SESSION['login'])){
	header("location: member_dashboard.php");
}
include_once("dbconnect.php");
$base = new Dmodel();

if(isset($_POST['btn-submit'])) {
	$email = $_POST['txtemail'];
	
	$pass = randPass();
	$sha1pass = sha1($pass);
	if(sendMail($email, $pass)) {
		$qry = "UPDATE member_info, user_authentication_info, login_info SET login_info.password='$sha1pass' WHERE member_info.email='$email' AND user_authentication_info.email='$email' AND user_authentication_info.isActive='Y' AND login_info.user_name = user_authentication_info.user_id";
		if($base->_updateData($qry)){
		echo "Password has been sent to your email";
		//echo $mailtext = "This is your new password: $pass";
		}
	} else {
		echo "Invalid email ID!!";
	}
	
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Forgot Password</title>
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

      <form class="form-signin" method="post" action="">
        <h2 class="form-signin-heading">Forgot Password</h2><hr />
        
        	<?php
			if(isset($msg))
			{
				echo $msg;
			}
			else
			{
				?>
              	<div class='alert alert-info'>
				Please enter your email address. You will receive a link to create a new password via email.!
				</div>  
                <?php
			}
			?>
        
        <input type="email" class="form-control" placeholder="Email address" name="txtemail" required />
     	<hr />
        <input class="btn btn-danger btn-primary" type="submit" name="btn-submit" value="Generate new Password" />
      </form>

    </div> <!-- /container -->
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

<?php
function randPass()
{
	$alphanum = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$len = 15;
	$str_len = strlen($alphanum)-1;
	
	$rand_pass = "";
	
	while(strlen($rand_pass)<=$len) 
	{
		$r = rand(0, $str_len);
		$rand_pass .= $alphanum{$r};
	}
	
	return $rand_pass;
}

function sendMail($email, $pass)
{
	//ini_set("sendmail_from","info@genuitysystems.com");
	//ini_set("SMTP","mail.dhakatel.com");
	//ini_set("smtp_port","25");
	$to = $email;
	$subject = "Password Recovery Mail";
	$headers = "MIME-Version: 1.0\n";
	//$headers .= "Bcc: $bcc\n";
    $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
	$headers .= 'From: webrahaman@gmail.com' . "\r\n";
	$headers .= "X-Priority: 3\r\n";
	$headers .= "X-Mailer: smail-PHP ".phpversion()."\r\n";
	
	$mailtext = "This is your new password: $pass";

	if(@mail($to, $subject, $mailtext, $headers)) {
		return true;
	} else {
		return false;
	}
}
?>