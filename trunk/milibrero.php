<?php
/*


*/
session_start();
include ('header.php');
include ('scripts.php');
//include ('leftmain.php');

echo "<title>$title - Mi Librero</title>\n";
$current_page = "milibrero.php";

if (!isset($_SESSION['lector_user'])) {

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
// borrar de mi librero
if(isset($_GET['remlibro']) && !empty($_GET['remlibro'])){
	$sql = "DELETE FROM libreros WHERE user= '".$_SESSION['lector_user']."' AND id_libro=".$_GET['remlibro']."";
	$res = mysql_query($sql);
}
// fin borrar de mi librero

// agregar a mi librero

if(isset($_GET['librero']) && !empty($_GET['librero'])){
	
	$error = 0;
	$sql = "SELECT * FROM libreros WHERE user='".$_SESSION['lector_user']."'";
	$res = mysql_query($sql);
	// ya tiene 10 libros en su librero
	if(mysql_num_rows($res)>=$libreromax){
		
				echo "<BR>";
				echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
				echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>Lo Sentimos Usted Tiene Lleno Mi Librero</td></tr>\n";
				echo "            </table>\n";
				$error = 1;
		
	}
	$sql = "SELECT * FROM libreros WHERE user='".$_SESSION['lector_user']."' AND id_libro='".$_GET['librero']."'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>=1){
		
				echo "<BR>";
				echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
				echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>Lo Sentimos Usted Ya Tiene El Libro en Mi Librero</td></tr>\n";
				echo "            </table>\n";
				$error = 1;
		
	}
	
	if($error == 0){
		
		$sql = "INSERT INTO libreros (id_libro, user) VALUES ('".$_GET['librero']."', '".$_SESSION['lector_user']."')";
		$res = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>EL Libro Se Ha Agregado a Mi Librero</td></tr>\n";
		echo "            </table>\n";
		
		
	}
	
}
// fin agregar a mi librero

// mostrar Mi Librero
$sql  = "SELECT libreros.*, libros.titulo FROM libreros,libros WHERE user='".$_SESSION['lector_user']."'
		AND libros.id = libreros.id_libro";
$res = mysql_query($sql);

echo "<FORM METHOD=GET>";
echo "<TABLE><TR>";
if(mysql_num_rows($res)>=1){
	while ($librero = mysql_fetch_array($res)){
	
		echo "<TD align=center><A HREF='milibrero.php?&remlibro=".$librero['id_libro']."'><IMG SRC='images/icons/delete.png' border=0 ALT='Borrar de Mi Librero'></A></TD>";
		//echo "<A HREF='viewer/upload.php?id=".$librero['id_libro']."'><IMG SRC='".$lomos_view_dir.$librero['id_libro'].".jpg"."' ALT='".$librero['titulo']."' WIDTH=65 HEIGHT=400 BORDER=0></A>\n";
	
	}
	mysql_data_seek($res,0);
	echo "</TR><TR>";
	while ($librero = mysql_fetch_array($res)){
	
		//echo "<A HREF='milibrero.php?remlibro=".$librero['id_libro']."'><IMG SRC='images/icons/delete.png'></A><BR>";
		echo "<TD><A HREF='viewer/upload.php?&id=".$librero['id_libro']."'><IMG SRC='".$lomos_view_dir.$librero['id_libro'].".jpg"."' ALT='".$librero['titulo']."' BORDER=0 WIDTH=85 HEIGHT=800></A></TD>\n"; //WIDTH=65 HEIGHT=400 
	
	}
	echo "</TR></TABLE>";
}else {
	
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>Aun No Tienes Ningun Libro</td></tr>\n";
		echo "            </table>\n";
	
}
// fin mostrar Mi Librero
echo "</FORM>";
include ('footer.php');
?>