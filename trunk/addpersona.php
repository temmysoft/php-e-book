<?php
/*


*/
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Agregar Persona</title>\n";
$current_page = "addpersona.php";

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

if(isset($_GET['edit'])){
	$_POST['submit']='editar persona';
	$_POST['id']=$_GET['edit'];
}

// editar persona
if($_POST['submit']=='editar persona'){
	
$sql = "SELECT * FROM personas WHERE id='".$_POST['id']."'";
$res = mysql_query($sql);
$persona = mysql_fetch_array($res);
echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "				<input type=hidden name='id' value='".$persona['id']."'>";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/user_green.png' />&nbsp;&nbsp;&nbsp;Editar Persona</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Apellido Paterno:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='apellido_pat' value='".$persona['apellido_pat']."'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Apellido Materno:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='apellido_mat' value='".$persona['apellido_mat']."'>&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nombre(s):</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='nombre' value='".$persona['nombres']."'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nacimiento:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:11px;padding-left:20px;'><input type='text' 
                      size='25' maxlength='26' name='nacimiento' value='".$persona['fecha_nacim']."'>&nbsp;Formato: 1986/05/15</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Muerte:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:11px;padding-left:20px;'><input type='text' 
                      size='25' maxlength='26' name='muerte' value='".$persona['fecha_muerte']."'>&nbsp;Formato: 1986/05/15</td></tr>\n";

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='Aplicar Cambios' src='images/buttons/done_button.png'></td>
                  <td><a href='addpersona.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table>";
	
}
// fin editar persona

// aplicar cambios

// fin aplicar cambios
if($_POST['submit']=='agregar persona'){
	
	
	$sql = "SELECT * FROM personas WHERE nombres='".$_POST['nombre']."' AND apellido_pat='".$_POST['apellido_pat']."' AND apellido_mat='".$_POST['apellido_mat']."'";
	$res = mysql_query($sql);
	
	if(mysql_num_rows($res)<=0){
		$sql = "UPDATE personas SET nombres='".$_POST['nombre']."', apellido_pat='".$_POST['apellido_pat']."', apellido_mat='".$_POST['apellido_mat']."',
				fecha_nacim='".$_POST['nacimiento']."', fecha_muerte='".$_POST['muerte']."' WHERE id='".$_POST['id']."'";
		$res = mysql_query($sql);
	
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>Se actualizo la persona con exito !!!</td></tr>\n";
		echo "            </table>\n";
	}else {
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: La persona ya existe !!!</td></tr>\n";
		echo "            </table>\n";
	}
	
}
// insert a personas
if($_POST['submit']=='Aplicar Cambios'){
	
	$sql = "SELECT * FROM personas WHERE nombres='".$_POST['nombre']."' AND apellido_pat='".$_POST['apellido_pat']."' AND apellido_mat='".$_POST['apellido_mat']."'";
	$res = mysql_query($sql);
	if(strlen($_POST['apellido_pat'])<1 || strlen($_POST['nombre'])<1){
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: alguno de los valores no es valido !!!</td></tr>\n";
		echo "            </table>\n";
		
	}else if(mysql_num_rows($res)>=1){
		$sql = "UPDATE personas SET nombres='".$_POST['nombre']."', apellido_pat='".$_POST['apellido_pat']."', apellido_mat='".$_POST['apellido_mat']."',
				fecha_nacim='".$_POST['nacimiento']."', fecha_muerte='".$_POST['muerte']."' WHERE id='".$_POST['id']."'";
		$res = mysql_query($sql);
	
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>Se actualizo la persona con exito !!!</td></tr>\n";
		echo "            </table>\n";
	}else {
		//$sql = "INSERT INTO personas (apellido_pat,apellido_mat,nombres,fecha_nacim,fecha_muerte) VALUES ('".$_POST['apellido_pat']."','".$_POST['apellido_mat']."','".$_POST['nombre']."','".$_POST['nacimiento']."','".$_POST['muerte']."')";
		$sql = "UPDATE personas SET nombres='".$_POST['nombre']."', apellido_pat='".$_POST['apellido_pat']."', apellido_mat='".$_POST['apellido_mat']."',
				fecha_nacim='".$_POST['nacimiento']."', fecha_muerte='".$_POST['muerte']."' WHERE id='".$_POST['id']."'";
		$result = mysql_query($sql);
			echo "<BR>";
			echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
			echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>La persona se actualizo con exito !!!</td></tr>\n";
			echo "            </table>\n";
	}
}
// fin insert a personas

