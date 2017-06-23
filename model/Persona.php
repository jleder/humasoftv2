<?php

/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

/**
 * Description of Persona
 *
 * @author Emergencia
 */
class Persona {
    
    private $codpersona;
    private $nombre;
    private $apellido;
    private $dni;
    private $fecnac;
    private $sexo;
    private $telefono;
    private $celular;
    private $email;
    private $foto;
    private $direccion;
    private $dist;
    private $prov;
    private $dep;    
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
    function insert_hs_psndb01() {
        $sql = "INSERT INTO hs_psndb01(nombre, apellido, dni, fecnac, sexo, telefono, celular, email, foto, direccion, dist, prov, dep, coduse) values ('$this->nombre', '$this->apellido', '$this->dni', '$this->fecnac', '$this->sexo', '$this->telefono', '$this->celular', '$this->email', '$this->foto', '$this->direccion', '$this->dist', '$this->prov', '$this->dep', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }    

    //Funcion Update
    function update_hs_psndb01() {

        $sql = "UPDATE hs_psndb01 SET "
                . "nombre = '$this->nombre', "
                . "apellido = '$this->apellido', "
                . "dni = '$this->dni', "
                . "fecnac = '$this->fecnac', "
                . "sexo = '$this->sexo', "
                . "telefono = '$this->telefono', "
                . "celular = '$this->celular', "
                . "email = '$this->email', "
                . "foto = '$this->foto', "
                . "direccion = '$this->direccion', "
                . "dist = '$this->dist', "
                . "prov = '$this->prov', "
                . "dep = '$this->dep', "
                . "usemod = '$this->dom_user', "
                . "fecmod = now() "
                . "WHERE codpersona = '$this->codpersona';";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_hs_psndb01() {
        $sql = "DELETE FROM hs_psndb01 WHERE codpersona = '$this->codpersona' ";
        $result = $this->consultas($sql);
        return $result;
    }    


}
