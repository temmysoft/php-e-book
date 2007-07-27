<?php
session_start();

include('../config.inc.php');
if (!isset($_SESSION['lector_user']) AND !isset($_SESSION['admin_user'])) {

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>Login BIBLIOTECA FOCIM</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=200 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>No estas registado<br>o<br>No tienes permiso de acceder a esta pagina.</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='login.php'><u>aqui</u></a> para logearse.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

if (!isset($_GET['id']))
	die ('no se envio libro');

$_SESSION['id'] = $_GET['id'];
$pages = 0;
$_SESSION['pfiles'] = array();
if ($gd = opendir($libros_dir.$_SESSION['id']."/")) {
        while (($archivo = readdir($gd)) !== false) {
            
            if($archivo!='.' && $archivo!='..' && $archivo!=$lomo){
            	//$imageid = $archivo;
            	$_SESSION['pfiles'][$pages] = substr($archivo,0,strlen($archivo)-4);
            	$pages++;
            }
            
        }
        closedir($gd);
    }

sort($_SESSION['pfiles']);
reset($_SESSION['pfiles']);
//print_r($_SESSION['pfiles']);
$_SESSION['Pages'] = $pages;
$_SESSION['max_zoom_level'] = 5;	// Maximum zoom level

$tempfilename = tempnam ($_SERVER['DOCUMENT_ROOT'] . '/biblioteca/viewer', 'pdf');
$tempfilename2 = '/tmp/'.$_SESSION['id']."/";
/*
if(opendir($tempfilename2)){
	
}else{
	mkdir('/tmp/'.$_SESSION['id']);
	copy ($libros_dir.$_SESSION['id']."/*.jpg", $tempfilename2);
}
*/
// Prepare high-res files

//shell_exec ("gs -dNOPAUSE -dSAFER -sDEVICE=png256 -r200 -sOutputFile=$tempfilename%ld.png -dBATCH {$_SESSION['id']}");

//$_SESSION['imgid'] = '/tmp/'.$_SESSION['id']."/".substr($imageid,0,strlen($imageid)-6);
$_SESSION['imgid'] = '/tmp/';
//$_SESSION['imgid'] = $libros_dir.$_SESSION['id']."/";
$_SESSION['docid'] = $libros_dir.$_SESSION['id']."/";
//<frame src="footer.php">
?>
<html>
<frameset cols="1*,100">
	<frame name=downtarget src="view.php?p=1&z1=1">	
</framset>
<frameset rows="1*, 100">
<frameset>
	
	<frame src="header.php">
	<frame src="footer.php">
	
</frameset>

</html>
