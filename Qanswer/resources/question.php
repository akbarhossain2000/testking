<?php
include_once("header_one.php");
include_once("dbconnect.php");
$base = new Dmodel();
$question_data = $base->getQuestionData();

if(isset($_GET['ex_id'])){
	$id = $_GET['ex_id'];

}

$ex_data = $base->getExamcode($id);
$exam_id = $ex_data[0]['exam_code'];
$exam_name = $ex_data[0]['exam_name'];
$vendor_id = $ex_data[0]['vendor_id'];
$exam_list = $base->getExamlist($vendor_id);

$rec_limit = 10;
$page = 1;
$start_from = $page * $rec_limit;

?>

<div class="col-md-8">
	
	<div class="mainbody-left">
		<div class="add-div">
			<img src="img/add1.jpg" alt="" />
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="mainbody-left-bottom">
					<div class="ex_info">
						<h6>EXAM INFORMATION</h6>
						<div class="ex_details">
							<?php
							echo "<p>Exam $exam_id: $exam_name</p>";
							?>
						</div>
					</div>
					
					<div class="other_ex_list">
						<h6>OTHER EXAMS</h6>
						<div class="ex_list_details">
							<ul>
								<?php
									for($i=0; $i<sizeof($exam_list); $i++)
									echo"<li><a href='question.php?ex_id=".$exam_list[$i]['exam_code_id']."'>".$exam_list[$i]['exam_code']."</a></li>";
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="mainbody-left-bottom-right">
					<div class="question_list">
						<?php
							
								for($i=0; $i<sizeof($question_data); $i++){
									if($question_data[$i]['exam_code_id']== $id){
										$separator = $question_data[$i]['date_time'];
										$date = split(" ", $separator)[0];
										$time = split(" ", $separator)[1];
										if($question_data[$i]['question'] != NULL){
											echo"<div class='q_list_details'>
											<h3><a href='answer.php?ques_id=".$question_data[$i]['question_id']."'>".$question_data[$i]['question']."</a></h3>
											<div class='date_comment'>
												<p><i></i>Posted by <b>".$question_data[$i]['user_id']."</b> on <a href='#'>".date("M d, y", strtotime($date))."</a><a href='#'><i>1</i>comment</a></p>
												
												<a href='answer.php?ques_id=".$question_data[$i]['question_id']."'><button type='button' class='btn btn-default pull-right'>Click to get answer here</button></a>
											</div>
										</div>";
										}else{
											echo"<div class='q_list_details'>
											<a href='answer.php?ques_id=".$question_data[$i]['question_id']."'><img src='admin/img/".$question_data[$i]['img_question']."'/></a>
											<div class='date_comment'>
												<p><i></i>Posted by <b>".$question_data[$i]['user_id']."</b> on <a href='#'>".date("M d, y", strtotime($date))."</a><a href='#'><i>1</i>comment</a></p>
												
												<a href='answer.php?ques_id=".$question_data[$i]['question_id']."'><button type='button' class='btn btn-default pull-right'>Click to get answer here</button></a>
											</div>
										</div>";
										}
										
									}
								}
						
						?>
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
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment sdfdj kaksjdfkdfd sfdsjfksdj</a></li>
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment</a></li>
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment</a></li>
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment</a></li>
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment</a></li>
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment</a></li>
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment</a></li>
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment</a></li>
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment</a></li>
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment</a></li>
					<li><b>admin</b>wrote<a href="#">Thanks for yours comment</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
						
						
<?php
include_once("footer.php");
?>
