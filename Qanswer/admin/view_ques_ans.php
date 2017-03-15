<?php
include_once("header.php");
include_once("dbconnect.php");
$base = new Dmodel();

$vendor_id = $base->getVendor();
$vendor_data = $base->getVendorData();
$exam_code_data = $base->getExamcodeData();
$question_data = $base->getQuestionData();
//$question = $base->getQuestion();


if(isset($_POST['search'])){
	
	if($_POST['vendor_id'] !=null && $_POST['exam_code_id']!=null){
		$exam_code_id = $base->getExamcodeId($_POST['exam_code_id'], $_POST['vendor_id']);
		@$question = $base->getQuestion($exam_code_id[0]['exam_code_id']);
		$vendor_name = $base->getEachvendor(@$exam_code_id[0]['vendor_id']);
		
		$msg = "<h2 style='color:red'>Results Not Found!</h2>";
		
	}else if($_POST['vendor_id']==null){
		echo"Please Select Vendor Name!";
	}else if($_POST['exam_code_id']==null){
		echo"Please Enter Exam Code!";
	}else{
		echo"Select box and Input field can't be empty!";
	}
	
	
	
}

?>

<div class="containner">
	<form action="view_ques_ans.php" id="srcFrm" method="post">
		<div class="row">
			<div class="col-md-12">
				<div class="well bg">
					<div class="row">
						<div class="col-md-4 use_padding">
							<select name="vendor_id" id="vendor_id" class="form-control">
								<option value=""> ----- Select Vendor -----</option>
								<?php
									foreach($vendor_id as $key=>$value){
										echo"<option value='$key'>$value</option>";
									}
								?>
							</select>
						</div>
						<div class="col-md-4 use_padding">
							<div class="form-group">
								<input type="text" class="form-control" name="exam_code_id" id="exam_code_id" placeholder="Enter Exam Code" />
							</div>
						</div>
						<div class="col-md-4 use_padding">
							<button class="btn btn-md btn-info btn-block" type="submit" name="search" id="search"><i class="fa fa-search"></i>Search</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<div class="row">
		<div class="col-md-12">
		<?php
		  if(@$question != null){
		?>
			<div class="row" id="v_ex_name">
				<div class="col-md-6">
					<h2>VENDOR NAME: <?php echo @$vendor_name[0]['vendor_name']; ?> </h2>
				</div>
				<div class="col-md-6">
					<h3>EXAM CODE: <?php echo @$exam_code_id[0]['exam_code']; ?> </h3>
					<p>EXAM NAME: <?php echo @$exam_code_id[0]['exam_name']; ?> </p>
				</div>
			</div>
			
			<div class="ques_ans">
			<?php
				$j=0;
				
				for($i=0; $i<sizeof(@$question); $i++){
					$j++;
					$answer = $base->getAnswerData($question[$i]['question_id']);
					echo"<div class='well' del='$j'>";
						//if(@$answer[0]['question_id'] == $question[$i]['question_id']){
							if($question[$i]['question'] != NULL){
								
								echo"<h3>Q.".$j.": ".$question[$i]['question']."</h3>";
								
									if(@$answer[0]['answer'] != null){
										echo"<p><b>Answer:</b> ".@$answer[0]['answer']."</p>";
										echo"<p><b>Description:</b> ".@$answer[0]['description']."</p>";
									}else if(@$answer[0]['img_answer'] != null){
										echo"<p><b>Answer:</b><img src='img/".@$answer[0]['img_answer']."' class='thumbnail'/></p>";
										echo"<p><b>Description:</b> ".@$answer[0]['description']."</p>";
									}else{
										echo"<p><b>Answer: </b> None.</p>";
										echo"<p><b>Description: </b>None.</p>";
									}
															
								
							}else{
								echo"<h3>Q.".$j.":</h3><img src='img/".$question[$i]['img_question']."' class='thumbnail'/>";
								if(@$answer[0]['answer'] != null){
									echo"<p><b>Answer:</b> ".@$answer[0]['answer']."</p>";
									echo"<p><b>Description:</b> ".@$answer[0]['description']."</p>";
								}else if(@$answer[0]['img_answer'] != null){
									echo"<p><b>Answer:</b><img src='img/".@$answer[0]['img_answer']."' class='thumbnail'/></p>";
									echo"<p><b>Description:</b> ".@$answer[0]['description']."</p>";
								}else{
										echo"<p><b>Answer: </b> None.</p>";
										echo"<p><b>Description: </b>None.</p>";
								}
								
								
							}
						//}
						
						echo"<div class='form-group m_bottom text-right'>
								<a href='javascript:void(0)' class='btn btn-primary qans_edit' rel='".$question[$i]['question_id']."_".@$answer[0]['answer_id']."'>Edit</a>
								<a href='javascript:void(0)' class='btn btn-danger qans_delete' del='".$question[$i]['question_id']."_".@$answer[0]['answer_id']."'>Delete</a>
							</div>";
							
					echo"</div>";
				}
			?>
			</div>
		<?php
		 }else{
				echo @$msg;
		 }
		?>
		</div>
	</div>
	
</div>


<?php
include_once("footer.php");
?>

<script type="text/javascript">
	$(document).ready(function(e){
		$(".qans_edit").click(function(){
			var qa_id = $(this).attr('rel');
			var ques_id = qa_id.split("_")[0];
			var ans_id  = qa_id.split("_")[1];
			var url = "edit_ques_ans.php?q_id="+ques_id;
			
			window.open(url, "_blank");
		});
		
		$(".qans_delete").click(function(){
			
			var qa_id = $(this).attr('del');
			var qd_id = qa_id.split("_")[0];
			var ad_id = qa_id.split("_")[1];
			var answer = confirm('Are you sure delete this Question And Answer?');
			if(answer){
				
				$.ajax({
						url:"delete_sql.php",
						type:"post",
						data:{action:"getqansDelete", del_qid:qd_id, del_aid:ad_id},
						success:function(resp){
							
						}
				});	
				$(this).parents(".well").animate({ backgroundColor: "#003" }, "slow")
  .animate({ opacity: "hide" }, "slow");
				
			}
					
		});
		
	});
	
</script>