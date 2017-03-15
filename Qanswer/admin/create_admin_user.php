<?php
	include_once("header.php");
	include_once("dbconnect.php");
	$base= new Dmodel();
	
	$login_info 	= $base->loginData();
	$user = @$_SESSION['user_name'];
	
	
	
	if(isset($_POST['create'])){
		extract($_POST);
		if($user_type !== ""){
			$sql_check = "SELECT * FROM admin_login WHERE user_name='".$_POST['user_name']."'";
		
			if($base->isExists($sql_check)){
				$data_array['id'] = "$id";
				$data_array['user_name'] = "$user_name";
				$data_array['password']  = sha1($password);
				$data_array['user_type'] = "$user_type";
				
				if($base->_insertData("admin_login", $data_array)){
					print"<script>alert('Data Save Successfully!');
					window.location.href='create_admin_user.php';
					</script>";
				}else{
					print"<script>alert('Data Save Failed!');</script>";
				}
			}else {
				echo"This User Already Exists!";
			}
		}else{
			print '<script>alert("Please Select User Type!");</script>';
		}
		
	}
	$id = $base->create_id("id", "admin_login");
?>
<div class="uiForm">
	<h3><?php if(@$success_msg){ echo @$success_msg; } ?></h3>
	<form action="create_admin_user.php" method="post">
	<input type="text" id="id" name="id" value="<?php echo $id; ?>" />
	
	<div class="form-group">
        <label class="control-label" for="textinput">Select User Type:</label>
        <div class="input_box">
			<select name="user_type" id="user_type">
				<option value="">--- Select here ---</option>
				<option value="SA">Super Admin</option>
				<option value="NA">Admin</option>
			</select>

        </div>
	</div>
	
	<div class="form-group">
        <label class="control-label" for="textinput">User Name :</label>
        <div class="input_box">
            <input type="text" id="user_name" name="user_name" required placeholder="Enter User Name" class="form-control input-md"/>

        </div>
	</div>
	
	<div class="form-group">
        <label class="control-label" for="textinput">Password :</label>
        <div class="input_box">
            <input type="password" id="password" name="password" required placeholder="Enter Your Password" maxlength="30" class="form-control input-md"/>

        </div>
	</div>
	
    
	<div class="s_button">
		<input type="submit" value="Create" id="create" name="create" class="btn btn-primary"/>
		<button type="button" class="btn btn-success view_user">View</button>
	</div>
	</form>
	
</div>



<div class='c_button'></div>
<div class="uiForm2"></div>



<?php
  include_once("footer.php");
?>

<script type="text/javascript">
			$(document).ready(function(){
				$(".view_user").click(function(){
					var login_data =<?php echo json_encode($login_info);?>;
					var login_user =<?php echo json_encode($user);?>;
					var c_div ="<button class='btn btn-danger btn-close closeto'>X</button>";
					var text ="<table class='table table-bordered'>";
					text += "<tr>";
					text += "<th>Sl. No</th>";
					text += "<th>User Name</th>";
					text += "<th>Password</th>";
					text += "<th>User Type</th>";
					text += "<th>Edit</th>";
					text += "<th>Delete</th>";
					text += "</tr>";
					for(id in login_data){
						text += "<tr class='user' rel='"+id+"'>";
						text += "<td>"+login_data[id].id+"</td>";
						text += "<td>"+login_data[id].user_name+"</td>";
						text += "<td>"+login_data[id].password+"</td>";
						text += "<td>"+login_data[id].user_type+"</td>";
						if((login_user == login_data[id].user_name && login_data[id].user_type == "SA")){
							text += "<td><a href='javascript:void(0)' class='btn btn-primary user_edit' rel='"+login_data[id].id+"'>Edit</a></td>";
							text += "<td><a href='javascript:void(0)' class='btn btn-danger user_delete' del='"+login_data[id].id+"'>Delete</a></td>";
							text += "</tr>";
						}else if(login_data[id].user_type == "SA"){
							text += "<td><a href='javascript:void(0)' class='btn btn-primary' disabled >Edit</a></td>";
							text += "<td><a href='javascript:void(0)' class='btn btn-danger' disabled >Delete</a></td>";
							text += "</tr>";
						}else{
							text += "<td><a href='javascript:void(0)' class='btn btn-primary user_edit' rel='"+login_data[id].id+"'>Edit</a></td>";
							text += "<td><a href='javascript:void(0)' class='btn btn-danger user_delete' del='"+login_data[id].id+"'>Delete</a></td>";
							text += "</tr>";
						}
					}
					$(".uiForm").hide();
					$(this).hide();
					$(".uiForm2").html(text);
					$(".c_button").html(c_div);
					
					$(".closeto").click(function(){
						$(".uiForm2").hide();
						$(".c_button").hide();
						$(".uiForm").show();
						$(".view_user").show();
					});
															
					$(".user_edit").click(function(){
						var eid = $(this).attr('rel');
						var url = "edit_admin_user.php?e_id="+eid;
						
						window.open(url, "", "height=400, width=500");
					});
					
					$(".user_delete").click(function(){
						var did = $(this).attr('del');
						var answer = confirm('Are you sure delete this vendor?');
						if(answer){
							
							$.ajax({
									url:"delete_sql.php",
									type:"post",
									data:{action:"getuserDelete", del_id:did},
									success:function(resp){
										
									}
							});	
							$(this).parents(".user").animate({ backgroundColor: "#003" }, "slow")
  .animate({ opacity: "hide" }, "slow");
						}
					});
				
				});
				
				
			});
			
			
			
</script>


