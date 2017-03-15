<?php
include_once("header.php");
if(@$_SESSION['user_id'] == ""):
include_once("dbconnect.php");
$base = new Dmodel();
$db = $base->getDBConnection();
//print_r($db);
$msg="";
$error_message="";
/*User Login*/
if(isset($_POST['login'])){
	$login_user = htmlentities($db->real_escape_string($_POST['uid']));
	$login_pass = sha1($db->real_escape_string($_POST['pass']));
	
	$sql = "SELECT login_info.user_name, login_info. password FROM login_info, user_authentication_info, member_info WHERE login_info.user_name='".$login_user."' AND login_info.password='".$login_pass."' AND login_info.user_type='".htmlentities($db->real_escape_string('U'))."' AND user_authentication_info.user_id='".$login_user."' AND member_info.uname='".$login_user."'";
	
	$sql2 = "SELECT login_info.user_name, login_info.password FROM login_info, user_authentication_info, member_info WHERE user_authentication_info.user_id='".$login_user."' AND user_authentication_info.isActive='".htmlentities($db->real_escape_string('Y'))."'";
	
	if($base->userlogIn($sql)){
		if($base->userlogIn($sql2)){
		$_SESSION['isLogin'] 	= "login";
		$_SESSION['user_type'] 	= htmlentities($db->real_escape_string('U'));
		$_SESSION['isActive']	= htmlentities($db->real_escape_string('Y'));
		$_SESSION['user_id'] 	= htmlentities($db->real_escape_string($_POST['uid']));
		?>
		<script type="text/javascript">
			window.location.href = 'member_dashboard.php';
		</script>
		<?php
			//header("location: member_dashboard.php");
		}else{
			$error_message="Your Account is not activated, please activate your account!";
		}
	}else{
		$error_message="Invalid User Name or Password, Please Try again!";
	}

}

/* User Registration */
if(isset($_POST['submit'])):
	extract($_POST);
	if($_POST['captcha'] == $_SESSION['vercode']){
		$name = trim($_POST['fname']." ".$_POST['lname']);
		$email = trim($_POST['email']);
		$mobile = trim($_POST['phone']);
		$subject = 'Comfirm Verification';

		$to      = $email;

				
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: webrahaman@gmail.com' . "\r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-Mailer: smail-PHP ".phpversion()."\r\n";
						
		$activation = md5($email.time());
		$base_url = "http://localhost/testking/";
		
		echo $body='Hi, <br/> <br/> We need to make sure you are human. Please verify your email and get started using your Website account. <br/> <br/> <a href="'.$base_url.'activation.php?key='.$activation.'">'.$base_url.'activation.php?key='.$activation.'</a>';
	
					
					$body.= '<p>Message Made On '.date('l jS \of F Y h:i:s A').'</p>';
					$body.= '<br />';
					$body.= '<p>Message From Ip '.$_SERVER['REMOTE_ADDR'].'</p>';
					$body.= '<br />';
					$body.= '<p>User Data '.$_SERVER['HTTP_USER_AGENT'].'</p>';
	

				if(isset($to, $subject, $body, $headers)):	
				
					$message = 'Your activation link below here. Thank you for your registration. <br />';
					$message .= 'your message was <br />';
					$message .= $body;
					
					$data_array['uname'] = htmlentities($db->real_escape_string($uname));
					$data_array['fname'] = htmlentities($db->real_escape_string($fname));
					$data_array['lname'] = htmlentities($db->real_escape_string($lname));
					$data_array['email'] = htmlentities($db->real_escape_string($email));
					$data_array['phone'] = htmlentities($db->real_escape_string($phone));
					$data_array['dob']	 = htmlentities($db->real_escape_string($dob));
					$data_array['gender']= htmlentities($db->real_escape_string($gender));
					
					$data_array1['user_name']= htmlentities($db->real_escape_string($uname));
					$data_array1['password'] = sha1($db->real_escape_string($password));
					$data_array1['user_type']= htmlentities($db->real_escape_string("U"));
					
					$data_array2['user_id']= htmlentities($db->real_escape_string($uname));
					$data_array2['email']= htmlentities($db->real_escape_string($email));
					$data_array2['activation']= $activation;
					
					echo $sql_log_info_check = "SELECT * FROM login_info WHERE user_name='".htmlentities($db->real_escape_string($uname))."'";
					echo $sql = "SELECT * FROM login_info, member_info, user_authentication_info WHERE login_info.user_name='".htmlentities($db->real_escape_string($uname))."' AND member_info.uname='".htmlentities($db->real_escape_string($uname))."' AND user_authentication_info.user_id='".htmlentities($db->real_escape_string($uname))."'";
	
					echo $sql1 = "SELECT * FROM member_info, user_authentication_info WHERE member_info.email='".htmlentities($db->real_escape_string($email))."' AND user_authentication_info.email='".htmlentities($db->real_escape_string($email))."'";
				  if($base->isUserExists($sql_log_info_check)){
					if($base->isUserExists($sql) && $base->isUserExists($sql1)){
					 if($base->isUserExists($sql)){
					  if($base->isUserExists($sql1)){
						if(mail($to, $subject, $message, $headers) && $base->_insertData("member_info", $data_array) && $base->_insertData("login_info", $data_array1) && $base->_insertData("user_authentication_info", $data_array2)){
						
							@$msg= "Registration successful, please activate email.";
							
						}else{
							@$msg= "Registration Failed, please Try Again.";
						}

					  }else{
							$msg= '<font color="#cc0000">The email is already taken, please try new.</font>';	
					  } 
						  
						
					 }else{
						$msg="This User Already Exists!";
					 }
				    }else{
						$msg="This User and Email Already Exists!";
					}
				  }else{
					  $msg="This User Already Exists, Please Try Another!";
				  }
					
					
				endif;
	}else{
		echo "Wrong Captcha Code!";
	}	
