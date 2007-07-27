<?php
/*

BIBLIOTECA FOCIM
Logout

*/
session_start();

if (isset($_SESSION['admin_user'])) {unset($_SESSION['admin_user']);}
if (isset($_SESSION['captur_user'])) {unset($_SESSION['captur_user']);}
if (isset($_SESSION['lector_user'])) {unset($_SESSION['lector_user']);}

session_destroy();

echo "<script type='text/javascript' language='javascript'> window.location.href = 'index.php';</script>";
?>  
