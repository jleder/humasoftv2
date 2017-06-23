<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViaticoDet
 *
 * @author Emergencia
 */
class ViaticoDet {

    //put your code here
    //Declaracion de Variables

    private $coddetalle;
    private $codviatico;
    private $codtipo;
    private $fecha;
    private $doctipo;
    private $docnum;
    private $proveedor;
    private $concepto;
    private $valor;
    private $igv;
    private $valigv;
    private $pventa;
    private $codzona;
    private $nomzona;
    private $codsubzona;
    private $nomsubzona;
    private $dist;
    private $prov;
    private $dep;
    private $dom_user;
    //Variables para Combustible
    private $codigo; //Codigo de Combustible    
    private $vehiculo;
    private $kmcierre;
    private $kmrecorrido;
    private $galones;
    private $pgalon;
    private $placa;

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
    
    //Proximo id autoincrementable
    function nextval(){        
        //https://www.postgresql.org/docs/8.1/static/functions-sequence.html
        //currval(regclass)
        //lastval()
        //setval(regclass, bigint), etc
        $sql = "select nextval('hs_vtcdb02_coddetalle_seq');";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista[0];
    }    

    //Funcion Insertar
    function insert_hs_vtcdb02() {
        $sql = "INSERT INTO hs_vtcdb02(coddetalle, codviatico, codtipo, fecha, doctipo, docnum, proveedor, concepto, valor, igv, valigv, pventa, codzona, nomzona, codsubzona, nomsubzona, dist, prov, dep, coduse) values ('$this->coddetalle', '$this->codviatico', '$this->codtipo', '$this->fecha', '$this->doctipo', '$this->docnum', '$this->proveedor', '$this->concepto', '$this->valor', '$this->igv', '$this->valigv', '$this->pventa', $this->codzona, '$this->nomzona', $this->codsubzona, '$this->nomsubzona', $this->dist, $this->prov, $this->dep, '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_hs_vtcdb02() {

        $sql = "UPDATE hs_vtcdb02 SET "
                . "codviatico = '$this->codviatico', "
                . "codtipo = '$this->codtipo', "
                . "fecha = '$this->fecha', "
                . "doctipo = '$this->doctipo', "
                . "docnum = '$this->docnum', "
                . "proveedor = '$this->proveedor', "
                . "concepto = '$this->concepto', "
                . "valor = '$this->valor', "
                . "igv = '$this->igv', "
                . "valigv = '$this->valigv', "
                . "pventa = '$this->pventa', "
                . "codzona = '$this->codzona', "
                . "nomzona = '$this->nomzona', "
                . "codsubzona = '$this->codsubzona', "
                . "nomsubzona = '$this->nomsubzona', "
                . "dist = '$this->dist', "
                . "prov = '$this->prov', "
                . "dep = '$this->dep', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now()"
                . "WHERE coddetalle = '$this->coddetalle' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Eliminar

    function delete_hs_vtcdb02() {

        $sql = "DELETE FROM hs_vtcdb02 WHERE coddetalle = '$this->coddetalle' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Listar por Codigo - Metodo para Modificar

    function listarDetalleViaticoByCod() {
        $sql = "SELECT coddetalle, codviatico, codtipo, fecha, doctipo, docnum, proveedor, concepto, valor, igv, valigv, pventa, codzona, nomzona, codsubzona, nomsubzona, dist, prov, dep FROM hs_vtcdb02 WHERE coddetalle = '$this->coddetalle'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function listarDetalleViaticoByCodViatico() {
        $sql = "SELECT coddetalle, codviatico, codtipo, desele, fecha, doctipo, docnum, proveedor, concepto, valor, igv, valigv, pventa, codzona, nomzona, codsubzona, nomsubzona, dist, prov, dep 
                FROM hs_vtcdb02 as v
                JOIN altbdb01 as t ON t.codele = v.codtipo
                WHERE codtab = 'TV' and codviatico = '$this->codviatico' order by fecha asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function listarDetalleViaticoCombByCodViatico() {
        $sql = "SELECT v.coddetalle, codviatico, codtipo, desele, fecha, doctipo, docnum, proveedor, concepto, valor, igv, valigv, pventa, codzona, nomzona, codsubzona, nomsubzona, dist, prov, dep, kmcierre, kmrecorrido, galones, pgalon, placa
                FROM hs_vtcdb02 as v
                JOIN altbdb01 as t ON t.codele = v.codtipo
                JOIN hs_vtcdb03 as c ON c.coddetalle = v.coddetalle
                WHERE codtab = 'TV' and codviatico = '$this->codviatico' and codele = '01' order by fecha asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function listarEgresosxClasificacion() {
        $sql = "SELECT codtipo, sum(valor), sum(valigv), sum(pventa)
                FROM hs_vtcdb02 as v
                JOIN altbdb01 as t ON t.codele = v.codtipo
                WHERE codtab = 'TV' and codviatico = '$this->codviatico' and codtipo = '$this->codtipo' group by codtipo order by codtipo asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    

    //Funcion Insertar Combustible
    function insert_hs_vtcdb03() {
        $sql = "INSERT INTO hs_vtcdb03(coddetalle, vehiculo, kmcierre, kmrecorrido, galones, pgalon, placa) values ('$this->coddetalle', '$this->vehiculo', '$this->kmcierre', '$this->kmrecorrido', '$this->galones', '$this->pgalon', '$this->placa');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_hs_vtcdb03() {
        $sql = "UPDATE hs_vtcdb03 SET "
                . "coddetalle = '$this->coddetalle', "
                . "vehiculo = '$this->vehiculo', "
                . "kmcierre = '$this->kmcierre', "
                . "kmrecorrido = '$this->kmrecorrido', "
                . "galones = '$this->galones', "
                . "pgalon = '$this->pgalon', "
                . "placa = '$this->placa' "
                . "WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_hs_vtcdb03() {
        $sql = "DELETE FROM hs_vtcdb03 WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar

    function listarCombustible() {
        $sql = "SELECT codigo, coddetalle, vehiculo, kmcierre, kmrecorrido, galones, pgalon, FROM hs_vtcdb03 WHERE codigo = '$this->codigo'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

}
