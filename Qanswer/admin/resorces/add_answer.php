<?php
	include_once("header.php");
	include_once("dbconnect.php");
	$base= new Dmodel();
	
	$ans_id = $base->create_id("answer_id", "answer");
	
	if(isset($_POST['branch_name'])){
		extract($_POST);
		
		if($question_id != ""){
		$data_array['answer_id']	= "$answer_id";
		$data_array['question_id']	= "$question_id";
		$data_array['answer']		= "$answer";
		$data_array['date_time']	= "$date_time";
		
			if($base->_insertData("answer", $data_array)){
				print"<script>alert('Answer Added Successfully!')</script>";
			}else{
				print"<script>alert('Answer Added Failed!');</script>";
			}
		}else{
			print"<script>alert('Please Select Question!')</script>";
		}
	}
	
	$question = $base->getQuestionid();
?>
<div class="uiForm">
	<form action="add_answer.php" method="post">
	<div class="row">
    	<div class="left">Question</div>
        <div class="middle">:</div>
        <div class="right">
			<select name="question_id" id="question_id">
				<option value="">-------</option>
				<?php
					foreach($question as $key=>$value){
						echo "<option value='$key'>$value</option>";
					}
				?>
			</select>
		</div>
        <br class="clear">
    </div>
	<div class="row">
    	<div class="left">Answer ID</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="answer_id" name="answer_id" value="<?php echo $ans_id; ?>" required /></div>
        <br class="clear">
    </div>
	
	<div class="row">
    	<div class="left">Answer</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="answer" name="answer" required /></div>
        <br class="clear">
    </div>
	
	<div class="row">
    	<div class="left">Date</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="date_time" name="date_time" value="<?php echo date('Y-m-d H:i:s'); ?>" /></div>
        <br class="clear">
    </div>
    
    <div class="row">
    	<div class="left"></div>
        <div class="middle"></div>
        <div class="right"><input type="submit" value="Save" id="branch_name" name="branch_name"/></div>
        <br class="clear">
    </div>
	</form>
</div>
<?php
	include_once("footer.php");
?>