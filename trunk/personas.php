<?php
/*


*/
session_start();

include ('header.php');
include('functions.php');
//include ('leftmain.php');

echo "<title>$title - Personas</title>\n";
$current_page = "personas.php";

if (!isset($_SESSION['captur_user']) AND !isset($_SESSION['admin_user'])) {

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>Login BIBLIOTECA FOCIM</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=200 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>No estas registado<br>o<br>No tienes permiso de acceder a esta pagina.</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='login.php'><u>aqui</u></a> para logearse.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

if(!isset($_GET['id'])){
	
	echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Tahoma;font-size:12px;'>ERROR: No se envio ningun libro</td></tr>\n";
		echo "            </table>\n";
	
}else {


		$sql ="SELECT libros.titulo, libros.edicion, editoriales.nombre FROM libros, editoriales WHERE libros.id='".$_GET['id']."'
			AND editoriales.id = libros.editorial";
		$res = mysql_query($sql);
		$titulo = mysql_fetch_array($res);

		echo "<BR>";
		echo "            <table align=center class=table_border width=90% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Tahoma;font-size:12px;'>".$titulo['titulo']." - ".$titulo['edicion']." - ".$titulo['nombre']."</td></tr>\n";
	
		$sql = "SELECT libros.id, libros.titulo, personas.id AS idpersona, personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre
				FROM libros, personas, categorias, libros_personas WHERE libros.id='".$_GET['id']."'
				AND libros_personas.id_libro = libros.id 
				AND libros_personas.id_persona = personas.id
				AND libros_personas.id_categoria = categorias.id
				GROUP BY personas.id";
		$res = mysql_query($sql);
		while($libro = mysql_fetch_array($res)){
			if(isset($_SESSION['admin_user'])){
				echo "              <tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Tahoma;font-size:12px;'><strong>".$libro['nombre'].":</strong> ".$libro['apellido_pat']." ".$libro['apellido_mat']." ".$libro['nombres'].'&nbsp;&nbsp;<a href=rempersona.php?id='.$libro['id'].'&per='.$libro['idpersona'].' onclick="return confirm(\'' . _('Estas Seguro?') . '\');">[eliminar]</a></td></tr>';
			}else {
				echo "              <tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Tahoma;font-size:12px;'><strong>".$libro['nombre'].":</strong> ".$libro['apellido_pat']." ".$libro['apellido_mat']." ".$libro['nombres']."</td></tr>\n";
			}
		}
		echo "            </table>\n";

		include ('footer.php');
		
}