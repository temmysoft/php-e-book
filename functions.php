<?php
/*

	FUNCION QUE IMPRIME LOS DATOS DE UN LIBRO

*/


function print_libro($id){
	
	$sql = "SELECT libros.titulo,
			libros.id,
			libros.anyo,
			libros.edicion,
			libros.isbn,
			libros.coleccion,
			editoriales.nombre AS edito,
			ciudades.nombre AS ciud,
			paises.nombre AS pais 
			FROM libros,
				editoriales,
				ciudades,
				paises 
			WHERE libros.id='".$id."'
			AND editoriales.id=libros.editorial
			AND ciudades.id=libros.ciudad
			AND paises.id=libros.pais";
	
	$reslib = mysql_query($sql);
	$libro = mysql_fetch_array($reslib);
	mysql_free_result($reslib);
	echo "<BR><BR>";
	// obtener personas
	$sql = "SELECT personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego 
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			ORDER BY categorias.nombre";
	$resper = mysql_query($sql);
	
	echo "            <table align=left class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
	echo "<TR>";
	while($personas = mysql_fetch_array($resper)){
		
		echo "              <td class=table_rows align=left style='color:blue;font-family:Arial;font-size:12px;'>
							<b>".$personas['catego'].'</b>: '.$personas['apellido_pat'].' '.$personas['apellido_mat'].', '.$personas['nombres']."
		</td>\n";
		
	}
	echo "</TR>";
	mysql_free_result($resper);
	// fin de personas
	
	// mostrar datos del libro
	echo "              <tr><td class=table_rows align=left colspan=4 style='color:black;font-family:Arial;font-size:12px;'>
							".$libro['anyo'].' - <b>'.$libro['titulo']."</b>
		</td></tr>\n";
	echo "              <tr><td class=table_rows align=left colspan=4 style='color:black;font-family:Arial;font-size:12px;'>
							".$libro['edicion'].' - '.$libro['ciud'].' '.$libro['pais'].': '.$libro['edito']."
		</td></tr>\n";
	// finaliza datos del libro
	
	// inicia imprimir materias y palabras clave
	
	
	
	// fin materias y palabras clave
	
	// finalizar la tabla
	echo "</table>\n";
}

// FICHA RESUMEN
// Título:
// Autores (separados por punto y coma)
// (parenteis con anyo libro)(punto)titulo(punto)ciudad(coma)pais(dos puntos)editorial

function ficha_resumen($id){
	
	$sql = "SELECT libros.titulo,
			libros.id,
			libros.anyo,
			libros.edicion,
			editoriales.nombre AS editorial,
			ciudades.nombre AS ciudad,
			paises.nombre AS pais 
			FROM libros,
				editoriales,
				ciudades,
				paises 
			WHERE libros.id='".$id."'
			AND editoriales.id=libros.editorial
			AND ciudades.id=libros.ciudad
			AND paises.id=libros.pais";
	
	$reslib = mysql_query($sql);
	$libro = mysql_fetch_array($reslib);
	mysql_free_result($reslib);
	
	$sql = "SELECT personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego 
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre LIKE '%Autor%'
			ORDER BY categorias.nombre";
	$resper = mysql_query($sql);
	echo "<table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
	echo "<TR>";
	echo "         <td class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		
		echo $personas['apellido_pat'].$materno.', '.$personas['nombres'].'; ';
		
		
	}	
	
	echo '('.$libro['anyo'].'). ';
	echo $libro['titulo'].'. '.$libro['ciudad'].', '.$libro['pais'].': '.$libro['editorial'];
	echo "</td>\n";
	echo "</TR>";
	echo "</TABLE><BR>";
}

function ficha_completa($id){
		
	$sql = "SELECT tipo FROM libros WHERE id= '".$id."'";
	$res = mysql_query($sql);
	$tipo = mysql_fetch_array($res);
	
	if($tipo['tipo']=='L'){
		mysql_free_result($res);
		ficha_comp_libro($id);
	}else{
		mysql_free_result($res);
		ficha_comp_rev($id);
	}
	
}

