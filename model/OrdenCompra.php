<?php

class OrdenCompra {

    private $numero_oc;
    private $numero_oc_new;
    private $codproveedor;
    private $codcia;
    private $contacto;
    private $via;
    private $fpago;
    private $fecha_oc;
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

    function insert_ocodb01() {
        $sql = "INSERT INTO ocodb01(numero_oc, codproveedor, codcia, contacto, via, fpago, fecha_oc, obs, coduse) values ('$this->numero_oc', '$this->codproveedor', '$this->codcia', '$this->contacto', '$this->via', '$this->fpago', '$this->fecha_oc', '$this->obs', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Update

    function update_ocodb01() {

        $sql = "UPDATE ocodb01 SET "
                . "numero_oc = '$this->numero_oc_new',"
                . "codproveedor = '$this->codproveedor', "
                . "codcia = '$this->codcia', "
                . "contacto = '$this->contacto', "
                . "via = '$this->via', "
                . "fpago = '$this->fpago', "
                . "fecha_oc = '$this->fecha_oc', "
                . "fecmod = now(), "
                . "obs = '$this->obs', "
                . "usemod = '$this->dom_user' "
                . "WHERE numero_oc = '$this->numero_oc' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Eliminar

    function delete_ocodb01() {

        $sql = "DELETE FROM ocodb01 WHERE numero_oc = '$this->numero_oc' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Listar por Codigo - Metodo para Modificar

    function listarByNumOC() {
        $sql = "SELECT numero_oc, codproveedor, p.nombre, c.codcia, c.contacto, via, fpago, fecha_oc, obs, fecentrega, c.coduse FROM ocodb01 as c JOIN cpprdb01 as p ON c.codproveedor = p.codigo WHERE numero_oc = '$this->numero_oc'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function listarOCByNumOC() {
        //                                                                       5                                       10                                                         15
        $sql = "SELECT numero_oc, codproveedor, p.nombre, c.codcia, c.contacto, via, fpago, fecha_oc, obs, c.coduse, cia.descia, cia.dircia, cia.telcia, cia.ruccia, cia.dirent, cia.discia, cia.pais
                FROM ocodb01 as c JOIN cpprdb01 as p ON c.codproveedor = p.codigo
                JOIN bhmcdb01 as cia ON c.codcia = cia.codcia
                WHERE numero_oc = '$this->numero_oc'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarAllOC() {
        $sql = "SELECT numero_oc, codproveedor, p.nombre, c.codcia, c.contacto, via, fpago, fecha_oc, obs, c.coduse 
                FROM ocodb01 as c JOIN cpprdb01 as p ON p.codigo = c.codproveedor
                order by fecha_oc desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function listarCompania() {
        $sql = "SELECT codcia, descia, dircia, telcia, ruccia, dirent, discia, pais FROM bhmcdb01 order by descia asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
