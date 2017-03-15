<?php
include_once("dbconnect.php");
$base = new Dmodel();


if(isset($_POST['submit'])):

		$name = trim($_POST['fname']);
		$email = trim($_POST['email']);
		$mobile = trim($_POST['phone']);
		$subject = 'Comfirm Verification';
		$message = 'ontest message';

		$to      = $email;

				
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '. $email . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
						
		$activation = md5($email.time());
		$base_url = "http://localhost/testking/";
		
		echo $body='Hi, <br/> <br/> We need to make sure you are human. Please verify your email and get started using your Website account. <br/> <br/> <a href="'.$base_url.'activation.php?'.$activation.'">'.$base_url.'activation.php?'.$activation.'</a>';
	
			/*echo $html = '<table bgcolor="#fff" width="800">
						<tr>
							<td width="200">Full Name </td><td width="10"> : </td>
							<td>'.$name.'</td>
						</tr>
						<tr>
							<td width="200">E-mail </td><td width="10"> : </td>
							<td>'.$email.'</td>
						</tr>
						<tr>
							<td> Mobile No: </td><td> : </td>
							<td>'.$mobile.'</td>
						</tr>
						<tr>
							<td> Subject</td><td> : </td>
							<td>'.$subject.'</td>
						</tr>
						
						<tr>
							<td> Message </td><td> : </td>
							<td>'.$message.'</td>
						</tr>


					</table>';
					
					$html.= '<br />';*/
					
					$body.= '<p>Message Made On '.date('l jS \of F Y h:i:s A').'</p>';
					$body.= '<br />';
					$body.= '<p>Message From Ip '.$_SERVER['REMOTE_ADDR'].'</p>';
					$body.= '<br />';
					$body.= '<p>User Data '.$_SERVER['HTTP_USER_AGENT'].'</p>';

					/*$html = wordwrap($html, 70, "\r\n");*/
					
					

				if(mail($to, $subject, $body, $headers)):	
				
					$message = 'You just Send an message to Aros. Thank your for your interest <br />';
					$message .= 'your message was <br />';
					$message .= $body;
					
					
					$headersuser  = 'MIME-Version: 1.0' . "\r\n";
					$headersuser .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headersuser .= 'From: webrahaman@gmail.com'. "\r\n" .
						'X-Mailer: PHP/' . phpversion();

					
					echo mail($to, $subject, $body, $headersuser);
					//echo '<script>location.href="'.$_SERVER['HTTP_REFERER'].'";</script>';
				endif;	
endif;	

?>