function ficha_comp_libro($id){
	
		$sql = "SELECT libros.titulo,
				libros.edicion,
				libros.observaciones,
				libros.anyo,
				libros.paginas,
				libros.largo,
				libros.ancho,
				libros.isbn,
				libros.coleccion,
			editoriales.nombre AS editorial,
			ciudades.nombre AS ciudad,
			paises.nombre AS pais 
			FROM libros,
				editoriales,
				ciudades,
				paises 
			WHERE libros.id='".$id."'
			AND editoriales.id=libros.editorial
			AND ciudades.id=libros.ciudad
			AND paises.id=libros.pais";
	
	$reslib = mysql_query($sql);
	$libro2 = mysql_fetch_array($reslib);
	mysql_free_result($reslib);
	
	$sql = "SELECT personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego 
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			ORDER BY categorias.nombre";
	$resper = mysql_query($sql);
	
	echo "<table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
	echo "<TR>";
	//echo "         <td class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
//echo "<TD>";
	echo "<TD><B>Titulo:</B></TD><TD>".$libro2['titulo']."<BR>";
	echo "</TD><TR>";
	
	$oldcat = '';
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		
		//echo $personas['apellido_pat'].$materno.', '.$personas['nombres'].'; ';
		echo "<TR><TD><B>".$personas['catego'].":</B></TD><TD><a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'</a><br><TD></TR>';
		if($oldcat != $personas['nombre'])echo "<BR>";
		$oldcat = $personas['nombre'];
		
	}	
	
	echo "<TR><TD><B>Editorial:</B></TD><TD>".$libro2['editorial']."<TD></TR>";
	echo "<TR><TD><B>Ciudad:</B></TD><TD>".$libro2['ciudad']."</TR>";
	echo "<TR><TD><B>Pais:</B></TD><TD>".$libro2['pais']."</TR>";
	echo "<TR><TD><B>Anyo:</B></TD><TD>".$libro2['anyo']."</TR>";
	// fin personas
	// materias y palabras clave

	$sql = "SELECT 
				materias.nombre,
				materias.id
			FROM
				materias,
				libros_materias
			WHERE
				libros_materias.id_libro = '".$id."'
				AND materias.id = libros_materias.id_materia";
	$resmaterias = mysql_query($sql);
	
	while($materias = mysql_fetch_array($resmaterias)){
		echo "<TR><TD><B>Materia: </B></TD>";
		//echo $materias['nombre']."<BR>";
		echo "<TD><a href='buscar.php?type=mat&bus=".$materias['id']."' target=new>".$materias['nombre'].', </a></TD></TR>';
		$sql = "SELECT 
				pal_clave.nombre,
				pal_clave.id
			FROM
				pal_clave,
				libros_palclave
			WHERE
				pal_clave.id_materia = '".$materias['id']."'
				AND libros_palclave.id_libro = ".$id."
				AND libros_palclave.id_palclave=pal_clave.id";

		$respalabras = mysql_query($sql);
		while($palabras = mysql_fetch_array($respalabras)){
		
			echo "<TR><TD COLSPAN=2>P. Clave: <a href='buscar.php?type=pal&bus=".$palabras['id']."' target=new>".$palabras['nombre'].', </a></TD></TR>';
			
		}
		echo "<BR>";
		
	}

	echo "</td>\n";
	echo "</TR>";
	echo "<TR><TD><B>ISBN: </B></TD>";
	echo "<TD>".$libro2['isbn']."</TD>";
	echo "<TR><TD><B>Medidas: </B></TD>";
	echo "<TD>".$libro2['ancho'].' x '.$libro2['largo']."</TD></TR>";
	echo "<TR><TD><B>Observaciones: </B></TD>";
	echo "<TD>".$libro2['observaciones']."</TD>";
	
	
	echo "</TABLE><BR>";
	
}


