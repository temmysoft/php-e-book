<?php
/*


*/
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Agregar Pais</title>\n";
$current_page = "addpais.php";

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
// insert a paises
if($_POST['submit']=='agregar pais'){
	if(strlen($_POST['nombre'])>1){
	$sql = "INSERT INTO paises (nombre) VALUES ('".$_POST['nombre']."')";
	$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>El pais se agrego con exito !!!</td></tr>\n";
		echo "            </table>\n";
	}
}
// fin insert a paises

if($_POST['submit']=='aplicar cambios'){
	if(strlen($_POST['nombre'])>1){
	
		$sql = "SELECT * FROM paises WHERE nombre = '".$_POST['nombre']."'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res)>0){
			echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: El pais ya existe !!!</td></tr>\n";
		echo "            </table>\n";
		}else {
		$sql = "UPDATE paises SET nombre = '".$_POST['nombre']."' WHERE id='".$_POST['id']."'";
		$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>El pais se edito con exito !!!</td></tr>\n";
		echo "            </table>\n";
		}
	}
}

if($_POST['submit']=='editar'){
$sql = "SELECT * FROM paises WHERE id='".$_POST['id']."'";
$res = mysql_query($sql);
$pais = mysql_fetch_array($res);
echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "				<input type=hidden name='id' value='".$pais['id']."'>";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/user_green.png' />&nbsp;&nbsp;&nbsp;Editar Pais</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nombre:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='nombre' value='".$pais['nombre']."'>&nbsp;*</td></tr>\n";

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='aplicar cambios' src='images/buttons/done_button.png'></td>
                  <td><a href='addpais.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table>";

include ('footer.php');
exit;
}

// delete a paises
if($_POST['submit']=='borrar pais'){
	/*
	$sql = "SELECT id FROM libros WHERE paise='".$_POST['id']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>=1){

		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>Un libro hace referencia a este pais. Imposible Borrar !!!</td></tr>\n";
		echo "            </table>\n";
			
	}else {
	
	$sql = "DELETE FROM paises WHERE id='".$_POST['id']."'";
	$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>El pais se borro con exito !!!</td></tr>\n";
		echo "            </table>\n";
	}
	*/
}
// fin delete a paises
echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "<table align=center class=table_border><form method='post' action'addpais.php'>";
$sql = "SELECT * FROM paises";
$result = mysql_query($sql);
echo '<tr><td><STRONG>VERIFICADOR</STRONG></td><td><select id="SelectDropdown" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="id">';
while($pais = mysql_fetch_array($result)){
	echo "<option value='".$pais['id']."'>".$pais['nombre']."</option>\n";
}
echo "</select><input type=submit name=submit value='editar'></td></tr></form></table><br><br>";
//<td><input type='submit' name='submit' src='images/icons/delete.png' value='borrar pais'></td>
// agregar pais
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group_add.png' />&nbsp;&nbsp;&nbsp;Agregar Pais</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nombre:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='nombre'>&nbsp;*</td></tr>\n";

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='agregar pais' src='images/buttons/done_button.png'></td>
                  <td><a href='index.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table></form>";
// fin agregar pais
// mostrar paises
$sql = "SELECT * FROM paises";
$result = mysql_query($sql);
echo "            <br />\n";
echo "            <table align=center class=table_border width=20% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group_add.png' />&nbsp;&nbsp;&nbsp;Listado Paises</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

while ($pais = mysql_fetch_array($result)){
	echo "            <form action='$current_page' method='post'>\n";
	echo "              <tr><td class=table_rows height=25 width=70% style='padding-left:32px;' nowrap>".$pais['nombre']."&nbsp;</td><td>";
	echo "				<input type='hidden' name='id' value='".$pais['id']."'>
						";
	//<input type='submit' name='submit' src='images/icons/delete.png' value='borrar pais'>
	echo "              </td></tr></form>\n";
	
}

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
// fin mostrar paises


include ('footer.php');
?>