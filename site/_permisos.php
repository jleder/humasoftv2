<?php
/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */
require_once '../controller/C_Permisos.php';

$obj = new Permiso();
?>
<!doctype html>
<html lang="es">
    <head>
    </head>
    <body>
        
        <ul>
            <li><input name="menu1[]" type="checkbox" value="1" /> Visitas 
                <ul>
                    <li><input name="menu2[]" type="checkbox" value="5" /> Tecnico</li>
                    <li><input name="menu2[]" type="checkbox" value="8" /> Comercial</li>
                </ul>
            </li>
            <li><input name="menu1[]" type="checkbox" value="1" /> Propuestas
                <ul>
                    <li><input name="menu2[]" type="checkbox" value="1" /> Tecnico</li>
                    <li><input name="menu2[]" type="checkbox" value="1" /> Comercial</li>
                </ul>
            </li>
        </ul>

    </body>

</html>


