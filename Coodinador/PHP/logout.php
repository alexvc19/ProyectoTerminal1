<?php
session_name('coordinador');
session_start();

session_destroy();

header("Location: ../login.php"); 
exit();
?>