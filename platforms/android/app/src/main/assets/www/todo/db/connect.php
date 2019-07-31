<?php

$inputuser = $_POST["user"];
$inputpass = $_POST["pass"];

if ($inputuser == "Evan" && $inputpass == "pass"){
	echo "Welcome";
}

else {
	echo "Failed auth";
}
?>