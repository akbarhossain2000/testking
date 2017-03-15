<?php
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "testking");
	$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	class Dmodel{
		private $_mysql_system = array();
		private $_mysql_resource = "";
		
		function __construct(){
			$this->_mysql_system["host"]	= DB_HOST;
			$this->_mysql_system["user"]	= DB_USER;
			$this->_mysql_system["pass"]	= DB_PASS;
			$this->_mysql_system["db_name"]= DB_NAME;
			$this->_mysql_resource = NEW mysqli($this->_mysql_system["host"], $this->_mysql_system["user"], $this->_mysql_system["pass"], $this->_mysql_system["db_name"]);
			if($this->_mysql_resource->connect_error){
				echo "Database Couldn't Connect!";
			}
			
		}
		
		public function _insertData($table_name, $data = array()){
			$sql = "";
			foreach($data as $k=>$v){
				if($sql != ''){
					$sql .= ", ";
				}
				$sql .= sprintf("%s='%s'", $this->_mysql_resource->escape_string($k), $this->_mysql_resource->escape_string($v));
			}
			
			$sql = "INSERT INTO {$table_name} SET {$sql}";
			$result = $this->_mysql_resource->query($sql);
			if($this->_mysql_resource->affected_rows>0){
				return true;
			}
				else{
					return false;
				}
			
		}
		
		public function create_id($field, $table_name){
			$sql = "SELECT MAX($field) as m_id FROM $table_name";
			$rec = $this->_mysql_resource->query($sql);
			if($row = $rec->fetch_array()){
				$mid	= $row['m_id'];
			}
			$mid++;
			return $mid;
		}
		
		public function getVendor(){
			$sql = "SELECT * FROM vendor WHERE status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$vendor_id = array();
			while($row = $rec->fetch_object()){
				$vid		= $row->vendor_id;
				$vname		= $row->vendor_name;
				$vendor_id[$vid] = $vname;
			}
			return $vendor_id;
		}
		
		public function getExamcode(){
			$sql = "SELECT * FROM exam_code WHERE status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$exam_code_id = array();
			while($row = $rec->fetch_object()){
				$exam_id		= $row->exam_code_id;
				$exam_code		= $row->exam_code;
				$exam_code_id[$exam_id] = $exam_code;
			}
			return $exam_code_id;
		}
		
		public function getQuestionid(){
			$sql = "SELECT * FROM question WHERE status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$question_id = array();
			while($row = $rec->fetch_object()){
				$q_id			= $row->question_id;
				$question		= $row->question;
				$question_id[$q_id] = $question;
			}
			return $question_id;
		}
		
		
		public function getVendorData(){
			$sql = "SELECT * FROM vendor WHERE status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$vendor_name = array();
			while($row = $rec->fetch_assoc()){
				
				$vendor_name[] = $row;
			}
			return $vendor_name;
		}
		
		public function getExamcodeData(){
			$sql = "SELECT * FROM exam_code WHERE status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$exam_code_data = array();
			while($row = $rec->fetch_assoc()){
				$exam_code_data[] = $row;
			}
			return $exam_code_data;
		}
		
		public function getQuestionData(){
			$sql = "SELECT * FROM question WHERE status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$question_data = array();
			while($row = $rec->fetch_assoc()){
				$question_data[] = $row;
			}
			return $question_data;
		}
		
		public function getEachvendor($vid){
			$sql = "SELECT * FROM vendor WHERE vendor_id ='$vid' AND status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$vendor = array();
			if($row = $rec->fetch_assoc()){
				$vendor[] = $row;
			}
			return $vendor;
		}
		
		public function getEachexamcode($eid){
			$sql = "SELECT * FROM exam_code WHERE exam_code_id ='$eid' AND status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$exam_data = array();
			if($row = $rec->fetch_assoc()){
				$exam_data[] = $row;
			}
			return $exam_data;
		}
		
		public function _updateData($sql){
			$result = $this->_mysql_resource->query($sql);
			if($this->_mysql_resource->affected_rows>0){
				return true;
			}
				else{
					return false;
				}
		}
		
		public function _deleteData($sql){
			$result = $this->_mysql_resource->query($sql);
			if($this->_mysql_resource->affected_rows>0){
				return true;
			}
				else{
					return false;
				}
		}
		
		public function logIn($sql){
			$result=$this->_mysql_resource->query($sql);
			if($result->num_rows>0){
				return true;
			}else{
				return false;
			}
		}
		
		
		public function isExists($sql){
			@$result = $this->_mysql_resource->query(@$sql);
			if(@$result->num_rows>0){
				return false;
			}else{
				return true;
			}
		}
		
		
		public function getAnswerData($ques_id){
			$sql = "SELECT * FROM answer WHERE question_id = '$ques_id' AND status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$answer_data = array();
			if($row = $rec->fetch_assoc()){
				$answer_data[] = $row;
			}
			return $answer_data;
		}
		
		public function getQuestion($ex_id){
			$sql = "SELECT * FROM question WHERE exam_code_id='$ex_id' AND status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$question_data = array();
			while($row = $rec->fetch_assoc()){
				$question_data[] = $row;
			}
			return $question_data;
		}
		
		public function getExamcodeId($exam_id, $v_id){
			$sql = "SELECT * FROM exam_code WHERE exam_code='$exam_id' AND vendor_id='$v_id' AND status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$exam_code_id = array();
			if($row = $rec->fetch_assoc()){
				$exam_code_id[] = $row;
			}
			return $exam_code_id;
		}
		
		public function getQuesAns($qid){
			$sql = "SELECT * FROM question, answer WHERE question.question_id='$qid' AND question.status='1' AND answer.question_id='$qid' AND answer.status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$data = array();
			if($row = $rec->fetch_assoc()){
				$data[] = $row;
			}
			return $data;
		}
		
		public function getVendorExamcode($v_id){
			$sql = "SELECT * FROM exam_code WHERE vendor_id='$v_id' AND status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$exam_code_id = array();
			while($row = $rec->fetch_object()){
				$exam_id		= $row->exam_code_id;
				$exam_code		= $row->exam_code;
				$exam_code_id[$exam_id] = $exam_code;
			}
			return $exam_code_id;
		}
		
		public function loginData(){
			$sql = "SELECT * FROM admin_login WHERE user_type='SA' OR user_type='NA'";
			$rec = $this->_mysql_resource->query($sql);
			$data = array();
			while($row = $rec->fetch_assoc()){
				$data[] = $row;
			}
			return $data;
			
		}
		
		public function eachloginData($id){
			$sql = "SELECT * FROM admin_login WHERE id='$id'";
			$rec = $this->_mysql_resource->query($sql);
			$data = array();
			if($row = $rec->fetch_assoc()){
				$data[] = $row;
			}
			return $data;
			
		}
		
		
	}
	
	

?>