<?php

class Movimiento {

    private $idmovimiento;
    private $idalmacen;
    private $fecmov;
    private $tipomov;
    private $transac_tipo;
    private $transac_numero;
    private $obs;
    private $estado;
    private $eliminado;
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
    function insert_movdb01() {
        $sql = "INSERT INTO movdb01(idalmacen, fecmov, tipomov, transac_tipo, transac_numero, obs, coduse) values ('$this->idalmacen', '$this->fecmov', '$this->tipomov', '$this->transac_tipo', '$this->transac_numero', '$this->obs', '$this->dom_user');"
                . "SELECT currval(pg_get_serial_sequence('movdb01','idmovimiento'));";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_movdb01() {

        $sql = "UPDATE movdb01 SET "
                . "idalmacen = '$this->idalmacen', "
                . "fecmov = '$this->fecmov', "
                . "transac_tipo = '$this->transac_tipo', "
                . "transac_numero = '$this->transac_numero', "
                . "obs = '$this->obs', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now() "
                . "WHERE idmovimiento = '$this->idmovimiento' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_movdb01() {

        $sql = "DELETE FROM movdb01 WHERE idmovimiento = '$this->idmovimiento' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar
    function listarByIDMovimiento() {
        $sql = "SELECT idmovimiento, idalmacen, fecmov, tipomov, transac_tipo, transac_numero, obs, estado, eliminado, coduse, usemod FROM movdb01 WHERE idmovimiento = '$this->idmovimiento'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarMovEntrada() {
        $sql = "SELECT idmovimiento, idalmacen, fecmov, tipomov, transac_tipo, transac_numero, obs, estado, eliminado, coduse, usemod FROM movdb01 WHERE tipomov = 'E'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarMovSalida() {
        $sql = "SELECT idmovimiento, idalmacen, fecmov, tipomov, transac_tipo, transac_numero, obs, estado, eliminado, coduse, usemod FROM movdb01 WHERE tipomov = 'S'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

}
