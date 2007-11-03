<?php
/*


*/
session_start();
include ('header.php');
include ('scripts.php');
include ('functions.php');
//include ('leftmain.php');

echo "<title>$title - Editar Libro</title>\n";
$current_page = "editar.php";

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
// se envio una busqueda

if(isset($_POST['id'])){
	$idlibro = $_POST['id'];
}else if(isset($_GET['id'])){
	$idlibro = $_GET['id'];
}else {
	unset($idlibro);
}

if(isset($idlibro)){
	
	echo "<BR>";
	ficha_resumen($idlibro);
	
	echo "<table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
	echo "	<tr>
   				<td class=table_rows align=center colspan=3 style='color:black;font-family:Arial;font-size:12px;'>
   					<a href='editarlibro.php?id=".$idlibro."'>Editar Datos Generales</a></td></tr>
   					<tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Arial;font-size:12px;'>
   						<a href='libropersonas.php?id=".$idlibro."'>Editar Personas</a></td></tr>
   					<tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Arial;font-size:12px;'>
   					<a href='libromaterias.php?id=".$idlibro."'>Editar Materias</a>
   				</td>
   			</tr>\n";
	echo "</table>\n";
	
}else { // no se envio ningun libro
	
	
	
}


include ('footer.php');
?>