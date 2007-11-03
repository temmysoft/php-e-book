<?php
/*
ANDRES AMAYA DIAZ
PUBLICAR UN LIBRO A PARTIR DE IMAGENES TIFF

*/
session_start();

include ('header.php');
include('functions.php');

echo "<title>$title - Subir Libro</title>\n";
$current_page = "sendbooks.php";

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
if (empty($_POST['Accion'])){
	
	//die ("File upload error. Please try again.");
	echo "<FORM METHOD='POST' ACTION='".$current_page."'>";
	echo "<CENTER>Publicar Libro</CENTER>";
	//echo "Directorio: <INPUT TYPE='text' NAME='bookdir'><BR>";
	echo "ID Libro: <INPUT TYPE='text' NAME='idlibro'><BR>";
	echo "Rotar: <INPUT TYPE=CHECKBOX NAME='rotar'><BR>";
	echo "<INPUT TYPE='submit' NAME='Accion' VALUE='Publicar'>";
	echo "</FORM>";
	
	echo "<FORM METHOD='POST' ACTION='".$current_page."'>";
	echo "<HR><CENTER>Despublicar Libro</CENTER>";
	echo "ID Libro: <INPUT TYPE='text' NAME='idlibro'><BR>";
	echo "<INPUT TYPE='submit' NAME='Accion' Value='Despublicar'>";
	echo "</FORM>";
// listado de publicados
	echo "<HR><CENTER>Libros Publicados</CENTER>";
	$dir = $libros_dir;
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}

sort($files);
foreach($files as $file){
	if($file!='.' && $file!='..')echo $file.", ";
}


}else if($_POST['Accion']=='Publicar'){
	$i=1;
	//if(!is_dir($_POST['bookdir'])){
		//die("La seleccion no es un directorio");
	//}
	
	$idlibro = $_POST['idlibro'];
	$dir = $libros_tmp.$idlibro."/";
	echo shell_exec("mkdir -m 777 ".$libros_dir.$idlibro."")."<BR>";
	
	echo exec("cd ".$libros_dir.$idlibro);
	if(file_exists($dir.$lomo.".jpg")){
       		$lomo = $lomo.".jpg";
       		$lomof = $idlibro.".jpg";	
       }else {
       		$lomo = $lomo.".tiff";	
       		$lomof = $idlibro.".jpg";
       }
       if(isset($_POST['rotar'])){ // voltear 90 grados la imagen
           			$file = "convert -rotate 90 -quality 60 ".$dir.$lomo." ".$lomos_dir.$lomof."";
           			//echo $dir.$lomo.' -> '.$lomos_dir.$lomof;
       }else {
           			$file = "convert -quality 60 ".$dir.$lomo." ".$lomos_dir.$lomof."";
           			//echo $dir.$lomo.' -> '.$lomos_dir.$lomof;
       }
       exec($file,$ret);
       		if(!$ret){
       			echo "<br>Se copio el Lomo<br>";
       			exec("chmod 777 ".$lomos_dir.$idlibro.".jpg");
       			echo "chmod 777 ".$lomos_dir.$idlibro.".jpg<BR>";
       		}else {
       			echo "<br>NO copio el Lomo<br> ".$file."<BR>";
       		}
       	if(!exec("cp ".$dir."COMPLETO.pdf ".$completo_dir.$idlibro.".pdf")){
       		echo "SE COPIO EL COMPLETO.PDF<BR>";
       	}else {
       		echo "NO SE COPIO EL COMPLETO.PDF<BR>";
       	}
	if ($gd = opendir($dir."/")) {
				
       while (($archivo = readdir($gd)) !== false) {
       		if($archivo != "." && $archivo != ".." && $archivo != $lomo && $archivo != 'COMPLETO.pdf'){
           		echo "Copiando archivo: $archivo : tipo de archivo: " . filetype($dir . $archivo) . "<br>\n";
           		$source = $dir.$archivo;
           		//$dest = $libros_dir.$idlibro."/".$i.".jpeg";
           		$dest = $libros_dir.$idlibro."/".substr($archivo,0,strlen($archivo)-4).".jpg";
           		if(isset($_POST['rotar'])){ // voltear 90 grados la imagen
           			$file = "convert -rotate 90 -quality 60 ".$source." ".$dest."";
           		}else {
           			$file = "convert -quality 60 ".$source." ".$dest."";
           		}
           		//echo $file."<BR>";
           		exec($file,$ret);
           		//print_r($ret)."<BR>";
           		$i++;
       		}
       		
           // shell_exec ("convert -quality 60 archivo.tiff archivo.jpeg");
           // obtener el id del libro
           // crear el directorio con el nombre de id libro
           // copiar los archivos *.tif de $dir a su carpeta destino con la extension jpg
       }
       
       	
       closedir($gd);
   }else {
   	
   		echo "<CENTER>IMPOSIBLE ABRIR EL DIRECTORIO DEL LIBRO</CENTER>";
   	
   }
	
}else if($_POST['Accion']=='Despublicar'){
	
	$idlibro = $_POST['idlibro'];
	if(!exec("rm -fR ".$libros_dir.$idlibro."/")){
		echo "Imagenes Borradas<BR>";	
	}else {
		echo "Imagenes NO Borradas<BR>";
		echo "rm -fR ".$libros_dir.$idlibro."/<BR>";
	}
	
	exec("rm ".$lomos_dir.$idlibro.".jpg");
	echo "Lomo Borrado<br>";
	exec("rm ".$completo_dir.$idlibro.".pdf");
	echo "PDF Borrado<br>";
	echo "Libro ".$idlibro." Despublicado";
	exec("rm /tmp/*");
	echo "<br>Archivos Temporales Borrados";
	
}

include ('footer.php');

?>
