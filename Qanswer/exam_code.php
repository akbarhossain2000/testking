<?php
include_once("header_one.php");
include_once("dbconnect.php");
$base= new Dmodel();
if(isset($_GET['v_id'])){
	$vendor_id = $_GET['v_id'];
}
$vendor_data = $base->getVendorData();
$exam_code_data = $base->getExamcodeData();
$question_data = $base->getQuestionData();


//print_r($comment_data);

?>
<div class="col-md-8">
							
	<div class="mainbody-left">
		<div class="add-div">
			<img src="img/add1.jpg" alt="" />
		</div>
		
			
				<div class="mainbody-left-bottom">
					<div class="exam_list">
						<h2>Available Exam</h2>
						<ul>
						<?php
							for($i=0; $i<sizeof($exam_code_data); $i++){
								if($exam_code_data[$i]['vendor_id'] == $vendor_id){
									echo"<li><a href='javascript:void(0)' class='question' rel='".$exam_code_data[$i]['exam_code_id']."_".$exam_code_data[$i]['vendor_id']."'>".$exam_code_data[$i]['exam_code']."</a></li>";
								}
							}
						?>
						</ul>
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
				
				
				$(".question").click(function(){
					var val = $(this).attr('rel');
					var exam_code_id = val.split("_")[0];
					var vendor_id = val.split("_")[1];
					//alert(exam_code_id);
					var url = "question.php?ex_id="+exam_code_id;
					
					window.open(url, '_SELF');
				});

			});
</script>

