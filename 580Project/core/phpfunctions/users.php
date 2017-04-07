<?php 

	class Users{
		private $id;
		private $password;
		private $username;
		private $points;

		public function __construct($id, $password, $username, $points) {
		    $this->id = $id;
		    $this->password = $password;
		    $this->username = $username;
		    $this->points = $points;
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
		public static function registerUser($username, $password){
			$conn = db_connect();

			$username = sanitize($conn, $username);
			$password = sanitize($conn, $password);

			$q = "INSERT INTO Users (id, username, password, points) VALUES (NULL, '$username', '$password', 0);";
			$result = $conn->query($q);
			return $result;
		}
		public static function getUserById($id){
			$conn = db_connect();

	  		//finds user in users table
	  		$q = "SELECT * FROM users WHERE id='$id' limit 1";
	  		$result = $conn->query($q);
	  		$data = $result->fetch_assoc();

	  		return new Users($data['id'], $data['username'], $data['password'], $data['points']);
		}
		public static function loginUser($username, $password){

			$conn = db_connect();
			$id = 
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

		public function getPoints(){
			return $this->points;
		}

		public function incrementPoints(){
			$this->points = $this->points+1;
			$this->update();
		}

		public function update(){
			$conn = db_connect();
			$q = "UPDATE Users SET id='" . $this->id . "', username ='" . $this->username . "', password ='" . $this->password . "', points ='" . $this->points . "' WHERE id = '" . $this->id . "'";
			$result = $conn->query($q);
			return $result;
		}
	}

?>
