<?php
session_start();
session_unset();
session_destroy();

// Redirect to the login page or any other page after logout
header("location: guestindex.php");
exit;
?>