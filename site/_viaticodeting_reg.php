<meta name="tipo_contenido"  content="application/json;" http-equiv="content-type" charset="utf-8" />        
<?php

/* 
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

$alumno = $_GET['objeto'];

print_r($alumno);
//$alumno = json_decode($_GET['sendInfo']);
echo $alumno['Name'].'<br/>';
//echo $alumno->Address.'<br/>';
//echo $alumno->Phone.'<br/>';
echo 'Hola aqui estoy';
?>
