<?php
session_start();
include ('header.php');

echo "<title>$title - Eviar por mail</title>\n";
$current_page = "mail.php";

if(!isset($_POST['direccion'])){ // a que direccion
	
	echo "<CENTER>";
	
	echo "<FORM ACTION=$current_page METHOD=POST>";
	foreach($_POST['ids'] as $lib){
		echo "<INPUT TYPE=hidden name='ids[]' value ='".$lib."'>";
	}
	
	echo "Direccion: <INPUT TYPE=tex Name='direccion'>";
	echo "<BR><INPUT TYPE='submit' vame='submit' value='Enviar via Mail'>";
	echo "</FORM></CENTER>";
	
}else { // enviar los libros

$ids = $_POST['ids'];
foreach($ids as $libroid){
	$librosmail .= $libroid.", ";
}
$librosmail = substr($librosmail,0,strlen($librosmail)-2);
$sql = "SELECT * FROM libros WHERE id IN (".$librosmail.")";
$res = mysql_query($sql) or die ('imposible query');
$msg = "";
while($libros = mysql_fetch_array($res)){

$msg .= " - [".$libros['id']."] ".$libros['titulo']."";
}

$para      = $_POST['direccion'];
$asunto    = 'Biblioteca FOCIM';
$mensaje   = $msg;
$mensaje = str_replace("\n.", "\n..", $msg);
$cabeceras = 'From: biblioteca@focim.com' . "\r\n" .
    'Reply-To: biblioteca@focim.com' . "\n";

if(mail($para, $asunto, $mensaje, $cabeceras)){
	echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
	echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>Se enviaron los libros al mail: $para</td></tr>\n";
	echo "            </table>\n";
}else {
	echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
	echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>ERROR: Imposible enviar libros al mail: $para</td></tr>\n";
	echo "            </table>\n";
}

}

include ('footer.php');
?> 
