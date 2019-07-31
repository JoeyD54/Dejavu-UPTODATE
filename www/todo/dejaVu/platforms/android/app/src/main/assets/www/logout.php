<?php
session_start();
unset($_SESSION);
session_destroy();
echo "You have been successfully logged out.";
header("refresh:1; url=index.php");
?>