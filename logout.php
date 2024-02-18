<?php
session_start();
$_SESSION = array();
session_destroy();
header("location: login.php");
// Redirect to the login page or any other page after logout
exit();
?>