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
	$response = array();
	if(count($path_components) == 2 && $path_components[1]=="login"){
		
	}else if(count($path_components) == 2 && $path_components[1]=="points"){
		if(!isset($_SESSION['user_id'])){
			$response['success'] = false;
			$response['message'] = "User not logged in";
			echo json_encode($response); 
			exit();
		}else{
			$userObject = getUserById($_SESSION['user_id']);
			$response['success'] = true;
			$response['message'] = $userObject->getPoints();
			echo json_encode($response); 
			exit();
		}
	}else if(count($path_components) == 2 && $path_components[1]=="pointsinc"){
		if(!isset($_SESSION['user_id'])){
			$response['success'] = false;
			$response['message'] = "User not logged in";
			echo json_encode($response); 
			exit();
		}else{
			$userObject = User::getUserById($_SESSION['user_id']);
			$studentObject = Student::getStudentById($userObject->getStudentId());
			$response['success'] = true;
			$studentObject->incrementPoints();
			exit();
		}
	}

}
/*
==========================================
		BEGIN USERS POST
==========================================
*/
else if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$response = array();
	if(count($path_components) == 2 && $path_components[1]=="login"){
		if(empty($_POST) === false){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$response = array();

			if (empty($username) || empty($password)){
				$response['message'] = "Please enter a valid username and password.";
				echo json_encode($response);
				exit();
			}
			 else if (Users::user_exists($username) === false){
				$response['message'] = "Invalid username.";
				echo json_encode($response);
				exit();
			}
			else{
				$loginSuccess = Users::loginUser($username, $password);
				if($loginSuccess == false){
					$response['message'] = "Invalid combination.";
					echo json_encode($response);
					exit();
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
	}else if(count($path_components) == 2 && $path_components[1]=="register"){
		if(empty($_POST['username']) || empty($_POST['password'])){
			$response['message'] = "Fields must not be empty";
			echo json_encode($response); 
			exit();
		}
		else if($_POST['password'] != $_POST['confirmpassword']){
			$response['message'] = "Passwords do not match";
			echo json_encode($response); 
			exit();
		}else if(Users::user_exists($_POST['username'])){
			$response['message'] = "Username is already taken";
			echo json_encode($response); 
			exit();
		}else if(empty($_POST['accounttype'])){
			$response['message'] = "Error";
			echo json_encode($response); 
			exit();
		}else if($_POST['accounttype'] == "student" && empty($_POST['accesscode'])){
			$response['message'] = "You must provide an access code";
			echo json_encode($response); 
			exit();
		}else if((Teacher::accessCodeExists($_POST['accesscode']) == false) && ($_POST['accounttype'] == "student")){
			$response['message'] = "Invalid access code";
			echo json_encode($response); 
			exit();
		}else{
			$result = Users::registerUser($_POST['username'], $_POST['password'], $_POST['accounttype'], $_POST['accesscode']);
			if($result == true){
				$response['message'] = "Success.";
				echo json_encode($response); 
			exit();
			}else{
				$response['message'] = "$result";
				echo json_encode($response); 
				exit();
			}
		}
	}
	if(count($path_components) == 2 && $path_components[1] == "logout"){
		if(empty($_POST) == false){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$response = array();
			
		}
	}
}
?>