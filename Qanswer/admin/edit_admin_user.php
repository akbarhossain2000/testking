<?php
include_once("dbconnect.php");
$base = new Dmodel();
if(isset($_GET['e_id'])){
	$euid = $_GET['e_id'];
	$user_login = $base->eachloginData($euid);
}
if(isset($_POST['update'])){
	
	extract($_POST);
	if($curr_password != "" && $new_password != ""){
		if($c_pass == sha1($curr_password)){
			$sqlchange = "UPDATE admin_login SET user_name='$user_name', password='".sha1($new_password)."', user_type='$user_type' WHERE id='$uid'";
			if($base->_updateData($sqlchange)){
				print '<script>alert("Update successfully!");</script>';
			}else{
				print '<script>alert("Update Failed!");</script>';
			}
		}else{
			echo "Current Password Not Match!";
		}
		
	}else{
		$sql = "UPDATE admin_login SET user_name='$user_name', user_type='$user_type' WHERE id='$uid'";
		
		if($base->_updateData($sql)){
			print '<script>alert("Update successfully!");</script>';
		}else{
			print '<script>alert("Update Failed!");</script>';
		}
	}
}

?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Edit admin user</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/main.css">
		
		<style type="text/css">
			.change_pass{
				display:none;
			}
		</style>
    </head>
    <body>
		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3 id="msg"></h3>
					<div class="uiForm">
						<form action="edit_admin_user.php" method="post">
						<input type="hidden" name="uid" id="uid" value="<?php echo @$euid; ?>" />
						<input type="hidden" name="c_pass" id="c_pass" value="<?php echo @$user_login[0]['password']; ?>" />

						<div class="form-group">
							<label class="control-label" for="textinput">User Type :</label>
							<div class="input_box">
								<select name="user_type" id="user_type">
									<?php
										if($user_login[0]['user_type'] == "SA") {
											echo '<option value="'.@$user_login[0]['user_type'].'" selected="selected">Super Admin</option>';
											echo '<option value="NA">Admin</option>';
										}else if($user_login[0]['user_type'] == "NA"){
											echo '<option value="'.@$user_login[0]['user_type'].'" selected="selected">Admin</option>';
											echo '<option value="SA">Super Admin</option>';
										}else{
											echo '<option value="">--- Select User Type</option>';
											echo '<option value="SA">Super Admin</option>';
											echo '<option value="NA">Admin</option>';
										}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="textinput">User Name :</label>
							<div class="input_box">
								<input type="text" id="user_name" name="user_name" required value="<?php echo @$user_login[0]['user_name']; ?>" class="form-control input-md"/>

							</div>
						</div>

						<div class="checkbox">
							<label>
								<input type="checkbox" name="pass_change" id="pass_change" />
								If you change password please checked
							</label>
						</div>

						<div class="change_pass">
							<div class="form-group">
								<label class="control-label" for="curr_password">Current Password :</label>
								<div class="input_box">
									<input type="password" id="curr_password" name="curr_password" maxlength="30" class="form-control input-md"/>

								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="new_password">New Password :</label>
								<div class="input_box">
									<input type="password" id="new_password" name="new_password" maxlength="30" class="form-control input-md"/>
								</div>
							</div>
						</div>


						<div class="s_button">
							<input type="submit" value="Update" id="update" name="update" class="btn btn-primary"/>
						</div>
						</form>

					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
		
		window.onunload = refreshParent;
			function refreshParent() {
				
				window.opener.location.reload(true);
			
				window.setInterval(self.close(), 1000);
				
			}
		
					
		$( window ).on( "load", function() {
			$('#pass_change').click(function(){
				if($(this).is(':checked')){
					$(".change_pass").fadeIn(600);
					$("#curr_password").attr("required", true);
					$("#new_password").attr("required", true);
				} else {
					$(".change_pass").fadeOut(600);
					$("#curr_password").removeAttr("required");
					$("#new_password").removeAttr("required");
				}
			});
			
			
			
			
		});

		</script>
		

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
