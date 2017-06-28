<?php

class C_Despacho {

    private $coddesp;
    private $codprop;
    private $fecprev;
    private $prioridad;
    private $orden;
    private $fecinicio;
    private $atendidopor;
    private $domuser; //coduse y usemod
    private $descripcion;
    private $montodesp;
    private $saldo;
    private $moneda;
    private $obs;

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

    function generarCodDespacho() {
        $sql = "select coddesp from despdb01 group by coddesp, fecreg ORDER BY fecreg desc limit 1;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $nsp = $lista[0];
        $numero = ($nsp) + 1;
        $num = ($numero);
        $existe = 1;
        while ($existe != 0) {
            $existe = $this->validarCodDesp($num);
            if ($existe != 0) {
                $numero++;
                $num = (1 + $numero);
            }
        }
        return $num;
    }

    function validarCodDesp($num) {
        $sql = "select count(coddesp) from despdb01 where coddesp = '$num';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $rpta = trim($lista[0]);
        return $rpta;
    }

//    function insertarDespachoDefault() {
//        $sql = "INSERT INTO propdb02(coddesp, codprop, fecha, estado, obs, coduse, activo) values ('$this->coddesp', '$this->codprop', '$this->fecha', 'EN OFICINA', 'NINGUNA', '$this->domuser', '1');";
//        $result = $this->consultas($sql);
//        return $result;
//    }
//
//    function insertarEstadoDepacho() {
//        $sql = "INSERT INTO propdb02(coddesp, codprop, fecha, estado, obs, activo, coduse) values ('$this->coddesp', '$this->codprop', '$this->fecha', '$this->estado', '$this->obs', '1', '$this->domuser');";
//        $result = $this->consultas($sql);
//        return $result;
//    }
//
//    function insertarDetalleDepacho() {
//        $sql = "INSERT INTO propdb02(coddesp, codprop, fecha, estado, obs, activo, coduse) values ('$this->coddesp', '$this->codprop', '$this->fecha', '$this->estado', '$this->obs', '1', '$this->domuser');";
//        $result = $this->consultas($sql);
//        return $result;
//    }

    function registrarDespacho() {
        $sql = "INSERT INTO despdb01(coddesp, codprop, fecprev, prioridad, coduse, fecreg, montodesp, saldo, moneda, descripcion, obs) values ('$this->coddesp', '$this->codprop', '$this->fecprev', '$this->prioridad', '$this->domuser', 'now()', $this->montodesp, $this->saldo, '$this->moneda',  '$this->descripcion', '$this->obs');";
        $result = $this->consultas($sql);
        return $result;
    }

    function modificarDespacho() {
        $sql = "UPDATE despdb01 SET "
                . "codprop = '$this->codprop', "
                . "fecprev = '$this->fecprev', "
                . "prioridad = '$this->prioridad', "
                . "montodesp = $this->montodesp, "
                . "saldo = $this->saldo, "
                . "moneda = '$this->moneda', "
                . "descripcion = '$this->descripcion', "
                . "obs = '$this->obs', "
                . "usemod = '$this->domuser', "
                . "fecmod = 'now()' "
                . "WHERE coddesp = '$this->coddesp' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function eliminarDespacho() {
        $sql = "DELETE FROM despdb01 WHERE coddesp = '$this->coddesp' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function eliminarDespachoByCodprop() {
        $sql = "DELETE FROM despdb01 WHERE codprop = '$this->codprop' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function despachosByCodprop() {
        $sql = "SELECT coddesp, codprop, prioridad, fecprev, descripcion, obs, montodesp, saldo, moneda, fecreg FROM despdb01 WHERE codprop = '$this->codprop' order by fecprev asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    

    function despachosByCoddesp() {
        $sql = "SELECT coddesp, codprop, prioridad, fecprev, descripcion, obs, montodesp, saldo, moneda FROM despdb01 WHERE coddesp = '$this->coddesp'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getcolorestado($cod) {
        $leyenda = '';
        switch ($cod) {
            case 'EN OFICINA': $leyenda = '<span style="font-size: 1em" class="label label-info" >EN OFICINA</span>';
                return $leyenda;
                break;
            case 'EN CURSO': $leyenda = '<span style="font-size: 1em" class="label label-warning" >EN CURSO</span>';
                return $leyenda;
                break;
            case 'DESPACHO PARCIAL': $leyenda = '<span style="font-size: 1em" class="label label-danger" >DESPACHO PARCIAL</span>';
                return $leyenda;
                break;
            case 'DESPACHADO': $leyenda = '<span style="font-size: 1em" class="label label-primary" >DESPACHADO</span>';
                return $leyenda;
                break;
            case 'ENTREGADO': $leyenda = '<span style="font-size: 1em" class="label label-success" >ENTREGADO</span>';
                return $leyenda;
                break;
        }
    }

    function getcoloractivo($cod) {
        $leyenda = '';
        switch ($cod) {
            case '0': $leyenda = '<img src="../site/img/iconos/bullet-grey.png" height="15px" />';
                return $leyenda;
                break;
            case '1': $leyenda = '<img src="../site/img/iconos/bullet-green.png" height="15px" />';
                return $leyenda;
                break;
        }
    }

    //Registrar Archivos Adjuntos
    function insert_intraarchivo($archivo, $des) {
        $sql = "INSERT INTO intraarchivos(codigo, url, descripcion) values ('$this->coddesp', '$archivo', '$des');";
        $result = $this->consultas($sql);
        return $result;
    }
    
   
    
    

//    function getcantidaddespachos() {
//        $sql = "select coddesp from propdb02 where codprop = '$this->codprop' GROUP BY coddesp ORDER BY coddesp ASC;";
//        $result = $this->consultas($sql);
//        $lista = $this->n_Arreglo($result);
//        return $lista;
//    }
//
//    function getDespachosByCodPropAndDesp() {
//        $sql = "select codestado, coddesp, codprop, fecha, estado, obs, activo, fecreg, coduse from propdb02 where codprop = '$this->codprop' AND coddesp = '$this->coddesp' ORDER BY fecha ASC;";
//        $result = $this->consultas($sql);
//        $lista = $this->n_Arreglo($result);
//        return $lista;
//    }
//
//    function setactivo() {
//        $sql = "UPDATE propdb02 SET activo = '$this->activo' WHERE codestado = '$this->codestado' ";
//        $result = $this->consultas($sql);
//        return $result;
//    }
//
//    function setEstadoInactivo() {
//        $sql = "UPDATE propdb02 SET activo =  '0' WHERE coddesp = '$this->coddesp'";
//        $result = $this->consultas($sql);
//        return $result;
//    }
}

?>