<?php
/*


*/
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Agregar Ciudad</title>\n";
$current_page = "addciudad.php";

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
// insert a ciudades
if($_POST['submit']=='agregar ciudad'){
	
	$sql = "INSERT INTO ciudades (nombre) VALUES ('".$_POST['nombre']."')";
	$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>La ciudad se agrego con exito !!!</td></tr>\n";
		echo "            </table>\n";
	
}
// fin insert a ciudades

if($_POST['submit']=='aplicar cambios'){
	if(strlen($_POST['nombre'])>1){
	
		$sql = "SELECT * FROM ciudades WHERE nombre = '".$_POST['nombre']."'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res)>0){
			echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: La ciudad ya existe !!!</td></tr>\n";
		echo "            </table>\n";
		}else {
		$sql = "UPDATE ciudades SET nombre = '".$_POST['nombre']."' WHERE id='".$_POST['id']."'";
		$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>La ciudad se edito con exito !!!</td></tr>\n";
		echo "            </table>\n";
		}
	}
}

if($_POST['submit']=='editar'){
$sql = "SELECT * FROM ciudades WHERE id='".$_POST['id']."'";
$res = mysql_query($sql);
$pais = mysql_fetch_array($res);
echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "				<input type=hidden name='id' value='".$pais['id']."'>";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/user_green.png' />&nbsp;&nbsp;&nbsp;Editar Ciudad</th></tr>\n";
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
                  <td><a href='$current_page'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table>";

include ('footer.php');
exit;
}

// delete a ciudades
if($_POST['submit']=='borrar ciudad'){
	/*
	$sql = "SELECT id FROM libros WHERE ciudad='".$_POST['id']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>=1){

		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;Arial:Arial;font-size:12px;'>Un libro hace referencia a esta ciudad. Imposible Borrar !!!</td></tr>\n";
		echo "            </table>\n";
			
	}else {
	$sql = "DELETE FROM ciudades WHERE id='".$_POST['id']."'";
	$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;Arial:Arial;font-size:12px;'>La ciudad se borro con exito !!!</td></tr>\n";
		echo "            </table>\n";
	}
	*/
}
// fin delete a ciudades
echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "<table align=center class=table_border><form method='post' action'addciudad.php'>";
$sql = "SELECT * FROM ciudades";
$result = mysql_query($sql);
echo '<tr><td><STRONG>VERIFICADOR</STRONG></td><td><select id="ciudades" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="id">';
while($ciudad = mysql_fetch_array($result)){
	echo "<option value='".$ciudad['id']."'>".$ciudad['nombre']."</option>\n";
}
echo "</select><input type=submit name=submit value='editar'></td></tr></form></table><br><br>";
//<td><input type='submit' name='submit' src='images/icons/delete.png' value='borrar ciudad'></td>
// agregar ciudad
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group_add.png' />&nbsp;&nbsp;&nbsp;Agregar Ciudad</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nombre:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='nombre'>&nbsp;*</td></tr>\n";

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='agregar ciudad' src='images/buttons/done_button.png'></td>
                  <td><a href='index.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table></form>";
// fin agregar ciudad

// mostrar ciudades
$sql = "SELECT * FROM ciudades";
$result = mysql_query($sql);
echo "            <br />\n";
echo "            <table align=center class=table_border width=20% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group_add.png' />&nbsp;&nbsp;&nbsp;Listado Ciudades</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

while ($ciudad = mysql_fetch_array($result)){
	echo "            <form action='$current_page' method='post'>\n";
	echo "              <tr><td class=table_rows height=25 width=70% style='padding-left:32px;' nowrap>".$ciudad['nombre']."&nbsp;</td><td>";
	echo "				<input type='hidden' name='id' value='".$ciudad['id']."'>
						";
	//<input type='submit' name='submit' src='images/icons/delete.png' value='borrar ciudad'>
	echo "              </td></tr></form>\n";
	
}
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
// fin mostrar ciudades

include ('footer.php');
?>