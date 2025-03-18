<?php
session_start();
session_destroy(); // Destroy session
header("Location: applicant_login.php");
exit();
?>
