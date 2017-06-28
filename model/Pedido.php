<?php

class Pedido {

    private $codpedido;
    private $codcli;
    private $ruc;
    private $nomcliente;
    private $telefono;
    private $dircli;
    private $contacto;
    private $numero_oc;
    private $fecoc;
    private $fecpedido;
    private $fpago;
    private $codven;
    private $nomven;
    private $tipodcto;
    private $descuento;
    private $subtotal;    
    private $valorventa;
    private $igv;
    private $flete;
    private $totalpagar;
    private $fau;
    private $lugar_entrega;
    private $detalle_entrega;
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
    function insert_peddb01() {
        $sql = "INSERT INTO peddb01(codpedido, codcli, ruc, nomcliente, telefono, dircli, contacto, numero_oc, fecoc, fecpedido, fpago, codven, nomven,  tipodcto, descuento, subtotal, igv, flete, totalpagar, lugar_entrega, detalle_entrega, obs, coduse, valorventa, fau) values ('$this->codpedido', '$this->codcli', '$this->ruc', '$this->nomcliente', '$this->telefono', '$this->dircli', '$this->contacto', '$this->numero_oc', '$this->fecoc', '$this->fecpedido', '$this->fpago', '$this->codven', '$this->nomven', '$this->tipodcto', '$this->descuento', '$this->subtotal', '$this->igv', '$this->flete', '$this->totalpagar', '$this->lugar_entrega', '$this->detalle_entrega', '$this->obs', '$this->dom_user', '$this->valorventa', '$this->fau');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_peddb01() {

        $sql = "UPDATE peddb01 SET "
                . "codpedido = '$this->codpedidonew', "
                . "codcli = '$this->codcli', "
                . "ruc = '$this->ruc', "
                . "nomcliente = '$this->nomcliente', "
                . "telefono = '$this->telefono', "
                . "dircli = '$this->dircli', "
                . "contacto = '$this->contacto', "
                . "numero_oc = '$this->numero_oc', "
                . "fecoc = '$this->fecoc', "
                . "fecpedido = '$this->fecpedido', "
                . "fpago = '$this->fpago', "
                . "codven = '$this->codven', "
                . "nomven = '$this->nomven', "
                . "tipodcto = '$this->tipodcto', "
                . "descuento = '$this->descuento', "
                . "subtotal = '$this->subtotal', "
                . "igv = '$this->igv', "
                . "flete = '$this->flete', "
                . "fau = '$this->fau', "
                . "totalpagar = '$this->totalpagar', "
                . "lugar_entrega = '$this->lugar_entrega', "
                . "detalle_entrega = '$this->detalle_entrega', "
                . "obs = '$this->obs', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now() "
                . "WHERE codpedido = '$this->codpedido';";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_peddb01() {
        $sql = "DELETE FROM peddb01 WHERE codpedido = '$this->codpedido' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar
    function listarPedidoByCod() {
        $sql = "SELECT codpedido, codcli, ruc, nomcliente, telefono, dircli, contacto, numero_oc, fecoc, fecpedido, fpago, codven, nomven, tipodcto, descuento, subtotal, igv, flete, totalpagar, lugar_entrega, detalle_entrega, obs, coduse, fau FROM peddb01 WHERE codpedido = '$this->codpedido'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function listarPedidoAll() {
        $sql = "SELECT codpedido, codcli, ruc, nomcliente, telefono, dircli, contacto, numero_oc, fecoc, fecpedido, fpago, codven, nomven, tipodcto, descuento, subtotal, igv, flete, totalpagar, lugar_entrega, detalle_entrega, obs, coduse, fau FROM peddb01;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
}
