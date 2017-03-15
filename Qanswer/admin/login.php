<?php
include_once("dbconnect.php");
$base = new Dmodel();

if(isset($_POST['login'])){
	extract($_POST);
	
	$sql = "SELECT * FROM admin_login WHERE user_name='$user_name' AND password='".sha1($password)."' AND user_type='SA'";
	
	$sql1 = "SELECT * FROM admin_login WHERE user_name='$user_name' AND password='".sha1($password)."' AND user_type='NA'";
	
	if($base->logIn($sql)){
		session_start();
		$_SESSION['isLogin'] = "login";
		$_SESSION['user_type'] = "SA";
		$_SESSION['user_name'] = $_POST['user_name'];
		header("location: index.php");
	}else if($base->logIn($sql1)){
		session_start();
		$_SESSION['isLogin'] = "login";
		$_SESSION['user_type'] = "NA";
		$_SESSION['user_name'] = $_POST['user_name'];
		header("location: index.php");
	}else{
		echo "Invalid Username or password!";
	}
}


?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/responsive.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
		
		<!-- Top Header -->
			<section id="login_header">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="top-header">
								<h1>FOR ADMIN LOGIN</h1>
							</div>
						</div>
					</div>
				</div>
			</section>
		<!-- End Top Header -->
		
		<!-- Login Body ---> 
			<section id="login_body">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="form_login">
								<div class="login-title">
									<h3>Please Sign In</h3>
								</div>
								<div class="panel-body">
									<form action="login.php" method="post">
										<fieldset>
											<div class="form-group">
												<input class="form-control" placeholder="Enter User Name" name="user_name" type="text">
											</div>
											<div class="form-group">
												<input class="form-control" placeholder="Enter Password" name="password" type="password" value="">
											</div>
													
											<div class="checkbox">
												<label>
													<input name="remember" type="checkbox" value="Remember Me"> Remember Me
												</label>
											</div>
											<div class="login_button">
												<button type="submit" name="login" class="btn btn-lg btn-primary">Login</button>
											</div>
													
										</fieldset>
									</form>
								</div>
									
							</div>
						</div>
					</div>
				</div>
			</section>
		<!-- End Login Body -->
		
		<!-- Footer -->
		
			<footer id="bottom-footer">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="login-footer">
								<p>&copy; 2015 All right reserved</p>
							</div>
						</div>
					</div>
				</div>
			</footer>
		
		<!-- End Footer -->
		
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.min.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>
