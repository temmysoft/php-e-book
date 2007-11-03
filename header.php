<?php
/*

BIBLIOTECA

andres amaya diaz

*/
include ('config.inc.php');
$title = "Biblioteca Focim";

?>
<HTML>

	<HEAD>
	
	</HEAD>
	
	<BODY>
	
<style>
	@import url( drop/css/dropdown.css );
</style>

<style>
div.selectContainer
{
	display: block;
	float: left;
	clear: none;
	height: 35px;
	background-image: url(i/blbg.png);
	box-sizing: border-box;
	-moz-box-sizing: border-box;
}

div.selectContainer div.acinputContainer
{
	margin: 7px 2px 0px 2px;
	border-color: #fff;
}

* html div.selectContainer div.acinputContainer
{
	margin: 6px 2px 0px 2px;
}

div.selectContainer div.left
{
	display: block;
	float: left;
	clear: none;
	width: 7px;
	height: 35px;
	background-image: url(i/leftb.png);
	box-sizing: border-box;
	-moz-box-sizing: border-box;
}

div.selectContainer div.right
{
	display: block;
	float: left;
	clear: none;
	width: 7px;
	height: 35px;
	background-image: url(i/rightb.png);
	box-sizing: border-box;
	-moz-box-sizing: border-box;
}
</style>

<script src="drop/js/mobrowser.js"></script>
<script src="drop/js/modomevent3.js"></script>
<script src="drop/js/modomt.js"></script>
<script src="drop/js/modomext.js"></script>
<script src="drop/js/tabs2.js"></script>
<script src="drop/js/getobject2.js"></script>
<script src="drop/js/xmlextras.js"></script>
<script src="drop/js/acdropdown.js"></script>

		<!-- syntax highlight -->
<script language="javascript" src="drop/js/shCore.js" ></script >
<script language="javascript" src="drop/js/shBrushXML.js" ></script >
<!-- syntax highlight -->
<script language="javascript">
function alertSelected()
{
  document.getElementById( 'selectedCountry' ).innerHTML = this.sActiveValue
}
</script>

