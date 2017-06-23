<?php

/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

//Declaracion de Variables
class Empleado {

    //Declaracion de Variables
    private $codpersona;
    private $salario;
    private $cargo;
    private $fecingreso;
    private $profesion;
    private $tipo;
    
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
    function insert_hs_epddb01() {
        $sql = "INSERT INTO hs_epddb01(codpersona, salario, cargo, fecingreso, profesion, tipo) values ('$this->codpersona', '$this->salario', '$this->cargo', '$this->fecingreso', '$this->profesion', '$this->tipo');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_hs_epddb01() {

        $sql = "UPDATE hs_epddb01 SET "
                . "salario = '$this->salario', "
                . "cargo = '$this->cargo', "
                . "fecingreso = '$this->fecingreso', "
                . "profesion = '$this->profesion', "
                . "tipo = '$this->tipo' "
                . "WHERE codpersona = '$this->codpersona' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_hs_epddb01() {

        $sql = "DELETE FROM hs_epddb01 WHERE codpersona = '$this->codpersona' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar
    function listarEmpleadoByCod() {
        $sql = "select p.codpersona, nombre, apellido, dni, fecnac, sexo, telefono, celular, email, foto, direccion, dist, prov, dep, salario, cargo, fecingreso, profesion, tipo 
                FROM hs_psndb01 as p
                JOIN hs_epddb01 as e ON e.codpersona = p.codpersona WHERE p.codpersona = '$this->codpersona'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function listarEmpleadoAll() {
        $sql = "select p.codpersona, nombre, apellido, dni, fecnac, sexo, telefono, celular, email, foto, direccion, dist, prov, dep, salario, cargo, fecingreso, profesion, tipo 
                FROM hs_psndb01 as p
                JOIN hs_epddb01 as e ON e.codpersona = p.codpersona ORDER BY nombre ASC;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
