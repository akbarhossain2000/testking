<?php
include_once("dbconnect.php");
$base = new Dmodel();

if($_POST['action'] == 'getDelete' ){
	$did = $_POST['del_id'];
	$sql = "UPDATE vendor SET status='0' WHERE vendor_id='$did'";
	echo $base->_deleteData($sql);
}else if($_POST['action'] == 'getexDelete' ){
	$deid = $_POST['del_eid'];
	$sql = "UPDATE exam_code SET status='0' WHERE exam_code_id='$deid'";
	echo $base->_deleteData($sql);
}else if($_POST['action'] == 'getqansDelete'){
	$dqid = $_POST['del_qid'];
	$daid = $_POST['del_aid'];
	$sql = "UPDATE question, answer SET question.status='0', answer.status='0' WHERE question.question_id='$dqid' AND answer.question_id='$dqid' AND answer.answer_id='$daid'";
	echo $base->_deleteData($sql);
}else if($_POST['action'] == 'getuserDelete'){
	$duid = $_POST['del_id'];
	$sql = "UPDATE admin_login SET user_type='' WHERE id='$duid'";
	echo $base->_deleteData($sql);
}

?>