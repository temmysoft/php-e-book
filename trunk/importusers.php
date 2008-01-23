<?php

/*
| delimitador

IMPORTAR UNA LISTA DE USUARIOS
					
*/
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Importar Usuarios</title>\n";
$current_page = "importusers.php";

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

if(!isset($_POST["filename"]) || $_POST["filename"]==""){ 	// no se envio ningun archivo

	echo '<CENTER><TABLE>';
	echo "<FORM METHOD=POST ACTION=".$_SERVER['PHP_SELF'].">";
	echo "Archivo a Importar: <INPUT TYPE='text' NAME='filename'></INPUT>";

	// OPCIONES PARA INVENTARIOS

	echo "</CENTER></TABLE>";
	echo "<BR><BR><INPUT TYPE=Submit></INPUT>";
	echo "</FORM>";

	echo "<center><h2> Formato del archivo: <br>";
	echo "nombre , apellido pat , appelido mat , usuario , password , admin [0|1] , capturista [0|1] , lector [0|1] , id escuela<br></center></h2>";
	include ('footer.php');
}else{								// se envio un archivo
	//$filename = "prueba.csv";
	$filename = $_POST['filename'];
	//$fh_out = fopen("clientes.sql","w+");
	mysql_query("BEGIN");
	if(@$fh_in = fopen("{$filename}","r"))
	{
		// CryptPass($_POST['Password'])
		while(!feof($fh_in))
		{
			$line = fgetcsv($fh_in,1024,',');

			if($line[0] == ""){
				// no contiene nada esta linea
			}else {
				// NECESITA PRUEBAS
				$sql = "INSERT INTO users (nombre, user, pass, admin, capturista, lector, inicio, fin, id_escuela) VALUES (
				'".$line[0].' '.$line[1].' '.$line[2]."',
				'".$line[3]."',
				encode('".$line[4]."','xy'),
				'".$line[5]."',
				'".$line[6]."',
				'".$line[7]."',
				'".date('Y-m-d')."',
				'0000-00-00',
				'".$line[8]."'
				)";
				$res = mysql_query($sql);
				echo "<CENTER><B>".$sql."</B></CENTER><HR>";
				echo "<CENTER><B>SATISFACTORIO !!!</B></CENTER><HR>";
			}
		}
		fclose($fh_in);
		mysql_query("COMMIT");
	}else {
		echo "<CENTER><H2>Archivo Inexistente</CENTER></H2>";
		include ('footer.php');
	}
}
include ('footer.php');
?>
