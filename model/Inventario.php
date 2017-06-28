<?php

class Inventario {

    private $codigo;
    private $codalmacen;
    private $codprod;
    private $umedida;
    private $stock;
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

    function insert_invdb01() {
        $sql = "INSERT INTO invdb01(codalmacen, codprod, umedida, stock, coduse) values ('$this->codalmacen', '$this->codprod', '$this->umedida', '$this->stock', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

    function update_stock() {
        $sql = "UPDATE invdb01 SET "
                . "stock = '$this->stock' "
                . "WHERE codigo = '$this->codigo';";
        $result = $this->consultas($sql);
        return $result;
    }

    function existe_producto() {
        $sql = "SELECT codigo, codalmacen, codprod, umedida, stock FROM invdb01 WHERE codalmacen = '$this->codalmacen' AND codprod = '$this->codprod' AND umedida = '$this->umedida';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function getStockxAlmacen(){
        $sql = "SELECT codalmacen, codprod, p.nombre, i.umedida, stock FROM invdb01 as i JOIN alardb01 as p ON i.codprod = p.codigo WHERE codalmacen = '$this->codalmacen';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
