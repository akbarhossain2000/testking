<?php
include_once("dbconnect.php");
$base = new Dmodel();

if($_GET['ex_id']){
	$eid = $_GET['ex_id'];
}
$exam_code_data = $base->getExamcode($eid);
$vendor_name = $base->getVendorName($exam_code_data[0]['vendor_id']);
$question_data = $base->getQuesByex($eid);
$dstrkey = createKey();
require("fpdf/fpdf.php");
$dir = "storage/";
echo $filename= $dstrkey.'.pdf';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,$vendor_name,0,0,"C");
$pdf->Ln();
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,10,'Exam Name: '.$exam_code_data[0]['exam_name'],0,0,"C");
$pdf->Ln();
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,10,'Exam Code: '.$exam_code_data[0]['exam_code'],0,0,"C");

$pdf->Ln();
$pdf->Ln();
$j=0;
for($i=0; $i<sizeof($question_data); $i++){
$j++;
$qn = $question_data[$i]['question'];
//$img_qn = $question_data[$i]['img_question'];
if($qn != NULL){
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,10,'Q.'.$j.':'.$qn,0,0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(0,10,'Ans:',0,0);
}else{
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(0,10,'Q.'.$j.':',0,0);
	$pdf->Ln();
	$pdf->Cell('','',$pdf->Image('admin/img/'.$question_data[$i]['img_question']),0,0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(0,10,'Ans:',0,0);
}
	$answer_data = $base->getAnswerData($question_data[$i]['question_id']);
	for($a=0; $a<sizeof($answer_data); $a++){
		$answer = $answer_data[$a]['answer'];
		if($answer != NULL){
			$separator = explode("#", $answer);
			for($an=0; $an<sizeof($separator); $an++){
				if(substr($separator[$an],0,1)=="@"){
					$ans = substr($separator[$an],1,strlen($separator[$an]));
					$pdf->Ln();
					$pdf->SetFont('Arial','',11);
					$pdf->SetTextColor(0,222,40);
					$pdf->Cell(0,10,($an+1).'. '.$ans,0,0);
				}else{
					$pdf->Ln();
					$pdf->SetFont('Arial','',11);
					$pdf->SetTextColor(0,0,0);
					$pdf->Cell(0,10,($an+1).'. '.$separator[$an],0,0);
				}
			}
		}else{
			$pdf->Ln();
			$pdf->Cell('','',$pdf->Image('admin/img/'.$answer_data[$a]['img_answer']),0,0);
		}
		
		$pdf->Ln();
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0,10,'Description: ',0,0);
		$pdf->Ln();
		$pdf->SetFont('Arial','',11);
		$pdf->Write(5,$answer_data[$a]['description']);
		$pdf->Ln();
	}

}

$email = "akbaronlinebd@gmail.com";
$subject = 'Download Link';

$to      = $email;
		
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: webrahaman@gmail.com' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: smail-PHP ".phpversion()."\r\n";
				
$base_url = "http://localhost/testking/";

echo $body='Hi, <br/> <br/> We need to make download. Please click download link to get Question and answer. <br/> <br/> <a href="'.$base_url.'download_test.php?key='.$dstrkey.'">'.$base_url.'download_test.php?key='.$dstrkey.'</a>';

			
	$body.= '<p>Message Made On '.date('l jS \of F Y h:i:s A').'</p>';
	$body.= '<br />';
	$body.= '<p>Message From Ip '.$_SERVER['REMOTE_ADDR'].'</p>';
	$body.= '<br />';
	$body.= '<p>User Data '.$_SERVER['HTTP_USER_AGENT'].'</p>';

if(isset($to, $subject, $body, $headers)):	
				
					$message = 'Your activation link below here. Thank you for your registration. <br />';
					$message .= 'your message was <br />';
					$message .= $body;	

$data_array['downloadkey'] = $dstrkey;
$data_array['file']		   = $filename;
$data_array['expires']	   = time()+(60*60*24*7);

	if(mail($to, $subject, $message, $headers) && $base->_insertdata("downloads", $data_array) && $pdf->Output($dir.$filename,'F')){
		echo "Please Check your email!";
	}else{
		echo"Your operation is failed, please try again!";
	}

endif;

function createKey(){
	$strkey = md5(microtime());
	$base = new Dmodel();
	if($base->getDkeycount($strkey)){
		return createKey();
	}else{
		return $strkey;
	}
}



?>