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
	
	echo '('.$libro2['anyo'].'). ';
	echo $libro2['titulo'].'. '.$libro2['ciudad'].', '.$libro2['pais'].': '.$libro2['editorial'].'<BR>';
	echo 'Edicion: '.$libro2['edicion'].' Paginas: '.$libro2['paginas'].' Largo: '.$libro2['largo'].' Ancho: '.$libro2['ancho'].'<BR>'; 
	echo 'ISBN: '.$libro2['isbn'].' Coleccion: '.$libro2['coleccion'].' Observaciones: '.$libro2['observaciones'];
	echo "</TD></TR>";
	echo "<TR><TD>";
	$sql = "SELECT personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego 
			FROM personas, categorias, libros_personas WHERE
			libros_personas.id_libro ='".$id."'
			AND personas.id = libros_personas.id_persona
			AND categorias.id = libros_personas.id_categoria
			AND categorias.nombre NOT LIKE '%Autor%'
			ORDER BY categorias.nombre";
	$resper = mysql_query($sql);
	while($demas = mysql_fetch_array($resper)){
		
		if(empty($demas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$demas['apellido_mat'];
		}
		
		
		echo '<b>'.$demas['catego'].':</b> '.$demas['apellido_pat'].$materno.', '.$demas['nombres'].'; ';
		
	}
	echo "</td>\n";
	echo "</TR>";
	// fin demas personas
	// materias y palabras clave
	echo "<TR><TD>";
	$sql = "SELECT 
				materias.nombre
			FROM
				materias,
				libros_materias
			WHERE
				libros_materias.id_libro = '".$id."'
				AND materias.id = libros_materias.id_materia";
	$resmaterias = mysql_query($sql);
	echo "<B>Materias: </B>";
	while($materias = mysql_fetch_array($resmaterias)){
		
		echo $materias['nombre'].', ';
		
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
		
		echo $palabras['nombre'].', ';
		
	}
	
	echo "</td>\n";
	echo "</TR>";
	
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
		
		echo $palabras['nombre'].', ';
		
	}
	
	echo "</td>\n";
	echo "</TR>";
	
	echo "</TABLE><BR>";
	
}

function ficha_busqueda($id, $sch){
	
	$sql = "SELECT libros.titulo,
			libros.id,
			libros.anyo
			FROM libros
			WHERE libros.id='".$id."'";
	
	$reslib = mysql_query($sql);
	$libro2 = mysql_fetch_array($reslib);
	mysql_free_result($reslib);
	//AND categorias.nombre LIKE '%Autor%'
	$sql = "SELECT personas.nombres, personas.apellido_pat, personas.apellido_mat, categorias.nombre AS catego
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
	echo "<STRONG>ID[".$id."] Persona(s): </STRONG>";
	while($personas = mysql_fetch_array($resper)){
		if(empty($personas['apellido_mat'])){
			$materno  = "";
		}else {
			$materno = " ".$personas['apellido_mat'];
		}
		
		
		echo $personas['apellido_pat'].$materno.', '.$personas['nombres'].'; ';
		
		
	}	
	echo "<BR>";
	echo '<STRONG>Anyo:</STRONG> '.$libro2['anyo']."<BR>";
	echo '<STRONG>Titulo: </STRONG>'.$libro2['titulo']."<BR>";
	echo "</TD></TR>";

	// materias y palabras clave
	echo "<TR><td class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
	$sql = "SELECT 
				materias.nombre
			FROM
				materias,
				libros_materias
			WHERE
				libros_materias.id_libro = '".$id."'
				AND materias.id = libros_materias.id_materia";
	$resmaterias = mysql_query($sql);
	echo "<STRONG>Materias: </STRONG>";
	while($materias = mysql_fetch_array($resmaterias)){
		
		echo $materias['nombre'].', ';
		
	}

	echo "</td>\n";
	echo "</TR>";
	// palabras clave
	echo "<TR><td class=table_rows align=left style='color:black;font-family:Arial;font-size:12px;'>";
	$sql = "SELECT 
				pal_clave.nombre
			FROM
				pal_clave,
				libros_palclave
			WHERE
				libros_palclave.id_libro = '".$id."'
				AND pal_clave.id = libros_palclave.id_palclave";
	$respalabras = mysql_query($sql);
	echo "<STRONG>Palabras Clave: </STRONG>";
	while($palabras = mysql_fetch_array($respalabras)){
		
		echo $palabras['nombre'].', ';
		
	}
	
	echo "</td>\n";
	echo "</TR>";
	
	echo "</TABLE><BR>";
	
}
?>
