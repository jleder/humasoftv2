<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Producto.php';
include '../model/Propuesta.php';
include '../model/EstadoComercial.php';
include '../model/Despacho.php';
include '../model/EstadoDespacho.php';