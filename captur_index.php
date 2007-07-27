<?php

//session_start();
//include ('header.php');
//include ('leftmain.php');

//echo "<title>BIBLIOTECA FOCIM</title>\n";
$current_page = "captur_index.php";

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

// principal capturista
	echo "<BR>";
	$row_count = 0;

	echo "            <table class=misc_items width=100% border=0 cellpadding=2 cellspacing=0>\n";
	echo "              <tr class=notprint>\n";
    
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          ID</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Titulo</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Autor(es)</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Materias</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Personas</td>\n";
	
	echo "</tr>";
	if(isset($_GET['page']))
	{
    	$pageNum = $_GET['page'];
	}
	// counting the offset
	$offset = ($pageNum - 1) * $rowsPerPage;
	$SQL = "SELECT id, titulo FROM libros ORDER BY id DESC LIMIT ".$offset.", ".$rowsPerPage."";
	$result = mysql_query($SQL);
	
	// how many rows we have in database
$query   = "SELECT COUNT(id) AS numrows FROM libros";
$result2  = mysql_query($query) or die('Error, query failed');
$row     = mysql_fetch_array($result2);
$numrows = $row['numrows'];
// how many pages we have when using paging?
	$maxPage = ceil($numrows/$rowsPerPage);

	// print the link to access each page
	$self = $_SERVER['PHP_SELF'];
	$nav  = '';
	echo "<FORM METHOD=GET>";
	echo "<CENTER><SELECT NAME='page'>";
	for($page = 1; $page <= $maxPage; $page++)
	{
    	if($page== $pageNum){  
			echo "<OPTION SELECTED VALUE=".$page.">".$page."</OPTION>";
    	}else {
    		echo "<OPTION VALUE=".$page.">".$page."</OPTION>";
    	}
	}
	echo "<INPUT TYPE='submit' VALUE='Ir'>";
	echo "</SELECT></CENTER></FORM>";
	
	while($libro = mysql_fetch_array($result)){
	
		// begin alternating row colors //
		$row_color = ($row_count % 2) ? $color1 : $color2;
		 echo "<tr>";
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$libro["id"]."</td>\n";
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$libro["titulo"]."</td>\n";
		 // autores
		 $sql = "SELECT personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego 
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$libro['id']."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre LIKE '%Autor%'
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
			$Personas .= $demas['catego'].': '.$demas['apellido_pat'].' '.$demas['apellido_mat'].' '.$demas['nombres'].', <BR>';
		}
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$Personas."</td>\n";
		 // fin demas personas
		 // add 1 to te row count
		$row_count++;
	}
	echo "</TR></table>";
// fin principal del capturista
include ('footer.php');
?>
