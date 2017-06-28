<?php

class Ubicacion {

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

    function getDepartamentos() {
        $sql = "SELECT coddepa, departamento FROM ubdepartamento order by coddepa;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getProvByDepa($coddepa) {
        $sql = "SELECT codprov, provincia FROM ubprovincia WHERE coddepa = '$coddepa' order by provincia asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getDistByProv($codprov) {
        $sql = "SELECT coddist, distrito FROM ubdistrito WHERE codprov = '$codprov' order by distrito asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getSubZonaByZona() {
        $sql = "SELECT s.codzona, s.codsubzona, z.zona, s.subzona FROM ubsubzona as s JOIN ubzona as z ON s.codzona = z.codzona order by zona;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function getZona() {
        $sql = "SELECT codzona, zona FROM ubzona order by zona;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function getDepaProvDist() {
        $sql = "SELECT concat(d.coddepa||'-'||p.codprov||'-'||c.coddist) as codigo, concat(departamento ||' - '||provincia || ' - '||distrito) as ubicacion FROM ubdistrito as c 
                JOIN ubprovincia as p ON c.codprov = p.codprov
                JOIN ubdepartamento as d ON p.coddepa = d.coddepa order by ubicacion asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }


}
