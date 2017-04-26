<?php 
	
	class Student{

		private $id;
		private $name;
		private $teacherid;
		private $countvert;
		private $countshape;
		private $simpleadd;
		private $simplesub;
		private $simplespell;
		private $simplerhyme;


		public function __construct($id, $name, $teacherid, $countvert, $countshape, $simpleadd, $simplesub, $simplespell, $simplerhyme) {
		    $this->id = $id;
		    $this->name = $name;
		    $this->teacherid = $teacherid;
		    $this->countvert = $countvert;
		    $this->countshape = $countshape;
		    $this->simpleadd = $simpleadd;
		    $this->simplesub = $simplesub;
		    $this->simplespell = $simplespell;
		    $this->simplerhyme = $simplerhyme;
	  	}

	  	public static function registerStudent($teacherid, $name){

	  		$conn = db_connect();
	  		$teacherid = sanitize($conn, $teacherid);
	  		$name = sanitize($conn, $name);
	  		
	  		$q = "INSERT INTO students (id, name, teacherid) VALUES (NULL, '$name', '$teacherid');";
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

	  		return new Student($data['id'], $data['name'], $data['teacherid'], $data['countingvertices'], $data['countingshapes'], $data['simpleadd'], $data['simplesub'], $data['simplespell'], $data['simplerhyme']);
	  	}
	  	public function updateActivityScore($activity, $errors){
	  		//return true/false based on success of update
	  		$conn = db_connect();
	  		$activity = sanitize($conn, $activity);
	  		$errors = sanitize($conn, $errors);

	  		switch($activity){
	  			case "countvert":
	  				$this->countvert = $errors;
	  				$this->update();
	  				return true;
	  				break;
	  			case "countshape":
	  				$this->countshape = $errors;
	  				$this->update();
	  				return true;
	  				break;
	  			case "simpleadd":
	  				$this->simpleadd = $errors;
	  				$this->update();
	  				return true;
	  				break;
	  			case "simplesub":
	  				$this->simplesub = $errors;
	  				$this->update();
	  				return true;
	  				break;
	  			case "simplespell":
	  				$this->simplespell = $errors;
	  				$this->update();
	  				return true;
	  				break;
	  			case "simplerhyme":
	  				$this->simplerhyme = $errors;
	  				$this->update();
	  				return true;
	  				break;

	  			default:
	  				return false;
	  		}

	  	}
	  	public function getName(){
	  		return $this->name;
	  	}
	  	public function getId(){
	  		return $this->id;
	  	}
	  	public function getCountVert(){
	  		return $this->countvert;
	  	}
	  	public function getCountShape(){
	  		return $this->countshape;
	  	}
	  	public function getSimpleAdd(){
	  		return $this->simpleadd;
	  	}
	  	public function getSimpleSub(){
	  		return $this->simplesub;
	  	}
	  	public function getSimpleSpell(){
	  		return $this->simplespell;
	  	}
	  	public function getSimpleRhyme(){
	  		return $this->simplerhyme;
	  	}

	  	public function getAccountType(){
	  		return "student";
	  	}

	  	public function update(){
	  		$conn = db_connect();
			$q = "UPDATE students SET id='" . $this->id . "', name ='" . $this->name . "', teacherid ='" . $this->teacherid . "', countingvertices ='" . $this->countvert . "', countingshapes ='" . $this->countshape . "', simpleadd ='" . $this->simpleadd . "', simplesub ='" . $this->simplesub . "', simplespell ='" . $this->simplespell . "', simplerhyme ='" . $this->simplerhyme . "' WHERE id = '" . $this->id . "'";
			$result = $conn->query($q);
			return $result;
	  	}


	}


?>