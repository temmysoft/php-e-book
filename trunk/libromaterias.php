<?php
/*


*/
session_start();

include ('header.php');
include ('functions.php');

echo "<title>$title - Agregar Materias a Libro</title>\n";
$current_page = "libromaterias.php";

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

if(isset($_GET['id'])){
	$libroid = $_GET['id'];
}else {
	$libroid = $_POST['idlibro'];
}

if(isset($_POST['submit']) && $_POST['submit']=='FIN'){
	
	echo "Para ir a la pagina principal <a href='index.php?'>haz click aqui</a>";
	include('footer.php');
	exit;
}

// agregar palabras claves seleccionadas
if(isset($_POST['submit']) && $_POST['idlibro'] && $_POST['submit']=='agregar palclaves'){

	$sql = "DELETE FROM libros_palclave WHERE id_libro='".$_POST['idlibro']."' 
			AND id_palclave IN (SELECT id FROM pal_clave WHERE id_materia='".$_POST['materia']."')";
	$res = mysql_query($sql);
	
	if(!empty($_POST['palabras'])) {
   		$libroid = $_POST['idlibro'];
		$materiaid = $_POST['materia'];
		$sql = "SELECT * FROM libros_materias WHERE id_libro='".$libroid."' AND id_materia='".$materiaid."'";
		$res = mysql_query($sql);
	
	if(mysql_num_rows($res)<1){
		$sql = "INSERT INTO libros_materias (id_libro, id_materia) VALUES ('".$libroid."', '".$materiaid."')";
		//echo $sql;
		mysql_query($sql);
	
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Tahoma;font-size:12px;'>Se agrego la Materia !!!</td></tr>\n";
		echo "            </table>\n";
	}
		$Lista=array_keys($_POST['palabras']);
    	foreach($Lista as $idpalabra) {
    		$sql="INSERT INTO libros_palclave (id_libro, id_palclave) VALUES ('".$_POST['idlibro']."', '".$idpalabra."')";
    		$res = mysql_query($sql);
    	}
	}	
	echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Tahoma;font-size:12px;'>Se agregaron las Palabras !!!</td></tr>\n";
		echo "            </table>\n";
		
		echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td>";
				
echo "</table>";
$_GET['id']=$_POST['idlibro'];
}

if((isset($_GET['id']) && $_GET['id']>=0) || isset($_POST['materia'])){
	
if(isset($_GET['id'])){
	$libroid = $_GET['id'];
}else {
	$libroid = $_POST['idlibro'];
}
ficha_materias($libroid);
/*
$sql = "SELECT libros.titulo, libros.edicion, editoriales.nombre FROM libros, editoriales  WHERE libros.id='".$libroid."'
		AND editoriales.id = libros.editorial";

	$res = mysql_query($sql);
	$libro = mysql_fetch_array($res);
	$sql = "SELECT 
				materias.nombre
			FROM
				materias,
				libros_materias
			WHERE
				libros_materias.id_libro = '".$libro['id']."'
				AND materias.id = libros_materias.id_materia";
		$resmaterias = mysql_query($sql);
		$Materias = "";
		while($materias = mysql_fetch_array($resmaterias)){
			$Materias .= $materias['nombre'].', <BR>';
		}
	
		echo "<BR>";
		echo "            <table align=center class=table_border width=50% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Tahoma;font-size:12px;'>".$libro['titulo']." - ".$libro['edicion']." - ".$libro['nombre']."</td></tr>\n";
		
		echo "<tr><td class=table_rows align=center colspan=3 style='color:black;font-family:Tahoma;font-size:12px;'>".$Materias."</td></tr>";
		
		echo "            </table>\n";
*/
// agregar materias
echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "			<input type='hidden' name='idlibro' value='".$libroid."'>";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group_add.png' />&nbsp;&nbsp;&nbsp;Agregar Materia</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

$sql = "SELECT * FROM materias";
$result = mysql_query($sql);
$i = 0;
/*
echo '<tr><td><select id="materia" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="materia">';
while($materia = mysql_fetch_array($result)){
	echo "<option value='".$materia['id']."'>".$materia['nombre']."</option>\n";
}
echo "</select></td><td><input type='image' name='submit' src='images/icons/delete.png' value='agregar_materia'></td></tr></form></table>";
*/
echo "<tr align=center>";
while ($materia = mysql_fetch_array($result)){
	
	if($i==3){
		echo "</tr><tr align=center>";
		$i = 0;
	}
	echo "<td style='font-family:Tahoma;font-size:13px;'>".$materia['nombre']."&nbsp;<input type='submit' src='images/icons/arrow_right.png' name='materia' value='".$materia['id']."'></td>";
	$i++;
	
}
echo "</tr>";

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
// fin mostrar materias

if(isset($_POST['materia']) && isset($_POST['idlibro'])){
	
	$materiaid = $_POST['materia'];
	$libroid = $_POST['idlibro'];
	
	$sql = "SELECT * FROM pal_clave WHERE id_materia = '".$materiaid."'";
	$res = mysql_query($sql);
	
// mostrar pal claves
echo "            <br />\n";
echo "            <form name='pal_claves' action='$current_page' method='post'>\n";
echo "				<input type='hidden' name='idlibro' value='".$libroid."'>";
echo "				<input type='hidden' name='materia' value='".$materiaid."'>";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/group_add.png' />&nbsp;&nbsp;&nbsp;Agregar palabras Claves</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
$j=0;
while ($palabra = mysql_fetch_array($res)){
	
		$sql = "SELECT * FROM libros_palclave WHERE id_libro=' ".$libroid."' AND id_palclave ='".$palabra['id']."'";
		//echo $sql;
		$rs =mysql_query($sql);
		if($j==3){
			echo "</tr><tr>";
			$j=0;
		}
		if(mysql_num_rows($rs)<=0){
			echo "              <td style='font-family:Tahoma;font-size:13px;'>
				<input type='checkbox' name='palabras[".$palabra['id']."]'>".$palabra['nombre']."</td>\n";
		}else {
			echo "              <td style='font-family:Tahoma;font-size:13px;'>
				<input type='checkbox'name='palabras[".$palabra['id']."]' CHECKED>".$palabra['nombre']."</td>\n";
		}
		$j++;
}

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='agregar palclaves' src='images/buttons/next_button.png'></td>
                  <td><a href='libromaterias.php?id=".$libroid."'><img src='images/buttons/cancel_button.png' border='0'></td>
                  
                  <td align='center'><input type='submit' name='submit' value='FIN' src='images/buttons/next_button.png'></td></tr>
                  
                  </table></form></td></tr>\n";
echo "";
echo "</table></form>";
// fin mostrar pal claves

	
}
	
}else {
	
		/*
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Tahoma;font-size:12px;'>ERROR: Esta pagina debe ser mandada llamar !!!</td></tr>\n";
		echo "            </table>\n";
		*/
		include('footer.php');
		exit;
	
}

include ('footer.php');
?>