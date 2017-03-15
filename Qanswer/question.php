<?php
include_once("header_one.php");
include_once("dbconnect.php");
$base = new Dmodel();
$question_data = $base->getQuestionData();

if(isset($_GET['ex_id'])){
	$id = $_GET['ex_id'];

}
@$ques_by_ex = $base->getQuesByex($id);
@$ex_data = $base->getExamcode($id);
@$exam_id = $ex_data[0]['exam_code'];
@$exam_name = $ex_data[0]['exam_name'];
@$vendor_id = $ex_data[0]['vendor_id'];
@$exam_list = $base->getExamlist($vendor_id);

$rec_limit = 10;
$count= sizeof($ques_by_ex);
$total_pages = ceil($count / $rec_limit); 

if($total_pages < 1){
	$total_pages = 1;
}

$pagenum = 1;
if(isset($_GET['pn'])){
	$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
}
if($pagenum < 1){
	$pagenum = 1;
}else if($pagenum > $total_pages){
	$pagenum = $total_pages;
}
$limit = 'LIMIT ' .($pagenum-1) * $rec_limit .','.$rec_limit;
//$start_from = ($page-1) * $rec_limit; 
$page_question_data = $base->limiTation($id, $limit);

$textline1 = "Questions (<b>$count</b>)";
$textline2 = "Page <b>$pagenum</b> of <b>$total_pages</b>";

$paginationCtrls = "";
if($total_pages != 0){
	if($pagenum > 1){
		$previous = $pagenum - 1;
		$paginationCtrls .="<a href='".$_SERVER['PHP_SELF']."?ex_id=".$id."&&pn=".$previous."' class='btn btn-default btn-sm'>Previous</a> &nbsp; &nbsp;";
		
		for($i=$pagenum-4; $i<$pagenum; $i++){
			if($i > 0){
				$paginationCtrls .="<a href='".$_SERVER['PHP_SELF']."?ex_id=".$id."&&pn=".$i."' class='btn btn-default btn-sm'>".$i."</a> &nbsp;";
			}
		}
	}
	$paginationCtrls .= ''.$pagenum.' &nbsp';
	for($i=$pagenum+1; $i<=$total_pages; $i++){
			$paginationCtrls .="<a href='".$_SERVER['PHP_SELF']."?ex_id=".$id."&&pn=".$i."' class='btn btn-default btn-sm'>".$i."</a> &nbsp;";
			if($i >= $pagenum + 4){
				break;
			}
	}
	if($pagenum != $total_pages){
		$next = $pagenum + 1;
		$paginationCtrls .="<a href='".$_SERVER['PHP_SELF']."?ex_id=".$id."&&pn=".$next."' class='btn btn-default btn-sm'>Next</a> &nbsp; &nbsp;";
	}
		
}

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
									if($exam_list[$i]['exam_code_id'] != $id){
										echo"<li><a href='question.php?ex_id=".$exam_list[$i]['exam_code_id']."'>".$exam_list[$i]['exam_code']."</a></li>";
									}else{
										echo"<li style='color:green;'><b>".$exam_list[$i]['exam_code']."</b></li>";
									}
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
							echo"<h2>".$textline1." Paged</h2>";
							echo"<p>$textline2</p>";
							for($i=0; $i<sizeof($page_question_data); $i++){
							  $separator = $page_question_data[$i]['date_time'];
							  $date = split(" ", $separator)[0];
							  $time = split(" ", $separator)[1];
								if(($page_question_data[$i]['question'] != NULL) && ($page_question_data[$i]['img_question'] != NULL)){
								  echo"<div class='q_list_details'>
										
									<h3><a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'>".$page_question_data[$i]['question']."</a></h3>
									<img src='admin/img/".$page_question_data[$i]['img_question']."'/>
									<div class='date_comment'>
										<p><i></i>Posted by <b>".$page_question_data[$i]['user_id']."</b> on <a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'>".date("M d, y", strtotime($date))."</a><a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'>";
										if($base->getCountComments($id, $page_question_data[$i]['question_id']) == 0){
											echo "comment";
										}else{
											echo"<i>(".$base->getCountComments($id, $page_question_data[$i]['question_id']).")</i> comment";
										}
										echo"</a></p>
										
										<a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'><button type='button' class='btn btn-default pull-right'>Click to get answer here</button></a>
									</div>
								  </div>";
								}else if($page_question_data[$i]['question'] != NULL){
								  echo"<div class='q_list_details'>
									<h3><a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'>".$page_question_data[$i]['question']."</a></h3>
									<div class='date_comment'>
										<p><i></i>Posted by <b>".$page_question_data[$i]['user_id']."</b> on <a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'>".date("M d, y", strtotime($date))."</a><a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'>";
										if($base->getCountComments($id, $page_question_data[$i]['question_id']) == 0){
											echo "comment";
										}else{
											echo"<i>(".$base->getCountComments($id, $page_question_data[$i]['question_id']).")</i> comment";
										}
										echo"</a></p>
										
										<a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'><button type='button' class='btn btn-default pull-right'>Click to get answer here</button></a>
									</div>
								  </div>";
								}else{
								  echo"<div class='q_list_details'>
									<a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'><img src='admin/img/".$page_question_data[$i]['img_question']."'/></a>
									<div class='date_comment'>
										<p><i></i>Posted by <b>".$page_question_data[$i]['user_id']."</b> on <a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'>".date("M d, y", strtotime($date))."</a><a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'>";
										if($base->getCountComments($id, $page_question_data[$i]['question_id']) == 0){
											echo "comment";
										}else{
											echo"<i>(".$base->getCountComments($id, $page_question_data[$i]['question_id']).")</i> comment";
										}
										echo"</a></p>
										
										<a href='answer.php?ques_id=".$page_question_data[$i]['question_id']."'><button type='button' class='btn btn-default pull-right'>Click to get answer here</button></a>
									</div>
								  </div>";
								}

									
							}
								
							echo"<div class='pagination_controls'>".$paginationCtrls."</div>";
						
						?>
					</div>
					<?php
						
					?>
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
