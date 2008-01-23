<?php
/*

AGREGAR ESCUELAS A LA BIBLIOTECA Y SUS LIBROS PERMITIDOS
*/
session_start();
include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Agregar Escuela</title>\n";
$current_page = "addescuela.php";
//echo $_POST['librosde'].'  -  '.$_POST['libroshasta']."<HR>";
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
if($_POST['submit']=='agregar escuela'){
	if(strlen($_POST['nombre'])>=1 && (strlen($_POST['libros'])>=1 || $_POST['librosde']!='' || $_POST['libroshasta']!='')){
		$sql = "SELECT * FROM escuelas WHERE nombre = '".$_POST['nombre']."'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res)>0){
			echo "<BR>";
			echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
			echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: La escuela ya existe !!!</td></tr>\n";
			echo "            </table>\n";
		}else {
			if($_POST['libros']=='')$_POST['libros']="";
			mysql_query("BEGIN");
			// insertar la escuela
			$sql = "INSERT INTO escuelas (nombre,libros) VALUES ('".$_POST['nombre']."','".$_POST['libros']."')";
			$result = mysql_query($sql);
			
			// obtener el ultimo id de la escuela recien insertada
			$sql = "SELECT MAX(id) AS lastid FROM escuelas ORDER BY id DESC LIMIT 1";
			$res = mysql_query($sql);
			$lastid = mysql_fetch_array($res);
			
			// separar los id de los libros por comas
			$libros = explode(",",$_POST['libros']);
			foreach($libros as $libro){
				if($libro!=''){
					$sql = "INSERT INTO libros_escuelas (id_libro,id_escuela) VALUES ('".$libro."','".$lastid['lastid']."')";
					echo $sql."<br>";
					$res = mysql_query($sql);
				}
			}
			// insertar rango e libros
			for($i=$_POST['librosde'];$i<=$_POST['libroshasta'];$i++){
				$sql = "INSERT INTO libros_escuelas (id_libro,id_escuela) VALUES ('".$i."','".$_POST['id']."')";
				echo $sql."<br>";
				$res = mysql_query($sql);
			}
			mysql_query("COMMIT");
			echo "<BR>";
			echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
			echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>La escuela se agrego con exito !!!</td></tr>\n";
			echo "            </table>\n";
		}
	}
}
// fin insert a ciudades

if($_POST['submit']=='aplicar cambios'){
	if(strlen($_POST['nombre'])>=1 && (strlen($_POST['libros'])>=1 || $_POST['librosde']!='' || $_POST['libroshasta']!='')){
	
		$sql = "SELECT * FROM escuelas WHERE nombre = '".$_POST['nombre']."' AND id != '".$_POST['id']."'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res)>0){
			echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: La escuela ya existe !!!</td></tr>\n";
		echo "            </table>\n";
		}else {
			$ok_single= 1;
			mysql_query("BEGIN");
			if(strlen($_POST['libros'])>=1)$ok_single=1;
		$sql = "UPDATE escuelas SET nombre = '".$_POST['nombre']."', libros = '".$_POST['libros']."' WHERE id='".$_POST['id']."'";
		$result = mysql_query($sql);

		if($ok_single==1){
			// separar los id de los libros por comas
			$libros = explode(",",$_POST['libros']);
			mysql_query("DELETE FROM libros_escuelas WHERE id_escuela ='".$_POST['id']."'");
			foreach($libros as $libro){
				$sql = "INSERT INTO libros_escuelas (id_libro,id_escuela) VALUES ('".$libro."','".$_POST['id']."')";
				$res = mysql_query($sql);
			}
		}
			// insertar rango e libros
			for($i=$_POST['librosde'];$i<=$_POST['libroshasta'];$i++){
				$sql = "INSERT INTO libros_escuelas (id_libro,id_escuela) VALUES ('".$i."','".$_POST['id']."')";
				$res = mysql_query($sql);
			}
		mysql_query("COMMIT");
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>La escuela se edito con exito !!!</td></tr>\n";
		echo "            </table>\n";
		}
	}
}

if($_POST['submit']=='editar'){
$sql = "SELECT escuelas.*, libros_escuelas.* 
		FROM escuelas, libros_escuelas
		WHERE 
			escuelas.id = libros_escuelas.id_escuela
			AND escuelas.id='".$_POST['id']."'";
$res = mysql_query($sql);
$k=0;
$libros ='';
while($escuela = mysql_fetch_array($res)){
	if($k>0){
		$libros .= ',';
	}
	$id = $escuela['id'];
	$nombre = $escuela['nombre'];
	$libros .= $escuela['id_libro'];
	$k++;
}

echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "				<input type=hidden name='id' value='".$id."'>";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/application.png' />&nbsp;&nbsp;&nbsp;Editar Escuela</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nombre:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='50' maxlength='190' name='nombre' value='".$nombre."'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Libros:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>
                      <TEXTAREA COLS=40 ROWS=6 NAME=libros>".$libros."</TEXTAREA>
                      </td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Libros de:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='10' maxlength='9' name='librosde'>&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Libros hasta:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='10' maxlength='9' name='libroshasta'>&nbsp;</td></tr>\n";

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
if($_POST['submit']=='borrar escuela'){
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
echo "<table align=center class=table_border><form method='post' action'$current_page'>";
$sql = "SELECT * FROM escuelas";
$result = mysql_query($sql);
echo '<tr><td><STRONG>VERIFICADOR</STRONG></td><td><select id="ciudades" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="id">';
while($escuela = mysql_fetch_array($result)){
	echo "<option value='".$escuela['id']."'>".$escuela['nombre']."</option>\n";
}
echo "</select><input type=submit name=submit value='editar'></td></tr></form></table><br><br>";
//<td><input type='submit' name='submit' src='images/icons/delete.png' value='borrar ciudad'></td>
// agregar ciudad
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/application_add.png' />&nbsp;&nbsp;&nbsp;Agregar Escuela</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nombre:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='50' maxlength='190' name='nombre'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Libros:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'>
                      <TEXTAREA COLS=40 ROWS=6 NAME=libros></TEXTAREA>
                      </td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Libros de:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='10' maxlength='9' name='librosde'>&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Libros hasta:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='10' maxlength='9' name='libroshasta'>&nbsp;</td></tr>\n";

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='agregar escuela' src='images/buttons/done_button.png'></td>
                  <td><a href='index.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table></form>";
// fin agregar ciudad

// mostrar ciudades
$sql = "SELECT * FROM escuelas";
$res = mysql_query($sql);
echo "            <br />\n";
echo "            <table align=center class=table_border width=20% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group_add.png' />&nbsp;&nbsp;&nbsp;Listado Escuelas</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

while ($ciudad = mysql_fetch_array($res)){
	
	$sql = "SELECT libros_escuelas.* FROM libros_escuelas WHERE id_escuela = '".$ciudad['id']."'";
	$libros2 = mysql_query($sql);
	$k=0;
	while($lib2 = mysql_fetch_array($libros2)){
		if($k>0){
			$libros .= ',';
			$id = $lib2['id'];
			$nombre = $lib2['nombre'];
		}
		$libros .= $lib2['id_libro'];
		$k++;
	}
	
	echo "            <form action='$current_page' method='post'>\n";
	echo "              <tr><td class=table_rows height=25 width=70% style='padding-left:32px;' nowrap>".$ciudad['id'].' '.$ciudad['nombre']."&nbsp;</td><td>";
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