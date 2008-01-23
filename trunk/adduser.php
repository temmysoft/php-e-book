<?php
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Usuarios</title>\n";
$current_page = "adduser.php";
$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

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
// borrar usuario

if($_POST['submit']=='borrar usuario'){
	
	$sql = "DELETE FROM users WHERE id='".$_POST['id']."'";
	$res = mysql_query($sql);
	echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>El Usuario se borro con Exito !!!</td></tr>\n";
		echo "            </table>\n";
}

// fin borrar usuario

// insert editar usuario

if($_POST['submit']=='cambiar'){
	
	$error = 0;
	if($_POST['password']!=$_POST['confirm_pass']){
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>Los Passwords no coinciden. Favor de Verificar !!!</td></tr>\n";
		echo "            </table>\n";
		if(isset($_POST['admin'])){
			$_POST['admin'] =1;
		}
		if(isset($_POST['captur'])){
			$_POST['captur'] = 1;
		}
		if(isset($_POST['lector'])){
			$_POST['lector'] = 1;
		}
		$_POST['submit']="editar usuario";
		$error = 1;
	}
	if($error==0){
		if(isset($_POST['admin'])){
			$admin =1;
		}
		if(isset($_POST['captur'])){
			$captur = 1;
		}
		if(isset($_POST['lector'])){
			$lector = 1;
		}
		if($_POST['password']==''){
			$sql = "UPDATE users SET nombre ='".$_POST['nombre']."',
				user='".$_POST['user']."', admin='".$admin."', capturista='".$captur."', lector='".$lector."', 
				inicio='".$_POST['fecha_inicio']."', fin='".$_POST['fecha_fin']."', id_escuela = '".$_POST['escuela']."' 
				WHERE id='".$_POST['id']."'";
		}else {
			$sql = "UPDATE users SET nombre ='".$_POST['nombre']."',  pass=encode('".$_POST['password']."','xy'),
				user='".$_POST['user']."', admin='".$admin."', capturista='".$captur."', lector='".$lector."', 
				inicio='".$_POST['fecha_inicio']."', fin='".$_POST['fecha_fin']."', id_escuela = '".$_POST['escuela']."' 
				WHERE id='".$_POST['id']."'";
		}
		$res = mysql_query($sql);
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>El Usuario se Actulizo con Exito !!!</td></tr>\n";
		echo "            </table>\n";
		
	}
	
}

// fin insert editar usuario

// editar usuario

