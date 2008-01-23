<?php
/*
	ANDRES AMAYA DIAZ
	AGREGAR O MODIFICAR UN LIBRO

*/
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Agregar Libro</title>\n";
$current_page = "agregar.php";

if (!isset($_SESSION['captur_user'])) {

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
// hacer el insert del libro
if(isset($_POST['submit']) && $_POST['submit']=='agregar libro'){
	
	$error = 0;
	$sql = "SELECT * FROM editoriales WHERE id='".$_POST['editorial']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<1){ // problema editorial
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: Editorial Invalida !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	
	}
	
	$sql = "SELECT * FROM paises WHERE id='".$_POST['pais']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<1){ // problema pais
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: Pais Invalido !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	
	}
	
	$sql = "SELECT * FROM ciudades WHERE id='".$_POST['ciudad']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<1){ // problema ciudad
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: Ciudad Invalida !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	
	}
	
	if($_POST['titulo']==''){ // no se agrego titulo
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: Alguno de los valores no es valido !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	}
	
	$sql = "SELECT isbn FROM libros WHERE isbn ='".$_POST['isbn']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>=1){
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: El ISBN Ya Existe !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
		
	}
	
	if($error==0) { // se aceptaron valores
	
		$sql = "INSERT INTO libros (titulo, editorial, pais, ciudad,  edicion, anyo, paginas,
				largo, ancho, isbn, coleccion, observaciones) VALUES (
				'".$_POST['titulo']."',
				'".$_POST['editorial']."',
				'".$_POST['pais']."',
				'".$_POST['ciudad']."',
				'".$_POST['num_edicion']."',
				'".$_POST['anyo_edicion']."',
				'".$_POST['paginas']."',
				'".$_POST['largo']."',
				'".$_POST['ancho']."',
				'".$_POST['isbn']."',
				'".$_POST['coleccion']."',
				'".$_POST['observaciones']."')";
		
		$result = mysql_query($sql);
		
		$sql = "SELECT id FROM libros WHERE titulo='".$_POST['titulo']."' AND editorial ='".$_POST['editorial']."' AND edicion='".$_POST['num_edicion']."'";
		$res = mysql_query($sql);
		$id = mysql_fetch_array($res);
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>El Libro se ha Agregado con Exito !!!</td></tr>\n";
		echo "            </table>\n";
		
		$sql = "INSERT INTO libros_capturista (id_libro, capturista) VALUES (
		'".$id['id']."',
		'".$_SESSION['captur_user']."')";
		$captur = mysql_query($sql);
		echo "<meta http-equiv='refresh' content='0;URL=libropersonas.php?id=".$id['id']."'>\n";
		echo "<br>Si no eres redireccionado<a href=libropersonas.php?id=".$id['id']."> haz click aqui</a>";
		include ('footer.php');
		exit;
		
	}
	
}
// fin insertar libro

// link agregar articulo revista
echo "            <br />\n";
echo "<a href='agregar_rev.php'>Agregar Revista</a>";

echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/brick_add.png' />&nbsp;&nbsp;&nbsp;Agregar Libro</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Titulo:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>
                      <TEXTAREA NAME='titulo' cols=150 rows=6>".$_POST['titulo']."</TEXTAREA>
                      &nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Editorial:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>";

// mostrar autocompletar editoriales

$sql = "SELECT * FROM editoriales ORDER BY nombre";
$result = mysql_query($sql);
echo '<select id="editoriales" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="editorial">';
while($info = mysql_fetch_array($result)){
	echo "<option value='".$info['id']."'>".$info['nombre']."</option>\n";
}
echo "</select>";

// fin autocompletar editoriales

// mostrar autocompletar ciudad                    
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Ciudad:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>";

$sql = "SELECT * FROM ciudades ORDER BY nombre";
$result = mysql_query($sql);
echo '<select id="ciudades" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="ciudad">';
while($info = mysql_fetch_array($result)){
	echo "<option value='".$info['id']."'>".$info['nombre']."</option>\n";
}
echo "</select>";
                     
echo "                   </td></tr>\n";
// fin autocompletar ciudad

// mostrar autocompletar paises                   
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Pais:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>";

$sql = "SELECT * FROM paises ORDER BY nombre";
$result = mysql_query($sql);
echo '<select id="paises" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="pais">';
while($info = mysql_fetch_array($result)){
	echo "<option value='".$info['id']."'>".$info['nombre']."</option>\n";
}
echo "</select>";
                     
echo "                   </td></tr>\n";
// fin autocompletar paises

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Numero de Edicion:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='6' maxlength='6' name='num_edicion' value=".$_POST['num_edicion'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Anyo:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='6' maxlength='6' name='anyo_edicion' value=".$_POST['anyo_edicion'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Paginas:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='6' maxlength='6' name='paginas' value=".$_POST['paginas'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Largo:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='6' maxlength='6' name='largo' value=".$_POST['largo'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Ancho:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='6' maxlength='6' name='ancho' value=".$_POST['ancho'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>isbn:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='15' maxlength='15' name='isbn' value=".$_POST['isbn'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Coleccion:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='50' maxlength='90' name='coleccion' value=".$_POST['coleccion'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Observaciones:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><TEXTAREA 
                      cols='30' rows='6' maxlength='50' name='observaciones'>".$_POST['observaciones']."</TEXTAREA>&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Arial;font-size:10px;'>*&nbsp;necesarios&nbsp;</td></tr>\n";
echo "            </table>\n";
//echo "            <script language=\"javascript\">cp.writeDiv()</script>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='agregar libro' src='images/buttons/next_button.png'></td>
                  <td><a href='index.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table>";

include ('footer.php');

?>