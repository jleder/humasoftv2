<?php

class PedidoDetalle {

    //Escriba tus variables
    private $codigo;
    private $codpedido;
    private $codprod;
    private $nomprod;
    private $cantidad;
    private $umedida;
    private $precio;
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
    function insert_peddb02() {
        $sql = "INSERT INTO peddb02(codpedido, codprod, nomprod, cantidad, umedida, precio, coduse) values ('$this->codpedido', '$this->codprod', '$this->nomprod', '$this->cantidad', '$this->umedida', '$this->precio', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_peddb02() {

        $sql = "UPDATE peddb02 SET "
                . "codpedido = '$this->codpedido', "
                . "codprod = '$this->codprod', "
                . "nomprod = '$this->nomprod', "
                . "cantidad = '$this->cantidad', "
                . "umedida = '$this->umedida', "
                . "precio = '$this->precio', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now() "
                . "WHERE codigo = '$this->codigo';";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function deletePedidoDetalleByCod() {
        $sql = "DELETE FROM peddb02 WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }
    
    //Funcion Eliminar
    function deletePedidoDetalleByCodPedido() {
        $sql = "DELETE FROM peddb02 WHERE codpedido = '$this->codpedido';";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar
    function listarPedidoDetalleByCodPedido() {
        $sql = "SELECT codigo, codpedido, codprod, nomprod, cantidad, umedida, precio, dom_user FROM peddb02 WHERE codpedido = '$this->codpedido'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function listarPedidoDetalleByCod() {
        $sql = "SELECT codigo, codpedido, codprod, nomprod, cantidad, umedida, precio, dom_user FROM peddb02 WHERE codigo = '$this->codigo'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }        

}
