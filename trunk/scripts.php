<script language='JavaScript'>

function palabras_names() {
var materias_select = document.libro.materia;
var palabras_select = document.libro.palabras;
palabras_select.options[0] = new Option("Choose One");
palabras_select.options[0].value = '';

if (materias_select.options[materias_select.selectedIndex].value != '') {
  palabras_select.length = 0;
}

<?php

$query = "select * from materias";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {
$materia_row = addslashes("".$row['nombre']."");
?>

if (materias_select.options[materias_select.selectedIndex].text == "<?php echo $materia_row; ?>") {
<?php
$query2 = "select pal_clave.* from materias, pal_clave where pal_clave.id_materia = materias.id 
           and materias.nombre = '".$materia_row."'";
$result2 = mysql_query($query2);
$opcion = "".'Todas'."";
$valor = "".'Todas'."";
echo "palabras_select.options[0] = new Option(\"Todas\");\n";
echo "palabras_select.options[0].value = \"\";\n";
$cnt = 1;

while ($row2=mysql_fetch_array($result2)) {
  $palabras = "".$row2['nombre']."";
  $ID = "".$row2['id']."";
  echo "palabras_select.options[$cnt] = new Option(\"$palabras\");\n";
  echo "palabras_select.options[$cnt].value = \"$ID\";\n";
  $cnt++;
}

?>
}
<?php
}
mysql_free_result($result);
mysql_free_result($result2);
?>

if (palabras_select.options[palabras_select.selectedIndex].value != '') {
  palabras_select.length = 0;
}
}
</script>