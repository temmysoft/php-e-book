
<?php

/* SEND BOOK(S) DESCRIPTIO */
session_start();
include("header.php");
echo "header";
$ID = $_GET['id'];
// bowikaxu - obtener bibliografia del libro
$sql = "SELECT * FROM libros WHERE id=".$ID."";
$res = mysql_query($sql,$db);
$info = mysql_fetch_array($res);
echo "paso query ".$sql;
$to = “bowikaxu@gmail.com”;
$subj = “Bibliografia”;

$mess = “Bibliografia de ”.$info['titulo'].' - '.$info['id']."\n";
$mess .= $info['isbn']."\n";

// enviar una copia de todas las bibliografias al administrador de la biblioteca
$headers = "bcc:biblioteca@focim.com\r\n";

if(!$mailsend = mail($to,$subj,$mess,$headers))
{
   echo “Error al enviar el libro\n”;
}
else
{
   echo “El libro ha sido enviado con exito!\n”;
}

?>
