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
	  				$string = $this->countvert;
	  				$array = explode(',', $string);
	  				$array[0] = $errors;
	  				$this->countvert = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;
	  			case "countshape":
	  				$string = $this->countshape;
	  				$array = explode(',', $string);
	  				$array[0] = $errors;
	  				$this->countshape = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;
	  			case "simpleadd":
	  				$string = $this->simpleadd;
	  				$array = explode(',', $string);
	  				$array[0] = $errors;
	  				$this->simpleadd = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;
	  			case "simplesub":
	  				$string = $this->simpleadd;
	  				$array = explode(',', $string);
	  				$array[0] = $errors;
	  				$this->simpleadd = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;
	  			case "simplespell":
	  				$string = $this->simpleadd;
	  				$array = explode(',', $string);
	  				$array[0] = $errors;
	  				$this->simpleadd = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;
	  			case "simplerhyme":
	  				$string = $this->simpleadd;
	  				$array = explode(',', $string);
	  				$array[0] = $errors;
	  				$this->simpleadd = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;

	  			default:
	  				return false;
	  		}

	  	}
	  	public function updateActivityCorrect($activity, $correct){
	  		$conn = db_connect();
	  		$activity = sanitize($conn, $activity);
	  		$correct = sanitize($conn, $correct);

	  		switch($activity){
	  			case "countvert":
	  				$string = $this->countvert;
	  				$array = explode(',', $string);
	  				$array[1] = $correct;
	  				$this->countvert = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;
	  			case "countshape":
	  				$string = $this->countshape;
	  				$array = explode(',', $string);
	  				$array[1] = $correct;
	  				$this->countshape = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;
	  			case "simpleadd":
	  				$string = $this->simpleadd;
	  				$array = explode(',', $string);
	  				$array[1] = $correct;
	  				$this->simpleadd = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;
	  			case "simplesub":
	  				$string = $this->simpleadd;
	  				$array = explode(',', $string);
	  				$array[1] = $correct;
	  				$this->simpleadd = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;
	  			case "simplespell":
	  				$string = $this->simpleadd;
	  				$array = explode(',', $string);
	  				$array[1] = $correct;
	  				$this->simpleadd = $array[0].','.$array[1];
	  				$this->update();
	  				return true;
	  				break;
	  			case "simplerhyme":
	  				$string = $this->simpleadd;
	  				$array = explode(',', $string);
	  				$array[1] = $correct;
	  				$this->simpleadd = $array[0].','.$array[1];
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
	  	public function getCountVertCorrect(){
	  		$array = explode(',', $this->countvert);
	  		return $array[1];
	  	}
	  	public function getCountShapeCorrect(){
	  		$array = explode(',', $this->countshape);
	  		return $array[1];
	  	}
	  	public function getSimpleAddCorrect(){
	  		$array = explode(',', $this->simpleadd);
	  		return $array[1];
	  	}
	  	public function getSimpleSubCorrect(){
	  		$array = explode(',', $this->simplesub);
	  		return $array[1];
	  	}
	  	public function getSimpleSpellCorrect(){
	  		$array = explode(',', $this->simplespell);
	  		return $array[1];
	  	}
	  	public function getSimpleRhymeCorrect(){
	  		$array = explode(',', $this->simplerhyme);
	  		return $array[1];
	  	}
	  	public function getCountVertErrors(){
	  		$array = explode(',', $this->countvert);
	  		return $array[0];
	  	}
	  	public function getCountShapeErrors(){
	  		$array = explode(',', $this->countshape);
	  		return $array[0];
	  	}
	  	public function getSimpleAddErrors(){
	  		$array = explode(',', $this->simpleadd);
	  		return $array[0];
	  	}
	  	public function getSimpleSubErrors(){
	  		$array = explode(',', $this->simplesub);
	  		return $array[0];
	  	}
	  	public function getSimpleSpellErrors(){
	  		$array = explode(',', $this->simplespell);
	  		return $array[0];
	  	}
	  	public function getSimpleRhymeErrors(){
	  		$array = explode(',', $this->simplerhyme);
	  		return $array[0];
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