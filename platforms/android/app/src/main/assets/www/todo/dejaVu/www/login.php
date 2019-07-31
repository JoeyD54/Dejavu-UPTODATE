<?php
include('config.php');

@mysql_select_db($DB_NAME) or ("Database not found");

$username = mysqli_real_escape_string($link, $_POST['username']);
$password = mysqli_real_escape_string($link, $_POST['password']);

/* Check if username & password are correct */
$query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
$sql = mysqli_query($link, $query); 
if(mysqli_num_rows($sql)==1){
		// find list id
		$query = "SELECT list_id FROM list WHERE username = '$username'"; // get first list_id
		$result= mysqli_query($link, $query);
		$list_id = mysqli_fetch_array($result);
		
		session_start();
		$_SESSION['auth']='true';
		$_SESSION['username']=$username;
		$_SESSION['list_id']=$list_id[0];
		header('location:home.php');
	}
else{
	echo "Invalid login. Please try again.";
	header("refresh:2; url=index.php"); /* redirect to login */
	}

//mysqli_close(); // close connection
?>