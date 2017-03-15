<?php
include_once("header.php");
include_once("dbconnect.php");
$base = new Dmodel();

if(isset($_GET['q_id'])){
	$ques_id = $_GET['q_id'];
	@$ques_ans = $base->getQuesAns($ques_id);
	@$each_exam_code = $base->getEachexamcode($ques_ans[0]['exam_code_id']);
	@$exam_code_id = $base->getVendorExamcode($each_exam_code[0]['vendor_id']);
}

if(isset($_POST['update'])){
	extract($_POST);
	
		@$qfile_name = $_FILES['img_question']['name'];
		@$qfile_path = $_FILES['img_question']['tmp_name'];
		@$qfile_type = $_FILES['img_question']['type'];
		@$qfile_size = $_FILES['img_question']['size'];
		@$extension	= substr($qfile_name,-3);
		@$qfile_name = "q".$question_id.".".$extension;
		move_uploaded_file($qfile_path, "img/$qfile_name");
		
		
		@$afile_name = $_FILES['img_answer']['name'];
		@$afile_path = $_FILES['img_answer']['tmp_name'];
		@$afile_type = $_FILES['img_answer']['type'];
		@$afile_size = $_FILES['img_answer']['size'];
		@$extension	= substr($afile_name,-3);
		@$afile_name = "aq".$question_id.".".$extension;
		move_uploaded_file($afile_path, "img/$afile_name");
	if($_POST['question'] != NULL && $_POST['answer'] != NULL){
		$sql = "UPDATE question, answer SET question.question = '$question', question.img_question='', question.date_time='$date_time', question.user_id='$user_id', answer.answer='$answer', answer.img_answer='', answer.description='$description' WHERE question.question_id='$question_id' AND answer.question_id='$question_id' AND answer.answer_id='$answer_id'";
	}else if($_POST['question'] != NULL && $_FILES['img_answer']['name'] != NULL){
		$sql = "UPDATE question, answer SET question.question = '$question', question.img_question='', question.date_time='$date_time', question.user_id='$user_id', answer.answer='', answer.img_answer='$afile_name', answer.description='$description' WHERE question.question_id='$question_id' AND answer.question_id='$question_id' AND answer.answer_id='$answer_id'";
	}else if($_FILES['img_question']['name'] != NULL && $_POST['answer'] != NULL){
		$sql = "UPDATE question, answer SET question.question = '', question.img_question='$qfile_name', question.date_time='$date_time', question.user_id='$user_id', answer.answer='$answer', answer.img_answer='', answer.description='$description' WHERE question.question_id='$question_id' AND answer.question_id='$question_id' AND answer.answer_id='$answer_id'";
	}else if($_FILES['img_question']['name'] != NULL && $_FILES['img_answer']['name'] != NULL){
		$sql = "UPDATE question, answer SET question.question = '', question.img_question='$qfile_name', question.date_time='$date_time', question.user_id='$user_id', answer.answer='', answer.img_answer='$afile_name', answer.description='$description' WHERE question.question_id='$question_id' AND answer.question_id='$question_id' AND answer.answer_id='$answer_id'";
	}else if($_POST['question'] != NULL){
		$sql = "UPDATE question, answer SET question.question = '$question' WHERE question.question_id='$question_id' AND answer.question_id='$question_id' AND answer.answer_id='$answer_id'";
	}else if($_FILES['img_answer']['name'] != NULL){
		$sql = "UPDATE question, answer SET answer.img_answer='$afile_name' WHERE question.question_id='$question_id' AND answer.question_id='$question_id' AND answer.answer_id='$answer_id'";
	}else if($_FILES['img_question']['name'] != NULL){
		$sql = "UPDATE question, answer SET question.img_question='$qfile_name' WHERE question.question_id='$question_id' AND answer.question_id='$question_id' AND answer.answer_id='$answer_id'";
	}else if($_POST['answer'] != NULL){
		$sql = "UPDATE question, answer SET answer.answer = '$answer' WHERE question.question_id='$question_id' AND answer.question_id='$question_id' AND answer.answer_id='$answer_id'";
	}
	
	if($base->_updateData($sql)){
		
		print"<script>alert('Update Data Successfully!')</script>";
	}else{
		print"<script>alert('Update Data Failed!')</script>";
	}
	
}

