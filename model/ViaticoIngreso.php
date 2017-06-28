<?php

/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

/**
 * Description of ViaticoIngreso
 *
 * @author Emergencia
 */
class ViaticoIngreso {

    //put your code here
    private $codigo;
    private $codviatico;
    private $codsession;
    private $fecha;
    private $descripcion;
    private $valor;
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
    
    function insert_hs_vtcdb04() {
        $sql = "INSERT INTO hs_vtcdb04(codviatico, fecha, descripcion, valor, coduse) values ('$this->codviatico', '$this->fecha', '$this->descripcion', '$this->valor', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

    function insert_hs_vtcdb04_temp() {
        $sql = "INSERT INTO hs_vtcdb04_temp(codsession, fecha, descripcion, valor, coduse) values ('$this->codsession', '$this->fecha', '$this->descripcion', '$this->valor', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Update

    function update_hs_vtcdb04_temp() {

        $sql = "UPDATE hs_vtcdb04_temp SET "
                . "codsession = '$this->codsession', "
                . "fecha = '$this->fecha', "
                . "descripcion = '$this->descripcion', "
                . "valor = '$this->valor', "
                . "dom_user = '$this->dom_user', "                
                . "WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Eliminar

    function delete_hs_vtcdb04_temp() {

        $sql = "DELETE FROM hs_vtcdb04_temp WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Listar por Codigo - Metodo para Modificar

    function listar() {
        $sql = "SELECT codigo, codsession, fecha, descripcion, valor, coduse FROM hs_vtcdb04_temp WHERE codigo = '$this->codigo'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function listarIngresosByCodviatico() {
        $sql = "SELECT codigo, codviatico, fecha, descripcion, valor, coduse FROM hs_vtcdb04 WHERE codviatico = '$this->codviatico' order by fecha asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
