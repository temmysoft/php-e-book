<?php
	session_start();
	include('../config.inc.php');
?>
<html>
<body onload="mainform = document.mainform; p = mainform.p; z1 = mainform.z1; z2 = mainform.z2; pag = mainform.pag; marc = mainform.marc">

<script language=javascript>
	function previouspage()
	{
		if (p.value > 1)
		{
			p.value--;
			pag.value = p.value;
			mainform.submit();
			
		}
	}
	function nextpage()
	{
		if (p.value < <?= $_SESSION['Pages'] ?>)
		{
			p.value++;
			pag.value = p.value;
			mainform.submit();
		}
		
		
	}
	function setpage(pg)
	{
		p.value = pg;
		pag.value = pg;
		marc.value = pg;
		mainform.submit();
	}

	function zoomout()
	{
		if (z1.value > 1)
		{
			z2.value = z1.value;
			z1.value--;
			mainform.submit();
			z2.value = z1.value;
		}
	}

	function zoomin()
	{
		if (z1.value < <?= $_SESSION['max_zoom_level'] ?>)
		{
			z2.value = z1.value;
			z1.value++;
			mainform.submit();
			z2.value = z1.value;
		}
	}
	function marcador(){
		
		if(marc.value<=0){
			
			marc.enabled(false);
		
		}else {
			marc.enabled(true);
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
	echo "Pag.<SELECT NAME=pag onchange='setpage(pag.value)'>";
	for ($i = 1; $i <= $_SESSION['Pages']; $i++){
		//echo "<a href='javascript:setpage($i);'>P. $i</a><br>";
		if($i == $_SESSION['pageid']){
			echo "<OPTION SELECTED>".$i."";
		}else {
			echo "<OPTION>".$i."";
		}
	}
	echo "</SELECT><BR>"
 // <input type=hidden name="marc" value=0> 
	//echo "<br><a href='javascript:marcar();'>Marcar</a>";
?>
</font>
<a href="javascript:zoomin()"><img src='../images/icons/magnifier+.png' border=0></a><br><?php // Agrandar ?>
<a href="javascript:zoomout()"><img src='../images/icons/magnifier-.png' border=0></a><br><?php // Disminuir ?>

<a href="javascript:previouspage();"><img src='../images/icons/arrow_left.png' border=0></a><br> <?php // Anterior ?>
<a href="javascript:nextpage();"><img src='../images/icons/arrow_right.png' border=0></a><br> <?php // Siguiente ?>

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
	echo "MARCADORES<SELECT NAME=marc onload='marcador();'>";
	while ($marc = mysql_fetch_array($result)){
		if($marc['pagina'] == $_SESSION['pageid']){
			echo "<OPTION SELECTED>".$marc['pagina']."";
		}else {
			echo "<OPTION>".$marc['pagina']."";
		}
		//echo "<a href='javascript:setpage(".$marc['pagina'].");'>M. ".$marc['pagina']."</a><br>";
	}
	// en el SELECT de marcadores hacer un onload=ifmarc.value='' marc.enabled=false else true
	// cuando no haya marcadores este deshabilitado
	echo "</SELECT><a href='javascript:setpage(marc.value);'>ir</a>";
	echo "</FORM>";
	echo "<FORM METHOD=get action=footer.php target=menu>";
	echo "<INPUT TYPE=submit NAME=BORRAR VALUE='BORRAR'>";
	echo "<INPUT TYPE=submit NAME=MARCAR VALUE='MARCAR PAGINA'>";
	echo "</FORM>";
?>
</body>
</html>