<?php
include_once("header_one.php");
include_once("dbconnect.php");
$base = new Dmodel();

if(isset($_GET['ques_id'])){
	$question_id = $_GET['ques_id'];
}

if(isset($_POST['comments'])){
	
	$data_array['name'] = htmlentities(mysql_real_escape_string($_POST['name']));
	$data_array['email'] = htmlentities(mysql_real_escape_string($_POST['email']));
	$data_array['comment'] = htmlentities(mysql_real_escape_string($_POST['comment']));
	$data_array['date_time'] = htmlentities(mysql_real_escape_string($_POST['date_time']));
	$data_array['exam_code_id'] = htmlentities(mysql_real_escape_string($_POST['exam_code_id']));
	$data_array['question_id']	= htmlentities(mysql_real_escape_string($_POST['question_id']));
	
	if($base->_insertData("comments", $data_array)){
		$smsg = "Comment Send Successfully!";
	}else{
		$errmsg = "Comment Send Failed!";
	}
	
}

$vendor_data	= $base->getVendorData();
$exam_data		= $base->getExamcodeData();
$question_data 	= $base->getQuestionData();
//$answer_data	= $base->getAnswerData();
@$answer_data	= $base->getAnswerData($question_id);
//@$answer_data[0]['answer'];
$question		= $base->getQuestion($question_id);
$q_id = $question[0]['exam_code_id'];
$qn	= $question[0]['question'];
$img_qn = $question[0]['img_question'];

$qs_count = $base->getQuestionCount($q_id);

$comments = $base->getComments($q_id, $question_id);
$comments_count = $base->getCountComments($q_id, $question_id);

?>
<style type="text/css">
.blue{color:green; font-weight:bold;}
.focus_ans{display:block;}
.hide_ans{display:none;}
#ans_des{display:block;}
#hide_des{display:none;}
</style>
<div class="col-md-8">
							
