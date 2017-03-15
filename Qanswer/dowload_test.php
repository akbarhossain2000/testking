<?php
session_start();
if(!isset($_SESSION['isLogin']) && $_SESSION['user_type']!='U'){
		
		header("location: member_area.php");
}
include_once("dbconnect.php");
$base = new Dmodel();

$strDownloadFolder = "storage/";
$boolAllowMultipleDownload = 0;
if(!empty($_GET['key'])){
    $arrcheck = $base->getDownloadkey($_GET['key']);
	print_r($arrcheck);
	if(!empty($arrcheck[0]['file'])){
		if($arrcheck[0]['expires']>=time()){
			if(!$arrcheck[0]['downloads'] OR $boolAllowMultipleDownload){
				$strDownload = $strDownloadFolder.$arrcheck[0]['file'];
				if(file_exists($strDownload)){
					//$strFile = file_get_contents($strDownload);
					//echo $arrcheck[0]['file'];
					
					header("Content-Description: File Transfer");
					header("Content-Disposition: attachment; filename=".$arrcheck[0]['file']);
					header("Content-Transfer-Encoding: binary");
					header("Content-type: application/pdf");
					
					readfile($strDownloadFolder.$arrcheck[0]['file']);
					//echo $strFile;
					$sql = "UPDATE downloads SET downloads = downloads + 1 WHERE downloadkey = '".$_GET['key']."' LIMIT 1";
					$base->_updateData($sql);
					exit;
				}else{
					echo "We couldn't find the file to download.";
				}
			}else{
				//this file has already been downloaded and multiple downloads are not allowed
				echo "This file has already been downloaded.";
			}
		}else{
			//this download has passed its expiry date
			echo "This download has expired.";
		}
	}else{
		//the download key given didnt match anything in the DB
		echo "No file was found to download.";
	}
}else{
	//No download key wa provided to this script
	echo "No download key was provided. Please return to the previous page and try again.";
}







?>