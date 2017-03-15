<?php
include_once("dbconnect.php");
$base = new Dmodel();

if(isset($_GET['e_id'])){
	$exid = $_GET['e_id'];
	$vendor_data = $base->getVendor();
	$exam_code_data = $base->getEachexamcode($exid);
	
}

if(isset($_POST['update'])){
	extract($_POST);
	$sql = "UPDATE exam_code SET exam_code='$exam_code', exam_name='$exam_name', vendor_id='$vendor_id' WHERE exam_code_id='$exam_code_id'";
	
	if($base->_updateData($sql)){
		print"<script>alert('Update Successfully!');</script>";
	}else{
		print"<script>alert('Update Failed!');</script>";
	}
	
}



?>

<form action="edit_exam_code.php" method="post">
	<input type="hidden" name="exam_code_id" id="exam_code_id" value="<?php echo $exam_code_data[0]['exam_code_id']; ?>" readonly />
	<table>
		<tr>
			<th>Edit Exam Code</th>
		</tr>
		
		<tr>
			<td>Vendor Name</td>
			<td>:</td>
			<td>
				<select name="vendor_id" id="vendor_id">
					<?php
						foreach($vendor_data as $key=>$value){
							if($exam_code_data[0]['vendor_id'] == $key){
								echo "<option value='$key' selected>$value</option>";
							}else{
								echo "<option value='$key'>$value</option>";
							}
							
						}
					?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>Exam Code</td>
			<td>:</td>
			<td><input type="text" name="exam_code" id="exam_code" value="<?php echo @$exam_code_data[0]['exam_code']; ?>" /></td>
		</tr>
		
		<tr>
			<td>Exam Name</td>
			<td>:</td>
			<td><input type="text" name="exam_name" id="exam_name" value="<?php echo @$exam_code_data[0]['exam_name']; ?>" /></td>
		</tr>
		
		
		<tr>
			<td colspan="3"><button type="submit" name="update" class="btn btn-primary" >Update</button></td>
		</tr>
	</table>
</form>


<script type="text/javascript">

window.onunload = refreshParent;
			function refreshParent() {
				window.opener.location.reload(true);
				
				window.setInterval(self.close(), 1000);
			}

</script>