?>

<div class="row">
	<div class="col-md-12">
	
	 <div class="well bg text-center d-border">
			<h1>EDIT QUESTION AND ANSWER</h1>
	 </div>
		
	  <div class="ques_ans">
		<form action="edit_ques_ans.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_name'];?>" />
			<input type="hidden" id="question_id" name="question_id" value="<?php echo @$ques_ans[0]['question_id']; ?>" required />
			<input type="hidden" id="answer_id" name="answer_id" value="<?php echo @$ques_ans[0]['answer_id']; ?>" />
			<div class="form-group">
				<label class="control-label" for="textinput">Exam Code :</label>
				<div class="input_box">
					<select name="exam_code_id" id="exam_code_id" class="form-control">
						<?php
							foreach($exam_code_id as $key=>$value){
								if($ques_ans[0]['exam_code_id']==$key){
									echo"<option value='$key' slected>$value</option>";
								}else{
									echo"<option value='$key'>$value</option>";
								}
								
							}
						?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label" for="textinput">Question :</label>
				<div class="input_box">
				<?php
					if(@$ques_ans[0]['question'] != NULL){
				?>
					<textarea id="question" name="question" class="form-control" rows="2"><?php echo $ques_ans[0]['question']; ?></textarea>
				<?php
					}else{
				?>
					<textarea id="question" name="question" class="form-control" rows="2" placeholder="Enter Your Question"></textarea>
				<?php
					}
				?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label" for="textinput">Question Answer :</label>
				<div class="input_box">
				<?php
					if(@$ques_ans[0]['answer'] != NULL){
				?>
					<textarea id="answer" name="answer" class="form-control" rows="3"><?php echo $ques_ans[0]['answer']; ?></textarea>
				<?php
					}else{
				?>
					<textarea id="answer" name="answer" class="form-control" rows="3" placeholder="Enter Your Question Answer"></textarea>
					
				<?php
					}
				?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="textinput">Image Question :</label>
				<div class="input_box">
				<?php
					if(@$ques_ans[0]['img_question'] != NULL){
				?>
					<img src="img/<?php echo @$ques_ans[0]['img_question']; ?>" class="thumbnail"/>
				<?php
					}else{
				?>
					<input type="file" id="img_question" name="img_question" class="btn btn-default" />
				<?php
					}
				?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label" for="textinput">Image Question Answer :</label>
				<div class="input_box">
				<?php
					if(@$ques_ans[0]['img_answer'] != NULL){
				?>
					<img src="img/<?php echo @$ques_ans[0]['img_answer']; ?>" class="thumbnail"/>
				<?php
					}else{
				?>
					<input type="file" id="img_answer" name="img_answer" class="btn btn-default" />
				<?php
					}
				?>
				</div>
			</div>
		
			<div class="form-group">
				<label class="control-label" for="textinput">Answer Description :</label>
				<div class="input_box">
					<textarea id="description" name="description" class="form-control" rows="3"><?php echo @$ques_ans[0]['description']; ?></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label" for="textinput">Date Time :</label>
				<div class="input_box">
					<input type="text" id="date_time" name="date_time" value="<?php echo @$ques_ans[0]['date_time']; ?>" class="form-control"/>
				</div>
			</div>
			
			<div class="u-button">
				<input type="submit" value="Update" id="update" name="update" class="btn btn-primary"/>
			</div>

		</form>
	  </div>
	</div>
</div>



<?php
include_once("footer.php");
?>

<script type="text/javascript">

window.onunload = refreshParent;
	function refreshParent() {
		window.opener.location.reload(true);
		window.setInterval(self.close(), 1000);
	}

</script>