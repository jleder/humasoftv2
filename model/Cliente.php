<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class C_Cliente {

    //ATRIBUTOS PARA CLIENTE Y FUNDO
    private $codcliente;
    private $codfundo;
    private $nombre;
    private $web;
    private $telefono;
    private $abrev;
    private $ruc;
    private $direccion;
    private $ciudad;
    private $provincia;
    private $departamento;
    private $notas;
    private $ubdist;
    private $ubprov;
    private $ubdepa;
    private $codzona;
    private $codsubzona;
    private $validado;
    //ATRIBUTOS PARA CONTACTO
    private $codcontacto;
    private $fecnac;
    private $email;
    private $dni;
    private $cargo;
    private $anexo;
    private $celular;
    private $coduse;
    private $usemod;
    //ATRIBUTOS PARA FACTORES
    private $codnut;
    private $factor;
    private $orden;

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

    //OPERACIONES CLIENTES

    function insertarCliente() {
        $sql = "INSERT INTO intracliente(codcliente, nombre, web, telefono, abrev, ruc, direccion, ciudad, provincia, departamento, notas, coduse, validado, ubdist, ubprov, ubdepa, codzona, codsubzona) "
                . "values ('$this->codcliente', '$this->nombre', '$this->web', '$this->telefono', '$this->abrev', '$this->ruc', '$this->direccion', '$this->ciudad', '$this->provincia', '$this->departamento', '$this->notas', '$this->coduse', FALSE, '$this->ubdist', '$this->ubprov', '$this->ubdepa', '$this->codzona', '$this->codsubzona');";
        $result = $this->consultas($sql);
        return $result;
    }

    function modificarCliente($codigoactual) {

        $sql = "UPDATE intracliente SET "
                . "codcliente = '$this->codcliente', "
                . "nombre = '$this->nombre', "
                . "web = '$this->web', "
                . "telefono = '$this->telefono', "
                . "abrev = '$this->abrev', "
                . "ruc = '$this->ruc', "
                . "direccion = '$this->direccion', "
                . "ciudad = '$this->ciudad', "
                . "provincia = '$this->provincia', "
                . "departamento = '$this->departamento', "
                . "ubdist = '$this->ubdist', "
                . "ubprov = '$this->ubprov', "
                . "ubdepa = '$this->ubdepa', "
                . "codzona = '$this->codzona', "
                . "codsubzona = '$this->codsubzona', "
                . "validado = '$this->validado', "
                . "notas = '$this->notas', "
                . "usemod = '$this->usemod', "
                . "fecmod = now()"
                . "WHERE codcliente = '$codigoactual' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function getClientesAll() {
        $sql = "select codcliente, nombre, abrev, ruc, web, telefono, direccion, ciudad, provincia, departamento, notas FROM intracliente order by nombre";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getClientesTop20() {
        $sql = "select codcliente, nombre, abrev, ruc, web, telefono, direccion, ciudad, provincia, departamento, notas FROM intracliente order by nombre limit 20";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getClienteByID() {
        $sql = "SELECT trim(codcliente), trim(nombre), trim(direccion), trim(telefono), trim(web), trim(abrev), trim(ciudad), trim(provincia), trim(departamento), validado, ubdist, ubprov, ubdepa, c.codzona, zona, c.codsubzona, subzona 
                FROM intracliente as c 
                LEFT JOIN ubzona as z ON c.codzona = z.codzona
                LEFT JOIN ubsubzona as s ON c.codsubzona = s.codsubzona
                WHERE codcliente = '$this->codcliente';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getFundosAll() {
        $sql = "select f.codcliente, codfundo, c.nombre as cliente, f.nombre as fundo, f.direccion, f.ciudad, f.provincia, f.departamento
                FROM intracliente as c JOIN intrafundo as f ON f.codcliente = c.codcliente order by cliente asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getFundosByID() {
        $sql = "select f.codcliente, codfundo, c.nombre as cliente, f.nombre as fundo, f.direccion, f.ciudad, f.provincia, f.departamento
                FROM intracliente as c JOIN intrafundo as f ON f.codcliente = c.codcliente WHERE codfundo = '$this->codfundo';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getContactosTop10() {
        $sql = "select c.nombre, dni, cargo, c.telefono, anexo, celular, email, cl.nombre as cliente from intracontacto as c JOIN intracliente as cl ON c.codcliente = cl.codcliente limit 10;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getContactosByID() {
        $sql = "select c.codcontacto, c.nombre, dni, cargo, c.telefono, anexo, celular, email, fecnac from intracontacto as c WHERE c.codcontacto = '$this->codcontacto';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getFundodesdeIDContacto() {
        $sql = "select f.codfundo, f.nombre as fundo from intracontacto as c JOIN intrafundo as f ON c.codfundo = f.codfundo where c.codcontacto = '$this->codcontacto';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getContactoxCliente() {
        $sql = "SELECT c.codcliente, c.codcontacto, c.nombre, c.cargo, c.telefono, c.email, c.celular, c.anexo, c.fecnac
                FROM intracontacto c JOIN intracliente cl ON c.codcliente = cl.codcliente
                WHERE c.codcliente = '$this->codcliente' order by c.nombre";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getFundoxCliente() {

        $sql = "SELECT f.codcliente, f.codfundo, f.nombre, f.direccion, f.ciudad, f.provincia, f.departamento 
                FROM intrafundo f JOIN intracliente c ON f.codcliente = c.codcliente
                WHERE f.codcliente = '$this->codcliente' order by f.codfundo";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getLotesxFundo() {
        $sql = "SELECT codlote, codcliente, codfundo, nombre, hatrabajada, tipocultivo, variedad, patron, triego, tsuelo FROM intralote WHERE codfundo = '$this->codfundo'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function cargarFundoxCliente() {
        $sql = "SELECT f.codcliente, f.codfundo, f.nombre, c.nombre 
                FROM intrafundo f JOIN intracliente c ON f.codcliente = c.codcliente
                WHERE f.codcliente = '$this->codcliente' order by f.nombre";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function insertarCliente2() {
        $sql = "INSERT INTO vscldb01(codigo, nombre, direccion, telefono, correo, abrev, fecreg) values ('$this->codigo', '$this->nombre', '$this->direccion', '$this->telefono', '$this->correo', '$this->abrev', now());";
        $result = $this->consultas($sql);
        return $result;
    }

    function insertarContacto() {
        //if ($this->codfundo != '') {
        $sql = "INSERT INTO intracontacto(codcliente, codfundo, nombre, fecnac, dni, cargo, telefono, anexo, celular, email, coduse) values ('$this->codcliente', $this->codfundo, '$this->nombre', $this->fecnac, '$this->dni', '$this->cargo', '$this->telefono', '$this->anexo', '$this->celular', '$this->email', '$this->coduse');";
        //} else {
        //  $sql = "INSERT INTO intracontacto(codcliente, nombre, fecnac, dni, cargo, telefono, anexo, celular, email, coduse) values ('$this->codcliente', '$this->nombre', '$this->fecnac', '$this->dni', '$this->cargo', '$this->telefono', '$this->anexo', '$this->celular', '$this->email', '$this->coduse');";
        //}
        $result = $this->consultas($sql);
        return $result;
    }

    function modificarCliente2($codigoactual) {

        $sql = "UPDATE vscldb01 SET "
                . "codigo = '$this->codigo', "
                . "nombre = '$this->nombre', "
                . "direccion = '$this->direccion', "
                . "telefono = '$this->telefono', "
                . "correo = '$this->correo', "
                . "abrev = '$this->abrev' "
                . "WHERE codigo = '$codigoactual' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function modificarConctacto() {

        $sql = "UPDATE intracontacto SET "
                . "nombre = '$this->nombre', "
                . "codfundo = $this->codfundo, "
                . "fecnac = $this->fecnac, "
                . "dni = '$this->dni', "
                . "cargo = '$this->cargo', "
                . "telefono = '$this->telefono', "
                . "anexo = '$this->anexo', "
                . "celular = '$this->celular', "
                . "email = '$this->email', "
                . "usemod = '$this->usemod', "
                . "fecmod = now() "
                . "WHERE codcontacto = '$this->codcontacto'";
        $result = $this->consultas($sql);
        return $result;
    }

//    function modificarConctactoyFundo() {
//
//        $sql = "UPDATE intracontacto SET "
//                . "codfundo = '$this->codfundo', "
//                . "fecnac = '$this->fecnac', "
//                . "nombre = '$this->nombre', "
//                . "dni = '$this->dni', "
//                . "cargo = '$this->cargo', "
//                . "telefono = '$this->telefono', "
//                . "anexo = '$this->anexo', "
//                . "celular = '$this->celular', "
//                . "email = '$this->email', "
//                . "usemod = '$this->usemod', "
//                . "fecmod = now() "
//                . "WHERE codcontacto = '$this->codcontacto'";
//        $result = $this->consultas($sql);
//        return $result;
//    }

    function deleteCliente() {

        $sql = "DELETE FROM intracliente WHERE codcliente = '$this->codcliente' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function deleteContacto() {

        $sql = "DELETE FROM intracontacto WHERE codcontacto = '$this->codcontacto' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function delete() {
        $sql = "DELETE FROM vscldb04 WHERE codcontacto = '$this->codcontacto' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function insertarFundo() {
        $sql = "INSERT INTO intrafundo(codcliente, nombre, direccion, ciudad, provincia, departamento) values ('$this->codcliente', '$this->nombre', '$this->direccion', '$this->ciudad', '$this->provincia', '$this->departamento');";
        $result = $this->consultas($sql);
        return $result;
    }

    function modificarFundo() {

        $sql = "UPDATE intrafundo SET "
                . "nombre = '$this->nombre', "
                . "direccion = '$this->direccion', "
                . "ciudad = '$this->ciudad', "
                . "provincia = '$this->provincia', "
                . "departamento = '$this->departamento' "
                . "WHERE  codfundo = '$this->codfundo'";
        $result = $this->consultas($sql);
        return $result;
    }

    function deleteFundo() {

        $sql = "DELETE FROM intrafundo WHERE codfundo = '$this->codfundo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function buscarClientes() {
        $sql = "select codcliente, nombre, abrev, ruc, web, telefono, direccion, ciudad, provincia, departamento, notas FROM intracliente WHERE nombre ilike '%$this->nombre%' order by nombre limit 20";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getFactorConversionByCliente() {
        $sql = "select codnut, codcliente, nomcliente, factor, orden from ppntdb03 where codcliente='$this->codcliente' order by orden";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPrecioxProdFertirriego() {
        $sql = "SELECT codigo, nombre, pventa, inicial2 FROM alardb01 where inicial2 <> '' order by orden;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getListaPrecioDscto() {
        $sql = "SELECT codlis, codigoprod, nombre, precio, c.valele, orden, inicial2
                FROM lista_precio2 as l 
                JOIN alardb01 as p ON p.codigo = l.codigoprod
                JOIN altbdb01 as c ON c.codele = p.codcate
                where inicial2 <> '' and codlis IN ('60')
                ORDER BY p.orden asc, codlis";

        /* $sql = "SELECT codlis, codigoprod, nombre, precio, c.valele, orden, inicial2
          FROM lista_precio2 as l
          JOIN alardb01 as p ON p.codigo = l.codigoprod
          JOIN altbdb01 as c ON c.codele = p.codcate
          where inicial2 <> '' and codlis IN ('60', '61', '62')
          ORDER BY p.orden asc, codlis";
         */
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getFactorConversionDefault() {
        $sql = "select codnut, codcliente, nomcliente, factor, orden from ppntdb03 where codcliente='20478013206' order by orden";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function insertFactorConversion() {
        $sql = "insert into ppntdb03(codnut, codcliente, nomcliente, factor, orden, coduse, fecreg) values('$this->codnut', '$this->codcliente', '$this->nombre', '$this->factor', '$this->orden', '$this->coduse', now());";
        $result = $this->consultas($sql);
        return $result;
    }

    function updateFactorConversion() {
        $sql = "UPDATE ppntdb03 SET "
                . "factor = '$this->factor', "
                . "fecmod = now(), "
                . "usemod = '$this->coduse' "
                . "WHERE  codcliente = '$this->codcliente' AND codnut = '$this->codnut'";
        $result = $this->consultas($sql);
        return $result;
    }

    function getClientesPendientes() {
        $sql = "select codcliente, nombre, abrev, ruc, web, telefono, direccion, ciudad, provincia, departamento, notas, validado, c.fecreg, c.coduse, u.desuse "
                . "FROM intracliente as c JOIN aausdb01 as u ON c.coduse = u.coduse WHERE validado = false ORDER BY nombre";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function exportarClientes() {
        $sql = "SELECT trim(codcliente), nombre, trim(direccion), trim(telefono), trim(web), trim(abrev), trim(ciudad), trim(provincia), trim(departamento), validado, ubdist, ubprov, ubdepa, c.codzona, zona, c.codsubzona, subzona 
                FROM intracliente as c 
                LEFT JOIN ubzona as z ON c.codzona = z.codzona
                LEFT JOIN ubsubzona as s ON c.codsubzona = s.codsubzona order by nombre;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarSoloClientes() {
        $sql = "select c.codcliente as id, c.nombre as cliente, abrev  from intracliente as c order by c.nombre asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function getVendedores() {
        $sql = "SELECT coduse, desuse FROM aausdb01 WHERE vendedor = 'SI' and activo = true;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
