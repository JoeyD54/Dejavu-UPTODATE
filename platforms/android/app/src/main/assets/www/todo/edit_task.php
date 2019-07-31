<?php
include('config.php');
	
	//echo "testing carry over<br>";
	$query = "SELECT * FROM task WHERE task_id=".$_GET['edit_task_id'];
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	$current_task_name = $row['task_name'];
	$current_due_date = $row['due_date'];
	$current_status = $row['status'];
	echo "Current task name: " . $current_task_name . "<br>";
	echo "Current due_date: " . $current_due_date . "<br>";
	echo "Current status: " . $current_status . "<br>";

if(isset($_GET['edit_task_id'])){
	$query = "SELECT * FROM task WHERE task_id=".$_GET['edit_task_id'];
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
}

if(isset($_POST['update'])){
	$task_name = mysqli_real_escape_string($link, $_POST['task_name']);
	$due_date = mysqli_real_escape_string($link, $_POST['due_date']);
	$status = mysqli_real_escape_string($link, $_POST['status_list']);
	
	$query = "UPDATE task SET task_name='$task_name', due_date='$due_date', status='$status' WHERE task_id=".$_GET['edit_task_id'];
	mysqli_query($link, $query);
	echo "Task update successful.";
	
}
?>
<html>
	<head>
		<title>Todo list</title>
	</head>
	<body>
		<form method="post">
			<label>New Task Name</label>
			<input type="text" name="task_name" required="required"></input><br> 
			<label>New Due Date</label>
			<input type="date" name="due_date"required="required"></input><br>
			<label>New Task Status</label>
			<select name= status_list id = "status_list" required="required">
				<option value = "1">Pending</option>
				<option value = "2">Started</option>
				<option value = "3">Completed</option>
				<option value = "4">Late</option>
			</select><br>
			<input type="submit" name="update" value="Update"</input><br>
		</form> 
		<a href="home.php"> Back </a></br>
	</body>
</html>