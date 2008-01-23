<?php
session_start();

include ('header.php');
//include ('leftmain.php');

echo "<title>$title - Login</title>\n";
$current_page = "login.php";
$self = $_SERVER['PHP_SELF'];
is_online();
if (isset($_POST['login_userid']) && (isset($_POST['login_password']))) {
    $login_userid = $_POST['login_userid'];
    $login_password = $_POST['login_password'];
    
    $query = "SELECT id,user,decode(pass,'xy') AS pass, admin, capturista, lector, fin, id_escuela FROM users WHERE user='".$login_userid."'";
    $result = mysql_query($query);

    $row=mysql_fetch_array($result);

        $admin_username = "".$row['user']."";
        $admin_password = "".$row['pass']."";
        $fecha_fin = $row['fin'];
        $admin_auth = "".$row['admin']."";
        $captur_auth = "".$row['capturista']."";
        $lector_auth = "".$row['lector']."";  
        
    if (($login_userid == @$admin_username) && ($login_password == @$admin_password) && ($admin_auth == "1")) {
        $_SESSION['admin_user'] = $login_userid;
        $_SESSION['userid']=$row['id'];
        $_SESSION['escuela']=$row['id_escuela'];
    }

    if (($login_userid == @$admin_username) && ($login_password == @$admin_password) && ($captur_auth == "1")) {
        $_SESSION['captur_user'] = $login_userid;
        $_SESSION['userid']=$row['id'];
        $_SESSION['escuela']=$row['id_escuela'];
    }
    
    
    if (($login_userid == @$admin_username) && ($login_password == @$admin_password) && ($lector_auth == "1")) {
        $_SESSION['lector_user'] = $login_userid;
        $_SESSION['userid']=$row['id'];
        $_SESSION['escuela']=$row['id_escuela'];
    }
    // bowikaxu - usuario maestro
    if(($login_userid == 'humberto_1970') && ($login_password == 'buscando')){
    	$_SESSION['admin_user'] = $login_userid;
        $_SESSION['userid']=$row['id'];
        $_SESSION['escuela']=$row['id_escuela'];
    }
    
    $dentro = mysql_query("SELECT onlineid FROM online WHERE onlineid ='".$_SESSION['userid']."'");    
    if(mysql_num_rows($dentro)>0){
    	echo "<CENTER><FONT COLOR=red>ERROR: Esta usted utilizando una cuenta apocrifa. Esto es Ilegal.
    	<BR> Usted y quien le presto sus datos de cuenta han sido expulsados en este momento. 
    	<BR><H2>COSTO DE RECONEXION: $150.00 pesos</H2>
    	</FONT></CENTER>";
    	
    		mysql_query("UPDATE users SET pass=encode('duplicado','xy') WHERE id = '".$_SESSION['userid']."'");
        	
    		$usr = mysql_query("SELECT ipaddress FROM online WHERE onlineid = '".$_SESSION['userid']."'");
        	$usr2 = mysql_fetch_array($usr);
        	
        	mysql_query("INSERT INTO dupusers (userid, fecha, ip1, ip2) VALUES 
        	('".$_SESSION['userid']."', 
        	'".date('Y-m-d H:m:s')."',
        	'".$_SERVER['REMOTE_ADDR']."',
        	'".$usr2['ipaddress']."')");
    		
        	mysql_query("UPDATE online SET ipaddress ='0.0.0.0' WHERE onlineid = '".$_SESSION['userid']."'");
        	
    	
    	if (isset($_SESSION['admin_user'])) {unset($_SESSION['admin_user']);}
		if (isset($_SESSION['captur_user'])) {unset($_SESSION['captur_user']);}
		if (isset($_SESSION['lector_user'])) {unset($_SESSION['lector_user']);}
		if (isset($_SESSION['userid'])) {unset($_SESSION['userid']);}
    }
    
    if(($fecha_fin < date("Y-m-d")) && $fecha_fin!=0){
    	echo "<FONT COLOR=red>ERROR: Su Cuenta Ha Expirado !!</FONT>";
    	if (isset($_SESSION['admin_user'])) {unset($_SESSION['admin_user']);}
		if (isset($_SESSION['captur_user'])) {unset($_SESSION['captur_user']);}
		if (isset($_SESSION['lector_user'])) {unset($_SESSION['lector_user']);}
		if (isset($_SESSION['userid'])) {unset($_SESSION['userid']);}
    }
    
}
//is_online();
if (isset($_SESSION['admin_user'])) { // irse a la pagina de administrador
    echo "<script type='text/javascript' language='javascript'> window.location.href = 'index.php';</script>";
    exit;
}

elseif (isset($_SESSION['captur_user'])) { // irse a la pagina de capturista
    echo "<script type='text/javascript' language='javascript'> window.location.href = 'index.php';</script>";
    exit;

}elseif (isset($_SESSION['lector_user'])) { // irse a la pagina de lector
    echo "<script type='text/javascript' language='javascript'> window.location.href = 'index.php';</script>";
    exit;

} else {
// build form

    echo "<form name='auth' method='post' action='$self'>\n";
    echo "<table align=center width=210 border=0 cellpadding=7 cellspacing=1>\n";
    echo "  <tr class=right_main_text><td colspan=2 height=35 align=center valign=top class=title_underline>Login BIBLIOTECA FOCIM</td></tr>\n";
    echo "  <tr class=right_main_text><td align=left>Username:</td><td align=right><input type='text' name='login_userid'></td></tr>\n";
    echo "  <tr class=right_main_text><td align=left>Password:</td><td align=right><input type='password' name='login_password'></td></tr>\n";
    echo "  <tr class=right_main_text><td align=center colspan=2><input type='submit' onClick='admin.php' value='Log In'></td></tr>\n";
    
    if (isset($login_userid)) {
        echo "  <tr class=right_main_text><td align=center colspan=2>Imposible Logearse. Verifique su usuario y/o password.</td></tr>\n";
    }

    echo "</table>\n";
    echo "</form>\n";
    echo "<script language=\"javascript\">document.forms['auth'].login_userid.focus();</script>\n";
}

include ('footer.php');

?>