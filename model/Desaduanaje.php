<?php


class Desaduanaje {

    private $codigo;
    private $numero_oc;
    private $numero_fact;
    private $regimen;
    private $fecinicio;
    private $fecfin;
    private $modalidad;
    private $fecnac;
    private $numero_dam;
    private $fecnum_dam;
    private $fecpago_dam;
    private $canal;
    private $feclevante;
    private $fecretadu;
    private $p_accion;
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

    function insert_hs_impdesadb01() {
        $sql = "INSERT INTO hs_impdesadb01(numero_oc, numero_fact, regimen, fecinicio, fecfin, modalidad, fecnac, numero_dam, fecnum_dam, fecpago_dam, canal, feclevante) values ('$this->numero_oc', '$this->numero_fact', '$this->regimen', '$this->fecinicio', '$this->fecfin', '$this->modalidad', '$this->fecnac', '$this->numero_dam', '$this->fecnum_dam', '$this->fecpago_dam', '$this->canal', '$this->feclevante');";
        $result = $this->consultas($sql);
        return $result;
    }

    function insert_desaduanaje_diferida() {
        $sql = "select imp_crud_desadb01('$this->numero_oc', '$this->numero_fact', '$this->regimen', $this->fecinicio, $this->fecfin, '$this->modalidad', $this->fecnac, '$this->numero_dam', $this->fecnum_dam, $this->fecpago_dam, '$this->canal', $this->feclevante, $this->fecretadu, '$this->dom_user', '$this->p_accion');";
        $result = $this->consultas($sql);
        return $result;
    }
    
    function insert_desaduanaje_nomrla() {
        $sql = "select imp_crud_desadb01('$this->numero_oc', '$this->numero_fact', '$this->regimen', $this->fecinicio, $this->fecfin, '$this->modalidad', $this->fecnac, '$this->numero_dam', $this->fecnum_dam, $this->fecpago_dam, '$this->canal', $this->feclevante, $this->fecretadu, '$this->dom_user', '$this->p_accion');";
        $result = $this->consultas($sql);
        return $result;
    }

}
