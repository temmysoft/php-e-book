<?php
/*


*/
session_start();

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
// se envio una busqueda

if(isset($_POST['submit']) && $_POST['submit']=='buscar'){

include ('config.inc.php');
include ('scripts.php');
include ('functions.php');

echo "<title>$title - Reportes</title>\n";
$current_page = "reports.php";
echo "<link rel='stylesheet' type='text/css' media='screen' href='css/default.css' />\n";

	$error = 0;
	
	if($_POST['materia']=='Todas'){
		//$_POST['materia'] = "AND libros_materias.id_materia LIKE '%%'";
		//$_POST['palabras']="AND libros_palclave.id_palclave LIKE '%%'";
		$sql = "SELECT libros.id, libros.titulo
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
			$sql = "SELECT libros.id, libros.titulo
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
			$sql = "SELECT libros.id, libros.titulo
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
							echo "<BR>";
	$row_count = 0;

	echo "            <table class=misc_items width=100% border=0 cellpadding=2 cellspacing=0>\n";
	echo "              <tr class=notprint>\n";
    
	echo "                <td nowrap width=10% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          ID</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Titulo</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Autores</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Materias</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Personas</td>\n";

	echo "</tr>";
			if(mysql_num_rows($result)<=0){ // error no hay resultados
				
				echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
				echo "              <tr><td class=table_rows align=center colspan=3 style='color:blue;font-family:Arial;font-size:12px;'>No se encontro ningun libro con esas caracteristicas</td></tr>\n";
				echo "            </table>\n";
				$error = 1;
			} else { // si hay resultados
				
				while($libro = mysql_fetch_array($result)){
	
		// begin alternating row colors //
		$row_color = ($row_count % 2) ? $color1 : $color2;
		 echo "<tr>";
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$libro["id"]."</td>\n";
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$libro["titulo"]."</td>\n";
		 // autores
		 // AND categorias.nombre LIKE '%Autor%'
		 $sql = "SELECT personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego 
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$libro['id']."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			
			ORDER BY categorias.nombre";
		 $AutRes = mysql_query($sql);
		 $Autores = "";
		 while($aut=mysql_fetch_array($AutRes)){
		 	$Autores .= $aut['apellido_pat'].' '.$aut['apellido_mat'].', '.$aut['nombres'].'<BR>';
		 }
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$Autores."</td>";
		 // fin autores
		 // materias
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
		echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$Materias."</td>\n";
		 // fin materias
		 // demas personas
		 $sql = "SELECT personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego 
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$libro['id']."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre NOT LIKE '%Autor%'
			ORDER BY categorias.nombre";
		$resper = mysql_query($sql);
		$Personas = "";
		while($demas = mysql_fetch_array($resper)){
			$Personas .= $demas['catego'].': '.$demas['apellido_pat'].' '.$demas['apellido_mat'].', '.$demas['nombres'].' <BR>';
		}
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$Personas."</td>\n";
		 // fin demas personas
		$row_count++;
	}
	echo "</table>";
				
	}
	
}


if(!isset($_POST['submit'])){
	include ('header.php');
include ('scripts.php');
include ('functions.php');
//include ('leftmain.php');

echo "<title>$title - Reportes</title>\n";
$current_page = "reports.php";
	// formulario busqueda
echo "            <br />\n";
echo "            <form name='libro' action='$current_page' method='post'>\n";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/magnifier.png' />&nbsp;&nbsp;&nbsp;Buscar</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Titulo:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='titulo'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Persona:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='autor'>&nbsp;*</td></tr>\n";
$sql = "SELECT * FROM materias";
$res = mysql_query($sql);
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Materia:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>";
echo "<SELECT NAME='materia' onchange='palabras_names();'>";
echo "<OPTION VALUE='Todas'>Todas</OPTION>";
while ($mat = mysql_fetch_array($res)){
echo "                <OPTION VALUE='".$mat['id']."'>".$mat['nombre']."</OPTION>\n";
}
//echo "<input type='submit' name='submit' value='ver_palclave' src='images/buttons/done_button.png'></td></tr></SELECT>";
echo "</td></tr></SELECT>";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Palabras Clave:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>";
echo "<SELECT NAME='palabras'>";
echo "</td></tr></SELECT>";

echo "<tr><td colspan=3 align=center width=80% style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>
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
	
}

?>