<?php
session_start();
session_destroy(); // Destroy session
header("Location: employer_login.php");
exit();
?>
