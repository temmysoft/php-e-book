<?php
/*

BIBLIOTECA FOCIM
Logout

*/

include('config.inc.php');
session_start();

mysql_query("DELETE FROM online WHERE onlineid = '".$_SESSION['userid']."'");

if (isset($_SESSION['admin_user'])) {unset($_SESSION['admin_user']);}
if (isset($_SESSION['captur_user'])) {unset($_SESSION['captur_user']);}
if (isset($_SESSION['lector_user'])) {unset($_SESSION['lector_user']);}
if (isset($_SESSION['userid'])) {unset($_SESSION['userid']);}

session_destroy();

echo "<script type='text/javascript' language='javascript'> window.location.href = 'index.php';</script>";
?>  
