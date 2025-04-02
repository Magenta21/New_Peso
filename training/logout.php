<?php
session_start();
session_destroy(); // Destroy session
header("Location: training_login.php");
exit();
?>
