<?php 
	
	class Student{

		private $id;
		private $teacherid;
		private $points;


		public function __construct($id, $teacherid, $points) {
		    $this->id = $id;
		    $this->teacherid = $teacherid;
		    $this->points = $points;
	  	}

	  	public static function registerStudent($teacherid){

	  		$conn = db_connect();
	  		$teacherid = sanitize($conn, $teacherid);
	  		
	  		$q = "INSERT INTO students (id, teacherid, points) VALUES (NULL, '$teacherid', 0);";
	  		$result = $conn->query($q);

	  		$studentid = mysqli_insert_id($conn);
	  		$teacher = Teacher::getTeacherById($teacherid);
	  		$teacher->addStudent($studentid);
	  		
	  		return $studentid; //returns the id of newly created student
	  		
	  	}

	  	public static function getStudentById($id){
	  		$conn = db_connect();
	  		$id = sanitize($conn, $id);

	  		$q = "SELECT * FROM students WHERE id='$id' limit 1";
	  		$result = $conn->query($q);
	  		$data = $result->fetch_assoc();

	  		return new Student($data['id'], $data['teacherid'], $data['points']);
	  	}
	  	public function incrementPoints(){
	  		$this->points = $this->points+1;
	  		$this->update();
	  	}

	  	public function getPoints(){
	  		return $this->points;
	  	}

	  	public function getAccountType(){
	  		return "student";
	  	}

	  	public function update(){
	  		$conn = db_connect();
			$q = "UPDATE students SET id='" . $this->id . "', teacherid ='" . $this->accesscode . "', points ='" . $this->points . "' WHERE id = '" . $this->id . "'";
			$result = $conn->query($q);
			return $result;
	  	}





	}




?>