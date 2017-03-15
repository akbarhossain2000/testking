<?php	
include_once("header.php");
if((isset($_SESSION['login']) && $_SESSION['user_type'] !="U") || $_SESSION['user_type'] =="A"){
	header("location: member_area.php");
}
$_SESSION['isLogin'];
$_SESSION['user_type'];
$_SESSION['isActive'];
$user_id = $_SESSION['user_id'];

?>

<div class="col-md-8">
	<div class="mainbody-left">
		<div class="add-div">
			<img src="img/add1.jpg" alt="" />
		</div>
		<div class="mainbody-left-bottom">
			
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="mainbody-right">
		<div class="add-div2">
			<img src="img/add2.jpg" alt="" />
		</div>
		<div class="mainbody-right-bottom">
			<div class="recent"><h3>Recent Comments</h3></div>
			<div class="comment-area">
				<ul id="comments">
					<?php
						for($c=0; $c<sizeof($comment_data); $c++){
							if($comment_data != NULL){
								echo"<li><b>".$comment_data[$c]['name']."</b>wrote<a href='javascript:void(0)'>".$comment_data[$c]['comment']."</a></li>";
							}
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
	


<?php
include_once("footer.php");
?>

<script type="text/javascript">
	$(document).ready(function(e){
		$(".vm_exam_list").click(function(){
			var vendor_id = $(this).attr('rel');
			//alert(vendor_id);
			var url = "m_exam_code.php?v_id="+vendor_id;
			
			window.open(url, '_SELF');
		});
		
	});
</script>