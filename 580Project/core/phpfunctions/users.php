<?php 

	class Users{

		public static function user_exists($username){

			$conn = db_connect();
			$username = sanitize($conn, $username);

			//query database here to test for username
			$q = "";

			$result = $conn->query($q);

			if ($result->num_rows > 0) {
				return true;
			}else{
				return false;
			}
		}

		public static function login_user($username, $password){

			$conn = db_connect();
			$username = sanitize($conn, $username);
			$password = sanitize($conn, $password);

			//query database here to test for the correct username and password, if the username and password are correct, return the User's ID in the database to be used as the Session ID.
			$q = "";

			$result = $conn->query($q);
			$row = $result->fetch_assoc();

			if ($row['id'] == $id) {
				
				return $id;

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
	}

?>
