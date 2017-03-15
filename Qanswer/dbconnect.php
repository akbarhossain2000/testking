<?php
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "testking");
	//$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	class Dmodel{
		private $_mysql_system = array();
		private $_mysql_resource = "";
		
		function __construct(){
			$this->_mysql_system["host"]	= DB_HOST;
			$this->_mysql_system["user"]	= DB_USER;
			$this->_mysql_system["pass"]	= DB_PASS;
			$this->_mysql_system["db_name"]= DB_NAME;
			$this->_mysql_resource = new mysqli($this->_mysql_system["host"], $this->_mysql_system["user"], $this->_mysql_system["pass"], $this->_mysql_system["db_name"]);
			if($this->_mysql_resource->connect_error){
				echo "Database Couldn't Connect!";
			}
			//print_r(self::$_mysql_resource);
		}
		
		public function getDBConnection(){
			return $this->_mysql_resource;
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
		
		public function getVendorData(){
			$sql = "SELECT * FROM vendor WHERE status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$vendor_name = array();
			while($row = $rec->fetch_assoc()){
				
				$vendor_name[] = $row;
			}
			return $vendor_name;
		}
		
		public function getVendorName($id){
			$sql = "SELECT * FROM vendor WHERE vendor_id='$id'";
			$rec = $this->_mysql_resource->query($sql);
			while($row = $rec->fetch_assoc()){
				
				$vendor_name = $row['vendor_name'];
			}
			return $vendor_name;
		}
		
		public function getExamcodeData(){
			$sql = "SELECT * FROM exam_code";
			$rec = $this->_mysql_resource->query($sql);
			$exam_code_data = array();
			while($row = $rec->fetch_assoc()){
				$exam_code_data[] = $row;
			}
			return $exam_code_data;
		}
		
		public function getExamcodeId($id){
			$sql = "SELECT * FROM exam_code WHERE exam_code_id = '$id'";
			$rec = $this->_mysql_resource->query($sql);
			while($row = $rec->fetch_assoc()){
				$vendor_id = $row['vendor_id'];
			}
			return $vendor_id;
		}
		
		public function getExamcode($id){
			$sql = "SELECT * FROM exam_code WHERE exam_code_id = '$id'";
			$rec = $this->_mysql_resource->query($sql);
			$ex_code = array();
			while($row = $rec->fetch_assoc()){
				$ex_code[] = $row;
			}
			return $ex_code;
		}
		
		public function getExamlist($id){
			$sql = "SELECT * FROM exam_code WHERE vendor_id = '$id'";
			$rec = $this->_mysql_resource->query($sql);
			$ex_code = array();
			while($row = $rec->fetch_assoc()){
				$ex_code[] = $row;
			}
			return $ex_code;
		}
		
		public function getQuestionData(){
			$sql = "SELECT * FROM question";
			$rec = $this->_mysql_resource->query($sql);
			$question_data = array();
			while($row = $rec->fetch_assoc()){
				$question_data[] = $row;
			}
			return $question_data;
		}
		
		public function getQuestion($id){
			$sql = "SELECT * FROM question WHERE question_id = '$id'";
			$rec = $this->_mysql_resource->query($sql);
			$question = array();
			while($row = $rec->fetch_assoc()){
				$question[] = $row;
			}
			return $question;
		}
		
		public function getQuestionCount($id){
			$sql = "SELECT question_id FROM question WHERE exam_code_id = '$id'";
			$rec = $this->_mysql_resource->query($sql);
			$qs_id = array();
			while($row = $rec->fetch_assoc()){
				$qs_id[]= $row;
			}
			return $qs_id;
		}
		
		/*public function getAnswerData(){
			$sql = "SELECT * FROM answer";
			$rec = $this->_mysql_resource->query($sql);
			$answer_data = array();
			while($row = $rec->fetch_assoc()){
				$answer_data[] = $row;
			}
			return $answer_data;
		}*/
		
		public function getAnswerData($qs_id){
			$sql = "SELECT * FROM answer WHERE question_id = '$qs_id'";
			$rec = $this->_mysql_resource->query($sql);
			$answer_data = array();
			if($row = $rec->fetch_assoc()){
				$answer_data[] = $row;
			}
			return $answer_data;
		}
		
		public function getQuesByex($exid){
			$sql = "SELECT * FROM question WHERE exam_code_id='$exid'";
			$rec = $this->_mysql_resource->query($sql);
			$question_data = array();
			while($row = $rec->fetch_assoc()){
				$question_data[] = $row;
			}
			return $question_data;
		}
		
		public function limiTation($exc_id, $limit){
			$sql = "SELECT * FROM question WHERE exam_code_id='$exc_id' $limit";
			$rec =$this->_mysql_resource->query($sql);
			$data = array();
			while($row = $rec->fetch_assoc()){
				$data[] = $row;
			}
			return $data;
		}
		
		public function isUserExists($sql){
			@$result = $this->_mysql_resource->query(@$sql);
			if(@$result->num_rows>0){
				return false;
			}else{
				return true;
			}
		}
		
		public function getComments($ex_id, $qs_id){
			$sql="SELECT * FROM comments WHERE exam_code_id='$ex_id' AND question_id='$qs_id' AND status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$comment_data = array();
			while($row = $rec->fetch_assoc()){
				$comment_data[] = $row; 
			}
			return $comment_data;
		}
		
		public function getCountComments($ex_id, $qs_id){
			$sql="SELECT COUNT(*) AS c_id FROM comments WHERE exam_code_id='$ex_id' AND question_id='$qs_id' AND status='1'";
			$rec = $this->_mysql_resource->query($sql);
			//$count = array();
			if($row = $rec->fetch_assoc()){
				$count = $row['c_id']; 
			}
			return $count;
		}
		
		public function getCommentsByid($com_id){
			$sql="SELECT * FROM comments WHERE id='$com_id' AND status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$comment_data = array();
			if($row = $rec->fetch_assoc()){
				$comment_data[] = $row; 
			}
			return $comment_data;
		}
		
		public function getReplyComments($com_id, $qs_id){
			$sql="SELECT * FROM reply_comments WHERE com_id ='$com_id' AND question_id='$qs_id' AND status='1'";
			$rec = $this->_mysql_resource->query($sql);
			$re_comment_data = array();
			while($row = $rec->fetch_assoc()){
				$re_comment_data[] = $row; 
			}
			return $re_comment_data;
		}
		
		public function getPopularity($exam_id){
			$sql = "SELECT * FROM popularity_count WHERE exam_code_id='$exam_id'";
			$rec = $this->_mysql_resource->query($sql);
			while($row = $rec->fetch_assoc()){
				$count = $row['get_count'];
				$new_count = $count + 1;
				$update = $this->_mysql_resource->query("UPDATE popularity_count SET get_count='$new_count' WHERE exam_code_id='$exam_id'");
			}
			return $new_count;
		}
		
		public function getPopularExam(){
			$sql = "SELECT * FROM popularity_count ORDER BY get_count DESC LIMIT 10";
			$rec = $this->_mysql_resource->query($sql);
			$popular_exam = array();
			while($row = $rec->fetch_assoc()){
				$popular_exam[] = $row;
			}
			return $popular_exam;
		}
		
		
		public function getActivationCode($sql){
			@$result = $this->_mysql_resource->query(@$sql);
			if(@$result->num_rows>0){
				return true;
			}else{
				return false;
			}
		}
		
		public function getCountId($sql){
			@$result = $this->_mysql_resource->query(@$sql);
			if(@$result->num_rows == 1){
				return true;
			}else{
				return false;
			}
		}
		
		public function _updateData($sql){
			$result = $this->_mysql_resource->query($sql);
			if($this->_mysql_resource->affected_rows>0){
				return true;
			}else{
				return false;
			}
		}
		
		public function userlogIn($sql){
			$result=$this->_mysql_resource->query($sql);
			if($result->num_rows>0){
				return true;
			}else{
				return false;
			}
		}
		
		public function getCommentsShow(){
			$sql = "SELECT * FROM comments WHERE status='1' ORDER BY id DESC limit 15";
			$rec = $this->_mysql_resource->query($sql);
			$comment = array();
			while($row = $rec->fetch_assoc()){
				$comment[] = $row;
			}
			return $comment;
		}
		
		/* download test */
		
		public function getDkeycount($s_key){
			$sql = "SELECT count(*) FROM downloads WHERE downloadkey = '".$s_key."' LIMIT 1";
			$rec = $this->_mysql_resource->query($sql);
			if($row = $rec->fetch_assoc()){
				$arrcheck = $row['count(*)'];
			}
			return $arrcheck;
		}
		
		public function getDownloadkey($key){
			$sql = "SELECT * FROM downloads WHERE downloadkey ='".$key."' LIMIT 1";
			$rec = $this->_mysql_resource->query($sql);
			$datacheck = array();
			if($row = $rec->fetch_assoc()){
				$datacheck[] = $row;
			}
			return $datacheck;
		}
		
		/* end download test */
		
		
		
	}
	
	

?>