function ficha_comp_rev($id){
	
		$sql = "SELECT libros.titulo,
				libros.edicion,
				libros.observaciones,
				libros.anyo,
				libros.paginas,
				libros.largo,
				libros.ancho,
				libros.isbn,
				libros.volumen,
				libros.numero,
				libros.epoca,
				libros.coleccion,
			editoriales.nombre AS editorial,
			ciudades.nombre AS ciudad,
			paises.nombre AS pais,
			revista.nombre AS revista
			FROM libros,
				editoriales,
				ciudades,
				paises,
				revista,
				revista_artic
			WHERE libros.id='".$id."'
			AND editoriales.id=libros.editorial
			AND ciudades.id=libros.ciudad
			AND paises.id=libros.pais
			AND revista_artic.id_revista = revista.id
			AND revista_artic.id_articulo = libros.id";
	
	$reslib = mysql_query($sql);
	$libro2 = mysql_fetch_array($reslib);
	mysql_free_result($reslib);
	
	$sql = "SELECT personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego 
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			ORDER BY categorias.nombre";
	$resper = mysql_query($sql);
	
	echo "<table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
	
	$oldcat = '';
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
				
		//echo $personas['apellido_pat'].$materno.', '.$personas['nombres'].'; ';
		echo "<TR><TD><B>".$personas['catego'].":</B></TD><TD><a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'</a><br><TD></TR>';
		if($oldcat != $personas['nombre'])echo "<BR>";
		$oldcat = $personas['nombre'];
		
	}	
	echo "<TR><TD><B>Anyo:</B></TD><TD>".$libro2['anyo']."</TR>";
	echo "<TR><TD><B>Titulo:</B></TD><TD>".$libro2['titulo']."</TD></TR>";
	echo "<TR><TD><B>Revista:</B></TD><TD>".$libro2['revista']."</TR>";
	
	echo "<TR><TD><B>Epoca: </TD><TD>".$libro2['numero']."</TD></TR>
	<TR><TD><B>Volumen: </TD><TD>".$libro2['volumen']."</TD></TR>
	<TR><TD><B>Numero: </TD><TD>".$libro2['paginas']."</TD></TR></B>";
	
	echo "<TR><TD><B>Editorial:</B></TD><TD>".$libro2['editorial']."<TD></TR>";
	echo "<TR><TD><B>Ciudad:</B></TD><TD>".$libro2['ciudad']."</TR>";
	
	// fin personas
	// materias y palabras clave

	$sql = "SELECT 
				materias.nombre,
				materias.id
			FROM
				materias,
				libros_materias
			WHERE
				libros_materias.id_libro = '".$id."'
				AND materias.id = libros_materias.id_materia";
	$resmaterias = mysql_query($sql);
	
	while($materias = mysql_fetch_array($resmaterias)){
		echo "<TR><TD><B>Materia: </B></TD>";
		//echo $materias['nombre']."<BR>";
		echo "<TD><a href='buscar.php?type=mat&bus=".$materias['id']."' target=new>".$materias['nombre'].', </a></TD></TR>';
		$sql = "SELECT 
				pal_clave.nombre,
				pal_clave.id
			FROM
				pal_clave,
				libros_palclave
			WHERE
				pal_clave.id_materia = '".$materias['id']."'
				AND libros_palclave.id_libro = ".$id."
				AND libros_palclave.id_palclave=pal_clave.id";

		$respalabras = mysql_query($sql);
		while($palabras = mysql_fetch_array($respalabras)){
		
			echo "<TR><TD COLSPAN=2>P. Clave: <a href='buscar.php?type=pal&bus=".$palabras['id']."' target=new>".$palabras['nombre'].', </a></TD></TR>';
			
		}
		echo "<BR>";
		
	}

	echo "</td>\n";
	echo "</TR>";
	echo "<TR><TD><B>ISSN: </B></TD>";
	echo "<TD>".$libro2['isbn']."</TD>";
	//echo "<TR><TD><B>Medidas: </B></TD>";
	//echo "<TD>".$libro2['ancho'].' x '.$libro2['largo']."</TD></TR>";
	//echo "<TR><TD><B>Observaciones: </B></TD>";
	//echo "<TD>".$libro2['observaciones']."</TD>";
	
	
	echo "</TABLE><BR>";
	
}

