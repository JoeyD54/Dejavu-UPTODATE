<?php
include('config.php');
session_start();

if($_SESSION['auth']=='true'){
		$username = $_SESSION['username'];
		
	/* Load first list_id  */
		$query = "SELECT list_id FROM list WHERE username = '$username'";
		$result = mysqli_query($link, $query);
		$list_id = mysqli_fetch_array($result);
		echo "*TESTING* List id = " . $list_id[0] . "<br/>";
	}
	else{
		echo("Please log in to continue!");
		header("refresh:2; url=index.php");
	}
	

	/* Add task to database */
		// task name
	if($_SERVER["REQUEST_METHOD"] == "POST"){ //check if POST method has been received
		$task_name = mysqli_real_escape_string($link, $_POST['task_name']);
		// due date conversion
		$due_date = mysqli_real_escape_string($link, $_POST['due_date']);
		$timestamp = strtotime($due_date); //convert to 
		$due_date_conv = date('Y-m-d H:i:s', $timestamp); // convert due_date into format for db
		// status
		$status = mysqli_real_escape_string($link, $_POST['status_list']);
		
		echo "New task name: $task_name<br>";
		echo "New task date: $due_date_conv<br>";
		echo "New status: $status<br>";
		
		$query = "INSERT INTO task (task_id, list_id, task_name, due_date, status) VALUES (NULL, '$list_id[0]', '$task_name', '$due_date_conv', '$status')";
		mysqli_query($link, $query);
		
		echo "Added to db";
		header('location:home.php');
	}
	else{
		echo "Add task failed.<br>";
	}
?>