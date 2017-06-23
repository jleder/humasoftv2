<?php

class MovimientoDetalle {

    private $codigo;
    private $idmovimiento;
    private $idproducto;
    private $umedida;
    private $cantidad;    
    private $precio;    
    private $estado;
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

    function insert_movdb02() {
        $sql = "INSERT INTO movdb02(idmovimiento, idproducto, umedida, cantidad, precio, estado, coduse) values ('$this->idmovimiento', '$this->idproducto', '$this->umedida', '$this->cantidad', '$this->precio', '$this->estado', '$this->dom_user');";
        $result = $this->consultas($sql);
        return $result;
    }

    

//Funcion Update

    /*
      function update_movdb02() {

      $sql = "UPDATE movdb02 SET "
      . "idmovimiento = '$this->idmovimiento', "
      . "idproducto = '$this->idproducto', "
      . "umedida = '$this->umedida', "
      . "cantidad = '$this->cantidad', "
      . "precio = '$this->precio', "
      . "estado = '$this->estado', "
      . "usemod = '$this->dom_user', "
      . "fecmod = now(), "
      . "WHERE codigo = '$this->codigo' ";
      $result = $this->consultas($sql);
      return $result;
      }
     * 
     */

//Funcion Eliminar

    /*
      function delete_movdb02() {

      $sql = "DELETE FROM movdb02 WHERE codigo = '$this->codigo' ";
      $result = $this->consultas($sql);
      return $result;
      }

      //Funcion Listar por Codigo - Metodo para Modificar

      function listar() {
      $sql = "SELECT codigo, idmovimiento, idproducto, umedida, cantidad, precio, estado, dom_user FROM movdb02 WHERE codigo = '$this->codigo'";
      $result = $this->consultas($sql);
      $lista = $this->n_fila($result);
      return $lista;
      }
     * 
     */
}
