<?php
/*


*/
session_start();

include ('header.php');
include('functions.php');
//include ('leftmain.php');

echo "<title>$title - Contacto</title>\n";
$current_page = "contacto.php";

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
is_online();

// informacion de contacto
echo "<center>";
echo "Cualquier duda, comentario y/o sugerencia relativa a la biblioteca, favor de comunicarse a cualquiera de nuestros siguientes contactos:"."<br><br>";
echo "</center>";
echo "Tel. 8347-9829"."<br><br>";
echo "E-Mail: biblioteca@focim.com (actualmente no activo)"."<br><br>";
echo "Direccion: "."<br>";
echo "Xicotencatl #975 Nte. Col. Centro"."<br>";
echo "Monterrey, N.L. C.P. 64000"."<br>";
echo "Esquina con Arteaga, 3er Piso"."<br>";

// fin informacion de contacto

include ('footer.php');
?>