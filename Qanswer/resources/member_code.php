<?php
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
		
		echo $body='Hi, <br/> <br/> We need to make sure you are human. Please verify your email and get started using your Website account. <br/> <br/> <a href="'.$base_url.'activation.php?act_id='.$activation.'">'.$base_url.'activation.php?act_id='.$activation.'</a>';
	
					
					$body.= '<p>Message Made On '.date('l jS \of F Y h:i:s A').'</p>';
					$body.= '<br />';
					$body.= '<p>Message From Ip '.$_SERVER['REMOTE_ADDR'].'</p>';
					$body.= '<br />';
					$body.= '<p>User Data '.$_SERVER['HTTP_USER_AGENT'].'</p>';
	

				if(isset($to, $subject, $body, $headers)):	
				
					$message = 'Your activation link below here. Thank you for your registration. <br />';
					$message .= 'your message was <br />';
					$message .= $body;
					
					
					/*$headersuser  = 'MIME-Version: 1.0' . "\r\n";
					$headersuser .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headersuser .= 'From: webrahaman@gmail.com'. "\r\n";
					$headersuser.="X-Priority: 3\r\n";
					$headersuser.="X-Mailer: smail-PHP ".phpversion()."\r\n";*/
					
					$data_array['uname'] = $uname;
					$data_array['fname'] = $fname;
					$data_array['lname'] = $lname;
					$data_array['email'] = $email;
					$data_array['phone'] = $phone;
					$data_array['dob']	 = $dob;
					$data_array['gender']= $gender;
					
					$data_array1['user_name']= $uname;
					$data_array1['password'] = $password;
					$data_array1['user_type']= "U";
					
					$data_array2['user_id']= $uname;
					$data_array2['email']= $email;
					$data_array2['activation']= $activation;
					
					$sql = "SELECT * FROM login_info, member_info, user_authentication_info WHERE login_info.user_name='".$uname."' AND member_info.uname='".$uname."' AND user_authentication_info.user_id='".$uname."'";
	
					$sql1 = "SELECT * FROM member_info, user_authentication_info WHERE member_info.email='".$email."' AND user_authentication_info.email='".$email."'";
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
						echo"This User Already Exists!";
					 }
				    }else{
						echo"This User and Email Already Exists!";
					}
					
					
					
				endif;