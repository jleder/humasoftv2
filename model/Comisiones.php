<?php

class Comisiones {

    //Escriba tus variables
    private $codigo;
    private $codpedido;
    private $tipocomision;
    private $codven;
    private $nomven;
    private $monto;
    private $dom_user;
    private $comision;

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
    function insert_comdb01() {
        $sql = "INSERT INTO comdb01(codpedido, tipocomision, codven, nomven, monto, coduse, comision) values ('$this->codpedido', '$this->tipocomision', '$this->codven', '$this->nomven', '$this->monto', '$this->dom_user', '$this->comision');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Update
    function update_comdb01() {
        $sql = "UPDATE comdb01 SET "
                . "codpedido = '$this->codpedido', "
                . "tipocomision = '$this->tipocomision', "
                . "codven = '$this->codven', "
                . "nomven = '$this->nomven', "
                . "monto = '$this->monto', "
                . "usemod = '$this->usemod', "
                . "fecmod = now()"
                . "WHERE codigo = '$this->codigo'; ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Eliminar
    function delete_comdb01() {
        $sql = "DELETE FROM comdb01 WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    //Funcion Listar por Codigo - Metodo para Modificar
    function listarComisionesByCod() {
        $sql = "SELECT codigo, codpedido, tipocomision, codven, nomven, monto, dom_user FROM comdb01 WHERE codigo = '$this->codigo'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarComisionesByCodPedido() {
        $sql = "SELECT codigo, codpedido, tipocomision, codven, nomven, monto, dom_user FROM comdb01 WHERE codpedido = '$this->codpedido'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarComisionesAll() {
        $sql = "SELECT codigo, codpedido, tipocomision, codven, nomven, monto, dom_user FROM comdb01;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarComisionesAll2() {
        $sql = "SELECT codigo, p.fecpedido, c.codpedido, nomcliente, c.codven, c.nomven, tipocomision, valorventa, c.comision, monto, p.fau
                FROM comdb01 as c JOIN peddb01 as p ON c.codpedido = p.codpedido";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function calcularComisionPrincipal($comision, $fau) {
        $comision_final = 0;

        if ($fau <= 40) {
            $comision_final = ($comision * 0.15);
        } elseif ($fau > 40 && $fau <= 46) {
            $comision_final = ($comision * 0.25);
        } elseif ($fau > 46 && $fau <= 80) {
            $comision_final = ($comision * 0.5);
        } elseif ($fau > 80 && $fau <= 110) {
            $comision_final = ($comision * 0.75);
        } elseif ($fau > 110) {
            $comision_final = ($comision);
        }
        return $comision_final;
    }
    
    function calcularComisionSecundaria($comision, $fau) {
        $comision_final = 0;

        if ($fau <= 40) {
            $comision_final = ($comision * 0.1);
        } elseif ($fau > 40 && $fau <= 46) {
            $comision_final = ($comision * 0.15);
        } elseif ($fau > 46 && $fau <= 80) {
            $comision_final = ($comision * 0.25);
        } elseif ($fau > 80 && $fau <= 110) {
            $comision_final = ($comision * 0.50);
        } elseif ($fau > 110) {
            $comision_final = ($comision * 0.75);
        }
        return $comision_final;
    }

}
