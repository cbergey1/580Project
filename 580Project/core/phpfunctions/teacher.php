<?php 
	
	class Teacher{

		private $id;
		private $accesscode;
		private $studentids;


		public function __construct($id, $accesscode, $studentids) {
		    $this->id = $id;
		    $this->accesscode = $accesscode;
		    $this->studentids = $studentids;
	  	}

	  	public static function registerTeacher(){

	  		$conn = db_connect();
	  		//Begin random 5 digit number generation
	  		$digits = 5;
			$accesscode =  rand(pow(10, $digits-1), pow(10, $digits)-1);
			//end random 5 digit number generation
	  		$q = "INSERT INTO teachers (id, accesscode, studentids) VALUES (NULL, '$accesscode', 0);";
	  		$result = $conn->query($q);
	  		
	  		return mysqli_insert_id($conn); //returns the id of newly created teacher
	  		
	  	}

	  	public static function accessCodeExists($accesscode){
	  		$conn = db_connect();
	  		$q = "SELECT * FROM teachers WHERE accesscode='$accesscode' limit 1";
			$result = $conn->query($q);
			if ($result->num_rows > 0) {
				return true;
			}else{
				return false;
			}
	  	}

	  	public static function getIdByAccessCode($accesscode){
			$conn = db_connect();
			$accesscode = sanitize($conn, $accesscode);

			$q = "SELECT * FROM teachers WHERE accesscode='$accesscode' limit 1";
			$result = $conn->query($q);
	  		$data = $result->fetch_assoc();

	  		return new Teacher($data['id'], $data['accesscode'], $data['studentids']);
	  	}

	  	public static function getTeacherById($id){
	  		$conn = db_connect();
	  		$id = sanitize($conn, $id);

	  		$q = "SELECT * FROM teachers WHERE id='$id' limit 1";
	  		$result = $conn->query($q);
	  		$data = $result->fetch_assoc();

	  		return new Teacher($data['id'], $data['accesscode'], $data['studentids']);
	  	}

	  	public function addStudent($studentid){
	  		$currentList = $this->studentids;
	  		$this->studentids = $currentList . "," . $studentid;
	  		$result = $this->update();
	  		return $result;

	  	}

	  	public function getStudents(){
	  		return $this->studentids;
	  	}

	  	public function getAccountType(){
	  		return "teacher";
	  	}

	  	public function getId(){
	  		return $this->id;
	  	}


	  	public function update(){
	  		$conn = db_connect();
			$q = "UPDATE teachers SET id='" . $this->id . "', accesscode ='" . $this->accesscode . "', studentids ='" . $this->studentids . "' WHERE id = '" . $this->id . "'";
			$result = $conn->query($q);
			return $result;
	  	}





	}




?>