<?php
@session_start();
date_default_timezone_set("America/Bogota");
include_once '../controller/C_Propuestas.php';
$pro = new C_Propuesta();

$codcliente = $_GET['cod'];

$pro->__set('codcliente', $codcliente);
$factores = $pro->getLast5Factores();

echo '<p>Últimas propuestas de este cliente</p>';
if(count($factores)>0){
    ?>
<table class="table table-striped" style="font-size: 10px;">        
        <tbody>
            <tr>                
                <td>Fecha: </td>
                <?php 
                    foreach ($factores as $fecha){
                        $fecreg = date("d/m/Y", strtotime($fecha['fecreg']));
                        echo '<td style="text-align: center;" >'.$fecreg.'</td>';
                    }                
                ?>                
            </tr>
            <tr>
                <td>Factor Aprobación: </td>
                <?php 
                    foreach ($factores as $factor){                        
                        echo '<td style="text-align: center; font-weight: bolder">'.$factor['fa'].'</td>';
                    }                
                ?>
            </tr>
        </tbody>
    </table>
<?php    
}else{
    echo '<p style="color:red">No existen propuestas relacionadas a este cliente en la base de datos.</p>';
}