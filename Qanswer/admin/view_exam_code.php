<?php
include_once("header.php");
include_once("dbconnect.php");
$base = new Dmodel();

$exam_code_data= $base->getExamcodeData();

?>
<div class="uiForm">
	<div class="show_data">
		<table class="table table-bordered">
			<tr>
				<th>SL. NO</th>
				<th>Vendor Name</th>
				<th>Exam Code</th>
				<th>Exam Name</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php
				$j=0;
				for($i=0; $i<sizeof($exam_code_data); $i++){
					$vendor_name = $base->getEachvendor($exam_code_data[$i]['vendor_id']);
					$j++;
					echo"<tr>
							<td>".$j."</td>
							<td>".$vendor_name[0]['vendor_name']."</td>
							<td>".$exam_code_data[$i]['exam_code']."</td>
							<td>".$exam_code_data[$i]['exam_name']."</td>
							<td><a href='' class='btn btn-primary ex_edit' rel='".$exam_code_data[$i]['exam_code_id']."'>Edit</a></td>
							<td><a href='' class='btn btn-danger ex_delete' del='".$exam_code_data[$i]['exam_code_id']."'>Delete</a></td>
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
	
	$(".ex_edit").click(function(){
		var ex_id = $(this).attr('rel');
		var url = "edit_exam_code.php?e_id="+ex_id;
		
		window.open(url, "", "height=500, width=500");
	});
	
	$(".ex_delete").click(function(){
			var ed_id = $(this).attr('del');
			var answer = confirm('Are you sure delete this vendor?');
			if(answer){
				
				$.ajax({
						url:"delete_sql.php",
						type:"post",
						data:{action:"getexDelete", del_eid:ed_id},
						success:function(resp){
							
						}
				});	
			}
					
			
	});
});

</script>