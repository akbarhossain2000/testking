<?php
include_once("header.php");
include_once("dbconnect.php");
$base = new Dmodel();

$vendor_data = $base->getVendorData();
$exam_code_data = $base->getExamcodeData();
$question_data = $base->getQuestionData();
$popular_exam = $base->getPopularExam();
//print_r($popular_exam);

?>

				
	<div class="col-md-8">
		<div class="mainbody-left">
			<div class="add-div">
				<img src="img/add1.jpg" alt="" />
			</div>
			<div class="mainbody-left-bottom">
				<div class="exam">
					<h2>Exams Question And Answer</h2>
				</div>
				<div class="v_exam_name">
					<div class="row">
						<?php
							for($i=0; $i<sizeof($vendor_data); $i++){
								echo"<div class='col-md-3 vwd'>";

									echo"<div class='vendor-name'>";
										echo"<h4>".$vendor_data[$i]['vendor_name']."</h4>";
									echo"</div>";
									echo"<div class='exam-list'>";
										echo"<ul id='ex_ul_list'>";
										for($j=0; $j<sizeof($exam_code_data); $j++){
											if($exam_code_data[$j]['vendor_id']==$vendor_data[$i]['vendor_id']){
												echo"<li><i class='fa fa-angle-right'></i><a href='javascript:void(0)' class='question_view' rel='".$exam_code_data[$j]['exam_code_id']."_".$exam_code_data[$j]['vendor_id']."'>".$exam_code_data[$j]['exam_code']."</a></li>";
											}
										}
										echo"</ul>";
									echo"</div>";

								echo"</div>";
							}
						?>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="mainbody-right">
			<div class="add-div2">
				<img src="img/add2.jpg" alt="" />
			</div>
			<div class="mainbody-right-bottom">
				<div class="recent"><h3>Popular Exams</h3></div>
				<div class="comment-area">
					<ul id="comments">
					<?php
						for($e=0; $e<sizeof($popular_exam); $e++){
							$exam_code_and_name = $base->getExamcode($popular_exam[$e]['exam_code_id']);
							for($ex=0; $ex<sizeof($exam_code_and_name); $ex++){
								echo"<li><b>".$exam_code_and_name[$ex]['exam_code'].":</b><a href='javascript:void(0)' class='popular_ex' rel='".$exam_code_and_name[$ex]['exam_code_id']."'>".$exam_code_and_name[$ex]['exam_name']."</a></li>";
							}
							
						}
					
					?>
					</ul>
				</div>
			</div>
		</div>
	</div>


<?php
include_once("footer.php");
?>


<script type="text/javascript">

	$(document).ready(function(e){
		
		$(".v_exam_list").click(function(){
			var vendor_id = $(this).attr('rel');
			//alert(vendor_id);
			var url = "exam_code.php?v_id="+vendor_id;
			
			window.open(url, '_SELF');
		});
		
		
		$(".question_view").click(function(){
			var val = $(this).attr('rel');
			var exam_code_id = val.split("_")[0];
			var vendor_id = val.split("_")[1];
			//alert(exam_code_id);
			var url = "question.php?ex_id="+exam_code_id;
			
			window.open(url, '_SELF');
		});
		
		
		$(".vm_exam_list").click(function(){
			var vendor_id = $(this).attr('rel');
			//alert(vendor_id);
			var url = "m_exam_code.php?v_id="+vendor_id;
			
			window.open(url, '_SELF');
		});
		
		
		$(".popular_ex").click(function(){
			var exam_code_id = $(this).attr('rel');
			//alert(vendor_id);
			var url = "question.php?ex_id="+exam_code_id;
			
			window.open(url, '_SELF');
		});
		
		
	});
</script>