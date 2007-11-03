<?php
/*
	ANDRES AMAYA DIAZ

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
is_online();
$_POST['id_per']= -1;

// verificar las busquedas por id
if(isset($_POST['FromID']) && !isset($_POST['ToID'])){
	$_POST['ToID'] = $_POST['FromID'];
}

// se envio una busqueda desde fuera
if(!empty($_GET['type']) && !empty($_GET['bus'])){
	if($_GET['type']=='per'){// se busca por persona
	
		$_POST['materia']='Todas';
		$_POST['autor']=$_GET['bus'];
		$_POST['submit']='buscar';
	}else if($_GET['type']=='mat'){ // busqueda por materia
		
		$_POST['materia']=$_GET['bus'];
		$_POST['submit']='buscar';
		
	}else { // busqueda por palabra clave
	
		$_POST['palabras']=$_GET['bus'];
		$_POST['submit']='buscar';
	
	}
	
}

if(isset($_POST['page'])){
	$_POST['submit']='buscar';
}

// se envio una busqueda

if(isset($_POST['submit']) && $_POST['submit']=='buscar'){
	
	$error = 0;
	
	if($_POST['materia']=='Todas'){
		//$_POST['materia'] = "AND libros_materias.id_materia LIKE '%%'";
		//$_POST['palabras']="AND libros_palclave.id_palclave LIKE '%%'";
		$sql = "SELECT libros.id, libros.tipo
					FROM libros,
						libros_personas,
						personas,
						categorias
					WHERE libros.titulo LIKE '%".$_POST['titulo']."%'					
					AND  concat(personas.apellido_pat,' ',personas.apellido_mat) LIKE '%".$_POST['autor']."%'
					AND libros.id = libros_personas.id_libro
					AND categorias.id = libros_personas.id_categoria
					AND categorias.nombre NOT LIKE '%DONADOR%'
					AND personas.id = libros_personas.id_persona";
	}else {
		//$_POST['materia'] = "AND libros_materias.id_materia = '".$_POST['materia']."'";		
		if($_POST['palabras']==''){
			$sql = "SELECT libros.id, libros.tipo
					FROM libros,
						libros_materias,
						libros_personas,
						personas,
						categorias
					WHERE libros.titulo LIKE '%".$_POST['titulo']."%'					
					AND libros_materias.id_materia = ".$_POST['materia']."
					AND libros.id = libros_materias.id_libro
					AND  concat(personas.apellido_pat,' ',personas.apellido_mat) LIKE '%".$_POST['autor']."%'
					AND libros.id = libros_personas.id_libro
					AND categorias.id = libros_personas.id_categoria
					AND categorias.nombre NOT LIKE '%DONADOR%'
					AND personas.id = libros_personas.id_persona";
		}else {
			$sql = "SELECT libros.id, libros.tipo
					FROM libros,
						libros_palclave,
						libros_personas,
						personas,
						categorias
					WHERE libros.titulo LIKE '%".$_POST['titulo']."%'					
					AND libros_palclave.id_palclave = ".$_POST['palabras']."
					AND libros.id = libros_palclave.id_libro
					AND  concat(personas.apellido_pat,' ',personas.apellido_mat) LIKE '%".$_POST['autor']."%'
					AND libros.id = libros_personas.id_libro
					AND categorias.id = libros_personas.id_categoria
					AND categorias.nombre NOT LIKE '%DONADOR%'
					AND personas.id = libros_personas.id_persona";
			//$_POST['palabras']="AND libros_palclave.id_palclave = '".$_POST['palabras']."'";
		}		
	}
	//echo $sql;
	//$result = mysql_query($sql);	
	// filtro 26 sept 2007
			if(isset($_POST['libros']) && $_POST['revistas']){
				
			}elseif(isset($_POST['libros'])){
				$sql .= " AND libros.tipo ='L'";
			}else if(isset($_POST['revistas'])){
				$sql .= " AND libros.tipo ='R'";
			}
	
			if(isset($_POST['FromID']) && strlen($_POST['FromID'])>0){
				$sql .= " AND libros.id >= ".$_POST['FromID']." 
							AND libros.id <= ".$_POST['ToID']." 
							GROUP BY libros.id
							ORDER BY libros.id"; 
			}else {
				$sql .= " GROUP BY libros.id
							ORDER BY libros.id";
			}
			
			//echo $sql;
			
			if(isset($_POST['page']))
			{
    			$pageNum = $_POST['page'];
			}
			// counting the offset
			$offset = ($pageNum - 1) * 20;
						
			if(isset($_POST['res'])){
				$sql = stripslashes($_POST['res']);	
			}
			
			$sql2 = $sql;
			//echo "SQL: ".$sql." <br>SQL2: ".$sql2;
			$sql .= " LIMIT ".$offset.", 20";
			//echo "SLQ: ".$sql."<BR>";
			//echo "SQL2: ".$sql2."<BR>";
			$result = mysql_query($sql);		
			$numrows = mysql_num_rows(mysql_query($sql2));

			// how many pages we have when using paging?
			$maxPage = ceil($numrows/20);

			// print the link to access each page
			$self = $_SERVER['PHP_SELF'];
			$nav  = '';
			echo "<FORM METHOD=POST>";
			echo "<CENTER><H4>Libros encontrados: ".$numrows."</H4>";
			echo "<SELECT NAME='page'>";
			for($page = 1; $page <= $maxPage; $page++)
			{
    			if($page== $pageNum){  
					echo "<OPTION SELECTED VALUE=".$page.">".$page."</OPTION>";
    			}else {
		    		echo "<OPTION VALUE=".$page.">".$page."</OPTION>";
    			}
			}
	echo '<INPUT TYPE=hidden NAME=res VALUE="'.$sql2.'">';
	echo "<INPUT TYPE='submit' VALUE='Ir'>";
	echo "</SELECT></CENTER></FORM>";
			
			if(mysql_num_rows($result)<=0){ // error no hay resultados
				
				echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
				echo "              <tr><td class=table_rows align=center colspan=3 style='color:blue;font-family:Arial;font-size:12px;'>No se encontro ningun libro con esas caracteristicas</td></tr>\n";
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
							<a href='viewer/upload.php?id=".$libro['id']."' target='new'>Ver libro</a><BR> 
							<a href='milibrero.php?librero=".$libro['id']."' target='new'>Agregar a Mi Librero</a><BR>
							<a href='ficha.php?id=".$libro['id']."' target='new'>Ficha Completa</a><BR>
							<INPUT TYPE=checkbox NAME='ids[]' VALUE='".$libro['id']."'>Enviar via Mail";
							echo "</TD><TD width=70%>";
							if($libro['tipo']=='L'){
								echo ficha_busqueda($libro['id'],$_POST['autor']);
							}else {
								echo ficha_busqueda2($libro['id'],$_POST['autor']);
							}
							
							echo "</TD></TR>";
				}else if(isset($_SESSION['admin_user'])){ // resultados si es administrador
						
						if(isset($_POST['print'])){
							
						}else {
						echo "<td width=30% class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
						echo "
						<a href='viewer/upload.php?id=".$libro['id']."' target='new'>Ver libro</a><BR>
						<a href='PDF/".$libro['id'].".pdf'>Descargar PDF</a><BR>
						<a href='editar.php?id=".$libro['id']."'>Editar Libro</a><BR>
						<a href='ficha.php?id=".$libro['id']."' target='new'>Ficha Completa</a><BR>
							<INPUT TYPE=checkbox NAME='ids[]' VALUE='".$libro['id']."'>Enviar via Mail";
							echo "</TD><TD width=70%>";
							if($libro['tipo']=='L'){
								echo ficha_busqueda($libro['id'],$_POST['autor']);
							}else {
								echo ficha_busqueda2($libro['id'],$_POST['autor']);
							}
						
							echo "</TD></TR>";
						}
				}else {
					echo "<td width=30% class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
					echo "
					<a href='viewer/upload.php?id=".$libro['id']."' target='new'>Ver libro</a><BR>
					<a href='ficha.php?id=".$libro['id']."' target='new'>Ficha Completa</a><BR><br>
					<INPUT TYPE=checkbox NAME='ids[]' VALUE='".$libro['id']."'>Enviar via Mail";
					echo "</TD><TD width=70%>";
					if($libro['tipo']=='L'){
								echo ficha_busqueda($libro['id'],$_POST['autor']);
							}else {
								echo ficha_busqueda2($libro['id'],$_POST['autor']);
							}
					
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

// busqueda por id solo para admin ???
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>ID:</td><td colspan=2 width=80%
                      style='color:black;font-family:Arial;font-size:10px;padding-left:20px;'>
                      &nbsp;Desde:<input type='text' size='7' maxlength='7' name='FromID'>&nbsp;
                      &nbsp;Hasta:<input type='text' size='7' maxlength='7' name='ToID'>&nbsp;</td>
                      </td></tr>\n";

// filtro 
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>
					&nbsp;Libros:<input type='checkbox' size='7' maxlength='7' name='libros'>&nbsp;
					</td><td colspan=2 width=80%
                     style='color:black;font-family:Arial;font-size:10px;padding-left:20px;'>
                     &nbsp;Revistas:<input type='checkbox' size='7' maxlength='7' name='revistas'>&nbsp;</td>
                     </td></tr>\n";
// fin filtro

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
?>
