<?php
/*


*/
session_start();
include ('header.php');
echo "<title>$title - Reportes</title>\n";
$current_page = "reports.php";

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
//include ('config.inc.php');

echo "<link rel='stylesheet' type='text/css' media='screen' href='css/default.css' />\n";
	echo "            <br />\n";
	echo "            <form name='user' action='$current_page' method='post'>\n";
	echo "				<input type='hidden' name='id' value='".$user['id']."'>";
	echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
	echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/report.png' />&nbsp;&nbsp;&nbsp;Reportes</th></tr>\n";
	echo "              <tr><td height=15></td></tr>\n";

	// reporte libros
	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>
						<LI><a href='report_libros.php'>Libros Completo ordenado por ID</a>
						</td></tr>\n";
	// reporte revistas
	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>
						<LI><a href='report_revistas.php'>Revistas Completo ordenado por ID</a>
						</td></tr>\n";
	// reporte donadores
	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>
						<LI><a href='report_donadores.php'>Libros y Revistas por Donadores</a>
						</td></tr>\n";
	// final tabla
	echo "            </table>\n";
	echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
	echo "              <tr><td height=15></td></tr>\n";
	echo "            </table>\n";


include ('footer.php');
?>