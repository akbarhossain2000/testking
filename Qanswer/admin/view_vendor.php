<?php
	include_once("header.php");
	include_once("dbconnect.php");
	$base= new Dmodel();
	
	$vendor_data 	= $base->getVendorData();
	
	
?>

<div class="uiForm">
	<div class="show_data">
		<table class="table table-bordered">
			<tr>
				<th>SL. NO</th>
				<th>Vendor Name</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php
				$j=0;
				for($i=0; $i<sizeof($vendor_data); $i++){
					$j++;
					echo"<tr>
							<td>".$j."</td>
							<td>".$vendor_data[$i]['vendor_name']."</td>
							<td><a href='' class='btn btn-primary edit' rel='".$vendor_data[$i]['vendor_id']."'>Edit</a></td>
							<td><a href='' class='btn btn-danger delete' del='".$vendor_data[$i]['vendor_id']."'>Delete</a></td>
						</tr>";
				}
			?>
		</table>
	</div>
	
</div>

<?php
	include_once("footer.php");
?>

<script type="text/javascript">
	$(document).ready(function(e){
		
		$(".edit").click(function(){
			
			var e_id = $(this).attr('rel');
			var url = "edit_vendor.php?v_id="+e_id;
			
			window.open(url,"", "width=400, height=400");
			
			
		});
		
		$(".delete").click(function(){
			var d_id = $(this).attr('del');
			var answer = confirm('Are you sure delete this vendor?');
			if(answer){
				
				$.ajax({
						url:"delete_sql.php",
						type:"post",
						data:{action:"getDelete", del_id:d_id},
						success:function(resp){
							
						}
				});	
			
				
			}
					
			
		});
 
				
	});
</script>