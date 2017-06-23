<?php

include '../controller/C_Solicitud.php';
$pro = new C_Propuesta;

$coduse = $_SESSION["usuario"];
$desuse = $_SESSION["nombreUsuario"];
$codprop = $_GET['cod1'];
$coditem = $_GET['cod2'];
$comentario = $_GET['cod3'];


$pro->__set('codprop', trim($codprop));
$pro->__set('coditem', trim($coditem));
$pro->__set('comentario', trim($comentario));
$pro->__set('desuse', trim($desuse));
$pro->__set('domuser', trim($coduse));

$result = $pro->insert_propdb15();
if ($result) {
    ?>
    <script>
        alert('OK :)!! El archivo se subio exitosamente.');        
    </script>            
    <?php

} else {
    ?>
    <script>alert('ERROR :(!! No se pudo subir el archivo.');</script>
    <?php

}