<?php
/*


*/
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Agregar Materia</title>\n";
$current_page = "addmateria.php";

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
// insert a pal_clave
if($_POST['submit']=='agregar palclave'){
	
	$sql = "INSERT INTO pal_clave (id_materia,nombre) VALUES ('".$_POST['id_materia']."', '".$_POST['nombre']."')";
	$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Tahoma;font-size:12px;'>La palabra clave se agrego con exito !!!</td></tr>\n";
		echo "            </table>\n";
		$_POST['id']=$_POST['id_materia'];
		$_POST['submit']='editar materia';
	
}
// fin insert a pal_clave

// delete a pal_clave
if($_POST['submit']=='borrar palclave'){
	
	$sql = "SELECT id_materia FROM pal_clave WHERE id='".$_POST['id']."'";
	$result = mysql_query($sql);
	$id_materia = mysql_fetch_array($result);
	$idmat = $id_materia['id_materia'];
	$sql = "DELETE FROM pal_clave WHERE id='".$_POST['id']."'";
	$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Tahoma;font-size:12px;'>La palabra clave se borro con exito !!!</td></tr>\n";
		echo "            </table>\n";
		$_POST['id']=$idmat;
		$_POST['submit']='editar materia';
	
}
// fin delete a pal_clave

// agregar palabras clave
if($_POST['submit']=='editar materia'){
	
		$id = $_POST['id'];
		$sql = "SELECT * FROM materias WHERE id='".$id."'";
		$result = mysql_query($sql);
		$materia = mysql_fetch_array($result);
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Tahoma;font-size:12px;'>".$materia['nombre']."</td></tr>\n";
		echo "            </table>\n";
		
	// agregar palabra clave
	echo "            <br />\n";
	echo "            <form name='libro' action='$current_page' method='post'>\n";
	echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
	echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      	<img src='images/icons/user_add.png' />&nbsp;&nbsp;&nbsp;Agregar Palabra Clave</th></tr>\n";
	echo "              <tr><td height=15></td></tr>\n";
	
	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Palabra:</td><td colspan=2 width=80%
	                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'><input type='text' 
    	                  size='45' maxlength='49' name='nombre'>&nbsp;*</td></tr>\n";
	
	echo "				<input type='hidden' name='id_materia' value ='".$id."'>";
	
	echo "            </table>\n";
	echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
	echo "              <tr><td height=15></td></tr>\n";
	echo "            </table>\n";
	echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
	echo "              <tr><td width=30><input type='submit' name='submit' value='agregar palclave' src='images/buttons/done_button.png'></td>
    	              <td><a href='addmateria.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
	echo "</table>";
	// fin agregar palabra clave
	
	// mostrar palabras clave
	$sql = "SELECT * FROM pal_clave WHERE id_materia ='".$id."'";
	$result = mysql_query($sql);
	echo "            <br />\n";
	echo "            <form name='libro' action='$current_page' method='post'>\n";
	echo "            <table align=center class=table_border width=20% border=0 cellpadding=3 cellspacing=0>\n";
	echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      	<img src='images/icons/user_orange.png' />&nbsp;&nbsp;&nbsp;Listado Palabras Clave</th></tr>\n";
	echo "              <tr><td height=15></td></tr>\n";
	
	while ($palclave = mysql_fetch_array($result)){
	echo "            <form action='$current_page' method='post'>\n";
	echo "              <tr><td class=table_rows height=25 width=70% style='padding-left:32px;' nowrap>".$palclave['nombre']."&nbsp;</td><td>";
	echo "				<input type='hidden' name='id' value='".$palclave['id']."'>
						<input type='submit' name='submit' src='images/icons/delete.png' value='borrar palclave'>";
	echo "              </td></tr></form>\n";
	
}
	
	echo "            </table>\n";
	echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
	echo "              <tr><td height=15></td></tr>\n";
	echo "            </table>\n";
	// fin mostrar palabras clave
	
	include ('footer.php');
	exit;
	
}
// agregar palabras clave

// insert a materias
if($_POST['submit']=='agregar materia'){
	
	$sql = "INSERT INTO materias (nombre) VALUES ('".$_POST['nombre']."')";
	$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Tahoma;font-size:12px;'>La materia se agrego con exito !!!</td></tr>\n";
		echo "            </table>\n";
	
}
// fin insert a materias

// delete a materias
if($_POST['submit']=='borrar materia'){
	
	$sql = "DELETE FROM materias WHERE id='".$_POST['id']."'";
	$result = mysql_query($sql);
	$sql = "DELETE FROM libros_palclave WHERE id_palclave IN (SELECT id FROM pal_clave WHERE id_materia='".$_POST['id']."')";
	$res = mysql_query($sql);
	$sql = "DELETE FROM pal_clave WHERE id_materia='".$_POST['id']."'";
	$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Tahoma;font-size:12px;'>La materia se borro con exito !!!</td></tr>\n";
		echo "            </table>\n";
	
}
// fin delete a materias

// delete a pal_clave
if($_POST['submit']=='borrar palclave'){
	
	$sql = "DELETE FROM pal_clave WHERE id='".$_POST['id']."'";
	$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Tahoma;font-size:12px;'>La palabra clave se borro con exito !!!</td></tr>\n";
		echo "            </table>\n";
	
}
// fin delete a pal_clave

echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";

echo "<table align=center class=table_border><form method='post' action'addciudad.php'>";
$sql = "SELECT * FROM materias";
$result = mysql_query($sql);
echo '<tr><td><STRONG>VERIFICADOR</STRONG></td><td><select id="materias" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="id">';
while($materia = mysql_fetch_array($result)){
	echo "<option value='".$materia['id']."'>".$materia['nombre']."</option>\n";
}
echo "</select></td><td><input type='submit' name='submit' src='images/icons/group_edit.png' value='editar materia'></td></tr></table><br><br>";
// <input type='submit' name='submit' src='images/icons/delete.png' value='borrar materia'>

// agregar materia
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/user_add.png' />&nbsp;&nbsp;&nbsp;Agregar Materia</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nombre:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='nombre'>&nbsp;*</td></tr>\n";

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='agregar materia' src='images/buttons/done_button.png'></td>
                  <td><a href='index.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table></form>";
// fin agregar materia

// mostrar materias
$sql = "SELECT * FROM materias";
$result = mysql_query($sql);
echo "            <br />\n";
echo "            <table align=center class=table_border width=20% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group_add.png' />&nbsp;&nbsp;&nbsp;Listado Materias</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

while ($materia = mysql_fetch_array($result)){
	echo "            <form action='$current_page' method='post'>\n";
	echo "              <tr><td class=table_rows height=25 width=70% style='padding-left:32px;' nowrap>".$materia['nombre']."&nbsp;</td><td>";
	echo "				<input type='hidden' name='id' value='".$materia['id']."'>
						
						<input type='submit' name='submit' src='images/icons/group_edit.png' value='editar materia'>";
	echo "              </td></tr></form>\n";
	// <input type='submit' name='submit' src='images/icons/delete.png' value='borrar materia'>
}
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
// fin mostrar materias

include ('footer.php');
?>