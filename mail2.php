<?php
session_start();
include ('header.php');
$sql = "SELECT * FROM libros LIMIT 2";
$res = mysql_query($sql) or die ('imposible query');
$msg = "";
while($libros = mysql_fetch_array($res)){

$msg .= " - ".$libros['titulo']."";
}
echo $msg."<br>";
$para      = 'bowikaxu@gmail.com';
$asunto    = 'el asunto';
$mensaje   = $msg;
$mensaje = str_replace("\n.", "\n..", $msg);
$cabeceras = 'From: focim@focim.com' . "\r\n" .
    'Reply-To: bowikaxu@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($para, $asunto, $mensaje, $cabeceras);
?> 
