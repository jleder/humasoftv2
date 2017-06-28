<?php

class C_Storecont {

    //ATRIBUTOS PARA TIENDA
    private $codcontacto;
    private $codstore;
    private $nombre;
    private $dni;
    private $cargo;
    private $telefono;
    private $anexo;
    private $celular;
    private $email;
    private $domuser;

    public function __get($atrb) {
        return $this->$atrb;
    }

    public function __set($atrb, $val) {
        $this->$atrb = $val;
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

    function consultas($sql) {
        $obj_conexion = new Conexion();
        return $obj_conexion->consultar($sql);
    }

    //OPERACIONES
    function insert_stordb02() {
        $sql = "INSERT INTO stordb02(codstore, nombre, dni, cargo, telefono, celular, email, coduse, validado) values ('$this->codstore', '$this->nombre', '$this->dni', '$this->cargo', '$this->telefono', '$this->celular', '$this->email', '$this->domuser', true);";
        $result = $this->consultas($sql);
        return $result;
    }
    
    function insert_aausdb01($coduse, $clave){
        $sql = "INSERT INTO aausdb01(coduse, desuse, pwduse, email, vendedor, vc, vt, externo, store) values ('$coduse', '$this->nombre', '$clave', '$this->email', 'NO', 'NO', 'NO', 'NO', TRUE);";
        $result = $this->consultas($sql);
        return $result;
    }

    function update__stordb02() {

        $sql = "UPDATE stordb02 SET "                
                . "nombre = '$this->nombre', "
                . "dni = '$this->dni', "
                . "cargo = '$this->cargo', "
                . "telefono = '$this->telefono', "                
                . "celular = '$this->celular', "
                . "email = '$this->email', "
                . "usemod = '$this->domuser', "
                . "fecmod = now() "
                . "WHERE codcontacto = '$this->codcontacto';";
        $result = $this->consultas($sql);
        return $result;
    }

    function delete_stordb02() {
        $sql = "DELETE FROM stordb02 WHERE codcontacto = '$this->codcontacto' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function getStordb02bycodcontacto() {
        $sql = "SELECT codcontacto, codstore, nombre, dni, cargo, telefono, anexo, celular, email FROM stordb02 WHERE codcontacto = '$this->codcontacto'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }    
    
    function getStordb02all() {
        $sql = "SELECT codcontacto, codstore, nombre, dni, cargo, telefono, anexo, celular, email FROM stordb02 WHERE codstore = '$this->codstore' ORDER BY nombre ;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
}
