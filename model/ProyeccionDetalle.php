<?php

/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

class ProyeccionDetalle {

    private $codigo;
    private $codproy;
    private $codprod;
    private $cantidad;
    private $umedida;
    private $preciou;
    private $preciot;

    public function __get($atrb) {
        return $this->$atrb;
    }

    public function __set($atrb, $val) {
        $this->$atrb = $val;
    }

    function consultas($sql) {
        $obj_conexion = new Conexion();
        return $obj_conexion->consultar($sql);
    }

    function n_Arreglo($result) {
        $lista = array();
        while ($reg = pg_fetch_array($result)) {
            array_push($lista, $reg);
        }
        return $lista;
    }

    function n_fila($result) {
        $row = pg_fetch_row($result);
        return $row;
    }
    
//    Obtener Variables de HTML
//
//
//$obj->__set('codigo', trim(strtoupper($_POST['codigo'])));
//$obj->__set('codproy', trim(strtoupper($_POST['codproy'])));
//$obj->__set('codprod', trim(strtoupper($_POST['codprod'])));
//$obj->__set('cantidad', trim(strtoupper($_POST['cantidad'])));
//$obj->__set('umedida', trim(strtoupper($_POST['umedida'])));
//$obj->__set('preciou', trim(strtoupper($_POST['preciou'])));
//$obj->__set('preciot', trim(strtoupper($_POST['preciot'])));
//$obj->__set('', trim(strtoupper($_POST[''])));
//Generar Variables de jQuery (Opcional)
//
//
//
//var codigo = $("#codigo").val();
//var codproy = $("#codproy").val();
//var codprod = $("#codprod").val();
//var cantidad = $("#cantidad").val();
//var umedida = $("#umedida").val();
//var preciou = $("#preciou").val();
//var preciot = $("#preciot").val();
//var = $("#").val();
//
//Enviar Variables
//
//'codigo': codigo,
//'codproy': codproy, 
//'codprod': codprod, 
//'cantidad': cantidad, 
//'umedida': umedida, 
//'preciou': preciou, 
//'preciot': preciot, 
    //Funcion Insertar    
    
    function insert_hs_prydb02() {
        $sql = "INSERT INTO hs_prydb02(codproy, codprod, cantidad, umedida, preciou, preciost) values ('$this->codproy', '$this->codprod', '$this->cantidad', '$this->umedida', '$this->preciou', '$this->preciost');";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Update

    function update_hs_prydb02() {

        $sql = "UPDATE hs_prydb02 SET "
                . "codproy = '$this->codproy', "
                . "codprod = '$this->codprod', "
                . "cantidad = '$this->cantidad', "
                . "umedida = '$this->umedida', "
                . "preciou = '$this->preciou', "
                . "preciot = '$this->preciot', "
                . " = '$this->' "
                . "WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Eliminar

    function delete_hs_prydb02() {

        $sql = "DELETE FROM hs_prydb02 WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Listar por Codigo - Metodo para Modificar

    function listar() {
        $sql = "SELECT codigo, codproy, codprod, cantidad, umedida, preciou, preciot, FROM hs_prydb02 WHERE codigo = '$this->codigo'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

}
