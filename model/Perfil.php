<?php

class C_Perfil {

    //Escriba tus variables
    private $id_perfil;
    private $nombre;
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
    function insert_aaperfil() {
        $sql = "INSERT INTO aaperfil(nombre, obs, coduse) values ('$this->nombre', '$this->obs', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_aaperfil() {

        $sql = "UPDATE aaperfil SET "
                . "nombre = '$this->nombre', "
                . "obs = '$this->obs', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now()"
                . "WHERE id_perfil = '$this->id_perfil';";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_aaperfil() {

        $sql = "DELETE FROM aaperfil WHERE id_perfil = '$this->id_perfil' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar
    function listar_aaperfil_by_cod() {
        $sql = "SELECT id_perfil, nombre, obs, coduse FROM aaperfil WHERE id_perfil = '$this->id_perfil'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function listar_aaperfil_all() {
        $sql = "SELECT id_perfil, nombre, obs, coduse FROM aaperfil;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }   

}