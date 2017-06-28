<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';

class C_Solicitud extends Conexion {

//Escriba tus variables
    private $codcatfert;
    private $codfert;
    private $codcatprod;
    private $codprod;
    private $codsolicitud;
    private $codcliente;
    private $codfundo;
    private $codlote;
    private $asesor;
    private $nitrogeno;
    private $urgencia;
    private $ha;
    private $cultivo;
    private $variedad;
    private $tsuelo;
    private $notas;
    private $estadosol;
    private $coduse;
    private $triego;
    private $nomcontacto;
    private $nomfundo;
    private $carcontacto;
    private $celcontacto;

    public function __get($atrb) {
        return $this->$atrb;
    }

    public function __set($atrb, $val) {
        $this->$atrb = $val;
    }

//    function consultas($sql) {
//        $obj_conexion = new Conexion();
//        return $obj_conexion->consultar($sql);
//    }

    function consultas($sql) {
        //$obj_conexion = new Conexion();
        return parent::consultar($sql);
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

    function listarNutrientes() {
        $sql = "SELECT codnutriente FROM ppntdb01 order by orden";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarSoloClientes() {
        $sql = "select c.codcliente as id, c.nombre as cliente  from intracliente as c order by c.nombre asc";
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

    function getProductosAll() {
        $sql = "SELECT codigo, codcate, nombre, codigoprov, umedida, stkmin, stkmax, pventa, observa, palmacen, peso, umed_com, lithec, descorto FROM alardb01 WHERE activo='SI' ORDER BY codcate, codigo";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function obtFechadeHoy() {
        $getfecha = getdate();
        $dia = $getfecha['mday'];
        $mes = $getfecha['mon'];
        $ano = $getfecha['year'];
        $hoy = $ano . '/' . $mes . '/' . $dia;
        return $hoy;
    }

    function listarCatFertilizantes() {
        $sql = "SELECT codtab, codele, desele FROM altbdb01 where codtab = 'TF' and codele <> '' ";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarFertxCat() {
        $sql = "select codcate, codigo, nombre, umedida from alfrdb01 as f JOIN altbdb01 as c ON f.codcate = c.codele AND codtab = 'TF' where f.codcate = '$this->codcatfert' order by codigo;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarCatProdHumagro() {
        $sql = "select codtab, codele, desele from altbdb01 where codtab = 'CF' and codele <> '' order by desele ";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarFamiliaProdHumagro() {
        $sql = "select codtab, codele, desele from altbdb01 where codtab = 'FP' and codele <> '' order by desele ";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarProdxCat() {
        $sql = "select codcate, codigo, nombre, umedida from alardb01 as f JOIN altbdb01 as c ON f.codcate = c.codele AND codtab = 'CF' where f.codcate = '$this->codcatprod' order by codigo;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarCatxFam($codtab, $codele) {
        $sql = "SELECT s.codtab, s.codele, s.subtab, s.subele, c.desele
                FROM altbdb02 AS s LEFT JOIN altbdb01 AS c ON TRIM(s.subtab) = TRIM(c.codtab) AND TRIM(s.subele) = TRIM(c.codele)
                WHERE s.codtab = '$codtab' AND s.codele = '$codele'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarCultivos() {
        $sql = "SELECT codtab, codele, desele from altbdb01 where codtab = 'TC' and codele>= '01' order by desele";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function generarTipoSuelo($name, $class) {
        $select = ' <select name="' . $name . '" id="' . $name . '" class="' . $class . '">
                        <option value="Arcilloso">Arcilloso</option>
                        <option value="Arcillo Limoso">Arcillo Limoso</option>
                        <option value="Arcillo Arenoso">Arcillo Arenoso</option>
                        <option value="Arenoso">Arenoso</option>
                        <option value="Areno Franco">Areno Franco</option>
                        <option value="Franco">Franco</option>
                        <option value="Franco Arcilloso">Franco Arcilloso</option>
                        <option value="Franco Arcillo Arenoso">Franco Arcillo Arenoso</option>
                        <option value="Franco Arcillo Limoso">Franco Arcillo Limoso</option>                        
                        <option value="Franco Arenoso">Franco Arenoso</option>
                        <option value="Franco Limoso">Franco Limoso</option>
                        <option value="Limoso">Limoso</option>
                      </select>';
        return $select;
    }

    function insertUsuario() {
        $sql = "INSERT INTO aausdb01(coduse, desuse) values ('$this->usuario', '$this->password' )";
        $result = $this->consultas($sql);
        return $result;
    }

    function generarTipoSuelo2($name, $class, $onchange, $onblur, $onclick) {
        $select = ' <select name="' . $name . '" id="' . $name . '" class="' . $class . '" onchange="' . $onchange . '" onblur="' . $onblur . '" onclick="' . $onclick . '">
                        <option value="Arcilloso">Arcilloso</option>
                        <option value="Arcillo Limoso">Arcillo Limoso</option>
                        <option value="Arcillo Arenoso">Arcillo Arenoso</option>
                        <option value="Arenoso">Arenoso</option>
                        <option value="Areno Franco">Areno Franco</option>
                        <option value="Franco">Franco</option>
                        <option value="Franco Arcilloso">Franco Arcilloso</option>
                        <option value="Franco Arcillo Arenoso">Franco Arcillo Arenoso</option>
                        <option value="Franco Arcillo Limoso">Franco Arcillo Limoso</option>                        
                        <option value="Franco Arenoso">Franco Arenoso</option>
                        <option value="Franco Limoso">Franco Limoso</option>
                        <option value="Limoso">Limoso</option>
                        <option value="OTRO">Otro</option>
                      </select>';
        return $select;
    }

    function generarTipoRiego2($name, $class, $onchange, $onblur, $onclick) {
        $select = ' <select name="' . $name . '" id="' . $name . '" class="' . $class . '" onchange="' . $onchange . '" onblur="' . $onblur . '" onclick="' . $onclick . '">
                        <option value="GOTEO">GOTEO</option>
                        <option value="PULSO">PULSO</option>
                        <option value="ASPERSION">ASPERSION</option>
                        <option value="DRENCH">DRENCH</option>
                        <option value="SURCOS">SURCOS</option>                        
                        <option value="OTRO">OTRO</option>
                    </select>';
        return $select;
    }

    function generarVariedades3($codcate) {
        $sql = "SELECT v.codcate, v.codigo, v.nombre as variedad FROM alvadb01 as v JOIN altbdb01 as c ON c.codele = v.codcate  WHERE c.codtab = 'TC' and trim(c.desele) = trim('$codcate') order by v.codigo;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function generarCodSolicitud() {
        $sql = "select codsolicitud from prscdb01 group by codsolicitud ORDER BY fecreg desc limit 1;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $result_explode = explode('-', $lista[0]);
        $nsp = $result_explode[2];
        $numero = ($nsp) + 1;
        $hoy = date('dmy');
        $num = 'SP-' . $hoy . '-' . ($numero);
        $existe = 1;
        while ($existe != 0) {
            $existe = $this->validarCodSol($num);
            if ($existe != 0) {
                $numero++;
                $num = 'SP-' . $hoy . '-' . (1 + $numero);
            }
        }
        return $num;
    }

    function getNombreUsuario($coduse) {
        $sql = "SELECT coduse, desuse FROM aausdb01 WHERE coduse = '$coduse'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function validarCodSol($num) {
        $sql = "select count(codsolicitud) from prscdb01 where codsolicitud = '$num';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $rpta = trim($lista[0]);
        return $rpta;
    }

    function insertarSolicitud() {
        $sql = "INSERT INTO prscdb01(codsolicitud, codcliente, codfundo, asesor, nitrogeno, urgencia, ha, cultivo, variedad, tsuelo, notas, coduse, triego ) "
                . "values ('$this->codsolicitud', '$this->codcliente', '$this->codfundo', '$this->asesor',  '$this->nitrogeno', '$this->urgencia', '$this->ha', '$this->cultivo', '$this->variedad', '$this->tsuelo', '$this->notas', '$this->coduse', '$this->triego');";
        $result = $this->consultas($sql);
        return $result;
    }

//Guardar Solicitud x Nutrientes
    function insertar_prscdb02($codnutriente, $unidad) {
        $sql = "INSERT INTO prscdb02(codsolicitud, codnutriente, unidad, coduse) "
                . "values ('$this->codsolicitud', '$codnutriente', '$unidad', '$this->coduse');";
        $result = $this->consultas($sql);
        return $result;
    }

//Guardar Solicitud x Fertilizantes
    function insertar_prscdb03($codcatfert, $codfert, $totkil, $und, $pre, $moneda, $igv, $total, $igvdesc, $totalconigv) {
        $sql = "INSERT INTO prscdb03(codsolicitud, codcate, codfertilizante, totkil, unidad,  precio, moneda, igv, total, coduse, igvdesc, totalconigv ) "
                . "values ('$this->codsolicitud', '$codcatfert', '$codfert', '$totkil', '$und', '$pre', '$moneda', '$igv', '$total', '$this->coduse', '$igvdesc', '$totalconigv');";
        $result = $this->consultas($sql);
        return $result;
    }

//Guardar Solicitud x Productos
    function insertar_prscdb04($codcatprod, $codprod, $cant, $und) {
        $sql = "INSERT INTO prscdb04(codsolicitud, codcate, codproducto, cantidad, unidad, coduse ) "
                . "values ('$this->codsolicitud', '$codcatprod', '$codprod', $cant, '$und', '$this->coduse');";
        $result = $this->consultas($sql);
        return $result;
    }

//Guardar Solicitud x Contactos
    function insertar_prscdb05($codcontacto) {
        $sql = "INSERT INTO prscdb05(codsolicitud, codcontacto, coduse ) "
                . "values ('$this->codsolicitud', '$codcontacto', '$this->coduse');";
        $result = $this->consultas($sql);
        return $result;
    }

//Guardar Solicitud x Estado
    function insertar_prscdb06() {
        $sql = "INSERT INTO prscdb06(codsolicitud, codtecnico, estado ) "
                . "values ('$this->codsolicitud', '$this->coduse', '$this->estadosol');";
        $result = $this->consultas($sql);
        return $result;
    }

    function set_prscdb06() {
        $sql = "UPDATE prscdb06 SET codtecnico = '$this->coduse', estado = '$this->estadosol' WHERE codsolicitud = '$this->codsolicitud';";
        $result = $this->consultas($sql);
        return $result;
    }

    function consultarSolicitud() {
        $sql = "SELECT s.codsolicitud FROM prscdb01 as s WHERE EXISTS (SELECT * FROM prscdb06 as e WHERE s.codsolicitud = e.codsolicitud and e.codsolicitud = '$this->codsolicitud');";
        $consulta = $this->consultas($sql);
        $result = pg_affected_rows($consulta);
        return $result;
    }

    function regClienteSimple($ruc, $nomcliente) {
        $sql = "INSERT INTO intracliente(codcliente, nombre, codcia, coduse, validado) values ('$ruc', '$nomcliente', '01', '$this->coduse', FALSE);";
        $result = $this->consultas($sql);
        return $result;
    }

    function regFundoSimple() {
        $sql = "INSERT INTO intrafundo(codcliente, nombre, codcia, coduse, validado) values ('$this->codcliente', '$this->nomfundo', '01', '$this->coduse', FALSE);";
        $result = $this->consultas($sql);
        return $result;
    }

    function regContactoSimple() {
        $sql = "INSERT INTO intracontacto(codcliente, nombre, cargo, celular, coduse, validado) values ('$this->codcliente', '$this->nomcontacto', '$this->carcontacto', '$this->celcontacto', '$this->coduse', FALSE);";
        $result = $this->consultas($sql);
        return $result;
    }

    function getLastIDFundo() {
        $sql = "SELECT MAX(codfundo) FROM intrafundo;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getLastIDContacto() {
        $sql = "SELECT MAX(codcontacto) FROM intracontacto;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function modificar() {
        $sql = "UPDATE prscdb01 SET "
                . "codcliente = '$this->codcliente', "
                . "codfundo = '$this->codfundo', "
                . "codlote = '$this->codlote', "
                . "asesor = '$this->asesor', "
                . "con_n = '$this->con_n', "
                . "con_50n = '$this->con_50n', "
                . "sin_n = '$this->sin_n', "
                . "urgencia = '$this->urgencia', "
                . "ha = '$this->ha', "
                . "cultivo = '$this->cultivo', "
                . "variedad = '$this->variedad', "
                . "tsuelo = '$this->tsuelo' "
                . "WHERE codsolicitud = '$this->codsolicitud' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function elim_prscdb01() {
        $sql = "DELETE FROM prscdb01 WHERE codsolicitud = '$this->codsolicitud' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function elim_prscdb02() {
        $sql = "DELETE FROM prscdb02 WHERE codsolicitud = '$this->codsolicitud' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function elim_prscdb03() {
        $sql = "DELETE FROM prscdb03 WHERE codsolicitud = '$this->codsolicitud' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function elim_prscdb04() {
        $sql = "DELETE FROM prscdb04 WHERE codsolicitud = '$this->codsolicitud' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function elim_prscdb05() {
        $sql = "DELETE FROM prscdb05 WHERE codsolicitud = '$this->codsolicitud' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function elim_prscdb06() {
        $sql = "DELETE FROM prscdb06 WHERE codsolicitud = '$this->codsolicitud' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function elim_solicitud() {

        $this->elim_prscdb06();
        $this->elim_prscdb05();
        $this->elim_prscdb04();
        $this->elim_prscdb03();
        $this->elim_prscdb02();
        $result = $this->elim_prscdb01();
        return $result;
    }

    function getSolicitud20All() {
        $sql = "select s.codsolicitud, s.codcliente, c.nombre, codfundo, asesor, nitrogeno, urgencia, ha, cultivo, variedad, tsuelo, s.notas, s.fecreg, s.coduse, e.estado, a.codigo
                FROM prscdb01 as s JOIN intracliente as c ON s.codcliente = c.codcliente
		LEFT JOIN prscdb06 as e ON e.codsolicitud = s.codsolicitud
		LEFT JOIN intraarchivos as a ON a.codigo = s.codsolicitud
                GROUP BY s.codsolicitud, c.nombre, e.estado, a.codigo order by fecreg desc limit 20";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getSolicitudByCod() {
        $sql = "select s.codsolicitud, s.codcliente, c.nombre, s.codfundo, asesor, nitrogeno, urgencia, ha, cultivo, variedad, tsuelo, s.notas, s.fecreg, s.coduse, e.estado, s.triego, f.nombre as fundo
                FROM prscdb01 as s JOIN intracliente as c ON s.codcliente = c.codcliente
                JOIN intrafundo as f ON f.codfundo = s.codfundo
                LEFT JOIN prscdb06 as e ON e.codsolicitud = s.codsolicitud where s.codsolicitud = '$this->codsolicitud'
                order by fecreg desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getSolicitudByCliente($codcliente) {
        $sql = "select s.codsolicitud, s.codcliente, c.nombre, s.codfundo, asesor, nitrogeno, urgencia, ha, cultivo, variedad, tsuelo, s.notas, s.fecreg, s.coduse, e.estado, s.triego, f.nombre as fundo
                FROM prscdb01 as s JOIN intracliente as c ON s.codcliente = c.codcliente
                JOIN intrafundo as f ON f.codfundo = s.codfundo
                LEFT JOIN prscdb06 as e ON e.codsolicitud = s.codsolicitud where s.codcliente = '$codcliente'
                order by fecreg desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getArchivosAdjuntos() {
        $sql = "select codarchivo, codigo, url, descripcion
                FROM intraarchivos where codigo = '$this->codsolicitud'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function get_prscdb02() {
        $sql = "select codsolicitud, codnutriente, unidad
                FROM prscdb02 where codsolicitud = '$this->codsolicitud' order by fecreg asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function get_prscdb03() {
        $sql = "select codsolicitud, s.codcate, codfertilizante, nombre, totkil, unidad, precio, moneda, igv, total, igvdesc, totalconigv 
                FROM prscdb03 as s JOIN alfrdb01 as f ON s.codfertilizante = f.codigo where codsolicitud = '$this->codsolicitud' order by s.fecreg asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function get_prscdb04() {
        $sql = "SELECT codsolicitud, p.codcate, codproducto, nombre, cantidad, unidad 
                FROM prscdb04 as s JOIN alardb01 as p ON s.codproducto = p.codigo where codsolicitud = '$this->codsolicitud' order by s.fecreg asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function get_prscdb05() {
        $sql = "SELECT codsolicitud, s.codcontacto, nombre, cargo, celular
                FROM prscdb05 as s JOIN intracontacto as c ON s.codcontacto = c.codcontacto where codsolicitud = '$this->codsolicitud' order by s.fecreg asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function crearPDFSolicitud() {
        require_once '../site/html2pdf_v4.03/html2pdf.class.php';
//Recogemos el contenido de la vista
        ob_start();
        $_GET['codsolicitud'] = $this->codsolicitud;
        require_once '_pdf_solpropuesta.php';
        $html = ob_get_clean();

//Le indicamos el tipo de hoja y la codificación de caracteres
        $mipdf = new HTML2PDF('P', 'A4', 'es', 'true', 'UTF-8', array(2, 1.5, 1.5, 2));

//Escribimos el contenido en el PDF
        $mipdf->writeHTML($html);

//Generamos el PDF        
        $mipdf->Output('solpropuesta/' . $this->codsolicitud . '.pdf', 'F');
    }

    function enviarMailSolPropuesta() {
//ENVIAR MAIL                                   
        $titulo = trim($this->codsolicitud) . ' - ' . trim($this->asesor);
        require '../site/PHPMailer/class.phpmailer.php';
        $mail = new PHPMailer();
        $mail->From = "sistemas@humagroperu.com";
        $mail->FromName = "HUMASOFT";
        $mail->Subject = $titulo;
        $mail->Body = 'Se ha creado una Solicitud de Propuesta';
        $mail->IsHTML(true);
        $mail->AddAddress('elaboraciondepropuestas@humagroperu.com', "Elaboracion de Propuestas");
        $mail->AddAddress('acomercial@humagroperu.com', "Area Comercial");
        $mail->AddAddress('areatecnica@humagroperu.com', "Area Tecnica");
        $mail->addCC('reportes@humagroperu.com', "Salvador Giha");
        $mail->addBCC('sistemas@humagroperu.com', "Juan Leder");
        $archivo = '../controller/solpropuesta/' . $this->codsolicitud . '.pdf';
        $mail->AddAttachment($archivo, $archivo);
        $mail->Send();
    }

    function enviarMailSolPropuesta_Prueba() {
//ENVIAR MAIL                                   
        $titulo = trim($this->codsolicitud) . ' - ' . trim($this->asesor);
        require '../site/PHPMailer/class.phpmailer.php';
        $mail = new PHPMailer();
        $mail->From = "sistemas@humagroperu.com";
        $mail->FromName = "HUMASOFT";
        $mail->Subject = $titulo;
        $mail->Body = 'Se ha creado una Solicitud de Propuesta';
        $mail->IsHTML(true);
        $mail->addAddress('juanleder@gmail.com', "Juan Leder");
        $mail->addBCC('sistemas@humagroperu.com', "Juan Leder");
        $archivo = '../controller/solpropuesta/' . $this->codsolicitud . '.pdf';
        $mail->AddAttachment($archivo, $archivo);
        $mail->Send();
    }

    function subirArchivo($url, $descripcion) {
        if ($url != '') {
            $sql = "INSERT INTO intraarchivos(codigo, url, descripcion) values ('$this->codsolicitud', '$url', '$descripcion');";
            $result = $this->consultas($sql);
            return $result;
        }
    }

    function generateRandomString($length) {
        $string = "";

//character that can be used 
        $possible = "0123456789bcdfghjkmnpqrstvwxyz";
        for ($i = 0; $i < $length; $i++) {
            $char = substr($possible, rand(0, strlen($possible) - 1), 1);

            if (!strstr($string, $char)) {
                $string .= $char;
            }
        }
        return $string;
    }

}

include '../model/Propuesta.php';

class C_Despacho {

    private $coddesp;
    private $codprop;
    private $fecprev;
    private $prioridad;
    private $orden;
    private $fecinicio;
    private $atendidopor;
    private $domuser; //coduse y usemod
    private $descripcion;
    private $montodesp;
    private $saldo;
    private $moneda;
    private $obs;

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

    function generarCodDespacho() {
        $sql = "select coddesp from despdb01 group by coddesp, fecreg ORDER BY fecreg desc limit 1;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $nsp = $lista[0];
        $numero = ($nsp) + 1;
        $num = ($numero);
        $existe = 1;
        while ($existe != 0) {
            $existe = $this->validarCodDesp($num);
            if ($existe != 0) {
                $numero++;
                $num = (1 + $numero);
            }
        }
        return $num;
    }

    function validarCodDesp($num) {
        $sql = "select count(coddesp) from despdb01 where coddesp = '$num';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $rpta = trim($lista[0]);
        return $rpta;
    }

//    function insertarDespachoDefault() {
//        $sql = "INSERT INTO propdb02(coddesp, codprop, fecha, estado, obs, coduse, activo) values ('$this->coddesp', '$this->codprop', '$this->fecha', 'EN OFICINA', 'NINGUNA', '$this->domuser', '1');";
//        $result = $this->consultas($sql);
//        return $result;
//    }
//
//    function insertarEstadoDepacho() {
//        $sql = "INSERT INTO propdb02(coddesp, codprop, fecha, estado, obs, activo, coduse) values ('$this->coddesp', '$this->codprop', '$this->fecha', '$this->estado', '$this->obs', '1', '$this->domuser');";
//        $result = $this->consultas($sql);
//        return $result;
//    }
//
//    function insertarDetalleDepacho() {
//        $sql = "INSERT INTO propdb02(coddesp, codprop, fecha, estado, obs, activo, coduse) values ('$this->coddesp', '$this->codprop', '$this->fecha', '$this->estado', '$this->obs', '1', '$this->domuser');";
//        $result = $this->consultas($sql);
//        return $result;
//    }

    function registrarDespacho() {
        $sql = "INSERT INTO despdb01(coddesp, codprop, fecprev, prioridad, coduse, fecreg, montodesp, saldo, moneda, descripcion, obs) values ('$this->coddesp', '$this->codprop', '$this->fecprev', '$this->prioridad', '$this->domuser', 'now()', $this->montodesp, $this->saldo, '$this->moneda',  '$this->descripcion', '$this->obs');";
        $result = $this->consultas($sql);
        return $result;
    }

    function modificarDespacho() {
        $sql = "UPDATE despdb01 SET "
                . "codprop = '$this->codprop', "
                . "fecprev = '$this->fecprev', "
                . "prioridad = '$this->prioridad', "
                . "montodesp = $this->montodesp, "
                . "saldo = $this->saldo, "
                . "moneda = '$this->moneda', "
                . "descripcion = '$this->descripcion', "
                . "obs = '$this->obs', "
                . "usemod = '$this->domuser', "
                . "fecmod = 'now()' "
                . "WHERE coddesp = '$this->coddesp' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function eliminarDespacho() {
        $sql = "DELETE FROM despdb01 WHERE coddesp = '$this->coddesp' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function eliminarDespachoByCodprop() {
        $sql = "DELETE FROM despdb01 WHERE codprop = '$this->codprop' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function despachosByCodprop() {
        $sql = "SELECT coddesp, codprop, prioridad, fecprev, descripcion, obs, montodesp, saldo, moneda FROM despdb01 WHERE codprop = '$this->codprop' order by fecreg asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function despachosByCoddesp() {
        $sql = "SELECT coddesp, codprop, prioridad, fecprev, descripcion, obs, montodesp, saldo, moneda FROM despdb01 WHERE coddesp = '$this->coddesp'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getcolorestado($cod) {
        $leyenda = '';
        switch ($cod) {
            case 'EN OFICINA': $leyenda = '<span style="font-size: 1em" class="label label-info" >EN OFICINA</span>';
                return $leyenda;
                break;
            case 'EN CURSO': $leyenda = '<span style="font-size: 1em" class="label label-warning" >EN CURSO</span>';
                return $leyenda;
                break;
            case 'DESPACHO PARCIAL': $leyenda = '<span style="font-size: 1em" class="label label-danger" >DESPACHO PARCIAL</span>';
                return $leyenda;
                break;
            case 'DESPACHADO': $leyenda = '<span style="font-size: 1em" class="label label-primary" >DESPACHADO</span>';
                return $leyenda;
                break;
            case 'ENTREGADO': $leyenda = '<span style="font-size: 1em" class="label label-success" >ENTREGADO</span>';
                return $leyenda;
                break;
        }
    }

    function getcoloractivo($cod) {
        $leyenda = '';
        switch ($cod) {
            case '0': $leyenda = '<img src="../site/img/iconos/bullet-grey.png" height="15px" />';
                return $leyenda;
                break;
            case '1': $leyenda = '<img src="../site/img/iconos/bullet-green.png" height="15px" />';
                return $leyenda;
                break;
        }
    }

    //Registrar Archivos Adjuntos
    function insert_intraarchivo($archivo, $des) {
        $sql = "INSERT INTO intraarchivos(codigo, url, descripcion) values ('$this->coddesp', '$archivo', '$des');";
        $result = $this->consultas($sql);
        return $result;
    }

//    function getcantidaddespachos() {
//        $sql = "select coddesp from propdb02 where codprop = '$this->codprop' GROUP BY coddesp ORDER BY coddesp ASC;";
//        $result = $this->consultas($sql);
//        $lista = $this->n_Arreglo($result);
//        return $lista;
//    }
//
//    function getDespachosByCodPropAndDesp() {
//        $sql = "select codestado, coddesp, codprop, fecha, estado, obs, activo, fecreg, coduse from propdb02 where codprop = '$this->codprop' AND coddesp = '$this->coddesp' ORDER BY fecha ASC;";
//        $result = $this->consultas($sql);
//        $lista = $this->n_Arreglo($result);
//        return $lista;
//    }
//
//    function setactivo() {
//        $sql = "UPDATE propdb02 SET activo = '$this->activo' WHERE codestado = '$this->codestado' ";
//        $result = $this->consultas($sql);
//        return $result;
//    }
//
//    function setEstadoInactivo() {
//        $sql = "UPDATE propdb02 SET activo =  '0' WHERE coddesp = '$this->coddesp'";
//        $result = $this->consultas($sql);
//        return $result;
//    }
}

class C_DetalleDespacho {

    private $codigo;
    private $coddesp;
    private $fecha;
    private $estado;
    private $obs;
    private $domuser;
    private $mailde;
    private $mailnom;

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

    function getDatosEmail() {
        $sql = "SELECT p.codprop, u.desuse, u.email from propdb00 as p 
                JOIN despdb01 as d ON p.codprop = d.codprop  
                JOIN aausdb01 as u ON u.coduse =  p.asesor
                WHERE d.coddesp = '$this->coddesp';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function bodyEstadoDespacho($codprop, $vendedor) {

        $body = '<!DOCTYPE html>
            <html>
                <head>
                    <title>Despacho de Propuestas</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <style>
                        .container { font-family: sans-serif;}
                        .titulo {background-color: #00cccc; color: #f7f7f7; font-weight: bolder; padding: 10px;}
                        .vendedor {color: blue; font-weight: bolder; }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="titulo">DESPACHO DE PROPUESTAS</div>                    
                        <p>
                            Estimado(a) <span class="vendedor">' . $vendedor . '</span>, se le informa que la <strong>Propuesta Nro. ' . $codprop . '</strong>, ya se encuentra 
                            en <strong>Proceso de Despacho</strong> y su estado actual es: <strong>' . $this->estado . '</strong>.
                        </p>';
        if ($this->obs <> '') {
            $body.= '<p><strong>Observación:</strong><br/>' . $this->obs . '</p>';
        }

        $body.= ' </div>
                </body>
            </html>';
        return $body;
    }

    function sendmailEstadoDespacho() {
        require '../site/PHPMailer/class.phpmailer.php';

        $lista = $this->getDatosEmail();
        $codprop = $lista[0];
        $vendedor = $lista[1];
        $mailpara = $lista[2];

        $body = $this->bodyEstadoDespacho($codprop, $vendedor);
        $mail = new PHPMailer();
        $mail->From = "$this->mailde";
        $mail->FromName = "$this->mailnom";
        $mail->Subject = "DESPACHO DE PROPUESTA";
        $mail->Body = $body;
        $mail->IsHTML(true);
        //CORREOS        
        $mail->addAddress("$mailpara", "$vendedor");
        $mail->addCC("$this->mailde", "$this->mailnom"); //copia oculto        
        $mail->addCC('isandoval@humagroperu.com', "Isabel Sandoval");
        $mail->addBCC('sistemas@humagroperu.com', "Juan Leder"); //Copia oculta        
        //ENVIAR CORREO
        $mail->Send();
    }

    function generarCodDetalleDesp() {
        $sql = "select codigo from despdb02 group by codigo, fecreg ORDER BY fecreg desc limit 1;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $nsp = $lista[0];
        $numero = ($nsp) + 1;
        $num = ($numero);
        $existe = 1;
        while ($existe != 0) {
            $existe = $this->validarCodDetalleDesp($num);
            if ($existe != 0) {
                $numero++;
                $num = (1 + $numero);
            }
        }
        return $num;
    }

    function validarCodDetalleDesp($num) {
        $sql = "select count(codigo) from despdb02 where codigo = '$num';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $rpta = trim($lista[0]);
        return $rpta;
    }

    function n_fila($result) {
        $row = pg_fetch_row($result);
        return $row;
    }

    function insertarDetalleDespacho() {
        $sql = "INSERT INTO despdb02(codigo, coddesp, fecha, estado, obs, coduse) values ('$this->codigo', '$this->coddesp', '$this->fecha', '$this->estado', '$this->obs', '$this->domuser');";
        $result = $this->consultas($sql);
        return $result;
    }

    function modificarDetalleDespacho() {

        $sql = "UPDATE despdb02 SET "
                . "fecha = '$this->fecha', "
                . "estado = '$this->estado', "
                . "obs = '$this->obs', "
                . "usemod = '$this->domuser' "
                . "WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function deleteDetDespByCodigo() {

        $sql = "DELETE FROM despdb02 WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function deleteDetDespByCoddesp() {
        $sql = "DELETE FROM despdb02 WHERE coddesp = '$this->coddesp' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function getDetDespByCoddesp() {
        $sql = "select codigo, coddesp, fecha, estado, obs, fecreg, coduse from despdb02 where coddesp = '$this->coddesp' ORDER BY fecha ASC;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getLastDetDespByCoddesp() {
        $sql = "select codigo, coddesp, fecha, estado, obs, fecreg, coduse from despdb02 where coddesp = '$this->coddesp' ORDER BY fecha DESC, fecreg DESC LIMIT 1;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getDetDespByCodigo() {
        $sql = "select codigo, coddesp, fecha, estado, obs, fecreg, coduse from despdb02 where codigo = '$this->codigo';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

}
?>
<script type='text/javascript'>
    //    setTimeout("document.getElementById('mensaje').style.visibility='hidden'", 1000);
    $("#mensaje").delay(2000).hide(1000);
    function refresh()
    {
        location.reload(true);
    }
</script>
<?php
$obj = new C_Solicitud();
$pro = new C_Propuesta();
$desp = new C_Despacho();
if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {
        case 'regSolicitud':

//RECOGIENDO VARIABLES
            $obj->__set('codsolicitud', trim(strtoupper($_POST['codsolicitud'])));
            $obj->__set('codcliente', trim(strtoupper($_POST['codcliente'])));
            $obj->__set('codfundo', trim(strtoupper($_POST['codfundo'])));
            $obj->__set('coduse', trim(strtoupper($_SESSION['usuario'])));
            $obj->__set('asesor', trim(strtoupper($_SESSION['nombreUsuario'])));
            $obj->__set('nitrogeno', trim(strtoupper($_POST['nitrogeno'])));
            $obj->__set('urgencia', trim(strtoupper($_POST['urgencia'])));
            $obj->__set('ha', trim(strtoupper($_POST['ha'])));
            $obj->__set('cultivo', trim(strtoupper($_POST['cultivo'])));
            $obj->__set('variedad', trim(strtoupper($_POST['variedad'])));
            $obj->__set('tsuelo', trim(strtoupper($_POST['tsuelo'])));
            $obj->__set('triego', trim(strtoupper($_POST['triego'])));
            $obj->__set('notas', trim(strtoupper($_SESSION['notas'])));
            $obj->__set('estadosol', 'EN ESPERA');

//ALGORITMOS PARA REGISTRAR SOLICITUD            
//******************** OBTENER CODFERTILIZANTES
            $codcatfert = $_POST['detcodcatfert'];
            $codfert = $_POST['detcodfert'];
            $totkilfert = $_POST['dettotkilfert'];
            $unidadfert = $_POST['detunidadfert'];
            $preciofert = $_POST['detpreciofert'];
            $monedafert = $_POST['detmonedafert'];
            $igvfert = $_POST['detigvfert'];
            $totalfert = $_POST['dettotalfert'];
            $igvdesc = $_POST['detigvdesc'];
            $totalconigv = $_POST['dettotalconigv'];

            $detcodcatfert = explode(',', $codcatfert);
            $detcodfert = explode(',', $codfert);
            $dettotkilfert = explode(',', $totkilfert);
            $detunidadfert = explode(',', $unidadfert);
            $detpreciofert = explode(',', $preciofert);
            $detmonedafert = explode(',', $monedafert);
            $detigvfert = explode(',', $igvfert);
            $dettotalfert = explode(',', $totalfert);
            $detigvdesc = explode(',', $igvdesc);
            $dettotalconigv = explode(',', $totalconigv);

//******************** VARIABLES PARA PRODUCTOS HUMAGRO
            $codcatprod = $_POST['detcodcatprod'];
            $codprod = $_POST['detcodprod'];
            $canprod = $_POST['detcanprod'];
            $undprod = $_POST['detundprod'];

            $detcodcatprod = explode(',', $codcatprod);
            $detcodprod = explode(',', $codprod);
            $detcanprod = explode(',', $canprod);
            $detundprod = explode(',', $undprod);

//******************** VARIABLES CONTACTOS
            $codcontacto = $_POST['detcodcontacto'];
            $detcodcontacto = explode(',', $codcontacto);


//******************** REGISTRAR NUEVO CLIENTE *****************************
            if ($_POST['crearcliente'] == TRUE) {

                $ruc = trim($_POST['ruc']);
                $nomcliente = trim($_POST['nomcliente']);
                $obj->__set('nomcliente', $nomcliente);
                $rptaCli = $obj->regClienteSimple($ruc, $nomcliente);
                if ($rptaCli) {
//Crear Nuevo Fundo
                    $obj->__set('codcliente', trim(strtoupper($_POST['ruc'])));
                }
            }

//******************** REGISTRAR NUEVO CLIENTE *****************************
            if ($_POST['crearfundo'] == TRUE) {
//Crear Nuevo Fundo                                    
                $obj->__set('nomfundo', trim(strtoupper($_POST['nomfundo'])));

                $rptaFdo = $obj->regFundoSimple();
                if ($rptaFdo) {
                    $codfundo = $obj->getLastIDFundo();
                    $obj->__set('codfundo', trim($codfundo[0]));
                } else {
                    $obj->__set('codfundo', 'NULL');
                }
            }

//******************** REGISTRAR SOLICITUD DE PROPUESTA ********************
            $rpta = $obj->insertarSolicitud();

            if ($rpta) {

                //SUBIR IMAGENES                
                $ruta = '../site/archivos/solicitud_temp/';
                $destino = '../site/archivos/solicitud/';
                $archivos = glob($ruta . '*.*');

                foreach ($archivos as $archivo) {
                    $archivo_copiar = str_replace($ruta, $destino, $archivo);
                    copy($archivo, $archivo_copiar);
                }
                if (isset($_SESSION['nomarchivo'])) {
                    for ($i = 0; $i < count($_SESSION['nomarchivo']); $i++) {
                        $obj->subirArchivo($_SESSION['nomarchivo'][$i], $_SESSION['leyenda'][$i]);
                        //Borrar archivo
                        $dir = $ruta . $_SESSION['nomarchivo'][$i];
                        if (file_exists($dir)) {
                            unlink($dir);
                        }
                    }
                }

                //Registrar Estado de Solicitud
                //$regestado = $obj->insertar_prscdb06();
                //Registrar Nutriente
                if ($_POST['add_nutr'] == 'SI') {
                    //VARIABLES NUTRIENTES            
                    $detcodnutriente = $_POST['codnutriente'];
                    $detundnutriente = $_POST['undnutriente'];
                    for ($i = 0; $i < count($detcodnutriente); $i++) {

                        $regnut = $obj->insertar_prscdb02($detcodnutriente[$i], $detundnutriente[$i]);
                    }
                }

//Registrar Fertilizante
                if ($_POST['add_fert'] == 'SI') {
                    for ($i = 0; $i < count($detcodcatfert); $i++) {

                        $regfert = $obj->insertar_prscdb03($detcodcatfert[$i], $detcodfert[$i], $dettotkilfert[$i], $detunidadfert[$i], $detpreciofert[$i], $detmonedafert[$i], $detigvfert[$i], $dettotalfert[$i], $detigvdesc[$i], $dettotalconigv[$i]);
                    }
                }

//Registrar Productos Humagro
                if ($_POST['add_prod'] == 'SI') {
                    for ($i = 0; $i < count($detcodcatprod); $i++) {

                        $regprod = $obj->insertar_prscdb04($detcodcatprod[$i], $detcodprod[$i], $detcanprod[$i], $detundprod[$i]);
                    }
                }

//Registrar Contactos x Solicitud                
                $nomcontacto = $_POST['detnomcontacto'];
                $carcontacto = $_POST['detcarcontacto'];
                $celcontacto = $_POST['detcelcontacto'];

                $detnomcontacto = explode(',', $nomcontacto);
                $detcarcontacto = explode(',', $carcontacto);
                $detcelcontacto = explode(',', $celcontacto);

                for ($i = 0; $i < count($detcodcontacto); $i++) {
                    if ($detcodcontacto[$i] <> 'nuevo') {
                        $regcontxsol = $obj->insertar_prscdb05($detcodcontacto[$i]);
                    } else {
                        $obj->__set('nomcontacto', $detnomcontacto[$i]);
                        $obj->__set('carcontacto', $detcarcontacto[$i]);
                        $obj->__set('celcontacto', $detcelcontacto[$i]);
                        $regcont = $obj->regContactoSimple();
                        if ($regcont) {
                            $codcontacto = $obj->getLastIDContacto();
                            $regcontxsol = $obj->insertar_prscdb05($codcontacto[0]);
                        }
                    }
                }


//**********    CREAR PDF
                $obj->crearPDFSolicitud();
                $obj->enviarMailSolPropuesta_Prueba();
                ?>
                <div class="alert-success" style="vertical-align: middle;" id="mensaje">OK. Se registro con suceso :) </div>
            <?php } else { ?>
                <div class="alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo registrar. :(</div>
                <?php
            }

            break;

        case 'prueba':
            $codcat = $_POST['detcodcatfert'];
            $codfert = $_POST['detcodfert'];
            $nomnutr = $_POST['nomnutr'];
            $nomfert = $_POST['detnomfert'];
            $detnomfert = explode(',', $nomfert);



            $ncat = count($codcat);
            $nfer = count($codfert);

            echo 'cantidad de categorias = ' . $ncat;
            echo '<br/>';
            echo 'cantidad de fertilizantes = ' . $nfer;
            echo '<br/>';
            print_r($codcat);
            echo '<br/>';
            print_r($codfert);
            echo '<br/>';
            print_r($nomnutr);
            echo '<br/>';
            print_r($detnomfert);

            break;

        case 'RegPropuesta':

            $codprop = trim(strtoupper($_POST['codprop']));
            $pro->__set('codprop', $codprop);
            $pro->__set('codcliente', trim(strtoupper($_POST['codcliente'])));
            $pro->__set('nomcliente', trim(strtoupper($_POST['nomcliente'])));
            $pro->__set('contacto', trim(strtoupper($_POST['contacto'])));
            $pro->__set('fecha', trim(strtoupper($_POST['fecha'])));
            $pro->__set('asesor', trim(strtoupper($_POST['asesor'])));
            $pro->__set('elaboradopor', trim(strtoupper($_POST['elaboradopor'])));
            $pro->__set('obs', trim(strtoupper($_POST['obs'])));
            $pro->__set('monto', trim(strtoupper($_POST['monto'])));
            $pro->__set('moneda', trim(strtoupper($_POST['moneda'])));
            $pro->__set('descuento', trim(strtoupper($_POST['descuento'])));
            $pro->__set('cultivo', trim(strtoupper($_POST['cultivo'])));
            $pro->__set('ha', trim(strtoupper($_POST['ha'])));
            $pro->__set('domuser', $_SESSION['usuario']);
            $pro->__set('fecenvio', trim($_POST['fecenvio']));
            $pro->__set('aprobado', trim(strtoupper($_POST['aprobado'])));
            $pro->__set('obsaprob', trim(strtoupper($_POST['obsaprob'])));
            $pro->__set('version', trim($_POST['version']));
            $pro->__set('fpago', trim($_POST['fpago']));
            $pro->__set('tprecio', trim($_POST['tprecio']));
            $pro->__set('interes', trim($_POST['interes']));
            $pro->__set('zona', trim($_POST['zona']));
            $pro->__set('lugar', trim($_POST['lugar']));

            //VARIABLES PARA CORREO
            $pro->__set('mailde', trim($_POST['mailde']));
            $pro->__set('mailnom', trim($_POST['mailnom']));
            $pro->__set('mailpara', trim($_POST['mailpara']));
            $pro->__set('mailmsj', trim($_POST['mailmsj']));


            if (!empty($_POST['newcultivo'])) {
                $pro->__set('cultivo', trim(strtoupper($_POST['newcultivo'])));
            }

            if (isset($_POST['pxp'])) {
                $pro->__set('precioxprod', 'SI');
            } else {
                $pro->__set('precioxprod', 'NO');
            }

            if (isset($_POST['islts'])) {
                $pro->__set('islts', 'SI');
            } else {
                $pro->__set('islts', 'NO');
            }

            //VARIABLES PARA DESPACHO     
            if ($_POST['creardesp'] == 'SI') {
                $coddesp = $desp->generarCodDespacho();
                $desp->__set('coddesp', trim(strtoupper($coddesp)));
                $desp->__set('codprop', trim(strtoupper($codprop)));
                $desp->__set('prioridad', trim(strtoupper($_POST['prioridad'])));
                $desp->__set('montodesp', trim($_POST['montodesp']));
                $desp->__set('saldo', trim($_POST['saldo']));
                $desp->__set('moneda', trim(strtoupper($_POST['monedadesp'])));
                $desp->__set('fecprev', trim(strtoupper($_POST['fecprev'])));
                $desp->__set('descripcion', trim(strtoupper($_POST['descripcion'])));
                $desp->__set('obs', trim(strtoupper($_POST['obsdesp'])));
                $desp->__set('domuser', $_SESSION['usuario']);
            }

            //REGISTRAR PROPUESTA
            $result = $pro->insertarPropuesta();

            if ($result) {

                $directorio = '../site/archivos/propuestas/';

                //Subir Propuesta en PDF
                if (isset($_FILES['pdf']['name'])) {
                    $pro->uploadFile('pdf', 'PDF', '');
                }

                //Subir Propuesta en Word
                if (isset($_FILES['word']['name'])) {
                    $pro->uploadFile('word', 'WORD', '');
                }

                //Subir Propuesta en Excel
                if (isset($_FILES['excel']['name'])) {
                    $pro->uploadFile('excel', 'EXCEL', '');
                }

                //Subir Orden de Compra
                if (isset($_FILES['guiaoc']['name'])) {
                    $pro->uploadFile('guiaoc', 'GUIAOC', 'OC-');
                }

                //Subir Factura
                if (isset($_FILES['factura']['name'])) {
                    $pro->uploadFile('factura', 'FACTURA', 'FC-');
                }

                //Subir Guia de Remision
                if (isset($_FILES['remision']['name'])) {
                    $pro->uploadFile('remision', 'GUIA DE REMISION', 'GR-');
                }

                //insertar nuevo despacho
                if ($_POST['creardesp'] == 'SI') {
                    $result = $desp->registrarDespacho();
                }

                //ENVIAR MAIL

                if ($_POST['prueba'] == 'SI') {
                    $pro->sendmailPropAprobtoPrueba();
                } else {
                    if ($_POST['aprobado'] == 'APROBADO') {
                        if ($_POST['enviarmail'] == 'SI') {
                            //APROBADA Y COPIA AL VENDEDOR
                            $pro->sendmailPropAprobadaVend();
                        } else {
                            //APROBADA PERO NO COPIA AL VENDEDOR
                            $pro->sendmailPropAprobada();
                        }
                    } else {
                        //PROPUESTA ENVIADA
                        $pro->sendmailPropEnviada();
                    }
                }
                ?>

                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente. Correo enviado.');
                    from_unico('<?php echo $codprop; ?>', 'principal', '_propuestav1.php');
                </script>
                <?php
            } else {
                ?>
                <script>alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');</script>
                <?php
            }

            break;

        case 'ActPropAprob':

            //Codigo deo Propuesta Aprobada
            $codprop = trim(strtoupper($_POST['codprop']));
            $codpropnew = trim(strtoupper($_POST['codprop_new']));
            if ($codpropnew <> $codprop) {
                $pro->__set('codprop', $codpropnew);
                //actualizar codpropuesta en tabla archivos
                $pro->actualizarCodPropInFile($codprop);
            } else {
                $pro->__set('codprop', $codprop);
            }

            $pro->__set('codcliente', trim(strtoupper($_POST['codcliente'])));
            $pro->__set('contacto', trim(strtoupper($_POST['contacto'])));
            $pro->__set('fecha', trim(strtoupper($_POST['fecha'])));
            $pro->__set('asesor', trim(strtoupper($_POST['asesor'])));
            $pro->__set('elaboradopor', trim(strtoupper($_POST['elaboradopor'])));
            $pro->__set('obs', trim(strtoupper($_POST['obs'])));
            $pro->__set('monto', trim(strtoupper($_POST['monto'])));
            $pro->__set('moneda', trim(strtoupper($_POST['moneda'])));
            $pro->__set('descuento', trim(strtoupper($_POST['descuento'])));
            $pro->__set('ha', trim(strtoupper($_POST['ha'])));
            $pro->__set('precioxprod', trim(strtoupper($_POST['precioxprod'])));
            $pro->__set('islts', trim(strtoupper($_POST['islts'])));
            $pro->__set('domuser', trim(strtoupper($_SESSION['usuario'])));
            $pro->__set('cultivo', trim(strtoupper($_POST['cultivo'])));
            if (!empty($_POST['newcultivo'])) {
                $pro->__set('cultivo', trim(strtoupper($_POST['newcultivo'])));
            }

            $pro->__set('fecenvio', trim(strtoupper($_POST['fecenvio'])));
            $pro->__set('version', trim(strtoupper($_POST['version'])));
            $pro->__set('aprobado', trim(strtoupper($_POST['aprobado'])));
            $pro->__set('obsaprob', trim(strtoupper($_POST['obsaprob'])));
            $pro->__set('fpago', trim(strtoupper($_POST['fpago'])));
            $pro->__set('tprecio', trim(strtoupper($_POST['tprecio'])));
            $pro->__set('interes', trim($_POST['interes']));


            //****************************** ACTUALIZAR ARCHIVOS ******************************
            //*
            //****************************** ACTUALIZANDO PROPUESTA EN PDF ******************************            
            if (isset($_POST['pdf']) && isset($_FILES['pdf_new']['name'])) {
                $fileold = $_POST['pdf'];
                $pro->replaceFile($fileold, 'pdf_new', '');
            }
            if (isset($_FILES['pdf_upload']['name'])) {
                $pro->uploadFile('pdf_upload', 'PDF', '');
            }

            //****************************** ACTUALIZANDO PROPUESTA EN WORD ******************************            
            if (isset($_POST['word']) && isset($_FILES['word_new']['name'])) {
                $fileold = $_POST['word'];
                $pro->replaceFile($fileold, 'word_new', '');
            }
            if (isset($_FILES['word_upload']['name'])) {
                $pro->uploadFile('word_upload', 'WORD', '');
            }

            //****************************** ACTUALIZANDO PROPUESTA EN EXCEL ******************************            
            if (isset($_POST['excel']) && isset($_FILES['excel_new']['name'])) {
                $fileold = $_POST['excel'];
                $pro->replaceFile($fileold, 'excel_new', '');
            }
            if (isset($_FILES['excel_upload']['name'])) {
                $pro->uploadFile('excel_upload', 'EXCEL', '');
            }

            //****************************** ACTUALIZANDO PROPUESTA EN ORDEN DE COMPRA ******************************            
            if (isset($_POST['guiaoc']) && isset($_FILES['guiaoc_new']['name'])) {
                $fileold = $_POST['guiaoc'];
                $pro->replaceFile($fileold, 'guiaoc_new', 'OC-');
            }
            if (isset($_FILES['guiaoc_upload']['name'])) {
                $pro->uploadFile('guiaoc_upload', 'GUIAOC', 'OC-');
            }

            //****************************** ACTUALIZANDO FACTURA ******************************            
            if (isset($_POST['factura']) && isset($_FILES['factura_new']['name'])) {
                $fileold = $_POST['factura'];
                $pro->replaceFile($fileold, 'factura_new', 'FC-');
            }
            if (isset($_FILES['factura_upload']['name'])) {
                $pro->uploadFile('factura_upload', 'FACTURA', 'FC-');
            }

            //****************************** ACTUALIZANDO FACTURA ******************************            
            if (isset($_POST['remision']) && isset($_FILES['remision_new']['name'])) {
                $fileold = $_POST['remision'];
                $pro->replaceFile($fileold, 'remision_new', 'GR-');
            }
            if (isset($_FILES['remision_upload']['name'])) {
                $pro->uploadFile('remision_upload', 'GUIA DE REMISION', 'GR-');
            }

            $pro->modificarPropAprob();
            if ($pro) {

                if ($_POST['correo'] == 'actualizacion') {
                    $pro->sendmailPropActualizada();
                } elseif ($_POST['correo'] == 'aprobacion') {
                    $pro->sendmailPropAprobada();
                }
                ?>
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se actualizo con suceso :) </div>
                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente.');
                    from_unico('<?php echo $_POST['codprop']; ?>', 'principal', '_propuestav1_ver.php');
                </script>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo actualizar. :(</div>
                <script>alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');</script>                
                <?php
            }

            break;

        case 'RegDespacho':

            $coddesp = $desp->generarCodDespacho();

            $desp->__set('coddesp', trim(strtoupper($coddesp)));
            $desp->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $desp->__set('prioridad', trim(strtoupper($_POST['prioridad'])));
            $desp->__set('montodesp', trim($_POST['montodesp']));
            $desp->__set('saldo', trim($_POST['saldo']));
            $desp->__set('moneda', trim(strtoupper($_POST['moneda'])));
            $desp->__set('fecprev', trim(strtoupper($_POST['fecprev'])));
            $desp->__set('descripcion', trim(strtoupper($_POST['descripcion'])));
            $desp->__set('obs', trim(strtoupper($_POST['obs'])));
            $desp->__set('domuser', $_SESSION['usuario']);

            //insertar nuevo despacho
            $result = $desp->registrarDespacho();
            if ($result) {
                ?>
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se registro con suceso :) </div>                
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo registrar. :(</div>                
                <?php
            }

            break;

        case 'ActDespacho':

            $desp->__set('coddesp', trim(strtoupper($_POST['coddesp'])));
            $desp->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $desp->__set('prioridad', trim(strtoupper($_POST['prioridad'])));
            $desp->__set('fecprev', trim(strtoupper($_POST['fecprev'])));
            $desp->__set('montodesp', trim($_POST['montodesp']));
            $desp->__set('saldo', trim($_POST['saldo']));
            $desp->__set('moneda', trim(strtoupper($_POST['moneda'])));
            $desp->__set('descripcion', trim(strtoupper($_POST['descripcion'])));
            $desp->__set('obs', trim(strtoupper($_POST['obs'])));
            $desp->__set('domuser', $_SESSION['usuario']);

            //ACTUALIZAR despacho
            $result = $desp->modificarDespacho();
            if ($result) {
                ?>
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se actualizó con suceso :) </div>                
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo actualizar. :(</div>
                <?php
            }

            break;

        case 'RegDetDespacho':

            $detd = new C_DetalleDespacho();
            $codigo = $detd->generarCodDetalleDesp();

            $detd->__set('codigo', trim(strtoupper($codigo)));
            $detd->__set('coddesp', trim(strtoupper($_POST['coddesp'])));
            $detd->__set('fecha', trim(strtoupper($_POST['fecha'])));
            $detd->__set('estado', trim(strtoupper($_POST['estado'])));
            $detd->__set('obs', trim(strtoupper($_POST['obs'])));
            $detd->__set('domuser', $_SESSION['usuario']);
            $detd->__set('mailnom', $_SESSION['nombreUsuario']);
            $detd->__set('mailde', $_SESSION['email_usuario']);

            //insertar nuevo detalle de despacho
            $result = $detd->insertarDetalleDespacho();
            if ($result) {
                $detd->sendmailEstadoDespacho();
                ?>
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se registro con suceso :) </div>                
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo registrar. :(</div>                
                <?php
            }

            break;

        case 'ActDetDespacho':

            $detd = new C_DetalleDespacho();
            $detd->__set('codigo', trim(strtoupper($_POST['codigo'])));
            $detd->__set('fecha', trim(strtoupper($_POST['fecha'])));
            $detd->__set('estado', trim(strtoupper($_POST['estado'])));
            $detd->__set('obs', trim(strtoupper($_POST['obs'])));
            $detd->__set('domuser', $_SESSION['usuario']);

            //insertar nuevo detalle de despacho
            $result = $detd->modificarDetalleDespacho();
            if ($result) {
                ?>
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se actualizó con suceso :) </div>                
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo actualizar. :(</div>
                <?php
            }

            break;

        case 'RegPropxAprob':
            //propdb10
            //AVERIGUAR SI YA EXISTE ESE CODIGO DE PROPUESTA
            $codprop = trim($_POST['codprop']);
            $pro->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $existe = $pro->existeCodPropuesta();

            if ($existe) {
                ?>
                <script>
                    alert('ESTE CODIGO YA EXISTE. CAMBIE EL CODIGO DE LA PROPUESTA.');
                    $("#codprop").focus();
                </script>
                <?php
            } else {
                if (isset($_SESSION['item']) && isset($_SESSION['car'])) {
                    $vectoritem = $_SESSION['item'];
                    $vectocar = $_SESSION['car'];
                    $vectorund = $_SESSION['und'];
                    $vectordesp = $_SESSION['cardesp'];

                    $cantitem = count($vectoritem);
                    $cantvcar = count($vectocar);
                    $cantvund = count($vectorund);
                    $cantdesp = count($vectordesp);
                    //Obteniendo Parametros para Tabla Propuesta propdb10
                    $pro->__set('codcliente', trim(strtoupper($_POST['codcliente'])));
                    $pro->__set('nomcliente', trim(strtoupper($_POST['nomcliente'])));
                    $pro->__set('asunto', trim($_POST['asunto']));
                    $pro->__set('descripcion', trim($_POST['obs']));
                    $pro->__set('estadoaprob', trim('PENDIENTE'));
                    //$pro->__set('tipocotizacion', trim(strtoupper($_POST['tipoprop'])));
                    $pro->__set('variedad', trim(strtoupper($_POST['variedad'])));
                    $pro->__set('efenologica', trim(strtoupper($_POST['efenologica'])));
                    $pro->__set('domuser', trim($_SESSION['usuario']));
                    $pro->__set('asesor', trim($_POST['vendedor']));
                    $pro->__set('codasesorexterno', trim($_POST['asesorexterno']));
                    $pro->__set('elaboradopor', trim($_SESSION['nombreUsuario']));
                    $pro->__set('demo', trim($_POST['demo']));
                    $pro->__set('condiciones', trim($_POST['condiciones']));
                    $pro->__set('antecedentes', trim($_POST['antecedentes']));
                    $pro->__set('fpago', trim($_POST['fpago']));

                    //VALIDAR CONTACTO
                    $pro->__set('contactos', trim($_POST['contacto']));
                    if (trim($_POST['contacto']) === 'otro') {
                        $pro->__set('contactos', trim($_POST['newcontacto']));
                    }

                    //REGISTRAR NUEVO CULTIVO
                    if (trim(strtoupper($_POST['newcultivo'])) <> '') {
                        $pro->__set('cultivo', trim(strtoupper($_POST['newcultivo'])));
                        $pro->registrarCultivo();
                    } elseif ($_POST['cultivo'] <> '0') {
                        $exp_cultivo = explode(',', $_POST['cultivo']);
                        $cultivo = $exp_cultivo[1];
                        $pro->__set('cultivo', $cultivo);
                    }

                    //REGISTRAR NUEVA VARIEDAD
                    if (trim(strtoupper($_POST['newvariedad'])) <> '') {
                        $pro->__set('variedad', trim(strtoupper($_POST['newvariedad'])));
                        $pro->registrarVariedad();
                    }

                    //REGISTRAR NUEVA ETAPA FENOLOGICA
                    if (trim(strtoupper($_POST['newefenologica'])) <> '') {
                        $pro->__set('efenologica', trim(strtoupper($_POST['newefenologica'])));
                        $pro->registrarEfenologica();
                    }

                    //REGISTRAR NUEVO CLIENTE
                    if (!empty(trim($_POST['ruc'])) || !empty(trim($_POST['razonsocial']))) {
                        $ruc = trim($_POST['ruc']);
                        $nomcliente = trim($_POST['razonsocial']);
                        $abrev = trim($_POST['abrev']);
                        $rptaCli = $pro->insert_intracliente_simple($ruc, $nomcliente, $abrev);
                        if ($rptaCli) {
                            $pro->__set('codcliente', trim(strtoupper($ruc)));
                            $pro->__set('nomcliente', trim(strtoupper($nomcliente)));
                        } else {
                            ?>
                            <script>
                                alert('EL NUMERO DE DNI O RUC YA EXISTE EN LA BASE DE DATOS.');
                            </script>
                            <?php
                            return FALSE;
                        }
                    }

                    //REGISTRA PROPUESTA
                    $result = $pro->insertPropxAprob();
                    if ($result) {

                        $exito = true;
                        for ($i = 0; $i < $cantitem; $i++) {

                            //VARIABLES PARA INSERTAR ITEM
                            $coditem = $pro->generarCodItemProp();
                            if ($coditem) {
                                $pro->__set('coditem', $coditem);
                            } else {
                                $pro->__set('coditem', '1');
                            }

                            $plantilla = $vectoritem[$i][7];
                            $pud = $vectoritem[$i][8];
                            $ha = $vectoritem[$i][5];
                            //$modificado = $vectoritem[$i][11];

                            $pro->__set('descuento', trim($vectoritem[$i][0]));
                            $pro->__set('pcc', trim($vectoritem[$i][1]));
                            $pro->__set('pca', trim($vectoritem[$i][2]));
                            $pro->__set('precioAMBT', $vectoritem[$i][3]);
                            $pro->__set('fa', $vectoritem[$i][4]);
                            $pro->__set('ha', $vectoritem[$i][5]);
                            $pro->__set('nitrogeno', $vectoritem[$i][6]);
                            $pro->__set('plantilla', trim($plantilla));
                            $pro->__set('pud', trim($pud));
                            $pro->__set('estadoitem', trim($vectoritem[$i][9]));
                            $pro->__set('modificado', trim($vectoritem[$i][10]));
                            $pro->__set('incluyeigv', trim($vectoritem[$i][11]));
                            $pro->__set('valigv', trim($vectoritem[$i][12]));
                            $pro->__set('itemdesc', trim($vectoritem[$i][13]));

                            //*** INSERTAR ITEM
                            $rptaitem = $pro->insertItem();
                            if ($rptaitem) {

                                //INSERTAR UNIDADES EN LA TABLA propdb13

                                if ($plantilla == 'HECTAREA PAQ') {

                                    if (count($cantvund) > 0) {
                                        foreach ($vectorund[$i] as $unidad) {
                                            $codnut = $unidad['codnut'];
                                            $und = $unidad['unidad'];
                                            $ord = $unidad['orden'];
                                            $pro->insert_propdb13($codnut, $und, $ord);
                                        }
                                    }
                                }

                                ///REGISTRAR PRE DETALLE PRODUCTOS
                                $size = count($vectocar[$i]);
                                if ($size > 0) {
                                    foreach ($vectocar[$i] as $carrito) {

                                        $cantidadtotal = $carrito['cantidad'] * $ha;
                                        $costototal = ($cantidadtotal * $carrito['preciodcto']);
                                        $preciodcto = $carrito['preciodcto'];

                                        $pro->__set('ordenta', $carrito['ordenta']);
                                        $pro->__set('ordenprod', $carrito['ordenprod']);
                                        $pro->__set('codprod', $carrito['codprod']);
                                        $pro->__set('cantidad', $carrito['cantidad']);
                                        $pro->__set('cantidadtotal', $cantidadtotal);
                                        $pro->__set('costo', $carrito['precio']);
                                        $pro->__set('costototal', $costototal);
                                        $pro->__set('preciodcto', $preciodcto);
                                        $pro->__set('umedida', $carrito['umedida']);
                                        $pro->__set('taplicacion', $carrito['tipoa']);
                                        $pro->__set('congelado', $carrito['congelado']);

                                        $result2 = $pro->insertPropxAprobDetalle();
                                        if ($result2) {
                                            
                                        } else {
                                            $exito = false;
                                            ?><script>alert('Error al registrar CARRITO de Productos');</script><?php
                                        }
                                    }
                                }

                                //REGISTRAR DETALLE PRODUCTOS (REDONDEADO)
                                if ($cantdesp > 0) {
                                    foreach ($vectordesp[$i] as $cardesp) {

                                        $codprod = $cardesp['codprod'];
                                        $cantidad1 = $cardesp['cantidad1'];
                                        $cantidad2 = $cardesp['cantidad2'];
                                        $umedida1 = $cardesp['umedida1'];
                                        $umedida2 = $cardesp['umedida2'];
                                        $preciou = $cardesp['precio1'];
                                        $preciodcto = $cardesp['precio2'];
                                        $preciototal = $cardesp['preciototal'];
                                        $factorb = $cardesp['factorb'];

                                        $result100 = $pro->insert_propdb14($codprod, $cantidad1, $cantidad2, $umedida1, $umedida2, $preciou, $preciodcto, $preciototal, $factorb);
                                        if ($result100) {
                                            
                                        } else {
                                            $exito = false;
                                            ?><script>alert('Error al registrar DISTRIBUCION de Productos');</script><?php
                                        }
                                    }
                                }
                            } else {
                                ?><script>alert('Error al registrar ITEM');</script><?php
                                $exito = false;
                            }
                        }

                        //ENVIAR MAIL
                        if ($exito) {

                            if ($_SESSION['usuario'] <> 'PRUEBA') {
                                $pro->sendmailPropxAprob();
                            }
                            unset($_SESSION['item']);
                            unset($_SESSION['car']);
                            unset($_SESSION['und']);
                            unset($_SESSION['cardesp']);
                            //$pro->sendmail_propinsert_gerente();
                            ?>
                            <script>
                                alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente.');
                                from_unico('', 'principal', '_propuestav2.php');
                            </script>
                            <?php
                        }
                    } else {
                        ?>
                        <script>alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');</script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        alert('DEBE CREAR AL MENOS UN ITEM.');
                    </script>
                    <?php
                }
            }
            break;

        case 'UpdatePropuestaV2':

            $pro->__set('codpropold', trim(strtoupper($_POST['codpropold'])));
            $pro->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $pro->__set('codcliente', trim(strtoupper($_POST['codcliente'])));
            $pro->__set('nomcliente', trim(strtoupper($_POST['nomcliente'])));
            $pro->__set('asunto', trim($_POST['asunto']));
            $pro->__set('descripcion', trim($_POST['obs']));
            $pro->__set('cultivo', trim(strtoupper($_POST['cultivo'])));
            $pro->__set('variedad', trim(strtoupper($_POST['variedad'])));
            $pro->__set('efenologica', trim(strtoupper($_POST['efenologica'])));
            $pro->__set('contactos', trim($_POST['contactos']));
            $pro->__set('elaboradopor', trim($_SESSION['nombreUsuario']));
            $pro->__set('asesor', trim($_POST['vendedor']));
            $pro->__set('zona', trim(strtoupper($_POST['zona'])));
            $pro->__set('lugar', trim(strtoupper($_POST['lugar'])));
            $pro->__set('demo', trim(strtoupper($_POST['demo'])));
            $pro->__set('fpago', trim(strtoupper($_POST['fpago'])));
            $pro->__set('antecedentes', trim($_POST['antecedentes']));
            $pro->__set('domuser', trim($_SESSION['usuario']));

            $result = $pro->update_propdb10();

            if ($result) {

                //ACTUALIZAR PROPDB12
                $ndetitem = $_POST['ndetitem'];
                for ($c = 0; $c < $ndetitem; $c++) {

                    $pro->__set('coditem', trim($_POST['coditem' . $c]));
                    $pro->__set('itemdesc', trim(strtoupper($_POST['pv2_itemdesc' . $c])));
                    $pro->__set('descuento', trim(strtoupper($_POST['pv2_descuento' . $c])));
                    $pro->__set('pcc', trim($_POST['pv2_pcc' . $c]));
                    $pro->__set('pca', trim($_POST['pv2_pca' . $c]));
                    $pro->__set('precioAMBT', trim($_POST['precioambt' . $c]));
                    $pro->__set('fa', trim($_POST['pv2_fa' . $c]));
                    $pro->__set('ha', trim($_POST['pv2_ha' . $c]));
                    $pro->__set('nitrogeno', trim($_POST['pv2_nitrogeno' . $c]));
                    $pro->__set('plantilla', trim($_POST['pv2_plantilla' . $c]));
                    $pro->__set('pud', trim($_POST['pv2_pud' . $c]));
                    $pro->__set('estadoitem', trim($_POST['pv2_estado' . $c]));
                    $pro->__set('modificado', trim($_POST['pv2_modificado' . $c]));
                    $resultpropdb12 = $pro->update_propdb12();

                    if ($resultpropdb12) {

                        //ACTUALIZAR PROPDB11 -> PRODUCTOS
                        //cantidad de productos en el carrito dentro de un item.
                        $ncar = $_POST['ncar' . $c];
                        for ($i = 0; $i < $ncar; $i++) {
                            $pro->__set('codprod', trim($_POST['codprod' . $c . $i]));
                            $pro->__set('taplicacion', trim($_POST['taplicacion' . $c . $i]));
                            $pro->__set('cantidad', trim($_POST['litros' . $c . $i]));
                            $pro->__set('costo', trim($_POST['precio' . $c . $i]));
                            $pro->__set('costototal', trim($_POST['costototal' . $c . $i]));
                            $pro->__set('preciodcto', trim($_POST['preciodcto' . $c . $i]));
                            $pro->__set('cantidadtotal', trim($_POST['ltsxha' . $c . $i]));
                            $pro->__set('ordenta', trim($_POST['ordenta' . $c . $i]));
                            $pro->__set('ordenprod', trim($_POST['ordenprod' . $c . $i]));
                            $pro->__set('umedida', trim($_POST['umedida' . $c . $i]));

                            //Actualizar Datos                            
                            $resultpropdb11 = $pro->update_propdb11();
                            if ($resultpropdb11) {
                                
                            } else {
                                return FALSE;
                            }
                        }
                    } else {
                        return false;
                    }
                }
                //$pro->sendmailMsjAprobacion();
                ?>
                <script>
                    //alert('Entre a UpdatePropuestaV2');
                    alert('OK :)!! Se ha actualizado el estado de la propuesta.');
                    //from_unico('', 'principal', '_propuestav2_aprob01.php');
                </script>
                <?php
            } else {
                ?>
                <script>alert('ERROR :(!! No se pudo actualizar esta propuesta.');</script>
                <?php
            }
            break;

        //cambiar estado de propuesta desde intranet
        case 'AprobPropuesta':
            $pro->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $pro->__set('obs_aprob', trim(strtoupper($_POST['obs_aprob'])));
            $pro->__set('estadoaprob', trim(strtoupper($_POST['estadoaprob'])));
            $pro->__set('elaboradopor', trim(strtoupper($_POST['elaboradopor'])));

            $result = $pro->aprobarPropuesta();
            if ($result) {
                $pro->sendmailMsjAprobacion();
                ?>
                <script>
                    alert('OK :)!! Se ha actualizado el estado de la propuesta.');
                    from_unico('', 'bodytable', '_propuestav2_aprob01.php');
                </script>
                <?php
            } else {
                ?>
                <script>alert('ERROR :(!! No se pudo actualizar esta propuesta.');</script>
                <?php
            }
            break;

        //cambiar estado de propuesta desde verweb
        case 'AprobPropuesta2':
            $pro->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $pro->__set('elaboradopor', trim(strtoupper($_POST['elaboradopor'])));

            $codigo = trim(strtoupper($_POST['codprop']));
            $bandera = true;
            $vectoritem = $_SESSION['itemcar'];
            $cantitem = count($vectoritem);
            $aprobaciontotal = TRUE;
            for ($i = 0; $i < $cantitem; $i++) {
                //VARIABLES PARA INSERTAR ITEM
                $coditem = $vectoritem[$i]['coditem'];
                $pro->__set('coditem', $coditem);
                $pro->__set('itemdesc', $vectoritem[$i]['itemdesc']);
                $pro->__set('descuento', $_POST['dscto' . $i]);
                $pro->__set('pcc', $_POST['pcc' . $i]);
                $pro->__set('pca', $_POST['pca' . $i]);
                $pro->__set('precioAMBT', $_POST['preambt' . $i]);
                $pro->__set('fa', $_POST['fau' . $i]);
                $pro->__set('ha', $_POST['pv2_ha' . $i]);
                $pro->__set('nitrogeno', $_POST['pv2_nitrogeno' . $i]);
                $pro->__set('plantilla', $_POST['pv2_plantilla' . $i]);
                $pro->__set('pud', $_POST['pv2_pud' . $i]);
                $pro->__set('estadoitem', $_POST['estadoitem' . $i]);
                $pro->__set('modificado', $_POST['modificado' . $i]);



                $result = $rptaitem = $pro->update_propdb12();
                if ($result) {
                    //bloqueado temporalmente hasta que este listo                    
                    ?>
                    <script>
                        alert('OK :)!! Se ha actualizado el estado de la propuesta.');
                        location.href = '../site/_propuestav2_aprob03_rpta.php?cod=<?php echo $codigo; ?>';
                    </script>
                    <?php
                } else {
                    ?>
                    <script>alert('ERROR :(!! No se pudo actualizar esta propuesta.');</script>
                    <?php
                    $bandera = false;
                    return;
                }
            }
            if ($bandera) {
                //$pro->generarPropuestaenPDF();
                $pro->sendmailMsjAprobacion();
            }

            break;

        case 'DespachoAdjunto':
            $pro->__set("codprop", trim($_POST['codprop']));
            //Subir Propuesta en PDF
            if (isset($_FILES['nomarchivo']['name'])) {
                $result = $pro->uploadFileNombreOriginal('nomarchivo', 'DESPACHO', 'DESP-');
                if ($result) {
                    ?>
                    <script>alert('OK :)!! El archivo se subio exitosamente.');</script>
                    <?php
                } else {
                    ?>
                    <script>alert('ERROR :(!! No se pudo subir el archivo.');</script>
                    <?php
                }
            }
            break;

        case 'RegComentario':

            $pro->__set('codprop', $_POST['codprop']);
            $pro->__set('coditem', $_POST['coditem']);
            $comentario = $_GET['comentario'];
            $desuse = $_SESSION['nombreUsuario'];
            $pro->insert_propdb15($comentario, $desuse);

            if (isset($_FILES['nomarchivo']['name'])) {
                $result = $pro->uploadFileNombreOriginal('nomarchivo', 'DESPACHO', 'DESP-');
                if ($result) {
                    ?>
                    <script>alert('OK :)!! El archivo se subio exitosamente.');</script>
                    <?php
                } else {
                    ?>
                    <script>alert('ERROR :(!! No se pudo subir el archivo.');</script>
                    <?php
                }
            }
            break;

        default:
            break;
    }
}