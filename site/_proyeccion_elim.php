<?php

/* 
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */
 
 include '../controller/Proyeccion.php';
$obj = new Proyeccion();
$obj->__set('codproy', $id);
$rpta = $obj->delete();
if ($rpta){
                ?>
<div id="mensaje" class="alert alert-success">Se elimino corretamente.</div>
            <script>
            from_unico("", "divclixempleado", "_proyeccion.php");
            </script>              
    <?php  
                            
            } else { 

                ?> 

                <div class="alert alert-danger">No se pudo eliminar, debido a que este cliente tiene datos asociados.

                <a href="#" class="" onclick="cargar('#principal', '_proyeccion.php')">Volver</a></div>

                <?php


            }