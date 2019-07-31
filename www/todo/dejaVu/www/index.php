<?php
include('config.php');
session_start();
?>

<html>
	<head>
		<title>Todo List</title>
	</head>
	<body>
		<h2>Welcome to Todo List</h2>
		
		<form action="login.php" method="post"> <!--used for authentication-->
			<input type="text" name="username" placeholder="Username"></input><br> <!--input box for entering username-->
			<input type="password" name="password" placeholder="Password"></input><br> <!--input box for entering password-->
			<input type="submit" name="enter"></input><br>
		</form>
		<a href="register.php"> Register new account</a>
	</body>
</html>
