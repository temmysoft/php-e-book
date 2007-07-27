<?php
/*


*/
session_start();
include ('header.php');
include ('scripts.php');
include ('functions.php');
//include ('leftmain.php');

echo "<title>$title - Busqueda</title>\n";
$current_page = "buscar.php";

if (!isset($_SESSION['lector_user']) AND !isset($_SESSION['admin_user']) AND !isset($_SESSION['captur_user'])) {

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>Login BIBLIOTECA FOCIM</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=200 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>No estas registado<br>o<br>No tienes permiso de acceder a esta pagina.</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='login.php'><u>aqui</u></a> para logearse.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

// se envio una busqueda

if(isset($_POST['submit']) && $_POST['submit']=='buscar'){
	
	$error = 0;
	
	if($_POST['materia']=='Todas'){
		//$_POST['materia'] = "AND libros_materias.id_materia LIKE '%%'";
		//$_POST['palabras']="AND libros_palclave.id_palclave LIKE '%%'";
		$sql = "SELECT libros.id
					FROM libros,
						libros_personas,
						personas
					WHERE libros.titulo LIKE '%".$_POST['titulo']."%'					
					AND  concat(personas.nombres,personas.apellido_pat,personas.apellido_mat) LIKE '%".$_POST['autor']."%'
					AND libros.id = libros_personas.id_libro
					AND personas.id = libros_personas.id_persona
					GROUP BY libros.id";
	}else {
		//$_POST['materia'] = "AND libros_materias.id_materia = '".$_POST['materia']."'";		
		if($_POST['palabras']==''){
			$sql = "SELECT libros.id
					FROM libros,
						libros_materias,
						libros_personas,
						personas
					WHERE libros.titulo LIKE '%".$_POST['titulo']."%'					
					AND libros_materias.id_materia = ".$_POST['materia']."
					AND libros.id = libros_materias.id_libro
					AND  concat(personas.nombres,personas.apellido_pat,personas.apellido_mat) LIKE '%".$_POST['autor']."%'
					AND libros.id = libros_personas.id_libro
					AND personas.id = libros_personas.id_persona
					GROUP BY libros.id";
		}else {
			$sql = "SELECT libros.id
					FROM libros,
						libros_palclave,
						libros_personas,
						personas
					WHERE libros.titulo LIKE '%".$_POST['titulo']."%'					
					AND libros_palclave.id_palclave = ".$_POST['palabras']."
					AND libros.id = libros_palclave.id_libro
					AND  concat(personas.nombres,personas.apellido_pat,personas.apellido_mat) LIKE '%".$_POST['autor']."%'
					AND libros.id = libros_personas.id_libro
					AND personas.id = libros_personas.id_persona
					GROUP BY libros.id";
			//$_POST['palabras']="AND libros_palclave.id_palclave = '".$_POST['palabras']."'";
		}		
	}
			//echo $sql;
			$result = mysql_query($sql);
			
			if(mysql_num_rows($result)<=0){ // error no hay resultados
				
				echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
				echo "              <tr><td class=table_rows align=center colspan=3 style='color:blue;font-family:Tahoma;font-size:12px;'>No se encontro ningun libro con esas caracteristicas</td></tr>\n";
				echo "            </table>\n";
				$error = 1;
			} else { // si hay resultados
				echo "<BR><FORM ACTION='mail.php' METHOD=POST>";
				echo "<TABLE>";
				echo "<td><tr><INPUT TYPE='submit' NAME='enviar' value='Enviar via Mail'></td></tr>";
				while ($libro = mysql_fetch_array($result)){
						echo "<TR><TD>";
						// Imprimir resultado si es lector
						if(isset($_SESSION['lector_user'])){
							echo "<td width=30% class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
							echo "
							<a href='viewer/upload.php?id=".$libro['id']."'>Ver libro</a><BR> 
							<a href='milibrero.php?librero=".$libro['id']."' target='new'>Agregar a Mi Librero</a><BR>
							<a href='ficha.php?id=".$libro['id']."' target='new'>Ficha Completa</a><BR>
							<INPUT TYPE=checkbox NAME='ids[]' VALUE='".$libro['id']."'>Enviar via Mail";
							echo "</TD><TD width=70%>";
							echo ficha_busqueda($libro['id'],$_POST['autor']);
							
							echo "</TD></TR>";
				}else if(isset($_SESSION['admin_user'])){ // resultados si es administrador
						
						if(isset($_POST['print'])){
							
						}else {
						echo "<td width=30% class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
						echo "
						<a href='viewer/upload.php?id=".$libro['id']."'>Ver libro</a><BR>
						<a href='PDF/".$libro['id'].".pdf'>Descargar PDF</a><BR>
						<a href='editar.php?id=".$libro['id']."'>Editar Libro</a><BR>
						<a href='ficha.php?id=".$libro['id']."' target='new'>Ficha Completa</a><BR>
							<INPUT TYPE=checkbox NAME='ids[]' VALUE='".$libro['id']."'>Enviar via Mail";
							echo "</TD><TD width=70%>";
							echo ficha_busqueda($libro['id'],$_POST['autor']);
						
							echo "</TD></TR>";
						}
				}else {
					echo "<td width=30% class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
					echo "
					<a href='viewer/upload.php?id=".$libro['id']."'>Ver libro</a><BR>
					<a href='ficha.php?id=".$libro['id']."' target='new'>Ficha Completa</a><BR><br>
					<INPUT TYPE=checkbox NAME='ids[]' VALUE='".$libro['id']."'>Enviar via Mail";
					echo "</TD><TD width=70%>";
					echo ficha_busqueda($libro['id'],$_POST['autor']);
					
					echo "</TD></TR>";
				}
			}
				echo "</FORM></TABLE>";
			}
	
}

// fin busqueda

// formulario busqueda
echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/magnifier.png' />&nbsp;&nbsp;&nbsp;Buscar</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Titulo:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='titulo'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Persona:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='autor'>&nbsp;*</td></tr>\n";
$sql = "SELECT * FROM materias";
$res = mysql_query($sql);
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Materia:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>";
echo "<SELECT NAME='materia' onchange='palabras_names();'>";
echo "<OPTION VALUE='Todas'>Todas</OPTION>";
while ($mat = mysql_fetch_array($res)){
echo "                <OPTION VALUE='".$mat['id']."'>".$mat['nombre']."</OPTION>\n";
}
//echo "<input type='submit' name='submit' value='ver_palclave' src='images/buttons/done_button.png'></td></tr></SELECT>";
echo "</td></tr></SELECT>";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Palabras Clave:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>";
echo "<SELECT NAME='palabras'>";
echo "</td></tr></SELECT>";

echo "<tr><td colspan=3 align=center width=80% style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
* No usar acentos en las busquedas
</td></tr>";

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='buscar' src='images/buttons/done_button.png'></td>
                  <td><a href='buscar.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table>";
// fin buqueda

include ('footer.php');
?>
