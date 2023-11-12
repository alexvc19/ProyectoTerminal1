<?php
session_name('estudiante');
session_start();

session_destroy();

header("Location: ../login.php"); 
exit();
?>