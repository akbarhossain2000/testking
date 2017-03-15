<?php 


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
		
		
		<script type="text/javascript">
			$(document).ready(function(e){
				
				
				$(".question_view").click(function(){
					var exam_code_id =$(this).attr('rel');
					//alert(exam_code_id);
					var url = "question.php?ex_id="+exam_code_id;
					
					window.open(url, '_blank');
				});
				
				$(".v_exam_list").click(function(){
					var vendor_id = $(this).attr('rel');
					//alert(vendor_id);
					var url = "exam_code.php?v_id="+vendor_id;
					
					window.open(url, '_blank');
				});
				
			});
		</script>

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