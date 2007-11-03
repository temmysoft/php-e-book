<?php
/*


*/
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Agregar Articulo Revista</title>\n";
$current_page = "agregar_rev.php";

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
// hacer el insert de la revista
if(isset($_POST['submit']) && $_POST['submit']=='agregar revista'){
	
	$error = 0;
	$sql = "SELECT * FROM editoriales WHERE id='".$_POST['editorial']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<1){ // problema editorial
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;Arial:Arial;font-size:12px;'>ERROR: Editorial Invalida !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	
	}
	
	$sql = "SELECT * FROM paises WHERE id='".$_POST['pais']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<1){ // problema pais
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;Arial:Arial;font-size:12px;'>ERROR: Pais Invalido !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	
	}
	
	$sql = "SELECT * FROM ciudades WHERE id='".$_POST['ciudad']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<1){ // problema ciudad
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;Arial:Arial;font-size:12px;'>ERROR: Ciudad Invalida !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	
	}
	
	$sql = "SELECT * FROM revista WHERE id='".$_POST['revista']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<1){ // problema revista
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;Arial:Arial;font-size:12px;'>ERROR: Revista Invalida !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	
	}
	
	if($_POST['titulo']==''){ // no se agrego titulo
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;Arial:Arial;font-size:12px;'>ERROR: Alguno de los valores no es valido !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	}
	
	if($error==0) { // se aceptaron valores
	
		$sql = "INSERT INTO libros (titulo, editorial, pais, ciudad,  edicion, anyo, paginas,
				volumen, numero, epoca,
				largo, ancho, isbn, coleccion, observaciones,tipo) VALUES (
				'".$_POST['titulo']."',
				'".$_POST['editorial']."',
				'".$_POST['pais']."',
				'".$_POST['ciudad']."',
				'0',
				'".$_POST['anyo_edicion']."',
				'".$_POST['paginas']."',
				'".$_POST['volumen']."',
				'".$_POST['numero']."',
				'".$_POST['epoca']."',
				'".$_POST['largo']."',
				'".$_POST['ancho']."',
				'".$_POST['isbn']."',
				'".$_POST['coleccion']."',
				'".$_POST['observaciones']."',
				'R')";
		
		$result = mysql_query($sql);
		
		$sql = "SELECT id FROM libros WHERE titulo='".$_POST['titulo']."' AND editorial ='".$_POST['editorial']."' AND edicion='0' AND tipo='R'";
		$res = mysql_query($sql);
		$id = mysql_fetch_array($res);
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;Arial:Arial;font-size:12px;'>La Revista se ha Agregado con Exito !!!</td></tr>\n";
		echo "            </table>\n";
		
		$sql = "INSERT INTO libros_capturista (id_libro, capturista) VALUES (
		'".$id['id']."',
		'".$_SESSION['captur_user']."')";
		$captur = mysql_query($sql);
		
		$sql = "INSERT INTO revista_artic (id_revista, id_articulo) VALUES (
		'".$_POST['revista']."',
		'".$id['id']."')";
		$rev = mysql_query($sql);
		
		echo "<meta http-equiv='refresh' content='0;URL=libropersonas.php?id=".$id['id'].">\n";
		echo "<br>Si no eres redireccionado<a href=libropersonas.php?id=".$id['id']."> haz click aqui</a>";
		include ('footer.php');
		exit;
		
	}
	
}
// fin insertar revista
if(!isset($_POST['titulo'])){
$sql = "SELECT libros.*, revista_artic.id_revista FROM libros, revista_artic WHERE libros.tipo = 'R' AND revista_artic.id_articulo = libros.id ORDER BY id DESC LIMIT 1";
$res = mysql_query($sql);
$lastrev = mysql_fetch_array($res);

//$_POST['titulo']=$lastrev['titulo'];
$_POST['editorial']=$lastrev['editorial'];
$_POST['ciudad']=$lastrev['ciudad'];
$_POST['pais']=$lastrev['pais'];
$_POST['revista']=$lastrev['id_revista'];

$_POST['anyo_edicion']=$lastrev['anyo'];
$_POST['paginas']=$lastrev['paginas'];
$_POST['isbn']=$lastrev['isbn'];
$_POST['coleccion']=$lastrev['coleccion'];
$_POST['volumen']=$lastrev['volumen'];
$_POST['numero']=$lastrev['numero'];
$_POST['epoca']=$lastrev['epoca'];
$_POST['observaciones']=$lastrev['observaciones'];
}

echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/brick_add.png' />&nbsp;&nbsp;&nbsp;Agregar Articulo Revista</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Titulo:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><INPUT TYPE='text' 
                      size='100' maxlength='500' name='titulo' value='".$_POST['titulo']."'>&nbsp;*</td></tr>\n";


echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Editorial:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'>";

// mostrar autocompletar editoriales

$sql = "SELECT * FROM editoriales ORDER BY nombre";
$result = mysql_query($sql);
echo '<select id="editoriales" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="editorial">';
while($info = mysql_fetch_array($result)){
	if($info['id']==$_POST['editorial']){
		echo "<option selected value='".$info['id']."'>".$info['nombre']."</option>\n";
	}else {
		echo "<option value='".$info['id']."'>".$info['nombre']."</option>\n";
	}
}
echo "</select>";

// fin autocompletar editoriales

// mostrar autocompletar ciudad                    
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Ciudad:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'>";

$sql = "SELECT * FROM ciudades ORDER BY nombre";
$result = mysql_query($sql);
echo '<select id="ciudades" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="ciudad">';
while($info = mysql_fetch_array($result)){
	if($info['id']==$_POST['ciudad']){
		echo "<option selected value='".$info['id']."'>".$info['nombre']."</option>\n";
	}else {
		echo "<option value='".$info['id']."'>".$info['nombre']."</option>\n";
	}
}
echo "</select>";
                     
echo "                   </td></tr>\n";
// fin autocompletar ciudad

// mostrar autocompletar paises                   
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Pais:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'>";

$sql = "SELECT * FROM paises ORDER BY nombre";
$result = mysql_query($sql);
echo '<select id="paises" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="pais">';
while($info = mysql_fetch_array($result)){
	if($info['id']==$_POST['pais']){
		echo "<option selected value='".$info['id']."'>".$info['nombre']."</option>\n";
	}else {
		echo "<option value='".$info['id']."'>".$info['nombre']."</option>\n";
	}
}
echo "</select>";
                     
echo "                   </td></tr>\n";
// fin autocompletar paises


// mostrar autocompletar revistas                   
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Revista:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'>";

$sql = "SELECT * FROM revista ORDER BY nombre";
$result = mysql_query($sql);
echo '<select id="revistas" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="revista">';
while($info = mysql_fetch_array($result)){
	if($info['id']==$_POST['revista']){
		echo "<option selected value='".$info['id']."'>".$info['nombre']."</option>\n";
	}else {
		echo "<option value='".$info['id']."'>".$info['nombre']."</option>\n";
	}
	
}
echo "</select>";
                     
echo "                   </td></tr>\n";
// fin autocompletar revistas

/*
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Numero de Edicion:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='6' maxlength='6' name='num_edicion' value=".$_POST['num_edicion'].">&nbsp;</td></tr>\n";
*/

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Anyo:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='6' maxlength='6' name='anyo_edicion' value=".$_POST['anyo_edicion'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Paginas:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='6' maxlength='6' name='paginas' value=".$_POST['paginas'].">&nbsp;</td></tr>\n";
/*
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Largo:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='6' maxlength='6' name='largo' value=".$_POST['largo'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Ancho:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='6' maxlength='6' name='ancho' value=".$_POST['ancho'].">&nbsp;</td></tr>\n";
*/
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>ISSN:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='15' maxlength='15' name='isbn' value=".$_POST['isbn'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Coleccion:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='50' maxlength='90' name='coleccion' value=".$_POST['coleccion'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Volumen:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='50' maxlength='90' name='volumen' value=".$_POST['volumen'].">&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Numero:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='50' maxlength='90' name='numero' value=".$_POST['numero'].">&nbsp;</td></tr>\n";


echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Epoca:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='50' maxlength='90' name='epoca' value=".$_POST['epoca'].">&nbsp;</td></tr>\n";


echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Observaciones:</td><td colspan=2 width=80%
                      style='color:red;Arial:Arial;font-size:10px;padding-left:20px;'><TEXTAREA 
                      cols='30' rows='6' maxlength='50' name='observaciones'>".$_POST['observaciones']."</TEXTAREA>&nbsp;</td></tr>\n";

echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;Arial:Arial;font-size:10px;'>*&nbsp;necesarios&nbsp;</td></tr>\n";
echo "            </table>\n";
//echo "            <script language=\"javascript\">cp.writeDiv()</script>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='agregar revista' src='images/buttons/next_button.png'></td>
                  <td><a href='index.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table>";

include ('footer.php');

?>