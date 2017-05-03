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
	}else if(count($path_components) == 2 && $path_components[1]=="activity"){
		
		$activity = $_GET["activity"];
		$errors = $_GET["errors"];
		$user = Users::getUserById($_SESSION['user_id']);
		//check to make sure logged in user is a student
		$studentid = $user->getStudentId();
		if($studentid == 0){
			$response['success'] = false;
			echo json_encode($response); 
			exit();
		}

		//else, get student object
		$student = Student::getStudentById($studentid);
		$success = $student->updateActivityScore($activity, $errors); //returns true/false based on success of update

		$response['success'] = $success;
		echo json_encode($response); 
		exit();


	}else if(count($path_components) == 2 && $path_components[1]=="studenterrorscores"){
		if(!isset($_SESSION['user_id'])){
			$response['success'] = false;
			$response['message'] = "User not logged in";
			echo json_encode($response); 
			exit();
		}else{
			$userObject = Users::getUserById($_SESSION['user_id']);
			$teacherId = $userObject->getTeacherId();
			//check to see if user is a teacher
			if($teacherId == 0){
				$response['success'] = false;
				$response['message'] = "User is not a teacher";
				echo json_encode($response); 
				exit();
			}
			//else, create 2D array of teacher's students and their error-scores on activities

			$teacherObject = Teacher::getTeacherById($teacherId);

			//csv of student ids (with zero as first value)
			$studentIdList = $teacherObject->getStudents();
			$studentIdArray = explode(',', $studentIdList);

			$studentScoreInfo = array();

			foreach($studentIdArray as $studentId){
				$scoreArray = array();

				if($studentId != 0){ //excludes the starting zero
					$studentObject = Student::getStudentById($studentId);
					$scoreArray['studentid'] = $studentObject->getName();
					$scoreArray['countvert'] = $studentObject->getCountVertErrors();
					$scoreArray['countshape'] = $studentObject->getCountShapeErrors();
					$scoreArray['simpleadd'] = $studentObject->getSimpleAddErrors();
					$scoreArray['simplesub'] = $studentObject->getSimpleSubErrors();
					$scoreArray['simplespell'] = $studentObject->getSimpleSpellErrors();
					$scoreArray['simplerhyme'] = $studentObject->getSimpleRhymeErrors();

					array_push($studentScoreInfo, $scoreArray);
				}
				
			}

			$response['success'] = true;
			$response['scores'] = $studentScoreInfo;
			echo json_encode($response); 
			exit();

		}
	}else if(count($path_components) == 2 && $path_components[1]=="studentcorrectscores"){
		if(!isset($_SESSION['user_id'])){
			$response['success'] = false;
			$response['message'] = "User not logged in";
			echo json_encode($response); 
			exit();
		}else{
			$userObject = Users::getUserById($_SESSION['user_id']);
			$studentId = $userObject->getStudentId();
			if($studentId == 0){
				$response['success'] = false;
				$response['message'] = "User is not a student";
				echo json_encode($response); 
				exit();
			}

			$studentObject = Student::getStudentById($studentId);

			$response['success'] = true;
			$response['countvert'] = $studentObject->getCountVertCorrect();
			$response['countshape'] = $studentObject->getCountShapeCorrect();
			$response['simpleadd'] = $studentObject->getSimpleAddCorrect();
			$response['simplesub'] = $studentObject->getSimpleSubCorrect();
			$response['simplespell'] = $studentObject->getSimpleSpellCorrect();
			$response['simplerhyme'] = $studentObject->getSimpleRhymeCorrect();

			echo json_encode($response); 
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
			$result = Users::registerUser($_POST['username'], $_POST['password'], $_POST['accounttype'], $_POST['accesscode'], $_POST['firstname']);
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