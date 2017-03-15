<?php
include_once("dbconnect.php");
$base = new Dmodel();
$msg='';
$success_msg='';
if(!empty($_GET['key']) && isset($_GET['key'])):

	$activation_id = $_GET['key'];
	
	$sql_check = "SELECT login_info.user_name, member_info.uname, user_authentication_info.user_id FROM login_info, member_info, user_authentication_info WHERE login_info.user_type='U' AND user_authentication_info.activation='".$activation_id."'";
	if($base->getActivationCode($sql_check)){
		$count = "SELECT login_info.user_name, member_info.uname, user_authentication_info.user_id FROM login_info, member_info, user_authentication_info WHERE login_info.user_type='U' AND user_authentication_info.activation='".$activation_id."' AND user_authentication_info.isActive='N'";
		if($base->getCountId($count)){
			$update = "UPDATE user_authentication_info SET isActive='Y' WHERE activation='".$activation_id."'";
			if($base->_updateData($update)){
				$success_msg = "Your account is activated. You can now<a href='member_area.php'>login</a>";
			}
		}else{
			$msg ="Your account is already active, no need to activate again.";
		}
	}else{
		$msg ="Wrong activation code.";
	}

endif;

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Account Verification</title>
<link rel="stylesheet" href="style.css"/>
</head>
<body>
	<div id="main">
	<h2><?php if($success_msg != ""){echo $success_msg;}else{ echo $msg; } ?></h2>
	</div>
</body>
</html>