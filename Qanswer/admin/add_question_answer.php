<?php
	include_once("header.php");
	include_once("dbconnect.php");
	$base= new Dmodel();
	
	$exam_code = $base->getExamcode();
	
	
	if(isset($_POST['branch_name'])){
		extract($_POST);
		if($_POST['question']!=null){
			@$sql = "SELECT * FROM question WHERE exam_code_id='".$_POST['exam_code_id']."' AND question='".$_POST['question']."' AND status='1'";
		}
		
		
		if($base->isExists(@$sql)){
		 if($exam_code_id != ""){
			if(($_POST['question']!=NULL && $_POST['answer']!=NULL) || (@$_FILES['img_question']['name']!=NULL && $_FILES['img_answer']['name']!=NULL) || ($_POST['question']!=NULL && $_FILES['img_answer']['name']!=NULL) || (@$_FILES['img_question']['name']!=NULL && $_POST['answer']!=NULL) || ($_POST['question']!=NULL || $_FILES['img_question']['name']) && ($_POST['answer']!=NULL || $_FILES['img_answer']['name'])){
				
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
				
				$data_array['question_id']	= "$question_id";
				$data_array['exam_code_id'] = "$exam_code_id";
				if($question != NULL){
					$data_array['question']		= "$question";
				}else{
					$data_array['question']		= "";
				}
				
				if(@$_FILES['img_question']['name']!= NULL){
					$data_array['img_question']	= "$qfile_name";
				}else{
					$data_array['img_question']	= "";
				}
				$data_array['date_time']	= "$date_time";
				$data_array['user_id']		= "$user_id";
				
				$data_array1['question_id']	= "$question_id";
				$data_array1['answer_id'] = "$answer_id";
				if($answer != NULL){
					$data_array1['answer']		= "$answer";
				}else{
					$data_array1['answer']		= "";
				}
				
				if(@$_FILES['img_answer']['name']!= NULL){
					$data_array1['img_answer']	= "$afile_name";
				}else{
					$data_array1['img_answer']	= "";
				}
				$data_array1['description']	= "$description";
		
				if($base->_insertData("question", $data_array) && $base->_insertData("answer", $data_array1)){
					print"<script>alert('Data Added Successfully!')</script>";
				}else{
					print"<script>alert('Data Added Failed!')</script>";
				}
				
			}else{
				echo"Please input at list any one type question and answer!";
			}
				
		  }else{
			print"<script>alert('Please Select Exam Code!')</script>";
		  }
		}else{
			echo"This question Already Exists";
		}
		
	}
	
	$qs_id = $base->create_id("question_id", "question");
	
	$ans_id = $base->create_id("answer_id", "answer");
	
?>
<div class="uiForm">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_name'];?>" />
		<input type="hidden" id="question_id" name="question_id" value="<?php echo $qs_id; ?>" required />
		<input type="hidden" id="answer_id" name="answer_id" value="<?php echo $ans_id; ?>" />
		<div class="form-group">
			<label class="control-label" for="textinput">Vendor :</label>
			<div class="input_box">
				<select name="vendor" id="vendor" class="form-control">
					<option value="">-------</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label" for="textinput">Exam Code :</label>
			<div class="input_box">
				<select name="exam_code_id" id="exam_code_id" class="form-control">
					<option value="">-------</option>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="textinput">Question :</label>
			<div class="input_box">
				<textarea id="question" name="question" placeholder="Enter Your Question" class="form-control" rows="2"></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="textinput">Question Answer :</label>
			<br />
			<span style="font-size: 16px; font-weight: 500; color: red;">Here are answer divider to use (#) sign and add to before right answer used to (#@) sign please.</span><br />
			<div class="input_box">
				<textarea id="answer" name="answer" placeholder="Enter Your Answer" class="form-control" rows="3"></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="textinput">Image Question :</label>
			<div class="input_box">
				<input type="file" id="img_question" name="img_question" class="btn btn-default" />

			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="textinput">Image Question Answer :</label>
			<div class="input_box">
				<input type="file" id="img_answer" name="img_answer" class="btn btn-default" />

			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="textinput">Answer Description :</label>
			<div class="input_box">
				<textarea id="description" name="description" required placeholder="Enter Your Answer Description" class="form-control" rows="3"></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="textinput">Date Time :</label>
			<div class="input_box">
				<input type="text" id="date_time" name="date_time" value="<?php echo date('Y-m-d H:i:s') ?>" class="form-control"/>
			</div>
		</div>
		
		<div class="s-button">
			<input type="submit" value="Save" id="branch_name" name="branch_name" class="btn btn-primary"/>
		</div>
	</form>
</div>
<?php
	include_once("footer.php");
?>

<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			type:"POST",
			url:"add_question_sql.php",
			dataType:"json",
			data:{action:'getJson'},
			success:function(resp){
				var vendor_name = resp.vendor_tbl;
				var text = "";
				text += "<option value=''>-----</option>";
				for(id in vendor_name){
					text +="<option value='"+id+"'>"+vendor_name[id]+"</option>";
					//alert(text);
				}
				$("#vendor").html(text);
				
				$("#vendor").change(function(){
					var exam_code = resp.exam_code_tbl;
					var vendor_id = $(this).val();
					//alert(vendor_id);
					var text1 = "";
					text1 +="<option value=''>-----</option>";
					for(id in exam_code){
						if(exam_code[id].vendor_id == vendor_id){
							text1 += "<option value='"+exam_code[id].exam_code_id+"'>"+exam_code[id].exam_code+"</option>";
						}
					}
					$("#exam_code_id").html(text1);
				});
			}
			
			
		});
	});

</script>