function ficha_materias($id){
	
		$sql = "SELECT libros.titulo,
			libros.id,
			libros.anyo,
			libros.edicion,
			editoriales.nombre AS editorial,
			ciudades.nombre AS ciudad,
			paises.nombre AS pais 
			FROM libros,
				editoriales,
				ciudades,
				paises 
			WHERE libros.id='".$id."'
			AND editoriales.id=libros.editorial
			AND ciudades.id=libros.ciudad
			AND paises.id=libros.pais";
	
	$reslib = mysql_query($sql);
	$libro2 = mysql_fetch_array($reslib);
	mysql_free_result($reslib);
	
	echo "<table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
	echo "<TR>";
	echo "         <td class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
	echo '('.$libro2['anyo'].') ';
	echo $libro2['titulo'].'. '.$libro2['ciudad'].', '.$libro2['pais'].': '.$libro2['editorial'];
	echo "</TD></TR>";
	// materias y palabras clave
	echo "<TR><TD>";
	$sql = "SELECT 
				materias.nombre,
				materias.id
			FROM
				materias,
				libros_materias
			WHERE
				libros_materias.id_libro = '".$id."'
				AND materias.id = libros_materias.id_materia";
	$resmaterias = mysql_query($sql);
	echo "<B>Materias: </B>";
	while($materias = mysql_fetch_array($resmaterias)){
		
		if(isset($_SESSION['admin_user'])){
			echo $materias['nombre'].'&nbsp;&nbsp;<a href=remmateria.php?id='.$libro2['id'].'&mat='.$materias['id'].' onclick="return confirm(\'' . _('Estas Seguro?') . '\');">[eliminar]</a>, ';
		}else {
			
		}
		
	}

	echo "</td>\n";
	echo "</TR>";
	// palabras clave
	echo "<TR><TD>";
	$sql = "SELECT 
				pal_clave.nombre
			FROM
				pal_clave,
				libros_palclave
			WHERE
				libros_palclave.id_libro = '".$id."'
				AND pal_clave.id = libros_palclave.id_palclave";
	$respalabras = mysql_query($sql);
	echo "<B>Palabras Clave: </B>";
	while($palabras = mysql_fetch_array($respalabras)){
		
		//echo "<a href='buscar.php?type=pal&bus=".$palabras['id']."' target=new>".$palabras['nombre'].', </a>';
		echo $palabras['nombre'].', ';
		
	}
	
	echo "</td>\n";
	echo "</TR>";
	
	echo "</TABLE><BR>";
	
}

function ficha_busqueda2($id, $sch){
	
	$sql = "SELECT libros.titulo,
			libros.id,
			libros.tipo,
			libros.anyo,
			libros.volumen,
			libros.paginas,
			revista.nombre AS revista
			FROM libros, revista, revista_artic
			WHERE libros.id='".$id."'
			AND revista.id = revista_artic.id_revista
			AND revista_artic.id_articulo = libros.id";
	
	$reslib = mysql_query($sql);
	$libro2 = mysql_fetch_array($reslib);
	mysql_free_result($reslib);
	//AND categorias.nombre LIKE '%Autor%'
	$sql = "SELECT personas.id, personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			
			AND  concat(personas.nombres,personas.apellido_pat,personas.apellido_mat) LIKE '%".$sch."%'
			ORDER BY categorias.nombre";
	
	$resper = mysql_query($sql);
	echo "<table align=center class=table_border width=90% border=0 cellpadding=3 cellspacing=0>\n";
	echo "<TR>";
	echo "         <td class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
	
	echo "<STRONG>ID[".$id."]:</STRONG>";
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		// bowikaxu - links de personas a busqueda
		echo "<a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'; </a>';
		
		
	}
	echo "<BR>";
	echo '<TR><TD>('.$libro2['anyo'].') ';
	echo '<STRONG>'.$libro2['titulo'].'&nbsp;</STRONG>';
	echo ''.$libro2['revista'].'.&nbsp;'.$libro2['volumen'].',&nbsp;'.$libro2['paginas'];
	echo "</TD></TR>";

	// materias y palabras clave
	echo "<TR><td class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
	$sql = "SELECT 
				materias.nombre,
				materias.id
			FROM
				materias,
				libros_materias
			WHERE
				libros_materias.id_libro = '".$id."'
				AND materias.id = libros_materias.id_materia";
	$resmaterias = mysql_query($sql);
	echo "<STRONG>Materias: </STRONG>";
	while($materias = mysql_fetch_array($resmaterias)){
		
		//echo "<a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'; </a>';
		echo "<a href='buscar.php?type=mat&bus=".$materias['id']."' target=new>".$materias['nombre'].', </a>';
		
	}

	echo "</td>\n";
	echo "</TR>";
	// palabras clave
	echo "<TR><td class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
	$sql = "SELECT 
				pal_clave.nombre,
				pal_clave.id
			FROM
				pal_clave,
				libros_palclave
			WHERE
				libros_palclave.id_libro = '".$id."'
				AND pal_clave.id = libros_palclave.id_palclave";
	$respalabras = mysql_query($sql);
	echo "<STRONG>Palabras Clave: </STRONG>";
	while($palabras = mysql_fetch_array($respalabras)){
		
		//echo "<a href='buscar.php?type=mat&bus=".$materias['id']."' target=new>".$materias['nombre'].', </a>';
		echo "<a href='buscar.php?type=pal&bus=".$palabras['id']."' target=new>".$palabras['nombre'].', </a>';
		
	}
	
	echo "</td>\n";
	echo "</TR>";
	
	echo "</TABLE><BR>";
	
}

