<?php
	include_once("header.php");
	include_once("dbconnect.php");
	$base= new Dmodel();
	
	$ex_id = $base->create_id("exam_code_id", "exam_code");
	
	if(isset($_POST['branch_name'])){
		extract($_POST);
		if($vendor_id != ""){
		$data_array['vendor_id']	= "$vendor_id";
		$data_array['exam_code_id'] = "$exam_code_id";
		$data_array['exam_code']	= "$exam_code";
		$data_array['exam_name']	= "$exam_name";
		
			if($base->_insertData("exam_code", $data_array)){
				print"<script>alert('Data Save SuccessFully!')</script>";
			}else{
				print"<script>alert('Data Save Failed')</script>";
			}
		}else{
			print"<script>alert('Please Select Vendor!')</script>";
		}
	}
	
	
	$vendor = $base->getVendor();
?>
<div class="uiForm">
	<form action="add_exam_code.php" method="post">
		<input type="hidden" id="exam_code_id" name="exam_code_id" value="<?php echo $ex_id ?>" required />
	<div class="form-group">
        <label class="control-label" for="textinput">Vendor :</label>
        <div class="input_box">
           <select name="vendor_id" id='vendor_id' class="form-control">
				<option value=''>-------</option>
				<?php
					foreach($vendor as $key=>$value){
						echo "<option value='$key'>$value</option>";
					}
				?>
			</select>

        </div>
	</div>
	
	<div class="form-group">
        <label class="control-label" for="textinput">Exam Code :</label>
        <div class="input_box">
            <input type="text" id="exam_code" name="exam_code" required placeholder="Enter Exam Code" class="form-control input-md"/>
		</div>
	</div>

	<div class="form-group">
        <label class="control-label" for="textinput">Exam Name :</label>
        <div class="input_box">
            <input type="text" id="exam_name" name="exam_name" required placeholder="Enter Exam Name" class="form-control input-md"/>
		</div>
	</div>
	
    <div class="s_button">
		<input type="submit" value="Save" id="branch_name" name="branch_name" class="btn btn-primary"/>
	</div>
	</form>
</div>
<?php
	include_once("footer.php");
?>