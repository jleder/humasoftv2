<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <title>Formulario de Registro</title>
        
    </head>
    <body>
        <form action="template.php" method="post">
            <h1>Datos de Empresa</h1>
                
            <p>Nombre Empresa: <input type="text" name="nombre" value="" /> </p>
            <p>Direccion: <input type="text" name="direccion" value="" /> </p>
            <p>Municipio: <input type="text" name="municipio" value="" /> </p>
            <p>Provincia: <input type="text" name="provincia" value="" /> </p>
            <p>Codigo Postal: <input type="text" name="codpostal" value="" /> </p>
            <p>Telefono: <input type="text" name="telefono" value="" /> </p>
            <br/>
            <input type="submit" value="Descargar Word" />
        </form>
    </body>    
</html>

