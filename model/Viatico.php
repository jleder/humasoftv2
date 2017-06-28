<?php

/**
 * Description of Viatico
 *
 * @author Emergencia
 */
class Viatico {

    //put your code hereprivate $codviatico;
    private $codviatico;
    private $codpersona;
    private $periodo_mes;
    private $periodo_ano;
    private $cargo;
    private $saldo;
    private $periodo;
    private $dom_user;
    //variables para categoria de viatico
    private $codtab;
    private $codele;
    private $desele;

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

    function insert_hs_vtcdb01() {
        $sql = "INSERT INTO hs_vtcdb01(codpersona, periodo, periodo_mes, periodo_ano, cargo, saldo, coduse) values ('$this->codpersona', '$this->periodo', '$this->periodo_mes', '$this->periodo_ano', '$this->cargo', '$this->saldo', '$this->dom_user');"
                . "SELECT currval(pg_get_serial_sequence('hs_vtcdb01','codviatico'));";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Update

    function update_hs_vtcdb01() {

        $sql = "UPDATE hs_vtcdb01 SET "
                . "codpersona = '$this->codpersona', "
                . "periodo_mes = '$this->periodo_mes', "
                . "periodo_ano = '$this->periodo_ano', "
                . "cargo = '$this->cargo', "
                . "saldo = '$this->saldo', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now()"
                . "WHERE codviatico = '$this->codviatico' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Eliminar

    function delete_hs_vtcdb01() {

        $sql = "DELETE FROM hs_vtcdb01 WHERE codviatico = '$this->codviatico' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Listar por Codigo - Metodo para Modificar

    function listarViaticoByCod() {
        $sql = "SELECT codviatico, codpersona, periodo_mes, periodo_ano, cargo, saldo FROM hs_vtcdb01 WHERE codviatico = '$this->codviatico'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarViaticoAll() {
        $sql = "SELECT codviatico, codpersona, periodo_mes, periodo_ano, cargo, saldo FROM hs_vtcdb01";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function listarPeriodoAll() {
        $sql = "SELECT codviatico, periodo_mes, periodo_ano FROM hs_vtcdb01 ORDER BY periodo_ano, periodo_mes";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function listarPerViaticoByCodPersona() {
        $sql = "SELECT codviatico, periodo_mes, periodo_ano FROM hs_vtcdb01 WHERE codpersona = '$this->codpersona' ORDER BY periodo_ano, periodo_mes";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function listarExistePeriodo() {
        $sql = "SELECT codviatico, codpersona, periodo, periodo_mes, periodo_ano, cargo, saldo from hs_vtcdb01 
                WHERE codpersona = '$this->codpersona' AND periodo = '$this->periodo' AND periodo_mes = '$this->periodo_mes' AND periodo_ano = '$this->periodo_ano';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    

    //Funcion Insertar Tipo Viatico
    function insert_altdb01() {
        $sql = "INSERT INTO altdb01(codtab, codele, desele, coduse) values ('$this->codtab', '$this->codele', '$this->desele', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Update

    function update_altdb01() {
        $sql = "UPDATE altdb01 SET "
                . "codele = '$this->codele', "
                . "desele = '$this->desele', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now() "
                . "WHERE codtab = '$this->codtab';";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_altdb01() {
        $sql = "DELETE FROM altdb01 WHERE codtab = '$this->codtab' and codele = '$this->codele';";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar
    function listarTipoViaticoByCod() {
        $sql = "SELECT codtab, codele, desele FROM altdb01 WHERE codtab = '$this->codtab' and codele = '$this->codele'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarTipoViaticoAll() {
        $sql = "SELECT codtab, codele, desele FROM altbdb01 WHERE codtab = 'TV' order by codele;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function cargarMeses() {
        $meses = array('01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO',
            '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE');
        return $meses;
    }

}
