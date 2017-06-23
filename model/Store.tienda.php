<?php

class C_Store {

    //ATRIBUTOS PARA TIENDA
    private $codstore;
    private $codstorenew;
    private $nombre;
    private $web;
    private $telefono;
    private $abrev;
    private $zona;
    private $direccion;
    private $distrito;
    private $provincia;
    private $departamento;
    private $ruc;
    private $domuser;

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

    //OPERACIONES
    function insert_stordb01() {
        $sql = "INSERT INTO stordb01(codstore, nombre, web, telefono, abrev, zona, direccion, distrito, provincia, departamento, ruc, coduse, validado) values ('$this->codstore', '$this->nombre', '$this->web', '$this->telefono', '$this->abrev', '$this->zona', '$this->direccion', '$this->distrito', '$this->provincia', '$this->departamento', '$this->ruc', '$this->domuser', true);";
        $result = $this->consultas($sql);
        return $result;
    }

    function update_stordb01() {
        $sql = "UPDATE stordb01 SET "
                . "codstore = '$this->codstorenew', "
                . "nombre = '$this->nombre', "
                . "web = '$this->web', "
                . "telefono = '$this->telefono', "
                . "abrev = '$this->abrev', "
                . "zona = '$this->zona', "
                . "direccion = '$this->direccion', "
                . "distrito = '$this->distrito', "
                . "provincia = '$this->provincia', "
                . "departamento = '$this->departamento', "
                . "ruc = '$this->ruc', "
                . "usemod = '$this->domuser', "
                . "fecmod = now() "
                . "WHERE codstore = '$this->codstore';";
        $result = $this->consultas($sql);
        return $result;
    }

    function delete_stordb01() {
        $sql = "DELETE FROM stordb01 WHERE codstore = '$this->codstore';";
        $result = $this->consultas($sql);
        return $result;
    }

    function getStordb01bycodstore() {
        $sql = "SELECT codstore, nombre, web, telefono, abrev, zona, direccion, distrito, provincia, departamento, ruc, coduse FROM stordb01 WHERE codstore = '$this->codstore'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getStordb01all() {
        $sql = "SELECT codstore, nombre, web, telefono, abrev, zona, direccion, distrito, provincia, departamento, ruc, coduse FROM stordb01 order by nombre asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function searchStordb01bynombre() {
        $sql = "SELECT codstore, nombre, web, telefono, abrev, zona, direccion, distrito, provincia, departamento, ruc, coduse FROM stordb01 WHERE nombre ilike '%$this->nombre%' order by nombre limit 20;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}