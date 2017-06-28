<?php

/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

class Proyeccion {

    private $codproy;
    private $proy_ano;
    private $proy_mes;
    private $codasesor;
    private $codcliente;
    private $ha;
    private $cultivo;
    private $total;
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

    function insert_hs_prydb01() {
        $sql = "INSERT INTO hs_prydb01(proy_ano, proy_mes, codasesor, codcliente, ha, cultivo, total, coduse) VALUES('$this->proy_ano', '$this->proy_mes', '$this->codasesor', '$this->codcliente', '$this->ha', '$this->cultivo', '$this->total', '$this->dom_user');"
                . "SELECT currval(pg_get_serial_sequence('hs_prydb01','codproy'));";
        $result = $this->consultas($sql);
        return $result;
    }

    function update_hsprydb01() {

        $sql = "UPDATE hsprydb01 SET "
                . "proy_ano = '$this->proy_ano', "
                . "proy_mes = '$this->proy_mes', "
                . "codasesor = '$this->codasesor', "
                . "codcliente = '$this->codcliente', "
                . "ha = '$this->ha', "
                . "cultivo = '$this->cultivo', "
                . "total = '$this->total' "
                . "WHERE codproy = '$this->codproy' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Eliminar

    function delete_hsprydb01() {

        $sql = "DELETE FROM hsprydb01 WHERE codproy = '$this->codproy' ";
        $result = $this->consultas($sql);
        return $result;
    }

//Funcion Listar por Codigo - Metodo para Modificar

    function listar() {
        $sql = "SELECT codproy, proy_ano, proy_mes, codasesor, codcliente, ha, cultivo, total FROM hsprydb01 WHERE codproy = '$this->codproy'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function cargarMeses() {
        $meses = array('01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO',
            '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE');
        return $meses;
    }

    function listarCultivos() {
        $sql = "SELECT codtab, codele, desele from altbdb01 where codtab = 'TC' and codele>= '01' order by desele";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarSoloClientes() {
        $sql = "select c.codcliente as id, c.nombre as cliente, abrev  from intracliente as c order by c.nombre asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarEmpleadoAll() {
        $sql = "select p.codpersona, nombre, apellido, dni, fecnac, sexo, telefono, celular, email, foto, direccion, dist, prov, dep, salario, cargo, fecingreso, profesion, tipo 
                FROM hs_psndb01 as p
                JOIN hs_epddb01 as e ON e.codpersona = p.codpersona WHERE e.es_vendedor = true ORDER BY nombre ASC;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function calcularTotal($arr_cantidad, $arr_preciou) {
        $total = 0;
        $subtotal = 0;

        $tamanho = count($arr_cantidad);
        for ($i = 0; $i < $tamanho; $i++) {
            $subtotal = ($arr_cantidad[$i] * $arr_preciou[$i]);
            $total+=$subtotal;
        }
        return $total;
    }

    function consultarProyeccionxAsesor() {
        $sql = "SELECT p.codproy, proy_ano, proy_mes, codasesor, p.codcliente, c.nombre as cliente, ha, cultivo, total, p.fecreg, codprod, a.nombre as producto, cantidad as litros, d.umedida 
                FROM hs_prydb01 as p 
                JOIN hs_prydb02 as d ON d.codproy = p.codproy
                JOIN alardb01 as a ON a.codigo = d.codprod
                JOIN intracliente as c ON c.codcliente = p.codcliente
                WHERE codasesor = '$this->codasesor' AND proy_ano = '$this->proy_ano' AND  proy_mes = '$this->proy_mes';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function consultarProyeccionxAsesorLitros() {
        $sql = "SELECT codprod, a.nombre, SUM(cantidad) as litros
                FROM hs_prydb01 as p 
                JOIN hs_prydb02 as d ON d.codproy = p.codproy
                JOIN alardb01 as a ON a.codigo = d.codprod
                JOIN intracliente as c ON c.codcliente = p.codcliente
                WHERE codasesor = '$this->codasesor' AND proy_ano = '$this->proy_ano' AND  proy_mes = '$this->proy_mes' GROUP BY codprod, a.nombre ORDER BY litros desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

//    Obtener Variables de HTML
//
//
//$obj->__set('codproy', trim(strtoupper($_POST['codproy'])));
//$obj->__set('proy_ano', trim(strtoupper($_POST['proy_ano'])));
//$obj->__set('proy_mes', trim(strtoupper($_POST['proy_mes'])));
//$obj->__set('codasesor', trim(strtoupper($_POST['codasesor'])));
//$obj->__set('codcliente', trim(strtoupper($_POST['codcliente'])));
//$obj->__set('ha', trim(strtoupper($_POST['ha'])));
//$obj->__set('cultivo', trim(strtoupper($_POST['cultivo'])));
//$obj->__set('total', trim(strtoupper($_POST['total'])));
//Generar Variables de jQuery (Opcional)
//
//
//
//var codproy = $("#codproy").val();
//var proy_ano = $("#proy_ano").val();
//var proy_mes = $("#proy_mes").val();
//var codasesor = $("#codasesor").val();
//var codcliente = $("#codcliente").val();
//var ha = $("#ha").val();
//var cultivo = $("#cultivo").val();
//var total = $("#total").val();
//
//Enviar Variables
//
//'codproy': codproy,
//'proy_ano': proy_ano, 
//'proy_mes': proy_mes, 
//'codasesor': codasesor, 
//'codcliente': codcliente, 
//'ha': ha, 
//'cultivo': cultivo, 
//'total': total
}
