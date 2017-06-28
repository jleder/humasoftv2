<?php

/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

/**
 * Description of C_Rol
 *
 * @author Emergencia
 */
class Rol {
    //put your code here
    
    
    public function __get($atrb) {
        return $this->$atrb;
    }

    public function __set($atrb, $val) {
        $this->$atrb = $val;
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

    function consultas($sql) {
        $obj_conexion = new Conexion();
        return $obj_conexion->consultar($sql);
    }
    
    function getRolAll() {
        $sql = "select codrol, descripcion from aaroldb01 order by descripcion;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
}
