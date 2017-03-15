<?php
if (!session_id());
	session_start();
	session_unset('login');
	session_destroy();
	header("location: login.php");
	exit;

?>