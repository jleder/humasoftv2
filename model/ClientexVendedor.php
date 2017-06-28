<?php

class ClientexVendedor {

    //Escriba tus variables    
    private $codclv;
    private $codven;
    private $codcli;
    private $nomven;
    private $nomcli;
    private $fecapertura;
    private $compartido;
    private $comisionpaq;
    private $coduse;
    private $fecreg;
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

    function insert_clvdb01() {
        $sql = "INSERT INTO clvdb01(codcli, codven, fecapertura, compartido, comisionpaq, coduse, nomven, nomcli) values ('$this->codcli', '$this->codven', '$this->fecapertura', '$this->compartido', '$this->comisionpaq', '$this->dom_user', '$this->nomven', '$this->nomcli');";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Update
    function update_clvdb01() {
        $sql = "UPDATE clvdb01 SET "
                . "codcli = '$this->codcli', "
                . "codven = '$this->codven', "
                . "fecapertura = '$this->fecapertura', "
                . "compartido = '$this->compartido', "
                . "comisionpaq = '$this->comisionpaq', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now(), "
                . "nomven = '$this->nomven', "
                . "nomcli = '$this->nomcli' "
                . "WHERE codclv = '$this->codclv' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Eliminar

    function delete_clvdb01() {
        $sql = "DELETE FROM clvdb01 WHERE codclv = '$this->codclv' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Listar por Codigo - Metodo para Modificar

    function listarByCod() {
        $sql = "SELECT codclv, codcli, codven, fecapertura, compartido, comisionpaq, coduse, usemod, fecreg, fecmod, codcia, nomven, nomcli FROM clvdb01 WHERE codclv = '$this->codclv'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function buscarClientexVendedor() {
        $sql = "SELECT codclv, codcli, codven, fecapertura, compartido, comisionpaq, coduse, usemod, fecreg, fecmod, codcia, nomven, nomcli FROM clvdb01 WHERE codcli = '$this->codcli' AND codven = '$this->codven';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarAll() {
        $sql = "SELECT codclv, codcli, codven, fecapertura, compartido, comisionpaq, coduse, usemod, fecreg, fecmod, codcia, nomven, nomcli FROM clvdb01";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getClientesAll() {
        $sql = "select codcliente, nombre, abrev, ruc, web, telefono, direccion, ciudad, provincia, departamento, notas FROM intracliente order by nombre";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listar_aausdb01_vendedores() {
        $sql = "SELECT coduse, desuse, pwduse, fecreg, imagen, email, activo, vendedor, vc, vt, externo, store FROM aausdb01 WHERE vendedor = 'SI' ORDER BY desuse";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