function ficha_busqueda($id, $sch){
	
	$sql = "SELECT libros.titulo,
			libros.id,
			libros.tipo,
			libros.anyo
			FROM libros
			WHERE libros.id='".$id."'";
	
	$reslib = mysql_query($sql);
	$libro2 = mysql_fetch_array($reslib);
	mysql_free_result($reslib);
	//AND categorias.nombre LIKE '%Autor%'
	
	
	// verificar si es libro o revista
	
	if($libro2['tipo']=='R'){
		echo "<STRONG>REVISTA </STRONG>";
	}
	
	// fin verificar si es libro o revista
	
	echo "<STRONG>ID[".$id."]</STRONG><BR>";
	
	if(strlen($sch)>1){
	// CATEGORIA AUTORES BUSCADOSAnyo
	$sql = "SELECT personas.id, personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre LIKE '%Autor%'
	
			AND  concat(personas.nombres,personas.apellido_pat,personas.apellido_mat) LIKE '%".$sch."%'
			ORDER BY categorias.nombre";
	//echo $sql."<BR>";
	$resper = mysql_query($sql);
	echo "<table align=center class=table_border width=90% border=0 cellpadding=3 cellspacing=0>\n";
	echo "<TR>";
	echo "         <td background-color=red class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
	
	echo "<STRONG>AUTORES:</STRONG>";
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		// bowikaxu - links de personas a busqueda
		echo "<a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new><FONT COLOR='#FF0000'>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'; </FONT></a>';
		
	}
	
	// AUTORES NO BUSCADOS
	$sql = "SELECT personas.id, personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre LIKE '%Autor%'
	
			AND  concat(personas.nombres,personas.apellido_pat,personas.apellido_mat) NOT LIKE '%".$sch."%'
			ORDER BY categorias.nombre";
	//echo $sql."<BR>";
	$resper = mysql_query($sql);
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		// bowikaxu - links de personas a busqueda
		echo "<a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'; </a>';
		
		
	}
	
	echo "<BR>";
	// FIN AUTORES
	
	// COLABORADORES ENCONTRADOS
	
	$sql = "SELECT personas.id, personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre LIKE '%COMPILADOR%'
	
			AND  concat(personas.nombres,personas.apellido_pat,personas.apellido_mat) LIKE '%".$sch."%'
			ORDER BY categorias.nombre";
	//echo $sql."<BR>";
	$resper = mysql_query($sql);
	echo "<STRONG>COMPILADORES:</STRONG>";
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		// bowikaxu - links de personas a busqueda
		echo "<a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new><FONT COLOR='#FF0000'>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'; </FONT></a>';
		
		
	}
	
	// FIN COLABORADORES ENCONTRADOS
	// COLABORADORES NO ENCONTRADOS
	
	$sql = "SELECT personas.id, personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre LIKE '%COMPILADOR%'
	
			AND  concat(personas.nombres,personas.apellido_pat,personas.apellido_mat) NOT LIKE '%".$sch."%'
			ORDER BY categorias.nombre";
	//echo $sql."<BR>";
	$resper = mysql_query($sql);
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		// bowikaxu - links de personas a busqueda
		echo "<a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'; </a>';		
		
	}
	echo "<BR>";
	// FIN COLABORADORES NO ENCONTRADOS
	$sql = "SELECT personas.id, personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre NOT LIKE '%COMPILADOR%' 
			AND categorias.nombre NOT LIKE '%Autor%'
			AND categorias.nombre NOT LIKE '%DONADOR%'	
			AND  concat(personas.nombres,personas.apellido_pat,personas.apellido_mat) LIKE '%".$sch."%'
			ORDER BY categorias.nombre";
	//echo $sql."<BR>";
	$resper = mysql_query($sql);
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		// bowikaxu - links de personas a busqueda
		echo "<STRONG>".$personas['catego'].': </STRONG>'."<a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new><FONT COLOR='#FF0000'>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'; </FONT></a>';
		echo "<BR>";
	}
	
	// BUSQUEDA SE ENCUENTRA EN OTRA CATEGORIA
	
	}else {
	echo "<table align=center class=table_border width=90% border=0 cellpadding=3 cellspacing=0>\n";
	echo "<TR>";
	echo "         <td background-color=red class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
		// AUTORES
		$sql = "SELECT personas.id, personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre LIKE '%Autor%'
			ORDER BY categorias.nombre";
	//echo $sql."<BR>";
	$resper = mysql_query($sql);
	
	echo "<STRONG>AUTORES:</STRONG>";
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		// bowikaxu - links de personas a busqueda
		echo "<a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'; </a>';
		
	}
	echo "<BR>";
	// COMPILADORES
	$sql = "SELECT personas.id, personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre LIKE '%COMPILADOR%'
			ORDER BY categorias.nombre";
	//echo $sql."<BR>";
	$resper = mysql_query($sql);
	
	echo "<STRONG>COMPILADORES:</STRONG>";
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		// bowikaxu - links de personas a busqueda
		echo "<a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'; </a>';
		
	}
	echo "<BR>";
	}
	
	// FIN BUSQUEDA EN OTRA CATEGORIA
	
	echo '<STRONG>Anyo:</STRONG> '.$libro2['anyo']."<BR>";
	echo '<STRONG>Titulo: </STRONG>'.$libro2['titulo']."<BR>";
	echo "</TD></TR>";

	// materias y palabras clave
	echo "<TR><td class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
	$sql = "SELECT 
				materias.nombre,
				materias.id
			FROM
				materias,
				libros_materias
			WHERE
				libros_materias.id_libro = '".$id."'
				AND materias.id = libros_materias.id_materia";
	$resmaterias = mysql_query($sql);
	echo "<STRONG>Materias: </STRONG>";
	while($materias = mysql_fetch_array($resmaterias)){
		
		//echo "<a href='buscar.php?type=per&bus=".$personas['nombres'].$personas['apellido_pat']."' target=new>".$personas['apellido_pat'].$materno.', '.$personas['nombres'].'; </a>';
		echo "<a href='buscar.php?type=mat&bus=".$materias['id']."' target=new>".$materias['nombre'].', </a>';
		
	}

	echo "</td>\n";
	echo "</TR>";
	// palabras clave
	echo "<TR><td class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
	$sql = "SELECT 
				pal_clave.nombre,
				pal_clave.id
			FROM
				pal_clave,
				libros_palclave
			WHERE
				libros_palclave.id_libro = '".$id."'
				AND pal_clave.id = libros_palclave.id_palclave";
	$respalabras = mysql_query($sql);
	echo "<STRONG>Palabras Clave: </STRONG>";
	while($palabras = mysql_fetch_array($respalabras)){
		
		//echo "<a href='buscar.php?type=mat&bus=".$materias['id']."' target=new>".$materias['nombre'].', </a>';
		echo "<a href='buscar.php?type=pal&bus=".$palabras['id']."' target=new>".$palabras['nombre'].', </a>';
		
	}
	
	echo "</td>\n";
	echo "</TR>";
	
	echo "</TABLE><BR>";
	
}

?>
