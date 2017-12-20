<?php

Class Controller_Login Extends Controller_Base {
	
	public $layouts = "first_layouts";
	
	function index() {
		if(isset($_SESSION["session_username"])){
			$newURL = "http://zima-task.zzz.com.ua/test";
			header('Location: '.$newURL);
		} else {
			$this->template->view('index');
		}
	}
	
	function loginAction(){
		$con = mysqli_connect(DB_SERVER,DB_USER, DB_PASS, DB_NAME) or die(mysqli_error());
		if(!empty($_POST['username']) && !empty($_POST['password'])) {
			$username=$_POST['username'];
			$password=$_POST['password'];

			$query =mysqli_query($con, "SELECT * FROM usertbl WHERE username='".$username."' AND password='".$password."'");

			$numrows=mysqli_num_rows($query);
			if($numrows!=0) {
				while($row=mysqli_fetch_assoc($query))
				{
					$dbusername=$row['username'];
					$dbpassword=$row['password'];
				}

				if($username == $dbusername && $password == $dbpassword) {
					session_start();
					 $_SESSION['session_username']=$username;
					$newURL = "http://zima-task.zzz.com.ua/test";
					header('Location: '.$newURL);
				} else {
					echo   "<div class=\"alert alert-danger\" role=\"alert\">Неправильный логин или пароль.</div>";
					$this->template->view('index');
				}
			} else {
				echo   "<div class=\"alert alert-danger\" role=\"alert\">Неправильный логин или пароль.</div>";
				$this->template->view('index');
			}

		} else {
			echo "<div class=\"alert alert-danger\" role=\"alert\">Все поля должны быть заполнены!</div>";
			$this->template->view('index');
		}
		
	}
}
