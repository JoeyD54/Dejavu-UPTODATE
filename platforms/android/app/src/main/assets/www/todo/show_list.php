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
		echo ("Please log in to continue.");
		header("refresh:1; url=index.php");
	}

/* show todo list */
	echo "Todo List <br>";
	$query = "SELECT task_name, due_date, status FROM task WHERE list_id = 2";
	$result = mysqli_query($link, $query);
	
	while($row = mysqli_fetch_array($result)){
		echo $row['task_name'] . ' ' .$row['due_date'] . ' ' .$row['status'].'<br/>';
	}
?>