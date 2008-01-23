<?php
	session_start();
	include('../config.inc.php');
?>
<html>
<style>
body {
	background:url(bottomrightbg.jpg);
	background-repeat: repeat-y;
}	
</style>
<style type="text/css">
<!--
#boton1 {
	height: 1px;
	width: 1px;
}
-->
</style>
<body onload="p = (document.all?document.all.mainform.p.value:mainform.p); z1 = (document.all?document.all.mainform.z1.value:mainform.z1); z2 = (document.all?document.all.mainform.z2.value:mainform.z2); pag = (document.all?document.all.mainform.pag.value:mainform.pag); marc = (document.all?document.all.mainform.marc.value:mainform.marc)">
<div align="center">
<font color="#000000" size="2">
<script language=javascript>
	function previouspage(){
		if (document.all){
			if (document.all.p.value > 1){
				document.all.p.value--;
				document.all.pag.value = document.all.p.value;
				document.mainform.submit();
			}	
		}else{
			if (p.value > 1){
				p.value--;
				pag.value = p.value;
				mainform.submit();
			}
		}	
	}

	function nextpage(){
		if (document.all){
			if (document.all.p.value < <?= $_SESSION['Pages'] ?>){
				document.all.p.value++;
				document.all.pag.value = document.all.p.value;
				document.mainform.submit();
			}
		}else{
			if (p.value < <?= $_SESSION['Pages'] ?>){
				p.value++;
				pag.value = p.value;
				mainform.submit();
			}
		}
	}

	function setpage(pg){
		if (document.all){
			document.all.p.value = pg;
			for(i=0;i<document.all.pag.length;i++){
				if(document.all.pag.options[i].value==pg){
					document.all.pag.selectedIndex = i;
				}
			}
			for(i=0;i<document.all.marc.length;i++){
				if(document.all.marc.options[i].value==pg){
					document.all.marc.selectedIndex = i;
				}
			}			
			document.mainform.submit();
		}else{
			p.value = pg;
			pag.value = pg;
			marc.value = pg;
			mainform.submit();
		}
	}

	function zoomout(){
		if (document.all){
			if (document.all.z1.value > 1){
				document.all.z2.value = document.all.z1.value;
				document.all.z1.value--;
				document.mainform.submit();
				document.all.z2.value = document.all.z1.value;
			}
		}else{
			if (z1.value > 1){
				z2.value = z1.value;
				z1.value--;
				mainform.submit();
				z2.value = z1.value;
			}
		}
	}
	
	function zoomin(){
		if (document.all){
			if (document.all.z1.value < <?= $_SESSION['max_zoom_level'] ?>)
			{
				document.all.z2.value = document.all.z1.value;
				document.all.z1.value++;
				document.mainform.submit();
				document.all.z2.value = document.all.z1.value;
			}	
		}else{
			if (z1.value < <?= $_SESSION['max_zoom_level'] ?>)
			{
				z2.value = z1.value;
				z1.value++;
				mainform.submit();
				z2.value = z1.value;
			}
		}
	}
		
	function marcador(){
		if (document.all){
			if(document.all.marc.selectedIndex+1<=0){
				document.all.marc.enabled(false);
			}else {
				document.all.marc.enabled(true);
			}
		}else{				
			if(marc.value<=0){
				marc.enabled(false);
			}else {
				marc.enabled(true);
			}
		}
	}
</script>

