<?php
if (!session_id());
	session_start();
	session_unset('login');
	session_destroy();
	header("location: member_area.php");
	exit;
?>