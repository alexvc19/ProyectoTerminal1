<?php
session_name('sesion_adm');
session_start();

session_destroy();

header("Location: ../loginAdm.php"); 
exit();
?>
