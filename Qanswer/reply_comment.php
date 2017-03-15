<?php
include_once("dbconnect.php");
$base = new Dmodel();

if(isset($_GET['com_id'])){
	$c_id = $_GET['com_id'];
}

$commet_by_id = $base->getCommentsByid($c_id);
//print_r($commet_by_id);

if(isset($_POST['reply_cmnt'])){
	
	$data_array['reply_name'] = htmlentities(mysql_real_escape_string($_POST['reply_name']));
	$data_array['reply_email'] = htmlentities(mysql_real_escape_string($_POST['reply_email']));
	$data_array['reply_comment'] = htmlentities(mysql_real_escape_string($_POST['reply_comment']));
	$data_array['re_date_time'] = htmlentities(mysql_real_escape_string($_POST['re_date_time']));
	$data_array['com_id'] = htmlentities(mysql_real_escape_string($_POST['com_id']));
	$data_array['exam_code_id'] = htmlentities(mysql_real_escape_string($_POST['exam_code_id']));
	$data_array['question_id'] = htmlentities(mysql_real_escape_string($_POST['question_id']));
	
	if($base->_insertData("reply_comments", $data_array)){
?>
	<script type="text/javascript">

		window.onunload = refreshParent;
			function refreshParent() {
				window.opener.location.reload(true);
				
				self.close();
		}

	</script>

<?php
		
	}else{
		print"<script>alert('Comment Send Failed!');</script>";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title></title>

    <!-- Bootstrap -->
   		<link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/uikit.min.css">
		<link rel="stylesheet" href="css/datepicker.css">
        <link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/responsive.css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900' rel='stylesheet' type='text/css'>
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
  </head>
  <body class="bodybg">
		<div class="container">
			<div class="row">
				<div class="post_comments">
					<div class="comment_form">
						<?php
						 /*if(isset($smsg)){
							 echo"<p style='color:green;'>$smsg</p>";
						 }else if(isset($errmsg)){
							 echo"<p style='color:red;'>$errmsg</p>";
						 }*/
						?>
						<h2>LEAVE A REPLY</h2>
						<form action="<?php htmlspecialchars($_SERVER['PHP_SELF'] , ENT_QUOTES ); ?>" method="post">
						
						  <input type="hidden" class="form-control" name="re_date_time" id="re_date_time" value="<?php echo date("Y-m-d H:i:s"); ?>" required>
						  
						  <input type="hidden" class="form-control" name="com_id" id="com_id" value="<?php echo $c_id; ?>" required>
						  
						  <input type="hidden" class="form-control" name="exam_code_id" id="exam_code_id" value="<?php echo $commet_by_id[0]['exam_code_id']; ?>" required>
						  
						  <input type="hidden" class="form-control" name="question_id" id="question_id" value="<?php echo $commet_by_id[0]['question_id']; ?>" required>
						  
						  <div class="form-group">
							<label for="exampleInputName">Name <i>*</i></label>
							<input type="text" class="form-control" name="reply_name" id="reply_name" placeholder="Name" required>
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail">Email <i>*</i></label>
							<input type="email" class="form-control" name="reply_email" id="reply_email" placeholder="Email Address" required>
						  </div>
						  <div class="form-group">
							<label for="exampleInputText">Comment</label>
							<textarea class="form-control" name="reply_comment" id="reply_comment" required></textarea>
						  </div>
						  
						  <input type="submit" name="reply_cmnt" class="btn btn-default" value="Reply Comment" />
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<script src="js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/uikit.min.js"></script>
		<script src="js/jquery-1.10.2.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
        <script src="js/main.js"></script>
        <script src="js/script.js"></script>
		
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
  </body>
</html>
<?php

?>