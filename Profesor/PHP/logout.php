<?php
session_name('profesor');
session_start();

session_destroy();

header("Location: ../login.php"); 
exit();
?>