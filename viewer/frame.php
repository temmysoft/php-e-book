<HTML>
</BODY>
<script language=javascript>
	function previouspage()
	{
	
		
		if (p.value > 1)
		{
			p.value--;
			mainform.submit();
			
		}
	}
	function nextpage()
	{
	
		
		if (p.value < <?= $_SESSION['Pages'] ?>)
		{
			p.value++;
			mainform.submit();
		}
		
		
	}
	function setpage(pg)
	{
		p.value = pg;
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
	
	function marcar()
	{
		<?php
		
			$sql = "INSERT INTO marcadores (id_libro,pagina,user_) VALUES ('".$_SESSION['id']."','".$_GET['p']."','".$_SESSION['admin_user']."')";
			//mysql_query($sql,$db);
					
		?>
		marc.value = p.value;
		mainform.submit();
		
		
	}

</script>
<frameset cols="1*,100">
		<frame src="header.php">
		<frame src="footer.php">
</frameset>
</BODY>
</HTML>