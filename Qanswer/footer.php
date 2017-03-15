<?php 
include_once("dbconnect.php");
$base = new Dmodel();
if(isset($_GET['ex_id'])){
	$exam_id = $_GET['ex_id'];
}

if(isset($exam_id)){
	$p_id = $base->create_id("id", "popularity_count");
	$sql_check ="SELECT * FROM popularity_count WHERE exam_code_id='$exam_id'";
	
	if($base->isUserExists($sql_check)){
		$data_array['id']  = $p_id;
		$data_array['exam_code_id'] = $exam_id;
		$data_array['get_count'] = "1";
		
		$insertdata = $base->_insertData("popularity_count", $data_array);
		
	}else{
		$get_new_count = $base->getPopularity($exam_id); 
	}
	
}



?>

					</div>
            	</div>
            </section>
        <!-- End Main Body -->
        
        
        <!-- Footer -->
        	<footer id="bottom-footer">
        		<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="footer"><p>&copy; 2015 All rights reserved</p></div>
						</div>
					</div>
                </div>
            </footer>
        <!-- End Footer -->
        	

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