endif;

$l_id = $base->create_id("id", "login_info");
$u_id = $base->create_id("id", "user_authentication_info");
$m_id = $base->create_id("id", "member_info");
?>
<div class="col-md-8">
	<div>
		<span class='rmsg'>
			<?php 
				if(isset($msg)){
					echo "<p style='color:red'>$msg</p>";
				} 
			?>
		</span> 
	</div>
	<div class="mainbody-left">
		<div class="add-div">
			<img src="img/add1.jpg" alt="" />
		</div>
		<div class="mainbody-left-bottom">
			<div>
				<span class='msg'>
					<?php 
						if(isset($error_message)){
							echo "<p style='color:red'>$error_message</p>";
						} 
					?>
				</span> 
			</div>
			<div id="loginbox" style="margin-top:50px;" class="loginbox col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
						<div class="panel-heading">
							<div class="panel-title">Sign In</div>
							<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="fpass.php" target="_blank">Forgot password?</a></div>
						</div>     

					<div style="padding-top:30px" class="panel-body" >

					<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
						
					<form id="loginform" class="form-horizontal" role="form" action="<?php htmlspecialchars($_SERVER['PHP_SELF'] , ENT_QUOTES );?>" method="post">
						
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input id="uid" type="text" class="form-control" name="uid" placeholder="Enter your Username"/>
						</div>
							
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input id="pass" type="password" class="form-control" name="pass" placeholder="password">
						</div>
								

							
						<div class="input-group">
						  <div class="checkbox">
							<label>
							  <input id="rememberme" type="checkbox" name="rememberme" value="1"> Remember me
							</label>
						  </div>
						</div>


						<div style="margin-top:10px" class="form-group">
							<!-- Button -->
							<div class="col-sm-12 controls marginbutton">
							  <input type="submit" id="btn-login" class="btn btn-primary" name="login" value="Login">
							  <!--<a id="btn-fblogin" href="#" class="btn btn-primary">Login with Facebook</a>-->

							</div>
						</div>


							<div class="form-group">
								<div class="col-md-12 control">
									<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
										Don't have an account! 
									<a onClick="$('#loginbox').hide(); $('#signupbox').show()">
										Sign Up Here
									</a>
									</div>
								</div>
							</div>    
						</form>     
					</div>                     
				</div>  
			</div>
	
	
	
	
			<div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panel-title">Sign Up</div>
						<div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
					</div>  
					<div class="panel-body" >
						<form id="signupform" class="form-horizontal" role="form" action="<?php htmlspecialchars($_SERVER['PHP_SELF'] , ENT_QUOTES );?>" method="post" onSubmit="return checkForm(this)">
							
							<div id="signupalert" style="display:none" class="alert alert-danger">
								<p>Error:</p>
								<span></span>
							</div>
								
							<input type="hidden" name="l_id" value="<?php echo $l_id; ?>" />
							<input type="hidden" name="u_id" value="<?php echo $u_id; ?>" />
							<input type="hidden" name="m_id" value="<?php echo $m_id; ?>" />
								
							<div class="form-group">
								<label for="firstname" class="col-md-3 control-label">First Name</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="fname" id="fname" onKeyPress="return onlyLetters(event)" placeholder="First Name" required>
								</div>
							</div>
							<div class="form-group">
								<label for="lastname" class="col-md-3 control-label">Last Name</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="lname" id="lname" onKeyPress="return onlyLetters(event)" placeholder="Last Name">
								</div>
							</div>
							<div class="form-group">
								<label for="username" class="col-md-3 control-label">User Name</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="uname" id="uname" onKeyPress="return alphaNumeric(event)" placeholder="User Name" maxlength="15">
								</div>
							</div>
							<div class="form-group" id="pass_msg" style="display:none;">
								<label for="" class="col-md-3 control-label"></label>
								<div class="col-md-9">
									<span id="pass_note"></span>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-md-3 control-label">Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="password" id="password" maxlength="20" onKeyUp="checkPassword()" placeholder="Password">
								</div>
							</div>
								
							<div class="form-group">
								<label for="re_password" class="col-md-3 control-label">Retype Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="re_passwd" id="re_passwd" placeholder="Retype Password">
								</div>
							</div>
							
							<div class="form-group">
								<label for="email" class="col-md-3 control-label">Email</label>
								<div class="col-md-9">
									<input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
								</div>
							</div>
							<div class="form-group">
								<label for="phone" class="col-md-3 control-label">Phone</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="phone" id="phone" onKeyPress="return onlyNumeric(event)" placeholder="Phone">
								</div>
							</div>
							<div class="form-group">
								<label for="dateofbirth" class="col-md-3 control-label">Date of Birth</label>
								<div class="col-md-9">
									<input type="text" class="form-control datepicker" name="dob" id="dob" placeholder="Date of Birth">
								</div>
							</div>
							<div class="form-group">
								<label for="gender" class="col-md-3 control-label">Gender</label>
								<div class="col-md-9">
									<select class="form-control" name="gender" id="gender">
										<option value="">----Select----</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
									</select>
								</div>
							</div>
							
							<div class="checkbox human_check">
								<label for="" class="col-md-offset-3">
									<input type="checkbox" name="check_human" id="check_human" /> If you are not a robot, please checked.
								</label>
							</div>
							
							<div class="form-group" id="captcha_view">
								<label class="col-md-3 control-label">Captcha</label>
								<div class="col-md-9">
								  <ul id="field_captcha">
								  	<li><input type="text" placeholder="Enter Code" id="captcha" name="captcha" class="form-control inputcaptcha" required="required"></li>
								  	<li><img src="captcha.php" class="imgcaptcha" alt="captcha"  /></li>
								  	<li><img src="img/refresh.png" alt="reload" class="refresh" /></li>
								  </ul> 
								</div>
							</div>

							<div class="form-group">
								<!-- Button -->                                        
								<div class="col-md-offset-3 col-md-9">
									<button id="btn-signup" type="submit" class="btn btn-info" name="submit"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
									<!--<span style="margin-left:8px;">or</span>-->  
								</div>
							</div>
							
							<!--<div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
								
								<div class="col-md-offset-3 col-md-9">
									<button id="btn-fbsignup" type="button" class="btn btn-primary"><i class="icon-facebook"></i>   Sign Up with Facebook</button>
								</div>                                           
									
							</div>-->
							
							
							
						</form>
					 </div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="mainbody-right">
		<div class="add-div2">
			<img src="img/add2.jpg" alt="" />
		</div>
		<div class="mainbody-right-bottom">
			<div class="recent"><h3>Recent Comments</h3></div>
			<div class="comment-area">
				<ul id="comments">
					<?php
						for($c=0; $c<sizeof($comment_data); $c++){
							if($comment_data != NULL){
								echo"<li><b>".$comment_data[$c]['name']."</b>wrote<a href='javascript:void(0)'>".$comment_data[$c]['comment']."</a></li>";
							}
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>



<?php
include_once("footer.php");
endif;
?>

<script type="text/javascript">
	$(document).ready(function(e){
		
		$(".v_exam_list").click(function(){
			var vendor_id = $(this).attr('rel');
			//alert(vendor_id);
			var url = "exam_code.php?v_id="+vendor_id;
			
			window.open(url, '_SELF');
		});
		
		/* capctcha script */
			$("#check_human").click(function(){
				if($(this).is(':checked')){
				$("#captcha_view").fadeIn(1000);
				} else {
					$("#captcha_view").fadeOut(600);
				}
			});
			$(".refresh").click(function () {
				$(".imgcaptcha").attr("src","captcha.php?_="+((new Date()).getTime()));
				
			});
		/* capctcha script */
		
	});
	
	$(function() {
 
		if (localStorage.chkbx && localStorage.chkbx != '') {
			$('#rememberme').attr('checked', 'checked');
			$('#uid').val(localStorage.usrname);
			$('#pass').val(localStorage.pass);
		} else {
			$('#rememberme').removeAttr('checked');
			$('#uid').val('');
			$('#pass').val('');
		}

		$('#rememberme').click(function() {

			if ($('#rememberme').is(':checked')) {
				// save username and password
				localStorage.usrname = $('#uid').val();
				localStorage.pass = $('#pass').val();
				localStorage.chkbx = $('#rememberme').val();
			} else {
				localStorage.usrname = '';
				localStorage.pass = '';
				localStorage.chkbx = '';
			}
		});
	});
</script>
