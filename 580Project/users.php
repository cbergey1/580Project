<?php
include 'core/init.php';

//this is a file that represents the "Users API"
$path_components = explode('/', $_SERVER['PATH_INFO']);

/*
==========================================
		BEGIN USERS GET
==========================================
*/
if ($_SERVER['REQUEST_METHOD'] == "GET") {

}
/*
==========================================
		BEGIN USERS POST
==========================================
*/
else if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if(count($path_components) == 2 && $path_components[1]=="login"){
		if(empty($_POST) === false){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$response = array();

			if (empty($username) || empty($password)){
				$response['message'] = "Please enter a valid username and password.";
			}
			 else if (Users::user_exists($username) === false){
				$response['message'] = "Invalid username.";
			}
			else{
				$loginSuccess = Users::loginUser($username, $password);
				if($loginSuccess == false){
					$response['message'] = "Invalid combination.";
				}else{
					$_SESSION["user_id"] = $loginSuccess; //sets the user's session id with the user's database id
					$response['message'] = "Success";
					echo json_encode($response);
					exit();
				}
			}
			echo json_encode($response); // goes to loginAJAX.js in core/jsfunctions folder
			exit();
		}else{
			$response['message'] = "Failure.";
			echo json_encode($response); 
			exit();
		}
	}
}
?>