<?php
	include_once("header.php");
	include_once("dbconnect.php");
	$base= new Dmodel();
	
	$vendor_data 	= $base->getVendorData();
	
	
	
	
	if(isset($_POST['branch_name'])){
		extract($_POST);
		
		$data_array['vendor_id'] = "$vendor_id";
		$data_array['vendor_name'] = "$vendor_name";
		
		if($base->_insertData("vendor", $data_array)){
			print"<script>alert('Data Save Successfully!')</script>";
		}else{
			print"<script>alert('Data Save Failed!')</script>";
		}
		
	}
	$v_id = $base->create_id("vendor_id", "vendor");
?>
<div class="uiForm">
	<form action="add_vendor.php" method="post">
	<input type="hidden" id="vendor_id" name="vendor_id" value="<?php echo $v_id; ?>" />
	<div class="form-group">
        <label class="control-label" for="textinput">Vendor Name :</label>
        <div class="input_box">
            <input type="text" id="vendor_name" name="vendor_name" required placeholder="Enter Vendor Name" class="form-control input-md"/>

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


<script type="text/javascript">
	$(document).ready(function(e){
		
	});
</script>