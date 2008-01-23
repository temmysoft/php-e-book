<?php
/*


*/
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Agregar Personas al Libro</title>\n";
$current_page = "libropersonas.php";
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
is_online();
// ir a materias

if(isset($_POST['submit']) && $_POST['submit']=='continuar'){
	
	echo "Usted esta siendo redirigido a agregar materias. sino lo envia automaticamente <a href='libromaterias.php?id=".$_POST['idlibro']."'>haz click aqui</a>";
	//echo "<meta http-equiv='refresh' content='0;URL=libromaterias.php?id=".$_POST['idlibro'].">";
	
}

// fin ir a materias

// insert a persona nueva
if(isset($_POST['submit']) && $_POST['submit']=='agregar persona2'){
	
	$error = 0;
	$sql = "SELECT * FROM categorias WHERE id ='".$_POST['idcategoria']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<1){
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>La Categoria no Existe en la BD !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	}
	if(strlen($_POST['apellido_pat'])<1 || strlen($_POST['nombre'])<1){
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: alguno de los valores no es valido !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
		
	}
	
	$sql = "SELECT id FROM personas WHERE nombre = '".$_POST['nombre']."' AND apellido_pat ='".$_POST['apellido_pat']."' AND apellido_mat = '".$_POST['apellido_mat']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0){
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: La persona ya existe en la B.D. !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	}
	
	if($error == 0){
		$sql = "INSERT INTO personas (apellido_pat,apellido_mat,nombres,fecha_nacim,fecha_muerte) VALUES ('".$_POST['apellido_pat']."','".$_POST['apellido_mat']."','".$_POST['nombre']."','".$_POST['nacimiento']."','".$_POST['muerte']."')";
		$result = mysql_query($sql);
		$sql = "SELECT id FROM personas WHERE apellido_pat='".$_POST['apellido_pat']."' AND apellido_mat='".$_POST['apellido_mat']."' AND nombres ='".$_POST['nombre']."'";
		$result2 = mysql_query($sql);
		$persona = mysql_fetch_array($result2);
		$sql = "INSERT INTO libros_personas (id_libro, id_persona, id_categoria) VALUES ('".$_POST['idlibro']."', '".$persona['id']."', '".$_POST['idcategoria']."')";
		
		$res = mysql_query($sql);
			echo "<BR>";
			echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
			echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>La persona se agrego con exito !!!</td></tr>\n";
			echo "            </table>\n";
			$_GET['id']=$_POST['idlibro'];
	}
}
// fin insert a persona nueva

