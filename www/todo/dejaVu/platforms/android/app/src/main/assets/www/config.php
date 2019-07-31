<?php

/* *************************************
Configuration for database connection 
************************************* */

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'todo_list');

/* Establish connection to database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

/* Check for errors */
if($link == false){
	die("Error: Connection failed." . mysqli_connect_error());
}
?>