if($_POST['submit']=='editar usuario'){
	
	$error = 0;
	$sql = "SELECT * FROM users WHERE id ='".$_POST['id']."'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)<1){
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>Usuario Invalido !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
		
	}
	
	if($error == 0){
		
		$user = mysql_fetch_array($result);
		
	echo "            <br />\n";
	echo "            <form name='user' action='adduser.php' method='post'>\n";
	echo "				<input type='hidden' name='id' value='".$user['id']."'>";
	echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
	echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/user_add.png' />&nbsp;&nbsp;&nbsp;Agregar Usuario</th></tr>\n";
	echo "              <tr><td height=15></td></tr>\n";

	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nombre:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='100' name='nombre' value='".$user['nombre']."'>&nbsp;*</td></tr>\n";

	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Usuario:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='49' name='user' value='".$user['user']."'>&nbsp;*</td></tr>\n";

	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Password:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='password' 
                      size='30' maxlength='49' name='password'>&nbsp;*</td></tr>\n";

	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Confirmar Password:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='password' 
                      size='30' maxlength='49' name='confirm_pass'>&nbsp;*</td></tr>\n";

	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Escuela:</td>
						<td colspan=2 width=80% style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>";
						$sql = "SELECT * FROM escuelas ORDER BY nombre";
						$res = mysql_query($sql);
	echo "				<SELECT NAME='escuela'>";
						while($escuelas = mysql_fetch_array($res)){
							if($escuelas['id']==$user['id_escuela']){
								echo "<OPTION SELECTED VALUE='".$escuelas['id']."'>".$escuelas['nombre'];
							}else {
								echo "<OPTION VALUE='".$escuelas['id']."'>".$escuelas['nombre'];
							}
						}
	echo "				</SELECT>&nbsp;*
						</td></tr>\n";
	
	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Fecha Inicio:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='fecha_inicio' value='".$user['inicio']."'>&nbsp;*</td></tr>\n";
	
	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Fecha Termino:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='fecha_fin' value='".$user['fin']."'>&nbsp;*</td></tr>\n";

	if($user['admin']==1){
	echo "              <td style='font-family:Arial;font-size:13px;'>
				<input type='checkbox' name='admin' CHECKED>Administrador</td>\n";
	}else {
		echo "              <td style='font-family:Arial;font-size:13px;'>
				<input type='checkbox' name='admin'>Administrador</td>\n";
	}

	if($user['capturista']==1){
	echo "              <td style='font-family:Arial;font-size:13px;'>
				<input type='checkbox' name='captur' CHECKED>Capturista</td>\n";
	}else{
		echo "              <td style='font-family:Arial;font-size:13px;'>
				<input type='checkbox' name='captur'>Capturista</td>\n";
	}

	if($user['lector']==1){
	echo "              <td style='font-family:Arial;font-size:13px;'>
				<input type='checkbox' name='lector' CHECKED>Lector</td>\n";
	}else {
		echo "              <td style='font-family:Arial;font-size:13px;'>
				<input type='checkbox' name='lector'>Lector</td>\n";
	}

	echo "            </table>\n";
	echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
	echo "              <tr><td height=15></td></tr>\n";
	echo "            </table>\n";
	echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
	echo "              <tr><td width=30><input type='submit' name='submit' value='cambiar' src='images/buttons/next_button.png'></td>
                  <td><a href='adduser.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
	echo "</table>";
	exit;

		
	}
	
}

// fin editar usuario

// insert del usuario

if($_POST['submit']=='agregar usuario'){
	
	$user = $_POST['user'];
	$pass = $_POST['password'];
	$confpass = $_POST['confirm_pass'];
	$error = 0;
	if(empty($_POST['user'])){
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>Usuario Invalido !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	}
	
	if(empty($pass) || empty($confpass)){
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>Verifique su Password !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
	}
	
	if($pass != $confpass){
		
		echo "<BR>";
		echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
		echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>Los Password no coinciden, intente de nuevo !!!</td></tr>\n";
		echo "            </table>\n";
		$error = 1;
		
	}
	
	$sql = "SELECT user FROM users";
	$result = mysql_query($sql);
	while ($users = mysql_fetch_array($result)){
		
		if($users['user']==$user){
			echo "<BR>";
			echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
			echo "              <tr><td class=table_rows align=center colspan=3 style='color:red;font-family:Arial;font-size:12px;'>El Usuario Ya Existe !!!</td></tr>\n";
			echo "            </table>\n";
			$error = 1;
		}
		
	}
	
	if($error == 0){ // realizar inserts, todo correcto
		
		$admin = 0;
		$captur = 0;
		$lector = 0;
		
		if(isset($_POST['admin'])){
			$admin = 1;
		}
		if(isset($_POST['captur'])){
			$captur = 1;
		}
		if(isset($_POST['lector'])){
			$lector = 1;
		}
		//$passfinal = crypt($pass, '1234567890');
		$sql = "INSERT INTO users (nombre, user, pass, admin, capturista, lector, inicio, fin, id_escuela) VALUES (
				'".$_POST['nombre']."',
				'".$user."',
				encode('".$pass."','xy'),
				'".$admin."',
				'".$captur."',
				'".$lector."',
				'".$_POST['fecha_inicio']."',
				'".$_POST['fecha_fin']."',
				'".$_POST['escuela']."'
				)";
		$res = mysql_query($sql);
		echo "<BR>";
			echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
			echo "              <tr><td class=table_rows align=center colspan=3 style='color:green;font-family:Arial;font-size:12px;'>El Usuario Se Agrego Con Exito !!!</td></tr>\n";
			echo "            </table>\n";
			unset($_POST['nombre']);
			unset($_POST['user']);
			unset($_POST['password']);
			unset($_POST['confirm_pass']);
			unset($_POST['admin']);
			unset($_POST['captur']);
			unset($_POST['lector']);
			unset($_POST['escuela']);
		
	}
	
}

