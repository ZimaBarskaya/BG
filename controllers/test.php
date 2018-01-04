<?php
include('includes/classSimpleImage.php');
Class Controller_Test Extends Controller_Base {
	public $layouts = "first_layouts";
	
	function index() {
		session_start();
		if(!isset($_SESSION["session_username"])){
			$_SESSION['session_username']="default_user";
		} else {
			$_SESSION['session_username']=$_SESSION['session_username'];
		}
		$this->template->view('index');
	}
	
	function logout(){
		unset($_SESSION['session_username']);
		session_destroy();
		$newURL = "http://zima-task.zzz.com.ua/login";
		header('Location: '.$newURL);
	}
	
	function task(){
		session_start();
		$_SESSION['session_username']=$_SESSION['session_username'];
		$con = mysqli_connect(DB_SERVER,DB_USER, DB_PASS, DB_NAME) or die(mysqli_error());
		if(!empty($_POST['task_name']) && !empty($_POST['task_email']) && !empty($_POST['task_text'])) {
			$name=$_POST['task_name'];
			$email=$_POST['task_email'];
			$text=$_POST['task_text'];
			
			//Img upload
                        $query2 =mysqli_query($con, "SELECT * FROM tasks");
			$uploaddir = 'uploads/img/';
			$filaname = ($query2->num_rows+1) . "_img.jpeg";
			$types = array('image/gif', 'image/png', 'image/jpg', 'image/jpeg');
			$image = new SimpleImage();
				   $image->load($_FILES['task_file']['tmp_name']);
				   $image->resize(320, 240);
				   $image->save($_FILES['task_file']['tmp_name']);
			
			if (!in_array($_FILES['task_file']['type'], $types)) {
				echo "<div class=\"alert alert-danger\" role=\"alert\">Запрещённый тип файла.</div>";
			} else {
				if (!@copy($_FILES['task_file']['tmp_name'], $uploaddir . ($query2->num_rows+1) . "_img.jpeg")){
				} 
				$sql="INSERT INTO tasks
					(name, email, text, picture, status)  
					VALUES('$name','$email', '$text', '$filaname', 1)";
				$result=mysqli_query($con, $sql);
				$this->template->view('index');
			}
			
		} else {
			echo "<div class=\"alert alert-danger\" role=\"alert\">Все поля должны быть заполнены!</div>";
		}
	}
	
	function save() {
		session_start();
		$_SESSION['session_username']=$_SESSION['session_username'];
		$con = mysqli_connect(DB_SERVER,DB_USER, DB_PASS, DB_NAME) or die(mysqli_error());
		if(!empty($_POST['new_name']) && !empty($_POST['new_email']) && !empty($_POST['new_text'])) {
			$task_id=$_POST['task_id'];
			$name=$_POST['new_name'];
			$email=$_POST['new_email'];
			$text=$_POST['new_text'];
			$status=$_POST['new_status'];
			
			//Img upload
			if(!empty($_POST['new_file2'])) {
				$query2 =mysqli_query($con, "SELECT * FROM tasks");
				$uploaddir = 'uploads/img/';
				$filaname = explode("/", $_POST['new_file2']);
				$filaname = end($filaname);
				$types = array('image/gif', 'image/png', 'image/jpg', 'image/jpeg');
				$image = new SimpleImage();
				$image->load($_FILES['new_file']['tmp_name']);
				$image->resize(320, 240);
				$image->save($_FILES['new_file']['tmp_name']);
				
				if (!@copy($_FILES['task_file']['tmp_name'], $uploaddir . ($query2->num_rows+1) . "_img.jpeg")){

				} 
			} else if(empty($_POST['new_file2']) && !empty($_POST['new_file'])) {
				$query2 =mysqli_query($con, "SELECT * FROM tasks");
				$uploaddir = 'uploads/img/';
				$filaname = ($query2->num_rows+1) . "_img.jpeg";
				$types = array('image/gif', 'image/png', 'image/jpg', 'image/jpeg');
				$image = new SimpleImage();
				$image->load($_FILES['new_file']['tmp_name']);
				$image->resize(320, 240);
				$image->save($_FILES['new_file']['tmp_name']);
				
				if (!@copy($_FILES['task_file']['tmp_name'], $uploaddir . ($query2->num_rows+1) . "_img.jpeg")){
				} 
			} else {
				$filaname = "";
			}
			
			
			if($status != 0 && $status != 1) {
				echo "<div class=\"alert alert-danger\" role=\"alert\">Недопустимый тип статуса.</div>";
			}
			$query =mysqli_query($con, "UPDATE tasks SET name='$name', email='$email', text='$text', status=$status, picture='$filaname' WHERE id=".$task_id);
			$this->template->view('index');
			$newURL = "http://zima-task.zzz.com.ua/test";
			header('Location: '.$newURL);
		} else {
			echo "<div class=\"alert alert-danger\" role=\"alert\">Все поля должны быть заполнены!</div>";
			$this->template->view('index');
		}
	}
	
	
	function sortByName() {
		$_COOKIE['SortBy'] = 'name';
		session_start();
		$_SESSION['session_username']=$_SESSION['session_username'];
		$this->template->view('index');
	}
	
	function sortByEmail() {
		$_COOKIE['SortBy'] = 'email';
		session_start();
		$_SESSION['session_username']=$_SESSION['session_username'];
		$this->template->view('index');
	}
	
	function sortByStatus() {
		$_COOKIE['SortBy'] = 'status';
		session_start();
		$_SESSION['session_username']=$_SESSION['session_username'];
		$this->template->view('index');
	}
}	
