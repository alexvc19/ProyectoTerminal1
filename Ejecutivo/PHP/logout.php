<?php
session_name('ejecutivo');
session_start();

session_destroy();

header("Location: ../login.php"); 
exit();
?>