<?php
include('config.php');
session_start();
?>

<html>
	<head>
		<title>Register</title>
	</head>
	<body>
		<h2>Register New Account</h2>

		<form action="register.php" method="POST">
			<input type="text" name="username" placeholder="Enter New Username" required="required"></input><br> 
			<input type="text" name="password" placeholder="Enter New Password" required="required"></input><br>
			<input type="text" name="password2" placeholder="Reenter Password" required="required"></input><br>
			<input type="submit" name="register" value="Register"></input><br>
		</form>	
	</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){ //check if POST method has been received
	$username = mysqli_real_escape_string($link, $_POST['username']); // encapsulates input into a string
	$password = mysqli_real_escape_string($link, $_POST['password']); // prevents SQL injections
	$password2 = mysqli_real_escape_string($link, $_POST['password2']);
	
	if ($password == $password2){
		/* add user to db*/
		$query = "SELECT * FROM user WHERE username= '$username'";
		$sql = mysqli_query($link, $query ); /* Check if username exists */
		if(mysqli_num_rows($sql)>=1){
			echo "Username is unavailable. Please try again.<br>";
		}
		else{ /* add user if available and create first list*/
			$query = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
			mysqli_query($link, $query);
			$query = "INSERT INTO list (list_id, username, list_name) VALUES (NULL, '$username', 'List')";
			mysqli_query($link, $query);
			echo "New username: ". $username . "<br>";
			echo "New password: ". $password . "<br><br>";
			echo "Success! Redirecting..."."<br>";
			/* $_SESSION['username'] = $username; */ /*Consider staying logged in after redirect */
			header("refresh:3; url=index.php"); /* redirect to login */
		}
	}
	else{
		echo "Passwords do not match. Try again.<br>";
	}
}
?>

<html>
<a href="index.php">Go back
</html>