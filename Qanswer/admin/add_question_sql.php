<?php
include_once("dbconnect.php");
$base = new Dmodel();

$action 				= isset($_POST['action'])? $_POST['action']:"";

$vendor  			= $base->getVendor();
$exam_code 			= $base->getExamcodeData();

$result = array(
		'vendor_tbl'=>$vendor,
		'exam_code_tbl'=>$exam_code
);

if($action == 'getJson'){
	echo json_encode($result);
}

?>