<div class="mainbody-left">
	<div class="add-div">
		<img src="img/add1.jpg" alt="" />
	</div>
	<div class="row">
		<div class="col-md-2  mright">
			<div class="mainbody-left-bottom">
				
				<div class="ans_ex_list">
					<h6>QUESTIONS</h6></br> =>
					<div class="ans_ex_list_details">
						<ul>
						<?php
							$j=0;
							for($i=0; $i<sizeof($qs_count); $i++){
								$j++;
								if($qs_count[$i]['question_id'] != $question_id){
								echo"<li><a href='answer.php?ques_id=".$qs_count[$i]['question_id']."' class='qn_sl'>$j</a></li>";
								}else{
									echo"<li style='color:green;' class='q_sl_no' rel='".$qs_count[$i]['question_id']."_".$j."'><b>$j</b></li>";
								}
								
							}
							$total_ques = $j;
							
						?>
							
						</ul>
					</div></br> =>
					
				</div>
			</div>
		</div>
		<div class="col-md-10">
			<div class="mainbody-left-bottom-right">
				<div class="question_list">
					<?php
						
					echo"<div class='q_list_details'>";
						if(($qn != NULL) && ($img_qn != NULL)){
							echo"<h3>".$qn."</h3>";
							echo"<img src='admin/img/".$img_qn."' alt='' />";
						}else if($qn != NULL){
							echo"<h3>".$qn."</h3>";
						}else{
							echo"<img src='admin/img/".$img_qn."' alt='' />";
						}
						$separate = $question[0]['date_time'];
						$date = split(" ", $separate)[0];
						$time = split(" ", $separate)[1];
						echo"<div class='date_comment'>
							<p><i></i>Posted by <b>".$question[0]['user_id']."</b> on <a href='javascript:void(0)'>".date("M d, y", strtotime($date))."</a><a href='javascript:void(0)'>";
							if($comments_count == 0){
								echo "comment";
							}else{
								echo"<i>($comments_count)</i> comment";
							}
							echo"</a></p>
						</div>";
						
						if((@$answer_data[0]['answer'] != NULL) && (@$answer_data[0]['img_answer'] != NULL)){
							echo"<div class='answer'>";
								echo "<img src='admin/img/".@$answer_data[0]['img_answer']."' alt='' />";
							  @$answer = $answer_data[0]['answer'];
							  @$separate = explode("#", $answer);
							  for($a=0; $a<sizeof($separate); $a++){
								  if(substr($separate[$a], 0,1) == "@"){
									  $ans = substr($separate[$a],1,strlen($separate[$a]));
									  echo"<p class = \"r_ans\"><i><b>".($a +1)."</b>. </i>$ans</p></br>";
								  } else {
									  echo"<p><i><b>".($a +1)."</b>. </i>$separate[$a]</p></br>";
								  }
								  
							  }
							echo"</div>
							
							<div class='ans_button'>
								<button class='btn btn-primary focus_ans pull-right'>Show Answer</button>
								<button class='btn btn-primary hide_ans pull-right'>Hide Answer</button>
							</div>
							
							<div class='desc_show'>
								<h5><b>Description:</b></h5> 
								<p>".$answer_data[0]['description']."</p>
							</div>";
							}else if(@$answer_data[0]['answer'] != NULL){
							echo"<div class='answer'>";
							  @$answer = $answer_data[0]['answer'];
							  @$separate = explode("#", $answer);
							  for($a=0; $a<sizeof($separate); $a++){
								  if(substr($separate[$a], 0,1) == "@"){
									  $ans = substr($separate[$a],1,strlen($separate[$a]));
									  echo"<p class = \"r_ans\"><i><b>".($a +1)."</b>. </i>$ans</p></br>";
								  } else {
									  echo"<p><i><b>".($a +1)."</b>. </i>$separate[$a]</p></br>";
								  }
								  
							  }
							echo"</div>
							
							<div class='ans_button'>
								<button class='btn btn-primary focus_ans pull-right'>Show Answer</button>
								<button class='btn btn-primary hide_ans pull-right'>Hide Answer</button>
							</div>
							
							<div class='desc_show'>
								<h5><b>Description:</b></h5> 
								<p>".$answer_data[0]['description']."</p>
							</div>";
							}else{
							echo"<div class='answer'>";
								echo "<img src='admin/img/".@$answer_data[0]['img_answer']."' alt='' />";
								echo"</div>
							
							<div class='ans_description'>
								<button class='btn btn-primary pull-right' id='ans_des'>Show Description</button>
								<button class='btn btn-primary pull-right' id='hide_des'>Hide Description</button>
							</div>
							<div class='desc_show'>
								<h5><b>Description:</b></h5> 
								<p>".@$answer_data[0]['description']."</p>
							</div>";
							}
					echo"</div>";
						
					?>
				<div class='add_div3'>
					<img src='img/add1.jpg' alt='' />
				</div>	
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="prev"><a href="javascript:void(0)" class="prev_ques">Previous Question</a></div>
					</div>
				<div class="col-md-6">
					<div class="next"><a href="javascript:void(0)" class="next_ques">Next Question</a></div>
				</div>
			</div>
			<div class="comment_area">
				<div class="dis"><p>Discussion</p></div>
				<?php
				if($comments == NULL){
				?>
				<h2>Not Comment Yet</h2>
				<?php
				}else{
				  for($i=0; $i<sizeof($comments); $i++){
					  $d_time = html_entity_decode(mysql_real_escape_string($comments[$i]['date_time']));
					  $date	  = split(" ", $d_time)[0];
					  $time	  = split(" ", $d_time)[1];
					  $comment_id = html_entity_decode(mysql_real_escape_string($comments[$i]['id']));
					  $comment_ques_id = html_entity_decode(mysql_real_escape_string($comments[$i]['question_id']));
					  $reply_cmnt = $base->getReplyComments($comment_id, $comment_ques_id);
					  
				?>
					<div class="view_comments">
						<div class="cmnt_show">
							<h6><b><?php echo html_entity_decode(mysql_real_escape_string($comments[$i]['name']));?></b> says:</h6>
							<a href=""><?php echo date("M d, y",strtotime($date));?> at <?php echo date("h:i A",strtotime($time));?></a>
							<p><?php echo $comments[$i]['comment'];?></p>
							
							<?php
							if($reply_cmnt != NULL){
								for($j=0; $j<sizeof($reply_cmnt); $j++){
									@$re_date_time = html_entity_decode(mysql_real_escape_string($reply_cmnt[$j]['re_date_time']));
									@$re_date = split(" ", $re_date_time)[0];
									@$re_time = split(" ", $re_date_time)[1];
									echo"<div class='re_cmnt_show'>
										<h6><b>".html_entity_decode(mysql_real_escape_string($reply_cmnt[$j]['reply_name']))."</b> says:</h6>
										<a href=''>".date("M d, y", strtotime($re_date))." at ".date("h:i A", strtotime($re_time))."</a>
										<p>".html_entity_decode(mysql_real_escape_string($reply_cmnt[$j]['reply_comment']))."</p>
									</div>";
								}
							}
							?>
							<a href="javascript:void(0)" class='btn btn-default btn-sm rc_id' rel="<?php echo html_entity_decode(mysql_real_escape_string($comments[$i]['id'])); ?>">Reply</a>
						</div>
					</div>
				<?php
				  }
				}
				?>
				<div class="post_comments">
					<div class="comment_form">
						<?php
						 if(isset($smsg)){
							 echo"<p style='color:green;'>$smsg</p>";
						 }else if(isset($errmsg)){
							 echo"<p style='color:red;'>$errmsg</p>";
						 }
						?>
						<h2>LEAVE A REPLY</h2>
						<form action="<?php htmlspecialchars($_SERVER['PHP_SELF'] , ENT_QUOTES ); ?>" method="post">
						
						  <input type="hidden" class="form-control" name="date_time" id="date_time" value="<?php echo date("Y-m-d H:i:s"); ?>" required>
						  
						  <input type="hidden" class="form-control" name="exam_code_id" id="exam_code_id" value="<?php echo $q_id; ?>" required>
						  
						  <input type="hidden" class="form-control" name="question_id" id="question_id" value="<?php echo $question_id; ?>" required>
						  
						  <div class="form-group">
							<label for="exampleInputName">Name <i>*</i></label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail">Email <i>*</i></label>
							<input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
						  </div>
						  <div class="form-group">
							<label for="exampleInputText">Comment</label>
							<textarea class="form-control" name="comment" id="comment" required></textarea>
						  </div>
						  
						  <input type="submit" name="comments" class="btn btn-default" value="Post Comment" />
						</form>
					</div>
				</div>
			</div>
			</div>
		</div>
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
	$(document).ready(function(e) {       
		$(".focus_ans").click(function(){
			var html = "<button class='btn btn-primary hide_ans'>Hide Answer</button>";
			$(".r_ans").css('color','green');
			$(".r_ans").css('font-weight','bold');
			$(this).css('display','none');
			$(".hide_ans").css('display','block');
			$(".desc_show").css('display','block');
		});
		
		$(".hide_ans").click(function(){
			$(".r_ans").css('color','#333333');
			$(".r_ans").css('font-weight','normal');
			$(this).css('display','none');
			$(".desc_show").css('display','none');
			$(".focus_ans").css('display','block');
		});
		
		$("#ans_des").click(function(){
			$(this).css('display','none');
			$("#hide_des").css('display','block');
			$(".desc_show").css('display','block');
		});
		
		$("#hide_des").click(function(){
			$(this).css('display','none');
			$(".desc_show").css('display','none');
			$("#ans_des").css('display','block');
		});
		
		$(".rc_id").click(function(){
			var id = $(this).attr('rel');
			var url = "reply_comment.php?com_id="+id;
			
			window.open(url, "", "height=500, width=500");
		});
		
		$(".prev_ques").click(function(){
			var qs_sl_no = $(".q_sl_no").attr('rel');
			var question =<?php echo json_encode($qs_count);?>;
			var ques_id  = qs_sl_no.split("_")[0];
			var ques_sl  = qs_sl_no.split("_")[1];
			var prev_val = 1;
				if(ques_sl == prev_val){
					$(this).hide();
				}else{
					if(ques_sl > prev_val){
						var sl = ques_sl - 1;
						var url		 = "answer.php?ques_id="+question[sl-1].question_id;
						window.open(url, "_SELF");
					}
				}
			
		});
		
		$(".next_ques").click(function(){
			var qs_sl_no = $(".q_sl_no").attr('rel');
			var question =<?php echo json_encode($qs_count);?>;
			var ques_id  = qs_sl_no.split("_")[0];
			var ques_sl  = qs_sl_no.split("_")[1];
			var total 	 =<?php echo $total_ques; ?>;
				if(ques_sl == total){
					$(this).hide();
				}else{
					if(total > ques_sl){
						var url		 = "answer.php?ques_id="+question[ques_sl].question_id;
						 window.open(url, "_SELF");
					}
						
				}
		});
		
    });
</script>