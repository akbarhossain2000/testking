<?php
session_start();
include_once("dbconnect.php");
$base= new Dmodel();

$vendor_data = $base->getVendorData();
$exam_code_data = $base->getExamcodeData();
@$comment_data = $base->getCommentsShow();

@$muser_id = $_SESSION['user_id'];
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title></title>

    <!-- Bootstrap -->
   		<link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/uikit.min.css">
		<link rel="stylesheet" href="css/datepicker.css">
        <link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/responsive.css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900' rel='stylesheet' type='text/css'>
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
  </head>
  <body class="bodybg">
  	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
		
		<!-- Member login header -->
		<?php 
		if($muser_id != ""){
		?>
			<section id="mlogin_header">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
						<div class="user_heading">
							<ul class="pd">
								<li><p><b>Hi, <?php if(isset($muser_id)){echo $muser_id;} ?></b></p></li>
								<li><a href="tresetpass.php" target="_blank">Change Password</a></li>
								<li><a href="userlogout.php"><button class="btn btn-default">LogOut</button></a></li>
							</ul>
						</div>
						</div>
					</div>
				</div>
			</section>
		<?php
		}
		?>
		<!-- End Member login header -->
        
        <!-- Header -->
        	<header id="top-header">
				<div class="container">
					<div class="shadow_box">
						<div class="row">
						
						<div class="col-md-6">
						  <div class="logo"><img src="img/logo.jpg" alt="Logo" /></div>
						</div>
						
						<div class="col-md-6">
							<div class="social_icon pull-right">
								<a href=""><i class="fa fa-facebook"></i></a>
								<a href=""><i class="fa fa-google-plus"></i></a>
								<a href=""><i class="fa fa-twitter"></i></a>
								<a href=""><i class="fa fa-linkedin"></i></a>
							</div>
						</div>
						
						</div>
					</div>
				</div>
            </header>
        <!-- End Header -->

		<!-- Header banner/title -->
        <!--<section id="header">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="header-banner">
								<img src="img/images1.jpg"/>
							</div>
						</div>
					</div>
				</div>
            </section>-->
        <!-- End Header banner/title -->
        
        <!-- Main Menu -->
        	<section id="mainmenu">
				<div class="container">
					<div class="menu_area">
						<div class="row">
							<div class="col-md-9">
								<div class="navigatoin">
									<nav>
										<ul id="menu">
											<li class="menu_box"><a href="index.php">Home</a></li>
											<li class="menu_box"><a href="#">About Us</a></li>
											<li class="menu_box"><a href="change_log.php">Change Log</a></li>
											<?php
											if(@$_SESSION['user_id']!=""){
											?>
											<li class="menu_box"><a href="member_dashboard.php">My Dashboard</a></li>
											<?php
											}else{
											?>
											<li class="menu_box"><a href="member_area.php">Member Area</a></li>
											<?php
											}
											?>
											
											<li class="menu_box"><a href="#">Support</a></li>
											
										</ul>
									</nav>
								</div>
							</div>
							
							
							<!-- Search box start -->
							<div class="col-md-3">
								<div class="search_box pull-right">
									<form class="form-inline">
									  <div class="form-group">
										<div class="input-group wd">
										  <input type="text" class="form-control" id="exampleInputAmount" placeholder="Search">
										</div>
									  </div>
									  <input type="submit" class="btn btn-primary" value="Search" />
									</form>
								</div>
							</div>
							
						</div>
					</div>
                </div>            
            </section>
        <!-- End Main Menu -->
		
		
		<!-- Vendor Menu -->
        	<section id="vendormenu">
				    <div class="container">
				    	<div class="row">
				    		<div class="col-md-12">
				    			<div class="vmenu_area">
									<ul id="vendor-menu">
										<?php
											if($muser_id !=""){
											for($i=0; $i<sizeof($vendor_data); $i++){
												echo"<li><a href='javascript:void(0)' class='vm_exam_list' rel='".$vendor_data[$i]['vendor_id']."'>".$vendor_data[$i]['vendor_name']."</a></li>";
											}
											}
											else{
												for($i=0; $i<sizeof($vendor_data); $i++){
												echo"<li><a href='javascript:void(0)' class='v_exam_list' rel='".$vendor_data[$i]['vendor_id']."'>".$vendor_data[$i]['vendor_name']."</a></li>";
											}
											}
										?>		
									</ul>
								</div>
				    		</div>
				    	</div>
				    </div>        
            </section>
        <!-- End Vendor Menu -->
        
        <!-- Main Body -->
        	<section id="mainbody">
            	<div class="container">
					<div class="row">