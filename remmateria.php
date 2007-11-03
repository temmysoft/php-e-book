<?php
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Eliminar Materia de Libro</title>\n";
$current_page = "remmateria.php";
$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

if (!isset($_SESSION['admin_user'])) {

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
// se envio un libro a borrar
if(isset($_GET['id']) && isset($_GET['mat'])){
	
	$sql = "DELETE FROM libros_materias WHERE id_libro=".$_GET['id']." AND id_materia=".$_GET['mat']."";
	mysql_query($sql);
	echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>La materia se elimino con exito !!!</td></tr>\n";
		echo "            </table>\n";
		$sql = "DELETE FROM libros_palclave WHERE id_libro=".$_GET['id']." AND id_palclave IN (SELECT id FROM pal_clave WHERE id_materia =".$_GET['mat'].")";
	mysql_query($sql);
	echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>La materia se elimino con exito !!!</td></tr>\n";
		echo "            </table>\n";
		exit;
	
}else {
	
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;Arial:Arial;font-size:12px;'>No se envio ninguna persona a borrar !!!</td></tr>\n";
		echo "            </table>\n";
		exit;
	
	
}


?>