<?php
include_once("dbconnect.php");
$base = new Dmodel();
if(isset($_GET['v_id'])){
	$ven_id = $_GET['v_id'];
	$vendor_details = $base->getEachvendor($ven_id);
}


if(isset($_POST['update'])){
	extract($_POST);
	$sql = "UPDATE vendor SET vendor_name='$vendor_name' WHERE vendor_id='$vendor_id'";
	if($base->_updateData($sql)){
		print"<script>alert('Update Successfully!');</script>";
	}else{
		print"<script>alert('Update Failed!');</script>";
	}
}

echo "<form action='edit_vendor.php' method='post'>";
	echo "<table>
		<tr>
			<td>Vendor ID</td>
			<td>:</td>
			<td><input type='text' id='vendor_id' name='vendor_id' value='".@$vendor_details[0]['vendor_id']."' readonly></td>
		</tr>
		
		<tr>
			<td>Vendor Name</td>
			<td>:</td>
			<td><input type='text' id='vendor_name' name='vendor_name' value='".@$vendor_details[0]['vendor_name']."'></td>
		</tr>
		<tr>
			<td colspan='3'><input type='submit' name='update' value='Update'</td>
		</tr>
	</table>";
echo"</form>";

?>


<script type="text/javascript">

window.onunload = refreshParent;
			function refreshParent() {
				window.opener.location.reload();
			}

</script>