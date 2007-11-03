<?php

/* mysql info --- $db_hostname is the hostname for your mysql server, default is localhost.
              --- $db_username is the mysql username you created during the install.
              --- $db_password is the mysql password for the username you created during
                  the install.
              --- $db_name is the mysql database you created during the install. */

$db_hostname = "localhost";
$db_username = "biblioteca";
$db_password = "bibliofocim34";
$db_name = "biblioteca";

/* --- OPTIONAL CHANGES --- */

//session_save_path("/var/www/biblioteca/tmp/");
/* A logo or graphic, this is displayed in the top left of each page.
   Set it to "none" to ignore this option. */

$logo = "images/logos/logo.jpg";

/* These are alternating row colors for the main page and for reports. */

$color1 = "#EFEFEF";
$color2 = "#FBFBFB";

// numero de resultados por pagina
$rowsPerPage = 50;

// mostrar la primera pagina por default
$pageNum = 1;

// Numero maximo de libros en Mi Librero
$libreromax = 15;

// Ubicacion de los libros final (jpg)
$libros_dir = "/home/ftp2/libros/";
// ubicacion de los libros temporal (tiff)
$libros_tmp = "/home/ftp2/librotiff/";
// nombre del archivo con el lomo del libro
$lomo = "LOMO";
// ubicacion de los lomos
$lomos_dir = "/var/www/biblioteca/lomos/";
$lomos_view_dir = "lomos/";

// ubicacion de completos.pdf
$completo_dir = "/var/www/biblioteca/PDF/";

// conexion con la base de datos
$db = mysql_pconnect($db_hostname, $db_username, $db_password);
if (!$db) {echo "Error: Could not connect to the database. Please try again later."; exit;}
mysql_select_db($db_name);

?>
