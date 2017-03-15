<?php
session_start();
	if(!isset($_SESSION['isLogin']) && ($_SESSION['user_type']!='SA' || $_SESSION['user_type']!='NA') ){
		
		header("location: login.php");
	}
    @$_SESSION['user_name'];
	
?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Panel</title>
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
        <!-- Header -->
			<section id="header">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-2">
							<div class="row">
								<div class="logo">
									<a href="#"><img src="img/logo.jpg" alt="" /></a>
								</div>
							</div>

						</div>
						<div class="col-md-8">
							<div class="header-title">
								<h1>Welcome to Admin Panel</h1>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="logout pull-right">
								<a href="logout.php" class="btn btn-logout">LogOut</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		
		<!-- End Header -->
		
		<!-- Main Body -->
		
			<section id="main-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-3">
							<div class="row">
								<div class="side-menu">
								<nav>
									<ul id="sidemenu">
										<li><a href="index.php">Home</a></li>
										<li><a href="add_vendor.php">Add Vendor</a></li>
										<li><a href="add_exam_code.php">Add Exam Code</a></li>
										<li><a href="add_question_answer.php">Add Question & Answer</a></li>
										<li><a href="view_vendor.php">View Vendor</a></li>
										<li><a href="view_exam_code.php">View Exam Code</a></li>
										<li><a href="view_ques_ans.php">View Question & Answer</a></li>
										<?php
										 if($_SESSION['user_type'] == "SA") {
										?>
										<li><a href="create_admin_user.php">Create Admin User</a></li>
										<?php
										 }
										?>
										<li><a href="#">Link</a></li>
									</ul>
								</nav>
							</div>
							</div>
						</div>
						<div class="col-md-9">