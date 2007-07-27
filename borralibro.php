<?php
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Borrar Libro</title>\n";
$current_page = "borralibro.php";
$self = $_SERVER['PHP_SELF'];

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

if(!empty($_GET['borrar'])){
	
	$ID = $_GET['borrar'];
	$sql = "DELETE FROM libros WHERE id='".$ID."'";
	mysql_query($sql);
	
	$sql = "DELETE FROM libros_materias WHERE id_libro='".$ID."'";
	mysql_query($sql);
	
	$sql = "DELETE FROM libros_personas WHERE id_libro='".$ID."'";
	mysql_query($sql);
	
	$sql = "DELETE FROM libros_palclave WHERE id_libro='".$ID."'";
	mysql_query($sql);

	$sql = "DELETE FROM libros_capturista WHERE id_libro='".$ID."'";
	mysql_query($sql);
	
	echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Tahoma;font-size:12px;'>El libro se borro con exito !!!</td></tr>\n";
		echo "            </table>\n";
	
}

echo "<script type='text/javascript' language='javascript'> window.location.href = 'index.php';</script>";

include ('footer.php');
?>