<?php

date_default_timezone_set("America/Bogota");

class C_Pagos {

    //Escriba tus variables
    private $codpago;
    private $codstore;
    private $numop;
    private $fecop;
    private $codbco;
    private $monto;
    private $moneda;
    private $depositante;
    private $obs;
    private $numcta;
    private $domuser;

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
    
    function getBancos(){
        $sql = "select codtab, codele, desele FROM altbdb01 where codele not in('', trim('01')) and codtab = 'BN' ORDER BY codele;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function generarCodPago() {
        $sql = "select codpago from pagodb01 order by fecreg desc limit 1;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista[0];
    }

    function insert_pagodb01() {
        $sql = "INSERT INTO pagodb01(codpago, codstore, numop, fecop, codbco, monto, obs, numcta, moneda, depositante, coduse) values ('$this->codpago', '$this->codstore', '$this->numop', '$this->fecop', '$this->codbco', '$this->monto', '$this->obs', '$this->numcta', '$this->moneda', '$this->depositante', '$this->domuser');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_pagodb01() {
        $sql = "UPDATE pagodb01 SET "                
                . "numop = '$this->numop', "
                . "fecop = '$this->fecop', "
                . "codbco = '$this->codbco', "
                . "monto = '$this->monto', "
                . "depositante = '$this->depositante', "
                . "obs = '$this->obs', "
                . "numcta = '$this->numcta', "
                . "fecmod = now() "
                . "WHERE codpago = '$this->codpago';";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_pagodb01() {
        $sql = "DELETE FROM pagodb01 WHERE codpago = '$this->codpago' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function getPagoByCodPago() {
        $sql = "SELECT codpago, codstore, numop, fecop, codbco, monto, obs, numcta, codele, codtab, desele, depositante, moneda
                FROM pagodb01 as p JOIN altbdb01 as b ON trim(b.codele) = p.codbco 
                WHERE codpago = '$this->codpago' AND trim(codtab) = 'BN';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function getPagoLimit20() {
        $sql = "SELECT codpago, codstore, numop, fecop, codbco, monto, obs, numcta, codele, codtab, desele, depositante, moneda
                FROM pagodb01 as p JOIN altbdb01 as b ON trim(b.codele) = p.codbco 
                WHERE codstore = '$this->codstore' AND trim(codtab) = 'BN';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}