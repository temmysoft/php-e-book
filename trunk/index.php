<?php
/*


*/

session_start();
include ('header.php');
//include ('leftmain.php');
include('functions.php');
echo "<title>$title</title>\n";
$current_page = "index.php";

if (!isset($_SESSION['admin_user']) && !isset($_SESSION['captur_user']) && !isset($_SESSION['lector_user'])) {

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>Login BIBLIOTECA FOCIM</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=200 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>No estas registado<br>o<br>No tienes permiso de acceder a esta pagina.</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='login.php'><u>aqui</u></a> para logearse.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n<BR><BR>"; 

echo "<P ALIGN=right><FONT color='#a595b9' size='1px'>Para visualizar esta página correctamente<br>debes tener instalado +IE6.2 o Mozilla Firefox</FONT></P>";
exit;

}
is_online();
// PAGINA DEL CAPTURISTA
if (isset($_SESSION['captur_user'])){
	
	include('captur_index.php');
	
}

// PAGINA DEL ADMINISTRADOR
if(isset($_SESSION['admin_user'])){
	
	// principal administrador
	/*
	echo "<BR>";
	$row_count = 0;

	echo "            <table class=misc_items width=100% border=0 cellpadding=2 cellspacing=0>\n";
	echo "              <tr class=notprint>\n";
    
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Titulo</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Edicion</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Archivo</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Sus Materias</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Sus Personas</td>\n";
	
	echo "                <td nowrap width=20% align=left style='font-size:11px;padding-left:10px;padding-right:10px;'>
                          Eliminar Libro</td>\n";
	
	echo "</tr>";
	
	$SQL = "SELECT * FROM libros";
	$result = mysql_query($SQL);
	
	while($libro = mysql_fetch_array($result)){
	
		// begin alternating row colors //
		$row_color = ($row_count % 2) ? $color1 : $color2;
		 echo "<tr>";
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$libro["titulo"]."</td>\n";
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$libro["edicion"]."</td>\n";
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'>".$libro["id"].".pdf</td>\n";
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'><a href='libromaterias.php?id=".$libro['id']."'>Agregar Materias al Libro</a></td>\n";
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'><a href='libropersonas.php?id=".$libro['id']."'>Agregar Personas al Libro</a></td>\n";
		 echo "                <td nowrap align=left width=20% bgcolor='$row_color' style='color:black;padding-left:10px;padding-right:10px;'><a href='borralibro.php?borrar=".$libro['id']."'>Eliminar Libro</a></td>\n";
		 // add 1 to te row count
		$row_count++;
	}
	echo "</table>";*/
// fin principal del capturista
	include('admin_index.php');
}

// PAGINA DEL LECTOR
if (isset($_SESSION['lector_user'])){
echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
/*
// izquierda
echo "    <td class=left_main width=20% align=left scope=col>\n";



echo "</font></td>";
// fin izquierda
*/

echo "    <td class=middle_main width=60% align=left scope=col>\n";
// centro
echo "<font size=2 color=black>";
echo "Bienvenido a la Biblioteca Digital del Instituto para el Fomento Científico de Monterrey."."<BR><BR>";

echo "Esta Biblioteca se ha ido formando como producto del acopio y conservación de libros, revistas, manuscritos y toda clase de documentos que han servido de base o apoyo secundario a investigaciones científicas o académicas. El depósito de libros y documentos está por lo tanto clasificado y orientado a la investigación, dando como resultado una organización por Líneas de Investigación, además de la tradicional organización electrónica por categorías como autor, título, editorial, etc."."<BR><BR>";

echo "Las tres formas como la biblioteca engrandece su acervo de libros y documentos son: <br>
a) <strong>Compra directa</strong> de materiales en función de investigaciones que se autorizan para alumnos o colaboradores del Instituto<br>
b) <strong>Donativos</strong> de libros y documentos por parte de catedráticos, casas editoriales, alumnos, colaboradores y amigos.<br>
c) <strong>Fusiones</strong> de nuestro acervo bibliográfico y hemerográfico con las bibliotecas privadas de catedráticos e instituciones educativas y centros de investigación."."<BR><BR>";

echo "Nuestra biblioteca es <strong>PRIVADA.</strong> Lo cual implica que únicamente los donadores de obras o colecciones, así como personas e instituciones que han fusionado sus bibliotecas privadas a la nuestra, tienen autorización para utilizar el fondo colectivo que se ha formado desde 1985. La biblioteca no persigue fines de lucro y no cobra por ningún servicio relacionado con el acopio y conservación de estos materiales. Su financiamiento proviene del fondo que destinan para tal efecto las instituciones que la utilizan."."<BR><BR>";

echo "Exiten RESTRICCIONES para el uso de los libros de esta biblioteca. Están diseñadas para proteger los derechos de autor. Básicamente consisten en que dos lectores no pueden estar utilizando simultáneamente una obra y que éstas no pueden ser descargadas completas ni impresas. Son de sólo lectura. Si el lector copia de manera individual página por página y las imprime lo hace bajo su entera responsabilidad y pierde por ese sólo hecho su derecho a ser lector de esta biblioteca."."<BR><BR>";

echo "Esta biblioteca está conformada por versiones electrónicas de libros que originalmente fueron publicados en papel o en versiones electrónicas. Cuenta con un acervo de 62,000 obras, de las cuales se han empezado a digitalizar un promedio de 15 obras diarias a partir de junio de 2007. "."<BR><BR>";

$sql = "SELECT count(id) AS total FROM libros";
$res = mysql_query($sql);
$total = mysql_fetch_array($res);
echo "Actualmente contamos con <strong>".$total['total']."</strong> registros de obras disponibles para su consulta on line."."<BR><BR>";

echo "Si tienes alguna duda, comentario o sugerencia, comunícate con nosotros por medio de correo electrónico, aquí mismo encontrarás el hipervínculo, en la parte superior de esta página web."."<BR><BR>";
echo "</font>";
// fin centro
echo "</td>";

echo "    <td class=right_main width=20% align=left scope=col>\n";
// derecha

// build form

    echo "<form name='buscar' method='post' action='buscar.php'>\n";
    echo "<br>";
   echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
   echo "              <tr>
   <td class=table_rows align=center colspan=3 style='color:black;font-family:Arial;font-size:12px;'>
   <INPUT TYPE=SUBMIT NAME=buscar VALUE='Buscar'></td></tr>\n";
   echo "            </table>\n";
// fin derecha
echo "</td>";

echo "</table><br>";
}

include ('footer.php');
?>