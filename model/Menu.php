<?php

/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

/**
 * Description of Menu
 *
 * @author Emergencia
 */
class Menu {
    //put your code here
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

    
    function getMenu($usuario, $tipo, $codpadre){
        $sql = "SELECT m.codigo, m.nombre, m.ruta, m.tipo, m.orden, m.codpadre, m.activo, es_padre,  m.icono
                FROM aampdb01 as m
                JOIN aaperdb01 as p ON p.codmenu = m.codigo
                JOIN aaroldb01 as r ON r.codrol = p.codrol
                JOIN aauxrdb01 as u ON u.codrol = r.codrol
                WHERE u.coduse = '$usuario' and m.tipo = '$tipo' and m.codpadre = $codpadre ORDER BY m.orden ASC;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
                
    }
}