<font size=2>
<?php
echo "<form name=mainform action=view.php method=get target=downtarget>";
if(isset($_GET['MARCAR'])){
	$sql = "INSERT INTO marcadores (id_libro,pagina, user_) VALUES ('".$_SESSION['id']."', '".$_SESSION['pageid']."', '".$_SESSION['userid']."')";
	mysql_query($sql);
	//echo $sql."<BR>";
}
if(isset($_GET['BORRAR'])){
	/*
	echo "BORRAR "."DELETE FROM marcadores WHERE
						user_ ='".$_SESSION['userid']."'
						AND pagina = '".$_SESSION['pageid']."'
						AND id_libro = '".$_SESSION['id']."'";
	*/					
	mysql_query("DELETE FROM marcadores WHERE
						user_ ='".$_SESSION['userid']."'
						AND pagina = '".$_SESSION['pageid']."'
						AND id_libro = '".$_SESSION['id']."'");
}
	echo "<br>- ".$_SESSION['id']." -<BR>";
	echo "<BR>Página<br><SELECT NAME=pag onchange='setpage((document.all?this.options[this.selectedIndex].value:this.value))'>";
	for ($i = 1; $i <= $_SESSION['Pages']; $i++){
		//echo "<a href='javascript:setpage($i);'>P. $i</a><br>";
		if($i == $_SESSION['pageid']){
			echo "<OPTION SELECTED VALUE=".$i.">".$i."</OPTION>\n";
		}else {
			echo "<OPTION VALUE=".$i.">".$i."</OPTION>\n";
		}
	}
	echo "</SELECT><BR>"
 // <input type=hidden name="marc" value=0> 
	//echo "<br><a href='javascript:marcar();'>Marcar</a>";
?>
</font></font>
<br>
<font color="#000000"><a href="javascript:zoomin()"><img src='../images/icons/magnifier+.png' border=0></a><br><br>
<?php // Agrandar ?>
<a href="javascript:zoomout()"><img src='../images/icons/magnifier-.png' border=0></a><br><br>
<?php // Disminuir ?>

<a href="javascript:previouspage();"><img src='../images/icons/arrow_left.png' border=0></a><br><br>
<?php // Anterior ?>
<a href="javascript:nextpage();"><img src='../images/icons/arrow_right.png' border=0></a><br><br>
<?php // Siguiente ?>

	<input type=hidden name="p" value=<?= $_SESSION['pageid'] ?>>
	<input type=hidden name="z1" value=<?= $_SESSION['zoom'] ?>>
	<input type=hidden name="z2" value=1>
	
<?php
	/*
	for ($i = 1; $i <= $_SESSION['Pages']; $i++){
		echo "<a href='javascript:setpage($i);'>P. $i</a><br>";
	}
	*/
	
	$sql = "SELECT pagina FROM marcadores WHERE user_ ='".$_SESSION['userid']."' AND id_libro= '".$_SESSION['id']."'";
	$result = mysql_query($sql);
	echo "Marcadores<SELECT NAME=marc onload='marcador();'>";
	while ($marc = mysql_fetch_array($result)){
		if($marc['pagina'] == $_SESSION['pageid']){
			echo "<OPTION SELECTED VALUE=".$marc['pagina'].">".$marc['pagina']."</OPTION>\n";
		}else {
			echo "<OPTION VALUE=".$marc['pagina'].">".$marc['pagina']."</OPTION>\n";
		}
		//echo "<a href='javascript:setpage(".$marc['pagina'].");'>M. ".$marc['pagina']."</a><br>";
	}
	// en el SELECT de marcadores hacer un onload=ifmarc.value='' marc.enabled=false else true
	// cuando no haya marcadores este deshabilitado 
	echo "</SELECT><a href='javascript:setpage((document.all?document.all.marc.options[document.all.marc.selectedIndex].value:marc.value));'>ir</a>";
	echo "</FORM>";
	echo "<FORM NAME=este METHOD=get action=footer.php target=menu>";
	echo "<input name=MARCAR type=image src=marcarpagina.png onClick=document.este.MARCAR.click() style=cursor:hand><br><INPUT TYPE=submit NAME=MARCAR VALUE='' id=boton1>";
	echo "<br><input name=BORRAR type=image src=delete.gif onClick=document.este.BORRAR.click() style=cursor:hand><br><INPUT TYPE=submit NAME=BORRAR VALUE='' id=boton1>";
	echo "</FORM>";
?>
</font></div>
</body>
</html>
