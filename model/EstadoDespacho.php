<?php

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

    function obtenerNombreCliente($codprop) {
        $sql = "select codprop, c.codcliente, nombre, asesor, desuse from propdb00 as p 
                JOIN intracliente as c on c.codcliente = p.codcliente
                JOIN aausdb01 as u on u.coduse = asesor 
                where codprop = '$codprop'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
        
    }

    function bodyEstadoDespacho($codprop, $vendedor) {
        $datos = $this->obtenerNombreCliente($codprop);
        
        $nomcliente = $datos[2];
        //$vendedor = $datos[4];


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
                        </p>
                        <p>Cliente: '.strtoupper($nomcliente).'</p>
                        <p>Vendedor: '.strtoupper($vendedor).'</p>';
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
        $mail->addCC('isandoval@agromicrobiotech.com', "Isabel Sandoval");
        $mail->addCC('acomercial@agromicrobiotech.com', "Jenifer Rivera");
        $mail->addBCC('reporteshumasoft@agromicrobiotech.com', "Juan Leder"); //Copia oculta        
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
                . "usemod = '$this->domuser', "
                . "fecmod = now() "
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
