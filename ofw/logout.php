<?php
session_start();
session_destroy(); // Destroy session
header("Location: ofw_login.php");
exit();
?>
