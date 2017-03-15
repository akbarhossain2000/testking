<?php
include_once("dbconnect.php");
$base = new Dmodel();

$strDownloadFolder = "/storage/";
$boolAllowMultipleDownload = 0;
if(!empty($_GET['key'])){
	$arrcheck = $base->getDownloadkey($_GET['key']);
	if(!empty($arrcheck['file'])){
		if($arrcheck['expires']>=time()){
			if(!$arrcheck['downloads'] OR $boolAllowMultipleDownload){
				$strDownload = $strDownloadFolder.$arrcheck['file'];
				if(file_exists($strDownload)){
					$strFile = file_get_contents($strDownload);
					header("Content-type: application/force-download");
					header("Content-Disposition: attachment; filename\"".str_replace(" ", "_", $arrcheck['file'])."\"");
					echo $strFile;
					
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






function createKey(){
	$strkey = md5(microtime());
	if($base->getDkeycount($strkey)){
		return createKey();
	}else{
		return $strkey;
	}
}

$strkey = createKey();
$data_array['downloadkey'] = $strkey;
$data_array['file']		   = "test.zip";
$data_array['expires']	   = time()+(60*60*24*7);

$base->_insertdata("downloads", $data_array);

?>