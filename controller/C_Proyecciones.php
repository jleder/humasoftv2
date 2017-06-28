<?php

/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

include '../database/Conexion.php';
include '../model/Proyeccion.php';
include '../model/ProyeccionDetalle.php';
include '../model/Menu.php';
require_once '../model/Producto.php';

if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {

        case 'RegProyeccion':

            $msjError = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';
            $msjAdver = '<div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';
            $msjSucess = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';
            $proy = new Proyeccion();
            $detproy = new ProyeccionDetalle();

            $proyeccion_detalle = $_POST['detproducto'];
            $proyeccion = $_POST['proyeccion'];

            $proy->proy_ano = trim(strtoupper($proyeccion['ano']));
            $proy->proy_mes = trim(strtoupper($proyeccion['mes']));
            $proy->codasesor = trim(strtoupper($proyeccion['codasesor']));
            $proy->codcliente = trim(strtoupper($proyeccion['codcliente']));
            $proy->ha = trim(strtoupper($proyeccion['ha']));
            $proy->cultivo = trim(strtoupper($proyeccion['cultivo']));
            $proy->dom_user = trim(strtoupper($_SESSION['usuario']));

            $arr_codprod = $proyeccion_detalle["codprod"];
            $arr_cantprod = $proyeccion_detalle["cantidad"];
            $arr_umedida = $proyeccion_detalle["umedida"];
            $arr_preciou = $proyeccion_detalle["preciou"];

            $proy->total = $proy->calcularTotal($arr_cantprod, $arr_preciou);

//            $proy->proy_mes = trim(strtoupper($_POST['proy_mes']));
//            $proy->codasesor = trim(strtoupper($_POST['codasesor']));
//            $proy->codcliente = trim(strtoupper($_POST['codcliente']));
//            $proy->ha = trim(strtoupper($_POST['ha']));
//            $proy->cultivo = trim(strtoupper($_POST['cultivo']));
            //Obteniendo Arreglos
//            $arr_codprod = $_POST["detcodprod"];
//            $arr_cantprod = $_POST["detcanprod"];
//            $arr_umedida = $_POST["detundprod"];
//            $arr_preciou = $_POST["detpreprod"];
            //$proy->total = $proy->calcularTotal($arr_cantprod, $arr_preciou);
            //$proy->total =  trim(strtoupper($_POST['total']));
            //$detproductos = json_decode($_POST['detalleprod']);
            //$productos = json_decode(input("productos"));            
            //$codpro = $detproductos.codprod;
            $resp = $proy->insert_hs_prydb01();
            if ($resp) {

                $get_codproy = $proy->n_fila($resp);
                //echo $get_codproy[0];
                $tamanho = count($arr_codprod);
                $is_ok = true;
                for ($i = 0; $i < $tamanho; $i++) {

                    $detproy->codproy = $get_codproy[0];
                    $detproy->codprod = $arr_codprod[$i];
                    $detproy->cantidad = $arr_cantprod[$i];
                    $detproy->umedida = $arr_umedida[$i];
                    $detproy->preciou = $arr_preciou[$i];
                    $subtotal = ($arr_cantprod[$i] * $arr_preciou[$i]);
                    $detproy->preciost = $subtotal;

                    if ($detproy->insert_hs_prydb02()) {
                        
                    } else {
                        $is_ok = false;
                        break;
                    }
                }

                if ($is_ok) {
                    $msjSucess .= '<strong>OK</strong> Se registró con éxito.</div>';
                    echo $msjSucess;
                } else {
                    $msjAdver .= '<strong>ADVERTENCIA</strong> Algunos productos no se registraron. Ingrese nuevamente</div>';
                    echo $msjAdver;
                }
            } else {
                $msjError .= '<strong>Error</strong> No se pudo registrar esta proyección.</div>';
                echo $msjError;
                break;
            }
            break;
        default:
            break;
    }
}
        