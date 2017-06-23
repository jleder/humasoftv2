<?php

class C_Usuario {

    //put your code here

    private $usuario;
    private $clave;
    private $correo;
    private $foto;    
    private $newcoduse;
    private $coduse;
    private $desuse;
    private $pwduse;    
    private $imagen;
    private $email;
    private $activo;
    private $vendedor;
    private $vc;
    private $vt;
    private $externo;
    private $store;

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

    function insert_aausdb01() {
        $sql = "INSERT INTO aausdb01(coduse, desuse, pwduse, fecreg, email, activo, vendedor, vc, vt, externo, store) values ('$this->coduse', '$this->desuse', '$this->pwduse', now(), '$this->email', true, '$this->vendedor', '$this->vc', '$this->vt', '$this->externo', '$this->store');";
        $result = $this->consultas($sql);
        return $result;
    }
    
    function insert_aausdb012() {
        $sql = "INSERT INTO aausdb01(coduse, desuse, pwduse, fecreg) values ('$this->coduse', '$this->desuse', '$this->pwduse', now());";
        $result = $this->consultas($sql);
        return $result;
    }

    function update_aausdb01() {

        $sql = "UPDATE aausdb01 SET "
                . "coduse = '$this->newcoduse', "
                . "desuse = '$this->desuse', "
                . "pwduse = '$this->pwduse', "
                . "fecmod = now(), "
                . "imagen = '$this->imagen', "
                . "email = '$this->email', "
                . "activo = '$this->activo', "
                . "vendedor = '$this->vendedor', "
                . "vc = '$this->vc', "
                . "vt = '$this->vt', "
                . "externo = '$this->externo', "
                . "store = '$this->store' "
                . "WHERE coduse = '$this->coduse' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Eliminar

    function delete_aausdb01() {

        $sql = "DELETE FROM aausdb01 WHERE coduse = '$this->coduse' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar
    function listar_aausdb01_by_cod() {
        $sql = "SELECT coduse, desuse, pwduse, fecreg, imagen, email, activo, vendedor, vc, vt, externo, store FROM aausdb01 WHERE coduse = '$this->coduse'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listar_aausdb01_todos() {
        $sql = "SELECT coduse, desuse, pwduse, fecreg, imagen, email, activo, vendedor, vc, vt, externo, store FROM aausdb01";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
   

    function conect_info() {
        $sql = "select user(), connection_id(), version(), database();";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function mostrar_Uno() {
        $sql = "SELECT coduse, desuse, pwduse, imagen, email FROM aausdb01  where coduse = '$this->usuario'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function mostrarUsuario_Uno() {
        $sql = "SELECT coduse, desuse, pwduse, imagen, email FROM aausdb01  where coduse = '$this->usuario'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function actualizarUsuario() {
        $sql = "UPDATE aausdb01 SET "
                . "pwduse = '$this->clave',"
                . "imagen = '$this->foto',"
                . "email = '$this->correo'"
                . "where coduse = '$this->usuario'";
        $result = $this->consultas($sql);
        return $result;
    }

}