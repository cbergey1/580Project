<?php 

	class Users{
		private $id;
		private $password;
		private $username;
		private $studentid;
		private $teacherid;

		public function __construct($id, $password, $username, $studentid, $teacherid) {
		    $this->id = $id;
		    $this->password = $password;
		    $this->username = $username;
		    $this->studentid = $studentid;
		    $this->teacherid = $teacherid;
		    
	  	}

		public static function user_exists($username){

			$conn = db_connect();
			$username = sanitize($conn, $username);

			//query database here to test for username
			$q = "SELECT id FROM Users WHERE username = '$username'";

			$result = $conn->query($q);

			if ($result->num_rows > 0) {
				return true;
			}else{
				return false;
			}
		}
		public static function registerUser($username, $password, $accounttype, $accesscode, $firstname){
			$conn = db_connect();

			$username = sanitize($conn, $username);
			$password = sanitize($conn, $password);
			$accounttype = sanitize($conn, $accounttype);
			$accesscode = sanitize($conn, $accesscode);
			$firstname = sanitize($conn, $firstname);

			if($accounttype == "student"){
				$teacher = Teacher::getIdByAccessCode($accesscode);
				$studentid = Student::registerStudent($teacher->getId(), $firstname);

				$q = "INSERT INTO Users (id, username, password, studentid, teacherid) VALUES (NULL, '$username', '$password', '$studentid', 0);";
				$result = $conn->query($q);
				return $result;
			}else if($accounttype == "teacher"){

				$teacherid = Teacher::registerTeacher();

				$q = "INSERT INTO Users (id, username, password, studentid, teacherid) VALUES (NULL, '$username', '$password', 0, '$teacherid');";
				$result = $conn->query($q);
				return $result;
			}else{
				return false;
			}
			
		}
		public static function getUserById($id){
			$conn = db_connect();

	  		//finds user in users table
	  		$q = "SELECT * FROM users WHERE id='$id' limit 1";
	  		$result = $conn->query($q);
	  		$data = $result->fetch_assoc();

	  		return new Users($data['id'], $data['username'], $data['password'], $data['studentid'], $data['teacherid']);
		}
		public static function loginUser($username, $password){

			$conn = db_connect();
			
			$username = sanitize($conn, $username);
			$password = sanitize($conn, $password);

			//query database here to test for the correct username and password, if the username and password are correct, return the User's ID in the database to be used as the Session ID.
			$q = "SELECT id FROM Users WHERE username = '$username' AND password = '$password'";

			$result = $conn->query($q);
			$row = $result->fetch_assoc();

			if ($result->num_rows > 0) {
				
				return $row['id'];

			}else{
				return false;
			}
		}
		
		public static function isLoggedIn(){
			if ($_SESSION['user_id'] !== null){
				return true;
			}else{
				return false;
			}
		}
		public static function isTeacher(){
			$conn = db_connect();
			$id = $_SESSION['user_id'];
	  		//finds user in users table
	  		$q = "SELECT * FROM users WHERE id='$id' limit 1";
	  		$result = $conn->query($q);
	  		$data = $result->fetch_assoc();
	  		if($data['teacherid'] == 0){
	  			return false;
	  		}else{
	  			return true;
	  		}
		}


		public function getStudentId(){
			return $this->studentid;
		}
		public function getTeacherId(){
			return $this->teacherid;
		}

		public function update(){
			$conn = db_connect();
			$q = "UPDATE Users SET id='" . $this->id . "', username ='" . $this->username . "', password ='" . $this->password . "', points ='" . $this->points . "' WHERE id = '" . $this->id . "'";
			$result = $conn->query($q);
			return $result;
		}
	}

?>
