<?php

class ClientexVendedorCompartido {

    private $codigo;
    private $codclv;
    private $codven;
    private $nomven;
    private $comisionpaq;
    private $comisionpud;
    private $obs;
    private $dom_user;
    private $codcia;

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
    function insert_clvdb02() {
        $sql = "INSERT INTO clvdb02(codclv, codven, nomven, comisionpaq, obs, coduse) values ('$this->codclv', '$this->codven', '$this->nomven', '$this->comisionpaq', '$this->obs', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_clvdb02() {
        $sql = "UPDATE clvdb02 SET "
                . "codclv = '$this->codclv', "
                . "codven = '$this->codven', "
                . "nomven = '$this->nomven', "
                . "comisionpaq = '$this->comisionpaq', "
                . "obs = '$this->obs', "
                . "fecmod = now(), "
                . "usemod = '$this->dom_user' "
                . "WHERE codigo = '$this->codigo';";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_clvdb02() {
        $sql = "DELETE FROM clvdb02 WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar
    function listarByCod() {
        $sql = "SELECT codigo, codclv, codven, nomven, comisionpaq, comisionpud, obs, fecreg, fecmod, coduse, usemod, codcia FROM clvdb02 WHERE codigo = '$this->codigo'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarAll() {
        $sql = "SELECT codigo, codclv, codven, nomven, comisionpaq, comisionpud, obs, fecreg, fecmod, coduse, usemod, codcia FROM clvdb02 WHERE codigo = '$this->codigo'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarByCodClv() {
        $sql = "SELECT codigo, codclv, codven, nomven, comisionpaq, comisionpud, obs, fecreg, fecmod, coduse, usemod, codcia FROM clvdb02 WHERE codclv = '$this->codclv'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
