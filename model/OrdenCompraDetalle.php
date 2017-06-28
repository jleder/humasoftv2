<?php

class OrdenCompraDetalle {

    private $codigo;
    private $numero_oc;
    private $codprod;
    private $cantidad;
    private $umedida;
    private $cantidadp;
    private $presentacion;
    private $preciou;
    private $saldo;
    private $container;
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
    function insert_ocodb02() {
        $sql = "INSERT INTO ocodb02(numero_oc, codprod, cantidad, umedida, cantidadp, presentacion, preciou, saldo, container, coduse) values ('$this->numero_oc', '$this->codprod', '$this->cantidad', '$this->umedida', '$this->cantidadp', '$this->presentacion', '$this->preciou', '$this->saldo', '$this->container', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_ocodb02() {

        $sql = "UPDATE ocodb02 SET "
                . "numero_oc = '$this->numero_oc', "
                . "codprod = '$this->codprod', "
                . "cantidad = '$this->cantidad', "
                . "umedida = '$this->umedida', "
                . "cantidadp = '$this->cantidadp', "
                . "presentacion = '$this->presentacion', "
                . "preciou = '$this->preciou', "
                . "container = '$this->container', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now() "
                . "WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_ocodb02() {
        $sql = "DELETE FROM ocodb02 WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function deleteByNumOC() {
        $sql = "DELETE FROM ocodb02 WHERE numero_oc = '$this->numero_oc' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar
    function listarByNumOC() {
        $sql = "SELECT oc.codigo, numero_oc, codprod, p.nombre, cantidad, saldo, oc.umedida, cantidadp, presentacion, oc.preciou, container 
                FROM ocodb02 as oc JOIN alardb01 as p ON oc.codprod = p.codigo WHERE numero_oc = '$this->numero_oc' order by nombre";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function actualizarSaldo() {

        $sql = "UPDATE ocodb02 SET "
                . "saldo = '$this->saldo', "                
                . "fecmod = now() "
                . "WHERE codigo = '$this->codigo';";
        $result = $this->consultas($sql);
        return $result;
    }

}
