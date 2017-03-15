<?php
include_once("header_one.php");

include_once("dbconnect.php");
$base= new Dmodel();
if(isset($_GET['v_id'])){
	@$vendor_id = $_GET['v_id'];
}
$vendor_data = $base->getVendorData();
$examcode_data = $base->getExamcodeData();
//print_r($examcode_data);
$question_data = $base->getQuestionData();


//print_r($comment_data);

if(isset($_POST['send'])){
	extract($_POST);
	$vid = $ven_id;
	$eid = $exm_id;

$exam_code_data = $base->getExamcode($eid);
$vendor_name = $base->getVendorName($exam_code_data[0]['vendor_id']);
$question_data = $base->getQuesByex($eid);
$dstrkey = createKey();
require("fpdf/fpdf.php");
$dir = "storage/";
$filename= $dstrkey.'.pdf';

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
$img_qn = $question_data[$i]['img_question'];
if(($qn != NULL) && ($img_qn != NULL)){
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,10,'Q.'.$j.':'.$qn,0,0);
	$pdf->Ln();
	$pdf->Cell('','',$pdf->Image('admin/img/'.$question_data[$i]['img_question']),0,0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(0,10,'Ans:',0,0);
}else if($qn != NULL){
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
		$img_answer = $answer_data[$a]['img_answer'];
		if(($answer != NULL) && ($img_answer != NULL)){
			$pdf->Ln();
			$pdf->Cell('','',$pdf->Image('admin/img/'.$answer_data[$a]['img_answer']),0,0);
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
			
		}else if($answer != NULL){
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

$email = trim($_POST['email']);
$subject = 'Download Link';

$to      = $email;
		
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: webrahaman@gmail.com' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: smail-PHP ".phpversion()."\r\n";
				
$base_url = "http://localhost/testking/";

echo $body='Hi, <br/> <br/> We need to make download. Please click download link to get Question and answer. <br/> <br/> <a href="'.$base_url.'dowload_test.php?key='.$dstrkey.'">'.$base_url.'dowload_test.php?key='.$dstrkey.'</a>';

			
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

	if(mail($to, $subject, $message, $headers)){
		$base->_insertdata("downloads", $data_array);
		$pdf->Output($dir.$filename,'F');
		print"<script>alert('Please Check your email!');</script>";
	}else{
		print"<script>alert('Your operation is failed, please try again!');</script>";
	}

endif;
}

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
<div class="col-md-8">
							
	<div class="mainbody-left">
		<div class="add-div">
			<img src="img/add1.jpg" alt="" />
		</div>
		
			
				<div class="mainbody-left-bottom">
					<div class="m_exam_list">
						<h2>Available Exam Question And Answer</h2>
						<ul id="m_ex_code">
							<li>
								<ul>
									<li>Exam Name</li>
									<li>Exam Code</li>
									<li>Action</li>
								</ul>
							</li>
							<?php
							//echo sizeof($examcode_data);
							for($i=0; $i<sizeof($examcode_data); $i++){
								if($examcode_data[$i]['vendor_id'] == @$vendor_id){
									//echo $exam_code_data[$i]['vendor_id'];
									echo"<li>
											<ul>
												<li>".$examcode_data[$i]['exam_name']."</li>
												<li>".$examcode_data[$i]['exam_code']."</li>";
												/*<li><a href='javascript:void(0)' class='download' rel='".$exam_code_data[$i]['exam_code_id']."_".$exam_code_data[$i]['vendor_id']."'>Click here to download</a></li>*/
												echo"<li><a href='javascript:void(0)' class='download' rel='".$examcode_data[$i]['exam_code_id']."_".$examcode_data[$i]['vendor_id']."' data-toggle='modal' data-target='#myModal'>Click here to download</a></li>
											</ul>
										</li>";
								}
							}
							?>
						</ul>
					</div>
				</div>
			
		
		
	</div>
	
	<!-- Modal -->
	  <div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-md">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Download Question and Answer</h4>
			</div>
			<form action="" method="post">
			<input type="hidden" name="ven_id" id="ven_id" />
			<input type="hidden" name="exm_id" id="exm_id" />
			<div class="modal-body m_body">
			  <div class="form-group eform">
				<input type="email" class="form-control" name="email" id="email" placeholder="Please enter your email!" required />
			  </div>
			 
			</div>
			<div class="modal-footer">
			  <input type="submit" name="send" class="btn btn-primary send" value="Send Email" />
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			</form>
		  </div>
		</div>
	  </div>
	<!--End Modal-->
</div>

<div class="col-md-4">
	<div class="mainbody-right">
		<div class="add-div2">
			<img src="img/add2.jpg" alt="" />
		</div>
		<div class="mainbody-right-bottom">
			<div class="recent"><h3>Recent Comments</h3></div>
			<div class="comment-area">
				<ul id="comments">
					<?php
						for($c=0; $c<sizeof($comment_data); $c++){
							if($comment_data != NULL){
								echo"<li><b>".$comment_data[$c]['name']."</b>wrote<a href='javascript:void(0)'>".$comment_data[$c]['comment']."</a></li>";
							}
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="col-md-12">
	<div class="mainbody-bottom">
		<div class="mb_text">Question & Answer Collection</div>
	</div>
</div>

	
<?php
include_once("footer.php");

?>

<script type="text/javascript">
			$(document).ready(function(e){

				$(".download").click(function(){
					var val = $(this).attr('rel');
					var exam_code_id = val.split("_")[0];
					var vendor_id = val.split("_")[1];
					//alert(exam_code_id);
					$("#ven_id").val(vendor_id);
					$("#exm_id").val(exam_code_id);

				});

			});
</script>

