<?php

$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Menu.php';

class C_Portada {

    //Escriba tus variables
    private $coduse;
    private $fechainicio;

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

    function getProximosEventosByUser() {
        $sql = "SELECT codagenda, asunto, fechainicio, EXTRACT(HOUR FROM horainicio) AS horainicio, EXTRACT(MINUTE FROM horainicio) AS mininicio, fechafin, EXTRACT(HOUR FROM horafin) AS horafin, EXTRACT(MINUTE FROM horafin) AS minfin, donde, descripcion, estado, coduse, fecreg FROM intraagenda WHERE date(fechainicio) >= '$this->fechainicio' AND coduse = '$this->coduse' AND estado = 'PENDIENTE' ORDER BY fechainicio";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function cargarMenuPrincipal($perfil){
        $sql = "select r.nombre, r.url from aarecurso as r JOIN aaperfilxrecurso as pr ON pr.id_recurso = r.id_recurso
                WHERE pr.id_perfil = '$perfil' and r.tipo = 'Menu Principal' order by orden;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;        
    }

    function arreglarHora($hora, $minuto) {
        $h = strlen($hora);
        $m = strlen($minuto);
        if ($h == 1) {
            $hora = '0' . $hora;
        }
        if ($m == 1) {
            $minuto = '0' . $minuto;
        }
        $resultado = $hora . ':' . $minuto;
        if($resultado == ':'){ $resultado = '';}
        return $resultado;
    }
    
    function obtFechadeHoy() {        
        date_default_timezone_set("America/Bogota");
        $getfecha = getdate();
        $dia = $getfecha['mday'];
        $mes = $getfecha['mon'];
        $ano = $getfecha['year'];
        $hoy = $ano . '/' . $mes . '/' . $dia;
        return $hoy;
    }

    function getAccesos2() {
        $sql = "SELECT id, a.coduse, u.desuse, entrada, salida FROM aausdb02 as a JOIN aausdb01 as u ON a.coduse = u.coduse order by entrada desc limit 20";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function getEmpresasMasVisitadas() {
        $sql = "select r.codcliente, c.nombre, count(c.nombre) as visitas  from intrareportes as r 
                JOIN intracliente as c ON c.codcliente = r.codcliente
                JOIN intrafundo as f ON f.codfundo = r.codfundo
                GROUP BY r.codcliente, c.nombre 
                ORDER BY visitas desc limit 20";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function getNroxVisitas($ruc, $tipo){
        $sql = "select count(codcliente) as visitas  from intrareportes WHERE tipo = '$tipo' and codcliente = '$ruc'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function getMenu($usuario, $tipo, $codpadre){
        $sql = "SELECT m.codigo, m.nombre, m.ruta, m.tipo, m.orden, m.codpadre, m.activo, es_padre,  m.icono
                FROM aampdb01 as m
                JOIN aaperdb01 as p ON p.codmenu = m.codigo
                JOIN aaroldb01 as r ON r.codrol = p.codrol
                JOIN aauxrdb01 as u ON u.codrol = r.codrol
                WHERE u.coduse = '$usuario' and m.tipo = '$tipo' and m.codpadre = $codpadre ORDER BY m.orden ASC;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
                
    }

}

$obj = new C_Portada();
if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {
        case 'login':

            break;

        default:
            break;
    }
}