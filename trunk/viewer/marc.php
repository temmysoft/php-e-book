<?php
session_start();

include('../config.inc.php');
if (!isset($_SESSION['lector_user']) AND !isset($_SESSION['admin_user'])) {

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>Login BIBLIOTECA FOCIM</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=200 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>No estas registado<br>o<br>No tienes permiso de acceder a esta pagina.</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='login.php'><u>aqui</u></a> para logearse.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

if (!isset($_GET['id']) || !isset($_GET['page']))
	die ('no se envio libro');
	
	$sql = "INSERT INTO marcadores (id_libro,page,user_) VALUES ('".$_GET['id']."','".$_GET['page']."','".$_SESSION['lector_user']."')";
	mysql_query($sql);
	
?>