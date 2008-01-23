<?php 
session_start();

$compare_string1 = 'http[s]?://' . $_SERVER['HTTP_HOST'] . '/biblioteca/viewer/header.php';
$compare_string2 = 'http[s]?://' . $_SERVER['HTTP_HOST'] . '/biblioteca/viewer/upload.php';

$_SESSION['pageid']= $_GET['p'];
$_SESSION['zoom'] = $_GET['z1'];
$page_id = $_GET['p'];
//$page_id = $_SESSION['pageid'];
$zoom_level = $_GET['z1'];

if(isset($_GET['MARCAR'])){
	echo "SE MARCO LA PAGINA: ".$_GET['pagid']."<BR>";
}
/*
$marc = $_GET['marc'];

if($marc > 0){
	
	$sql = "INSERT INTO marcadores (id_libro,pagina,user_) VALUES ('".$_SESSION['id']."','".($page_id-1)."','".$_SESSION['admin_user']."')";
	//mysql_query($sql);
	
}
*/
/*
if ((!is_numeric ($page_id) || $page_id < 1 || $page_id > $_SESSION['args']['Pages']) ||
   (!is_numeric ($zoom_level) || $zoom_level < 1 || $zoom_level > $_SESSION['max_zoom_level']))
	die ('Invalid access.');
*/
//$file_name = $_SESSION['imgid'] . $page_id . 's' . $zoom_level . '.jpg';
$file_name = $_SESSION['imgid'] . $_SESSION['id']. '_' .$_SESSION['pfiles'][$page_id-1] . 's' . $zoom_level . '.jpg';

//if (ereg ($compare_string1, substr ($_SERVER['HTTP_REFERER'], 0, strlen ($compare_string1))) || ereg ($compare_string2, substr ($_SERVER['HTTP_REFERER'], 0, strlen ($compare_string2))))
//{
	
	if (!file_exists ($file_name))
	{
		copy ($_SESSION['docid'] . $_SESSION['pfiles'][$page_id-1].'.jpg', $file_name);
		shell_exec ('mogrify -scale ' . ($zoom_level * 250) . ' ' . $file_name);
	}
	
	header ("Content-type: image/jpeg");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
							     // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
	header("Cache-Control: pre-check=0", false);
	header("Pragma: no-cache");                          // HTTP/1.0
	//readfile ($_SESSION['imgid'] . $_SESSION['id']. '_' . $_SESSION['pfiles'][$page_id-1] . 's' . $zoom_level . '.jpg');
	readfile ($file_name);
	
	//echo "<IMG SRC='".$_SESSION['imgid'] . $page_id . 's' . $zoom_level . '.jpg'."'>";
//}
//else
	//die ("ERROR...<p>");
?>