<?php
define ('TIMEOUT', 10);
function is_online(){
	
// Check if visitor is already in the table
$ipaddress = $_SERVER['REMOTE_ADDR'];
$lastactive = time();
mysql_query ("DELETE FROM online WHERE lastactive < ".$inactive."");
$intable = mysql_query ("SELECT onlineid FROM online WHERE onlineid = '".$_SESSION['userid']."'");

if (mysql_num_rows($intable)<=0) {
        // Insert new visitor
        if(isset($_SESSION['userid'])){
        	mysql_query("INSERT INTO online (onlineid, ipaddress, lastactive) VALUES ('".$_SESSION['userid']."','".$ipaddress."', ".$lastactive.")");
        	//echo "INSERT INTO online (onlineid, ipaddress, lastactive) VALUES ('".$_SESSION['userid']."','".$ipaddress."', ".$lastactive.")"."<BR>";
        }
        $res = false;

} else {
	
		$res = mysql_query("SELECT onlineid FROM online WHERE onlineid = '".$_SESSION['userid']."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."'");
        if(mysql_num_rows($res)>0){
        	mysql_query("UPDATE online SET lastactive = '".$lastactive."' WHERE onlineid = '".$_SESSION['userid']."'");
        //echo "UPDATE online SET lastactive = '".$lastactive."' WHERE onlineid = '".$_SESSION['userid']."'<BR>";
        $res = true;
        }else {
        	echo "<CENTER><FONT COLOR=red>ERROR: Esta usted utilizando una cuenta apocrifa. Esto es Ilegal.
    	<BR> Usted y quien le presto sus datos de cuenta han sido expulsados en este momento. 
    	<BR><H2>COSTO DE RECONEXION: $150.00 pesos</H2>
    	</FONT></CENTER>";
        	
        	mysql_query("UPDATE users SET pass=encode('duplicado','xy') WHERE id = '".$_SESSION['userid']."'");
        	
        	mysql_query("UPDATE online SET ipaddress ='0.0.0.0' WHERE onlineid = '".$_SESSION['userid']."'");
        	$usr = mysql_query("SELECT ipaddress FROM online WHERE onlineid = '".$_SESSION['userid']."'");
        	$usr2 = mysql_fetch_array($usr);
        	
        	mysql_query("INSERT INTO dupusers (userid, fecha, ip1, ip2) VALUES 
        	('".$_SESSION['userid']."', 
        	'".date('Y-m-d H:m:s')."',
        	'".$_SERVER['REMOTE_ADDR']."',
        	'".$usr2['ipaddress']."')");
        	
    		if (isset($_SESSION['admin_user'])) {unset($_SESSION['admin_user']);}
			if (isset($_SESSION['captur_user'])) {unset($_SESSION['captur_user']);}
			if (isset($_SESSION['lector_user'])) {unset($_SESSION['lector_user']);}
			if (isset($_SESSION['userid'])) {unset($_SESSION['userid']);}
			exit;
        }
		// Update exisiting visitor  
}

// Remove any inactive visitors
$inactive = time()-(60*TIMEOUT);
//echo "DELETE FROM online WHERE lastactive < ".$inactive."<BR>";
mysql_query("DELETE FROM online WHERE lastactive < ".$inactive."");
}
//is_online();
//online();
echo "<link rel='stylesheet' type='text/css' media='screen' href='css/default.css' />\n";
//echo "<link rel='stylesheet' type='text/css' media='print' href='css/print.css' />\n";

// color por default: #748771
echo "<table class=header width=100% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr>";
echo "<td align=left><a href='index.php'><img border=0 src='$logo'></a></td>\n";

echo "    <td colspan=2 scope=col align=right valign=middle><a href='$date_link' style='color:#000000;font-family:Arial;font-size:10pt;
            text-decoration:none;'>";
$todaydate=date('d-m-y');
echo "$todaydate&nbsp;&nbsp;</a></td></tr>\n";
echo "</table>\n";

// Lector topbar //
if(isset($_SESSION['lector_user'])){
echo "<table class=topmain_row_color width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "  <tr>\n";

echo "    <td align=left valign=middle>Usuario: &nbsp;".$_SESSION['lector_user']."</td>\n"; 

echo "    <td align=right valign=middle><img src='images/icons/house.png' border='0'>&nbsp;&nbsp;</td>\n";   
echo "    <td align=right valign=middle width=10><a href='index.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
        Inicio&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/magnifier.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='buscar.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Buscar&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/bricks.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='milibrero.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Librero&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/information.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='contacto.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Contacto&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

if(!isset($_SESSION['admin_user']) && !isset($_SESSION['captur_user'])){
echo "    <td align=right valign=middle width=25><img src='images/icons/arrow_rotate_clockwise.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='logout.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Salir&nbsp;&nbsp;</a></td>\n";
}

echo "</tr></table>\n";
}
// fin Lector topbar //

// captur topbar //
if(isset($_SESSION['captur_user'])){
echo "<table class=topmain_row_color width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "  <tr>\n";

echo "    <td align=left valign=middle>Capturista: &nbsp;".$_SESSION['captur_user']."</td>\n"; 

echo "    <td align=right valign=middle><img src='images/icons/house.png' border='0'>&nbsp;&nbsp;</td>\n";   
echo "    <td align=right valign=middle width=10><a href='index.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
        Inicio&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/magnifier.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='buscar.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Buscar&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/database_go.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='agregar.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Capturar&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

if(!isset($_SESSION['admin_user'])){
echo "    <td align=right valign=middle width=25><img src='images/icons/arrow_rotate_clockwise.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='logout.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Salir&nbsp;&nbsp;</a></td>\n";
}

echo "</tr></table>\n";
}
// fin captur topbar //

// Administration topbar //
if(isset($_SESSION['admin_user'])){
echo "<table class=topmain_row_color width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "  <tr>\n";

echo "    <td align=left valign=middle>Administrador: &nbsp;".$_SESSION['admin_user']."</td>\n"; 

echo "    <td align=right valign=middle><img src='images/icons/house.png' border='0'>&nbsp;&nbsp;</td>\n";   
echo "    <td align=right valign=middle width=10><a href='index.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
        Inicio&nbsp;&nbsp;</a></td>\n";

echo "    <td align=right valign=middle width=25><img src='images/icons/magnifier.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='buscar.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Buscar&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/application_edit.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='reports.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Reportes&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/group_add.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='adduser.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
        Usuarios&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";


echo "    <td align=right valign=middle width=25><img src='images/icons/bricks.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addrevista.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
        Revistas&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";


echo "    <td align=right valign=middle width=25><img src='images/icons/user.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addpais.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
        Paises&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/user_green.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addciudad.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Ciudades&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/user_red.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addmateria.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Materias&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/user_orange.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addpersona.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Personas&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/user_suit.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addeditorial.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Editoriales&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/brick.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addcategoria.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Categoria&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/report.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='sendbooks.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Publicar&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/arrow_rotate_clockwise.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='logout.php' style='color:#000000;font-family:Arial;font-size:10pt;text-decoration:none;'>
		Salir&nbsp;&nbsp;</a></td>\n";

echo "</tr></table>\n";
}
// fin Administration topbar //

?>
