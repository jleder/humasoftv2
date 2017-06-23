<?php

class C_Recurso {

    //Escriba tus variables
    private $id_recurso;
    private $nombre;
    private $tipo;
    private $orden;
    private $url;
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

    function insert_aarecurso() {
        $sql = "INSERT INTO aarecurso(nombre, tipo, orden, url, coduse) values ('$this->nombre', '$this->tipo', '$this->orden', '$this->url', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Update

    function update_aarecurso() {

        $sql = "UPDATE aarecurso SET "
                . "nombre = '$this->nombre', "
                . "tipo = '$this->tipo', "
                . "orden = '$this->orden', "
                . "url = '$this->url', "
                . "usemod = '$this->dom_user' "
                . "WHERE id_recurso = '$this->id_recurso' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Eliminar

    function delete_aarecurso() {
        $sql = "DELETE FROM aarecurso WHERE id_recurso = '$this->id_recurso' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Listar por Codigo - Metodo para Modificar

    function listar_aarecurso_by_cod() {
        $sql = "SELECT id_recurso, nombre, tipo, orden, url FROM aarecurso WHERE id_recurso = '$this->id_recurso'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function listar_aarecurso_all() {
        $sql = "SELECT id_recurso, nombre, tipo, orden, url FROM aarecurso order by fecreg ASC";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}