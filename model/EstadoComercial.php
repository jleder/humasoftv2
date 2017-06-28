<?php

$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

class C_EstadoComercial {

    //Escriba tus variables
    private $codestado;
    private $codprop;
    private $fecha;
    private $estado;
    private $obs;
    private $dom_user;

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
    
    

    //Funcion Insertar

    function insert_propdb16() {
        $sql = "INSERT INTO propdb16(codprop, fecha, estado, obs, coduse, fecreg) values ('$this->codprop', '$this->fecha', '$this->estado', '$this->obs', '$this->dom_user', now());";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Update

    function update_propdb16() {

        $sql = "UPDATE propdb16 SET "
                . "codprop = '$this->codprop', "
                . "fecha = '$this->fecha', "
                . "estado = '$this->estado', "
                . "obs = '$this->obs', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now() "
                . "WHERE codestado = '$this->codestado' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Eliminar

    function delete_propdb16() {
        $sql = "DELETE FROM propdb16 WHERE codestado = '$this->codestado' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Listar por Codigo - Metodo para Modificar
    function listar_propdb16_by_cod() {
        $sql = "SELECT codestado, codprop, fecha, estado, obs, coduse FROM propdb16 WHERE codestado = '$this->codestado'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    //Listar Estado Comercial
    function listar_propdb16_all() {
        $sql = "SELECT codestado, codprop, fecha, estado, obs, coduse FROM propdb16 ORDER BY fecha ASC;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    //Listar todos los Estados Comerciales de una Propuesta    
    function listar_propdb16_all_by_codprop() {
        $sql = "SELECT codestado, codprop, fecha, estado, obs, coduse FROM propdb16 WHERE codprop='$this->codprop' ORDER BY fecha ASC;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function obtener_ultimo_estado_by_codprop(){
        $sql = "SELECT codestado, codprop, fecha, estado, obs, coduse FROM propdb16 where codprop = '$this->codprop' ORDER BY fecha DESC LIMIT 1;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
