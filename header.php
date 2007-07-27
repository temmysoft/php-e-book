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

echo "<link rel='stylesheet' type='text/css' media='screen' href='css/default.css' />\n";
//echo "<link rel='stylesheet' type='text/css' media='print' href='css/print.css' />\n";

// color por default: #748771
echo "<table class=header width=100% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr>";
echo "<td align=left><a href='index.php'><img border=0 src='$logo'></a></td>\n";

echo "    <td colspan=2 scope=col align=right valign=middle><a href='$date_link' style='color:#000000;font-family:Tahoma;font-size:10pt;
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
echo "    <td align=right valign=middle width=10><a href='index.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
        Inicio&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/magnifier.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='buscar.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Buscar&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/bricks.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='milibrero.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Librero&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/information.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='contacto.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Contacto&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

if(!isset($_SESSION['admin_user']) && !isset($_SESSION['captur_user'])){
echo "    <td align=right valign=middle width=25><img src='images/icons/arrow_rotate_clockwise.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='logout.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
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
echo "    <td align=right valign=middle width=10><a href='index.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
        Inicio&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/magnifier.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='buscar.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Buscar&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/database_go.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='agregar.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Capturar&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

if(!isset($_SESSION['admin_user'])){
echo "    <td align=right valign=middle width=25><img src='images/icons/arrow_rotate_clockwise.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='logout.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
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
echo "    <td align=right valign=middle width=10><a href='index.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
        Inicio&nbsp;&nbsp;</a></td>\n";

echo "    <td align=right valign=middle width=25><img src='images/icons/magnifier.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='buscar.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Buscar&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/application_edit.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='reports.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Reportes&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/group_add.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='adduser.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
        Usuarios&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";


echo "    <td align=right valign=middle width=25><img src='images/icons/user.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addpais.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
        Paises&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/user_green.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addciudad.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Ciudades&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/user_red.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addmateria.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Materias&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/user_orange.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addpersona.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Personas&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/user_suit.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addeditorial.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Editoriales&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/brick.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='addcategoria.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Categoria&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/report.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='sendbooks.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Publicar&nbsp;&nbsp;</a></td>\n";
echo "<td align=right valign=middle width=10></td>";

echo "    <td align=right valign=middle width=25><img src='images/icons/arrow_rotate_clockwise.png' border='0'>&nbsp;&nbsp;</td>\n";
echo "    <td align=right valign=middle width=10><a href='logout.php' style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>
		Salir&nbsp;&nbsp;</a></td>\n";

echo "</tr></table>\n";
}
// fin Administration topbar //

?>