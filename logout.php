<?php
session_start();

// Destroy all session variables
session_destroy();

// Redirect the user to the login page
header('Location: login.php');
exit;
?>