// delete a personas
if($_POST['submit']=='borrar persona'){
	/*
	$sql = "DELETE FROM personas WHERE id='".$_POST['id']."'";
	$result = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>La persona se borro con exito !!!</td></tr>\n";
		echo "            </table>\n";
		*/
	
}
// fin delete a personas
echo "            <br />\n";
echo "            <table align=center class=table_border width=20% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group.png' />&nbsp;&nbsp;&nbsp;Busqueda por Apellido Paterno</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            <form action='$current_page' method='post'>\n";
echo "<TR><TD>Apellido Paterno: </TD><TD><INPUT TYPE=TEXT NAME=ap_pat SIZE=30 MAXLENGTH=50 VALUE='".$_POST['ap_pat']."'></TD></TR></TABLE></FORM>";
echo "<BR>";

if(isset($_POST['ap_pat']) && strlen($_POST['ap_pat'])>=2){
	
echo "            <table align=center class=table_border width=20% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group.png' />&nbsp;&nbsp;&nbsp;Resultados de: ".$_POST['ap_pat']."</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            <form action='$current_page' method='post'>\n";

$sql = "SELECT * FROM personas WHERE apellido_pat = '".$_POST['ap_pat']."'";
$res = mysql_query($sql);
while($per = mysql_fetch_array($res)){
	
	echo "<TR><TD><A HREF='addpersona.php?edit=".$per['id']."'>".$per['apellido_pat'].' '.$per['apellido_mat'].' '.$per['nombres']."</a></TD></TR>";
	
}
echo "<BR>";
	
}

// agregar persona
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/user_green.png' />&nbsp;&nbsp;&nbsp;Agregar Persona</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Apellido Paterno:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='apellido_pat'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Apellido Materno:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='apellido_mat'>&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nombre(s):</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='nombre'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nacimiento:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:11px;padding-left:20px;'><input type='text' 
                      size='25' maxlength='26' name='nacimiento'>&nbsp;Formato: 1986/05/15</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Muerte:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:11px;padding-left:20px;'><input type='text' 
                      size='25' maxlength='26' name='muerte'>&nbsp;Formato: 1986/05/15</td></tr>\n";

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='agregar persona' src='images/buttons/done_button.png'></td>
                  <td><a href='index.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table></form>";
// fin agregar persona
/*
// mostrar personas
$sql = "SELECT * FROM personas ORDER BY apellido_pat, apellido_mat, nombres";
$result = mysql_query($sql);
echo "            <br />\n";
echo "            <table align=center class=table_border width=20% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group.png' />&nbsp;&nbsp;&nbsp;Listado Personas</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

while ($persona = mysql_fetch_array($result)){
	echo "            <form action='$current_page' method='post'>\n";
	echo "              <tr><td class=table_rows height=25 width=70% style='padding-left:32px;' nowrap>".$persona['apellido_pat']."
						&nbsp;".$persona['apellido_mat'].",&nbsp;&nbsp;".$persona['nombres']."&nbsp;&nbsp;</td>";
//<input type='submit' name='submit' src='images/icons/delete.png' value='borrar persona'>
	echo "				<td><input type='hidden' name='id' value='".$persona['id']."'>
						
						<input type='submit' name='submit' src='images/icons/delete.png' value='editar persona'>";
	echo "              </td></tr></form>\n";
	
}
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
// fin mostrar personas
*/
include ('footer.php');
?>