if(isset($_POST['submit']) && $_POST['submit']=='agregar' && $_POST['idlibro']>=0){
	
	$error = 0;
	$sql = "SELECT * FROM personas WHERE id='".$_POST['idpersona']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<1){
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>La Persona no Existe en la BD !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	}
	$sql = "SELECT * FROM categorias WHERE id ='".$_POST['idcategoria']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<1){
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>La Categoria no Existe en la BD !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	}
	if($error == 0){
		$sql = "INSERT INTO libros_personas (id_libro, id_persona, id_categoria) VALUES ('".$_POST['idlibro']."', '".$_POST['idpersona']."', '".$_POST['idcategoria']."')";
		$res = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>La persona se agrego con exito !!!</td></tr>\n";
		echo "            </table>\n";
		$_GET['id']=$_POST['idlibro']; 
		
	}
	
}
if(isset($_POST['id'])){
$_GET['id']=$_POST['id'];
}
if(isset($_GET['id'])){
		
// tabla de la izquierda
//echo "<table width=100% height=90% border=0 cellpadding=0 cellspacing=1>\n";
//echo "  <tr valign=top>\n";
//echo "    <td class=left_main width=47% align=center scope=col>\n";
// izquierda
	echo "<center><a href='#Listado'>Ver listado de personas</a></center>";
	// agregar persona
	echo "            <br />\n";
	echo "            <form name='personas' action='$current_page' method='post'>\n";
	echo "				<input type='hidden' name='idlibro' value='".$_GET['id']."'>";
	echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
	echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
    	                  <img src='images/icons/group_add.png' />&nbsp;&nbsp;&nbsp;Agregar Persona al Libro</th></tr>\n";
	echo "              <tr><td height=15></td></tr>\n
	<input type=hidden name=id value='".$_GET['id']."'>";
	
	echo "<TR><TD>Apellido Paterno: <INPUT TYPE=TEXT NAME=ap_pat SIZE=30 MAXLENGTH=50 VALUE='".$_POST['ap_pat']."'></TD></TR>";
	
if(isset($_POST['submit']) && $_POST['submit']=='buscar'){
	
	$sql = "SELECT * FROM personas WHERE apellido_pat = '".$_POST['ap_pat']."'";
$res = mysql_query($sql);
echo "<TR><TD><SELECT NAME=idpersona>";
while($per = mysql_fetch_array($res)){
	
	//echo "<TR><TD><A HREF='libropersonas.php?idpersona=".$per['id']."'>".$per['apellido_pat'].' '.$per['apellido_mat'].' '.$per['nombres']."</a></TD></TR>";
	echo "<OPTION VALUE=".$per['id'].">".$per['apellido_pat'].' '.$per['apellido_mat'].' '.$per['nombres']."";
	
}
echo "</TD></TR></SELECT>";
$sql = "SELECT * FROM categorias";
$result = mysql_query($sql);
echo '<tr><td>Categorias: <select id="categoria" acdropdown=true style="width:400px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="idcategoria">';
while($catego = mysql_fetch_array($result)){
	echo "<option value='".$catego['id']."'>".$catego['nombre']."</option>\n";
}
echo "</select></td></tr>";

}
//echo "</table>";

//echo "            <table align=left width=40% border=0 cellpadding=0 cellspacing=3>\n";
//echo "              <tr><td height=15></td></tr>\n";
//echo "            </table>\n";
//echo "            <table align=left width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='buscar' src='images/buttons/next_button.png'>
					<input type='submit' name='submit' value='agregar' src='images/buttons/next_button.png'>
					</td>
					<td width=60><input type='submit' name='submit' value='continuar' src='images/buttons/done_button.png'></td>
                  <td><a href='index.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form>\n";
//echo "</table></form>";

// agregar persona
//echo "            <br \>\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "				<input type='hidden' name='idlibro' value='".$_GET['id']."'>";
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

$sql = "SELECT * FROM categorias";
$result = mysql_query($sql);
echo '<tr><td>Categoria: <select id="categorias" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="idcategoria">';
while($catego = mysql_fetch_array($result)){
	echo "<option value='".$catego['id']."'>".$catego['nombre']."</option>\n";
}
echo "</select></td></tr>";

//echo "            </table>\n";
//echo "            <table align=left width=40% border=0 cellpadding=0 cellspacing=3>\n";
//echo "              <tr><td height=15></td></tr>\n";
//echo "            </table>\n";
//echo "            <table align=left width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='agregar persona2' src='images/buttons/next_button.png'></td>
				<td width=60><input type='submit' name='submit' value='continuar' src='images/buttons/done_button.png'></td>
                  <td><a href='index.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form>\n";
//echo "</table></form>";
// fin agregar persona

//echo "</td>";

//echo "    <td class=middle_main width=5% align=center scope=col>\n</td>";
//echo "    <td class=right_main width=47% align=center scope=col>\n";
// fin derecha
	echo "<P><A NAME='Listado'></A></P>";
		$sql ="SELECT libros.titulo, libros.edicion, editoriales.nombre FROM libros, editoriales WHERE libros.id='".$_GET['id']."'
			AND editoriales.id = libros.editorial";
		$res = mysql_query($sql);
		$titulo = mysql_fetch_array($res);

		echo "<BR>";
		echo "            <table align=center class=table_border width=90% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Arial;font-size:12px;'>".$titulo['titulo']." - ".$titulo['edicion']." - ".$titulo['nombre']."</td></tr>\n";
	
		$sql = "SELECT libros.id, libros.titulo, personas.id AS idpersona, personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre
				FROM libros, personas, categorias, libros_personas WHERE libros.id='".$_GET['id']."'
				AND libros_personas.id_libro = libros.id 
				AND libros_personas.id_persona = personas.id
				AND libros_personas.id_categoria = categorias.id";
		$res = mysql_query($sql);
		while($libro = mysql_fetch_array($res)){
			if(isset($_SESSION['admin_user'])){
				echo "              <tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Arial;font-size:12px;'><strong>".$libro['nombre'].":</strong> ".$libro['apellido_pat']." ".$libro['apellido_mat']." ".$libro['nombres'].'&nbsp;&nbsp;<a href=rempersona.php?id='.$libro['id'].'&per='.$libro['idpersona'].' onclick="return confirm(\'' . 'Estas Seguro?' . '\');">[eliminar]</a></td></tr>';
			}else {
				echo "              <tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Arial;font-size:12px;'><strong>".$libro['nombre'].":</strong> ".$libro['apellido_pat']." ".$libro['apellido_mat']." ".$libro['nombres']."</td></tr>\n";
			}
		}
		echo "            </table>\n";
		
//		echo "</tr></td></table>"; // fin derecha


}

include ('footer.php');
?>