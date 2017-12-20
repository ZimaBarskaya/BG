<?php
include('includes/classSimpleImage.php');
// контролер
Class Controller_Registration Extends Controller_Base {
	
	public $layouts = "first_layouts";
	
	function index() {
		if(isset($_SESSION["session_username"])){
			$newURL = "http://zima-task.zzz.com.ua/test";
			           header('Location: '.$newURL);
		} else {
			$this->template->view('index');
		}
	}
	
	function register(){
		$con = mysqli_connect(DB_SERVER,DB_USER, DB_PASS, DB_NAME) or die(mysqli_error());
		if(!empty($_POST['user_name']) && !empty($_POST['user_email']) && !empty($_POST['user_login']) && !empty($_POST['user_pass'])) {
			$full_name=$_POST['user_name'];
			$email=$_POST['user_email'];
			$username=$_POST['user_login'];
			$password=$_POST['user_pass'];
			
			$query=mysqli_query($con, "SELECT * FROM usertbl WHERE username='".$username."'");
			$numrows=mysqli_num_rows($query);
			
			if($numrows==0)
			{
				$sql="INSERT INTO usertbl
						(full_name, email, username,password) 
						VALUES('$full_name','$email', '$username', '$password')";

				$result=mysqli_query($con, $sql);
				if($result){
			           $newURL = "http://zima-task.zzz.com.ua/login";
			           header('Location: '.$newURL);
				} else {
					echo "<div class=\"alert alert-danger\" role=\"alert\">Failed to insert data information!</div>";
					$this->template->view('index');
				}

			} else {
				echo "<div class=\"alert alert-danger\" role=\"alert\">That username already exists! Please try another one!</div>";
				$this->template->view('index');
			}

		} else {
			echo "<div class=\"alert alert-danger\" role=\"alert\">All fields are required!</div>";
			$this->template->view('index');
		}
		
		if (!empty($message)) {
			echo "<div class=\"alert alert-danger\" role=\"alert\">" . "MESSAGE: ". $message . "</div>";
			
		}
	}

}		