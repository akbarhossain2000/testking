<?php
	include_once("header.php");
	include_once("dbconnect.php");
	$base= new Dmodel();
	
	$qs_id = $base->create_id("question_id", "question");
	
	
	if(isset($_POST['branch_name'])){
		extract($_POST);
		if($exam_code_id != ""){
		$data_array['question_id']	= "$question_id";
		$data_array['exam_code_id'] = "$exam_code_id";
		$data_array['question']		= "$question";
		$data_array['date_time']	= "$date_time";
		$data_array['user_id']		= "$user_id";
		
			if($base->_insertData("question", $data_array)){
				print"<script>alert('Question Added Successfully!')</script>";
			}else{
				print"<script>alert('Question Added Failed!')</script>";
			}
		}else{
			print"<script>alert('Please Select Exam Code!')</script>";
		}
	}
	
	$exam_code = $base->getExamcode();
?>
<div class="uiForm">
	<form action="add_question.php" method="post">
	
	<div class="form-group">
        <label class="control-label" for="textinput">Exam Code :</label>
        <div class="input_box">
			<select name="exam_code_id" id="exam_code_id" class="form-control">
				<option value="">-------</option>
				<?php
					foreach($exam_code as $key=>$value){
						echo"<option value='$key'>$value</option>";
					}
				?>
			</select>
        </div>
	</div>
	
	<div class="form-group">
        <label class="control-label" for="textinput">Question :</label>
        <div class="input_box">
            <input type="text" id="exam_code" name="exam_code" required placeholder="Enter Exam Code" class="form-control input-md"/>
			<textarea id="question" name="question" class="form-control" row="2"></textarea>
        </div>
	</div>
	
	<div class="form-group">
        <label class="control-label" for="textinput">Exam Code :</label>
        <div class="input_box">
            <input type="text" id="exam_code" name="exam_code" required placeholder="Enter Exam Code" class="form-control input-md"/>

        </div>
	</div>
	
	<div class="form-group">
        <label class="control-label" for="textinput">Exam Code :</label>
        <div class="input_box">
            <input type="text" id="exam_code" name="exam_code" required placeholder="Enter Exam Code" class="form-control input-md"/>

        </div>
	</div>
	<input type="hidden" name="user_id" id="user_id" value="<?php echo 'root';?>" />
	<!--<div class="row">
    	<div class="left">Exam Code</div>
        <div class="middle">:</div>
        <div class="right">
			
		</div>
        <br class="clear">
    </div>
	<div class="row">
    	<div class="left">Question ID</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="question_id" name="question_id" value="<?php echo $qs_id; ?>" required /></div>
        <br class="clear">
    </div>
	
	<div class="row">
    	<div class="left">Question</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="question" name="question" required /></div>
        <br class="clear">
    </div>
	
	<div class="row">
    	<div class="left">Date Time</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="date_time" name="date_time" value="<?php echo date('Y-m-d H:i:s') ?>"/></div>
        <br class="clear">
    </div>
    
    <div class="row">
    	<div class="left"></div>
        <div class="middle"></div>
        <div class="right"><input type="submit" value="Save" id="branch_name" name="branch_name"/></div>
        <br class="clear">
    </div>-->
	</form>
</div>
<?php
	include_once("footer.php");
?>