// fin insert del usuario
echo "            <br />\n";
echo "            <form name='user' action='$current_page' method='post'>\n";
echo "<table align=center class=table_border><form method='post' action='$current_page'>";
$sql = "SELECT * FROM users";
$result = mysql_query($sql);
echo '<tr><td><STRONG>VERIFICADOR</STRONG></td><td><select id="usuario" acdropdown=true style="width:300px;" autocomplete_complete="false" autocomplete_onselect="alertSelected" name="id">';
while($user = mysql_fetch_array($result)){
	echo "<option value='".$user['id']."'>".$user['nombre']."</option>\n";
}
echo "</select></td><td><input type='submit' name='submit' src='images/icons/arrow_right.png' value='editar usuario'><input type='submit' name='submit' src='images/icons/delete.png' value='borrar usuario'></td></tr></form></table><br><br>";

// agregar usuario
echo "            <form name='user' action='$current_page' method='post'>\n";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/user_add.png' />&nbsp;&nbsp;&nbsp;Agregar Usuario</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Nombre:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='100' name='nombre' value='".$_POST['nombre']."'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Usuario:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='user' value='".$_POST['user']."'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Password:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='password' 
                      size='30' maxlength='31' name='password'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Comfirmar Password:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='password' 
                      size='30' maxlength='31' name='confirm_pass'>&nbsp;*</td></tr>\n";

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Escuela:</td>
						<td colspan=2 width=80% style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>";
						$sql = "SELECT * FROM escuelas ORDER BY nombre";
						$res = mysql_query($sql);
	echo "				<SELECT NAME='escuela'>";
						while($escuelas = mysql_fetch_array($res)){
								echo "<OPTION VALUE='".$escuelas['id']."'>".$escuelas['nombre'];
						}
	echo "				</SELECT>&nbsp;*
						</td></tr>\n";

	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Fecha Inicio:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='fecha_inicio' value='".date("Y-m-d")."'>&nbsp;*</td></tr>\n";
	
	echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Fecha Termino:</td><td colspan=2 width=80%
                      style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'><input type='text' 
                      size='30' maxlength='31' name='fecha_fin'>&nbsp;*</td></tr>\n";

echo "              <td style='font-family:Arial;font-size:13px;'>
				<input type='checkbox' name='admin'>Administrador</td>\n";

echo "              <td style='font-family:Arial;font-size:13px;'>
				<input type='checkbox' name='captur'>Capturista</td>\n";

echo "              <td style='font-family:Arial;font-size:13px;'>
				<input type='checkbox' name='lector'>Lector</td>\n";

echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=40% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='submit' name='submit' value='agregar usuario' src='images/buttons/done_button.png'></td>
                  <td><a href='index.php'><img src='images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
echo "</table></form>";
// fin agregar usuario

// LINK ALTA MASIVA DE USUARIOS
echo "            <br />\n";
echo "            <table align=center class=table_border width=40% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3>
                      <img src='images/icons/user_add.png' />&nbsp;&nbsp;&nbsp;Alta Masiva de Usuarios</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";

echo "              <tr><td align=center colspan=2 width=100% style='color:red;font-family:Arial;font-size:10px;padding-left:20px;'>
                      <a href='importusers.php'>IMPORTAR USUARIOS</a>
                      </td></tr>\n";

echo "            </table>\n";

include ('footer.php');
?>

