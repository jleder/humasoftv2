<?php

class C_Propuesta {

//Escriba tus variables
    private $codprop;
    private $codpropold;
    private $codcliente;
    private $nomcliente;
    private $contacto;
    private $demo;
    private $fecha;
    private $asesor;
    private $elaboradopor;
    private $obs;
    private $url;
    private $descripcion;
    private $monto;
    private $descuento;
    private $cultivo;
    private $variedad;
    private $efenologica;
    private $ha;
    private $moneda;
    private $precioxprod;
    private $urgencia;
    private $domuser;
    private $numdespacho;
    private $fecenvio;
    private $aprobado;
    private $obs_aprob;
    private $version;
    private $islts;
    private $tprecio;
    private $interes;
    private $incluyeigv;
    private $valigv;
    private $fpago;
    private $obs_atec;
    //variables de propuesta a ser aprobada por el gerente
    private $asunto;
    private $pcc;
    private $pca;
    private $precioAMBT;
    private $fa; //factor aprobacion
    private $estadoaprob;
    private $codprod;
    private $cantidad;
    private $cantidadtotal;
    private $costo;
    private $costototal;
    private $preciodcto;
    private $umedida;
    private $taplicacion;
    private $coditem;
    private $itemdesc;
    private $contactos;
    private $nitrogeno;
    //private $codasesorexterno; Se elimina esta variable porque el vendedor externo se almacenara en el campo codvendedor y nomvendedor
    private $codvendedor;
    private $nomvendedor;
    private $congelado;
    private $pud;
    private $pup;
    private $estadoitem;
    private $modificado;
    private $desuse;
    private $condiciones;
    private $trato;
    private $verfc;
    //variables de propdb13
    private $codnut;
    private $unidad;
    private $factor;
    private $ordenund;
    //variables de propdb14 distribucion
    private $dis_codprop;
    private $dis_codprod;
    private $dis_coditem;
    private $dis_cantidad1;
    private $dis_cantidad2;
    private $dis_umedida1;
    private $dis_umedida2;
    private $dis_preciou;
    private $dis_preciodcto;
    private $dis_preciototal;
    private $dis_factorb;
    private $dis_ordenprod;
    //variables de propdb15 comentario
    private $comm_codigo;
    private $comm_comentario;
    //variables de propdb17
    private $cond_text;
    private $cond_orden;
    //Variables de Mail
    private $mailde;
    private $mailnom;
    private $mailpara;
    private $mailcc;
    private $mailasunto;
    private $mailmsj;
    private $ordenta;
    private $ordenprod;
    private $zona;
    private $lugar;
    private $plantilla;
    private $codcomentario;
    
    //Nuevas variables
    private $estado_ger;
    private $estado_com;
        

    public function __get($atrb) {
        return $this->$atrb;
    }

    public function __set($atrb, $val) {
        $this->$atrb = $val;
    }

    public function set($atrb, $val) {
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

    function generarCodItemProp() {
        $sql = "select coditem from propdb12 order by coditem desc, fecreg desc limit 1;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $codigo = $lista[0];
        //$codigo = '220';

        $existe = 1;
        while ($existe != 0) {
            $existe = $this->validarCodItemProp($codigo);
            if ($existe != 0) {
                $codigo++;
            }
        }
        return $codigo;
    }

    function validarCodItemProp($codigo) {
        $sql = "select count(coditem) from propdb12 where coditem = '$codigo'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $rpta = trim($lista[0]);
        return $rpta;
    }

    function listar_catzona() {
        $sql = "SELECT codtab, codele, desele, coduse FROM altbdb01 where codtab = 'ZC' and codele <> '' ORDER BY codele;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listar_zonabycat($catzona) {
        $sql = "SELECT codigo, lugar  FROM zona WHERE zona = '$catzona' ;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function insertarPropuesta() {
        $sql = "INSERT INTO propdb00(codprop, codcliente, contacto, fecaprob, asesor, elaboradopor, obs, monto, descuento, cultivo, ha, moneda, precioxprod, coduse, fecenvio, aprobado, obsaprob, version, fpago, islts, tprecio, interes, zona, lugar) values ('$this->codprop', '$this->codcliente', '$this->contacto', '$this->fecha', '$this->asesor', '$this->elaboradopor', '$this->obs', '$this->monto', '$this->descuento', '$this->cultivo', '$this->ha', '$this->moneda', '$this->precioxprod', '$this->domuser', '$this->fecenvio', '$this->aprobado', '$this->obsaprob', $this->version, '$this->fpago', '$this->islts', '$this->tprecio', '$this->interes', '$this->zona', '$this->lugar');";
        $result = $this->consultas($sql);
        return $result;
    }

    function insertarArchivos() {
        $sql = "INSERT INTO intraarchivos(codigo, url, descripcion) values ('$this->codprop', '$this->url', '$this->descripcion');";
        $result = $this->consultas($sql);
        return $result;
    }    

    function getFileDespachoByCodprop() {
        $sql = "select codarchivo, codigo, url, descripcion from intraarchivos where codigo = '$this->codprop' and descripcion = 'DESPACHO' ";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function searchFileProp($descripcion) {
        $sql = "select codarchivo, codigo, url, descripcion from intraarchivos where codigo = '$this->codprop' and descripcion = '$descripcion' ";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    //nomfile = nombre de campohtml
    function uploadFile($nomfile, $descripcion, $prefijo) {
        $rpta = false;
        $directorio = '../site/archivos/propuestas/';
        $file = $_FILES[$nomfile]['name'];
        if (!empty($_FILES[$nomfile]['name'])) {

            $tmpfile = $_FILES[$nomfile]['tmp_name']; //nombre temporal de la imagen                                            
            $result_explode = end(explode('.', $file));
            $extension = $result_explode;

            $file = trim(strtoupper($_POST['codprop']));
            $file = $prefijo . $file . '.' . $extension;
            move_uploaded_file($tmpfile, "$directorio$file"); //movemos el archivo a la carpeta de destino                

            $this->__set('url', $file);
            $this->__set('descripcion', $descripcion);
            $rpta = $this->insertarArchivos();
        }
        return $rpta;
    }

    function uploadFileNombreOriginal($nomfile, $descripcion, $prefijo) {
        $rpta = false;
        $directorio = '../site/archivos/propuestas/';
        $file = $_FILES[$nomfile]['name'];
        if (!empty($_FILES[$nomfile]['name'])) {

            $tmpfile = $_FILES[$nomfile]['tmp_name']; //nombre temporal de la imagen                                            
            //$result_explode = end(explode('.', $file));
            //$extension = $result_explode;
            //$file = trim(strtoupper($_POST['codprop']));
            $file = $prefijo . $file;
            move_uploaded_file($tmpfile, ("$directorio$file")); //movemos el archivo a la carpeta de destino                

            $this->__set('url', $file);
            $this->__set('descripcion', $descripcion);
            $rpta = $this->insertarArchivos();
        }
        return $rpta;
    }

    function replaceFile($fileold, $nomfile, $prefijo) {
        $directorio = '../site/archivos/propuestas/';
        $file = $_FILES[$nomfile]['name'];
        if (!empty($_FILES[$nomfile]['name'])) {

            //*************** Eliminar actual propuesta PDF
            $this->deleteURLFilePropAprob($fileold);

            $tmpfile = $_FILES[$nomfile]['tmp_name']; //nombre temporal de la imagen                                            
            $result_explode = end(explode('.', $file));
            $extension = $result_explode;

            $file = trim(strtoupper($_POST['codprop']));
            $file = $prefijo . $file . '.' . $extension;
            move_uploaded_file($tmpfile, "$directorio$file"); //movemos el archivo a la carpeta de destino                            
        }
    }

    function modificarPropAprob() {

        $sql = "UPDATE propdb00 SET "
                . "codprop = '$this->codprop', "
                . "contacto = '$this->contacto', "
                . "elaboradopor = '$this->elaboradopor', "
                . "obs = '$this->obs', "
                . "usemod = '$this->domuser', "
                . "fecmod = now(), "
                . "asesor = '$this->asesor', "
                . "monto = '$this->monto', "
                . "descuento = '$this->descuento', "
                . "cultivo = '$this->cultivo', "
                . "ha = '$this->ha', "
                . "fecaprob = '$this->fecha', "
                . "moneda = '$this->moneda', "
                . "precioxprod = '$this->precioxprod', "
                . "fecenvio = '$this->fecenvio', "
                . "version = '$this->version', "
                . "obsaprob = '$this->obsaprob', "
                . "aprobado = '$this->aprobado', "
                . "fpago = '$this->fpago', "
                . "islts = '$this->islts', "
                . "tprecio = '$this->tprecio', "
                . "interes = '$this->interes' "
                . "WHERE codprop = '$this->codprop' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function actualizarCodPropInFile($codigo) {
        $sql = "UPDATE intraarchivos SET "
                . "codigo = '$this->codprop' "
                . "WHERE codigo = '$codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function deletePropuesta() {
        $sql = "DELETE FROM propdb00 WHERE codprop = '$this->codprop' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function deleteArchivos() {
        $sql = "DELETE FROM intraarchivos WHERE codigo = '$this->codprop' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function listarAsesores() {
        $sql = "SELECT coduse, desuse FROM aausdb01 WHERE vendedor = 'SI' AND activo = 't' order by desuse;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarVendedores() {
        $sql = "SELECT e.codpersona, concat(nombre ||' '|| apellido) vendedor, cargo, profesion, e.tipo, es_vendedor, email, p.trato from hs_epddb01 as e
                JOIN hs_psndb01 as p ON p.codpersona = e.codpersona
                WHERE p.activo = 't' and es_vendedor = 't' and tipo = 'I'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarAsesoresExternos() {
        $sql = "SELECT u.coduse, u.desuse, a.dni FROM aausdb01 as u JOIN vsvedb02 as a ON a.usuario = u.coduse WHERE activo = 't' AND externo = 'SI';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarVendedoresExternos() {
        $sql = "SELECT e.codpersona, concat(nombre ||' '|| apellido) vendedor, cargo, profesion, e.tipo, es_vendedor, email from hs_epddb01 as e
                JOIN hs_psndb01 as p ON p.codpersona = e.codpersona
                WHERE p.activo = 't' and es_vendedor = 't' and tipo = 'E'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarPropuestas() {
        $sql = "SELECT codprop, p.codcliente, p.contacto, p.fecaprob, u.desuse as asesor, elaboradopor, obs, desuse, c.nombre as cliente, cultivo, ha, monto, descuento, moneda, precioxprod, urgencia, p.asesor, fecenvio, aprobado, obsaprob, version, fpago, islts, tprecio, interes, u.desuse as vendedor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse ORDER BY p.fecreg desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarPropAprobByAsesor() {
        $sql = "SELECT codprop, p.codcliente, p.contacto, p.fecaprob, u.desuse as asesor, elaboradopor, obs, desuse, c.nombre as cliente, cultivo, ha, monto, descuento, moneda, precioxprod, urgencia, p.asesor, fecenvio, aprobado, obsaprob, version, fpago, islts, tprecio, interes, u.desuse as vendedor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where p.asesor = '$this->asesor' ORDER BY p.fecaprob DESC";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getOnlyPropAprobadas() {
        $sql = "select p.codprop, p.fecaprob, u.desuse as asesor, c.nombre as cliente, contacto, ha, cultivo, monto, descuento, moneda, precioxprod, urgencia, fecenvio, obsaprob, version, aprobado, islts, tprecio, u.desuse as vendedor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse where aprobado = 'APROBADO' order by fecaprob desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getOnlyPropAprobadasByCliente() {
        $sql = "select p.codprop, p.fecaprob, u.desuse as asesor, c.nombre as cliente, contacto, ha, cultivo, monto, descuento, moneda, precioxprod, urgencia, fecenvio, obsaprob, version, aprobado, islts, tprecio, u.desuse as vendedor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse where aprobado = 'APROBADO' AND p.codcliente = '$this->codcliente'  order by fecaprob desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getOnlyPropEnviadas() {
        $sql = "select p.codprop, p.fecaprob, u.desuse as asesor, c.nombre as cliente, contacto, ha, cultivo, monto, descuento, moneda, precioxprod, urgencia, fecenvio, obsaprob, version, aprobado, islts, tprecio, u.desuse as vendedor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse where aprobado <> 'APROBADO' and aprobado <> 'NO APROBADO' order by fecaprob desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getDespachosByPropuesta() {
        $sql = "SELECT codestado, coddesp, codprop, fecha, estado, obs, coduse, activo FROM propdb02 WHERE codprop = '$this->codprop' and activo = '1' order by coddesp;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropAprobByCod() {
        $sql = "SELECT codprop, p.codcliente, p.contacto, p.fecaprob, u.desuse as asesor, elaboradopor, obs, desuse, c.nombre as cliente, cultivo, ha, monto, descuento, moneda, precioxprod, urgencia, p.asesor, fecenvio, aprobado, obsaprob, version, fpago, islts, tprecio, interes
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where codprop = '$this->codprop'  order by p.fecaprob desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getPropuestaEnviadasByVendedor() {
        $sql = "select p.codprop, p.fecaprob, u.desuse as asesor, c.nombre as cliente, contacto, ha, cultivo, monto, descuento, moneda, precioxprod, urgencia, fecenvio, obsaprob, version, aprobado, islts, tprecio, u.desuse as vendedor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where aprobado <> 'APROBADO' and aprobado <> 'NO APROBADO' AND p.asesor = '$this->asesor' order by p.fecaprob desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropuestaAprobadasByVendedor() {
        $sql = "select p.codprop, p.fecaprob, u.desuse as asesor, c.nombre as cliente, contacto, ha, cultivo, monto, descuento, moneda, precioxprod, urgencia, fecenvio, obsaprob, version, aprobado, islts, tprecio, u.desuse as vendedor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where aprobado = 'APROBADO' AND p.asesor = '$this->asesor'  order by p.fecaprob desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropuestaTodasByVendedor() {
        $sql = "select p.codprop, p.fecaprob, u.desuse as asesor, c.nombre as cliente, contacto, ha, cultivo, monto, descuento, moneda, precioxprod, urgencia, fecenvio, obsaprob, version, aprobado, islts, tprecio, u.desuse as vendedor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where p.asesor = '$this->asesor'  order by p.fecaprob desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getestiloestado($estado) {
        $leyenda = '';
        switch ($estado) {
            case 'EN VENDEDOR': $leyenda = 'estado_vend';
                return $leyenda;
            case 'EN CLIENTE': $leyenda = 'estado_clie';
                return $leyenda;
            case 'EN SEGUIMIENTO': $leyenda = 'estado_seg';
                return $leyenda;
            case 'APROBADO': $leyenda = 'estado_aprob';
                return $leyenda;
            case 'NO APROBADO': $leyenda = 'estado_noaprob';
                return $leyenda;
        }
    }

    function getParimpar($numero) {

        $estilo = '';

        if ($numero % 2 == 0) {
            //echo "el $numero es par";
            $estilo = 'fila1';
        } else {
            //echo "el $numero es impar";
            $estilo = 'fila2';
        }
        return $estilo;
    }

    function getPropAprobByCodByAsesor() {
        $sql = "SELECT codprop, p.codcliente, p.contacto, p.fecaprob, u.desuse as asesor, elaboradopor, obs, desuse, c.nombre as cliente, cultivo, ha, monto, descuento, moneda, precioxprod, urgencia, p.asesor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where codprop = '$this->codprop' and p.asesor = '$this->asesor';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getPropAprobadaByRango($desde, $hasta) {
        $sql = "select p.codprop, p.fecaprob, u.desuse as asesor, c.nombre as cliente, contacto, ha, cultivo, monto, descuento, moneda, precioxprod, urgencia, fecenvio, obsaprob, version, aprobado, islts, tprecio, u.desuse as vendedor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where p.fecaprob between date('$desde') and date('$hasta');";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropAprobadaByRangoByAsesor($desde, $hasta) {
        $sql = "SELECT codprop, p.codcliente, p.contacto, p.fecaprob, u.desuse as asesor, elaboradopor, obs, desuse, c.nombre as cliente, cultivo, ha, monto, descuento, moneda, precioxprod, urgencia, p.asesor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where p.asesor = '$this->asesor' and p.fecaprob between date('$desde') and date('$hasta');";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getArchivosByCod() {
        $sql = "SELECT codigo, url, descripcion FROM intraarchivos WHERE codigo = '$this->codprop';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropAprobByCliente() {
        $sql = "select p.codprop, p.fecaprob, u.desuse as asesor, c.nombre as cliente, contacto, ha, cultivo, monto, descuento, moneda, precioxprod, urgencia, fecenvio, obsaprob, version, aprobado, islts, tprecio, u.desuse as vendedor
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where p.codcliente = '$this->codcliente' order by p.fecaprob desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropAprobByClienteByAsesor() {
        $sql = "SELECT codprop, p.codcliente, p.contacto, p.fecaprob, u.desuse as asesor, elaboradopor, obs, desuse, c.nombre as cliente, cultivo, ha, monto, descuento, moneda, precioxprod, urgencia, p.asesor
                    FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                    JOIN aausdb01 as u ON p.asesor = u.coduse
                    where p.codcliente = '$this->codcliente' and p.asesor = '$this->asesor' order by p.fecaprob desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getArchivoByCodPropuesta($tipo) {
        $sql = "SELECT codigo, url, descripcion, codarchivo FROM intraarchivos WHERE codigo = '$this->codprop' and descripcion = trim('$tipo');";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getArchivoByCodProp() {
        $sql = "SELECT codigo, url, descripcion, codarchivo FROM intraarchivos WHERE codigo = '$this->codprop';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function deleteFilePropAprob($codigo, $file) {
        $ruta = '../site/archivos/propuestas/';
        $dir = $ruta . $file;
        if (file_exists($dir)) {
            unlink($dir);
        }
        $sql = "DELETE FROM intraarchivos WHERE codarchivo = '$codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function deleteURLFilePropAprob($file) {
        $ruta = '../site/archivos/propuestas/';
        $dir = $ruta . $file;
        if (file_exists($dir)) {
            unlink($dir);
        }
    }

    function getArchivoByCodPropuestaOnly() {
        $sql = "SELECT codigo, url, descripcion FROM intraarchivos WHERE codigo = '$this->codprop';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function sendmailPropActualizada() {
        require '../site/PHPMailer/class.phpmailer.php';
        $mail = new PHPMailer();
        $mailremite = $_SESSION['email_usuario'];
        $nomremite = $_SESSION['nombreUsuario'];
        $mail->From = "$mailremite";
        $mail->FromName = "$nomremite";
        $mail->Subject = 'ACTUALIZACION DE PROPUESTA Nro: ' . $this->codprop;
        $mail->Body = 'Se ha modificado la Propuesta Nro. ' . $this->codprop . ' por favor verificar cambios';
        $mail->IsHTML(true);
        $mail->addCC("$mailremite", "$nomremite");
        $mail->addAddress('isandoval@agromicrobiotech.com', "Isabel Sandoval");
        $mail->addCC('reportes@humagroperu.com', "Salvador Giha");
        $mail->addBCC('reporteshumasoft@agromicrobiotech.com', "Juan Leder"); //Copia oculta
        $mail->Send();
    }

    function sendmailPropAprobtoPrueba() {
        require '../site/PHPMailer/class.phpmailer.php';
        $body = $this->bodyPropAprob();
        //$body = file_get_contents('../site/_propuestav1_mailbody_regmsg.php?codprop=PROPUESTA56');
        $mailremite = $_SESSION['email_usuario'];
        $nomremite = $_SESSION['nombreUsuario'];
        $mail = new PHPMailer();
        $mail->From = "$mailremite";
        $mail->FromName = "$nomremite";
        $mail->Subject = 'Propuesta Nro: ' . $this->codprop;
        $mail->Body = $body;
        $mail->IsHTML(true);
        $mail->addAddress('reporteshumasoft@agromicrobiotech.com', "Juan Leder");
        $mail->Send();
    }

    //Mensaje cuando una propuesta es aprobada por el cliente.
    function sendmailMsjAprobacionACaDESP() {
        require '../site/PHPMailer/class.phpmailer.php';
        $body = $this->bodyMsjAprobacionACaDESP();
        $mailremite = $_SESSION['email_usuario'];
        $nomremite = $_SESSION['nombreUsuario'];
        $mail = new PHPMailer();
        $mail->From = "$mailremite";
        $mail->FromName = "$nomremite";
        $mail->Subject = 'PROPUESTA APROBADA POR CLIENTE - ' . $this->nomcliente;
        $mail->Body = $body;
        $mail->IsHTML(true);
        $mail->addAddress($this->mailpara);
        //$mail->addCC($mailremite, $nomremite);
        //$mail->addCC('reportes@humagroperu.com', "Salvador Giha");
        //$mail->addBCC('sistemas@agromicrobiotech.com', "Juan Leder"); //Copia oculta
//        $mail->addBCC('acomercial@agromicrobiotech.com', "Jennifer Rivera");
        if($mail->Send()){
            return true;
        }else{
            return false;
        }
    } 
    
    //Mensaje cuando una propuesta es aprobada por el cliente.
    function sendmailMsjAprobacionACaVEND() {
        require '../site/PHPMailer/class.phpmailer.php';
        $body = $this->bodyMsjAprobacionACaVEND();
        $mailremite = $_SESSION['email_usuario'];
        $nomremite = $_SESSION['nombreUsuario'];
        $mail = new PHPMailer();
        $mail->From = "$mailremite";
        $mail->FromName = "$nomremite";
        $mail->Subject = 'PROPUESTA ELABORADA PARA ' . $this->nomcliente;
        $mail->Body = $body;
        $mail->IsHTML(true);
        $mail->addAddress($this->mailpara);
        $mail->addCC($this->mailcc);
        //$mail->addCC($mailremite, $nomremite);
        //$mail->addCC('reportes@humagroperu.com', "Salvador Giha");
        //$mail->addBCC('sistemas@agromicrobiotech.com', "Juan Leder"); //Copia oculta
//        $mail->addBCC('acomercial@agromicrobiotech.com', "Jennifer Rivera");
        //ARCHIVOS ADJUNTOS
        $archivo = '../site/archivos/propuestas/' . $this->codprop . '.pdf';
        $mail->AddAttachment($archivo, $this->codprop);
        if($mail->Send()){
            return true;
        }else{
            return false;
        }
    }

    function sendmailPropAprobadaVend() {
        require '../site/PHPMailer/class.phpmailer.php';
        $body = $this->bodyPropAprob();
        $mail = new PHPMailer();
        $mail->From = "$this->mailde";
        $mail->FromName = "$this->mailnom";
        $mail->Subject = $this->nomcliente . ' - PROPUESTA N° ' . $this->codprop;
        $mail->Body = $body;
        $mail->IsHTML(true);
        //CORREOS        
        $mail->addAddress("$this->mailpara", "");
        $mail->addCC("$this->mailde", "$this->mailnom");
        $mail->addCC('isandoval@agromicrobiotech.com', "Isabel Sandoval");
        $mail->addCC('reportes@humagroperu.com', "Salvador Giha");
        $mail->addBCC('reporteshumasoft@agromicrobiotech.com', "Juan Leder"); //Copia oculta
        //ARCHIVOS ADJUNTOS
        $archivo = '../site/archivos/propuestas/' . $this->codprop . '.pdf';
        $mail->AddAttachment($archivo, $this->codprop);
        //ENVIAR CORREO
        $mail->Send();
    }

    function bodyPropAprob() {
        $lista = $this->getPropAprobByCod();
        $monto = $lista[13] . ' ' . number_format($lista[11], 2);

        $body = '<!DOCTYPE html>
            <html>
                <head>
                    <title>Cuerpo Propuesta Aprobada</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <style>
                        .container { font-family: sans-serif;}
                        .titulo {background-color: #00ff00; color: blue; font-weight: bolder;}
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="titulo">PROPUESTA APROBADA</div>
                    <table>            
                        <tbody>
                            <tr>
                                <td>NRO PROPUESTA</td>
                                <td width="50px">:</td>
                                <td>' . $lista[0] . '</td>
                            </tr>
                            <tr>
                                <td>CLIENTE</td>
                                <td>:</td>
                                <td>' . $lista[8] . '</td>
                            </tr>
                            <tr>
                                <td>CONTACTO</td>
                                <td>:</td>
                                <td>' . $lista[2] . '</td>
                            </tr>
                            <tr>
                                <td>VENDEDOR</td>
                                <td>:</td>
                                <td>' . $lista[4] . '</td>
                            </tr>
                            <tr>
                                <td>CULTIVO</td>
                                <td>:</td>
                                <td>' . $lista[9] . '</td>
                            </tr>                            
                        </tbody>
                    </table>
                    <p style="color: blue">' . $this->mailmsj . '</p>
                    <p style="color: white">MODULOPROPUESTAHUMASOFT</p>
            </div>
                </body>
            </html>';
        return $body;
    }

    function sendmailPropEnviada() {
        require '../site/PHPMailer/class.phpmailer.php';
        $body = $this->bodyPropEnviada();
        $mail = new PHPMailer();
        $mail->From = "$this->mailde";
        $mail->FromName = "$this->mailnom";
        $mail->Subject = $this->nomcliente . ' - PROPUESTA N° ' . $this->codprop;
        $mail->Body = $body;
        $mail->IsHTML(true);
        //CORREOS                
        $mail->addAddress("$this->mailde", "$this->mailnom");
        $mail->addCC('reportes@humagroperu.com', "Salvador Giha");
        $mail->addBCC('reporteshumasoft@agromicrobiotech.com', "Juan Leder"); //Copia oculta
        //ARCHIVOS ADJUNTOS
        $archivo = '../site/archivos/propuestas/' . $this->codprop . '.pdf';
        $mail->AddAttachment($archivo, $this->codprop);
        //ENVIAR CORREO
        $mail->Send();
    }

    function sendmailPropEnviadaVendedor() {
        require '../site/PHPMailer/class.phpmailer.php';
        $body = $this->bodyPropEnviada();
        $mail = new PHPMailer();
        $mail->From = "$this->mailde";
        $mail->FromName = "$this->mailnom";
        $mail->Subject = $this->nomcliente . ' - PROPUESTA N° ' . $this->codprop;
        $mail->Body = $body;
        $mail->IsHTML(true);
        //CORREOS        
        $mail->addAddress("$this->mailpara", "");
        $mail->addCC("$this->mailde", "$this->mailnom"); //copia oculto        
        $mail->addCC('reportes@humagroperu.com', "Salvador Giha");
        $mail->addBCC('reporteshumasoft@agromicrobiotech.com', "Juan Leder"); //Copia oculta
        //ARCHIVOS ADJUNTOS
        $archivo = '../site/archivos/propuestas/' . $this->codprop . '.pdf';
        $mail->AddAttachment($archivo, $this->codprop);
        //ENVIAR CORREO
        $mail->Send();
    }

    function bodyPropEnviada() {
        $lista = $this->getPropAprobByCod();
        $monto = $lista[13] . ' ' . number_format($lista[11], 2);

        $body = '<!DOCTYPE html>
            <html>
                <head>
                    <title>Cuerpo Propuesta</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <style>
                        .container { font-family: sans-serif;}
                        .titulo { color: blue; font-weight: bolder;}
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="titulo">PROPUESTA REGISTRADA</div>
                    <table>            
                        <tbody>
                            <tr>
                                <td>NRO PROPUESTA</td>
                                <td width="50px">:</td>
                                <td>' . $lista[0] . '</td>
                            </tr>
                            <tr>
                                <td>CLIENTE</td>
                                <td>:</td>
                                <td>' . $lista[8] . '</td>
                            </tr>
                            <tr>
                                <td>CONTACTO</td>
                                <td>:</td>
                                <td>' . $lista[2] . '</td>
                            </tr>
                            <tr>
                                <td>VENDEDOR</td>
                                <td>:</td>
                                <td>' . $lista[4] . '</td>
                            </tr>
                            <tr>
                                <td>CULTIVO</td>
                                <td>:</td>
                                <td>' . $lista[9] . '</td>
                            </tr>                                                 
                        </tbody>
                    </table>
                    <br/>
                    <p style="color: blue">' . $this->mailmsj . '</p>
                    <p style="color: white">MODULOPROPUESTAHUMASOFT</p>
            </div>
                </body>
            </html>';
        return $body;
    }

    function getnivelurgencia($cod) {
        $leyenda = '';
        switch ($cod) {
            case 1: $leyenda = '<span style="font-size: 1em;" class="label label-danger" >Muy Urgente</span>';
                return $leyenda;
                break;
            case 2: $leyenda = '<span style="font-size: 1em;" class="label label-warning" >Urgente</span>';
                return $leyenda;
                break;
            case 3: $leyenda = '<span style="font-size: 1em;" class="label label-info" >Normal</span>';
                return $leyenda;
                break;
            case 4: $leyenda = '<span style="font-size: 1em;" class="label label-default" >Dentro de 7 dias</span>';
                return $leyenda;
                break;
        }
    }

    //***************************************************************
    ///Funciones Propuestas a Ser Aprobadas por el Gerente.
    //***************************************************************

    function getLast5Factores() {
        $sql = "SELECT i.codprop, i.fa, i.fecreg, i.estado, i.descuento, i.pud, i.coditem  from propdb12 as i JOIN propdb10 as p ON p.codprop = i.codprop JOIN intracliente as c ON c.codcliente = p.codcliente
                WHERE P.codcliente = '$this->codcliente' AND i.estado = 'APROBADO' LIMIT 5;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getCantidadProductosByItem() {
        $sql = "SELECT count(*) from propdb11 where coditem = '$this->coditem'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista[0];
    }

    function getPropuestasxAprobGerente() {
        $sql = "SELECT codprop, codcliente, nomcliente, descripcion, fecreg, fpago, demo, vendedor from propdb10 order by fecreg desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropuestasATecnica() {
        $sql = "SELECT codprop, codcliente, nomcliente, descripcion, fecreg, fpago, demo, vendedor from propdb10 order by fecreg desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropuestasAComercial() {
        $sql = "SELECT d.codprop, codcliente, nomcliente, p.descripcion, p.fecreg, p.fpago, p.demo, p.vendedor, d.estado
                FROM propdb12 as d JOIN propdb10 as p ON p.codprop = d.codprop
                WHERE d.estado = 'APROBADO' GROUP BY d.codprop, p.codcliente, nomcliente, p.descripcion, p.fecreg, p.fpago, p.demo, p.vendedor, d.estado ORDER BY p.fecreg desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropuestasxAprobGerenteByCliente() {
        $sql = "SELECT codprop, codcliente, nomcliente, descripcion, fecreg, fpago, demo, vendedor from propdb10 where codcliente = '$this->codcliente' order by fecreg desc;";

        /* $sql = "select p.codprop, p.fecaprob, u.desuse as asesor, c.nombre as cliente, contacto, ha, cultivo, monto, descuento, moneda, precioxprod, urgencia, fecenvio, obsaprob, version, aprobado, islts, tprecio, u.desuse as vendedor
          FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
          JOIN aausdb01 as u ON p.asesor = u.coduse
          where p.codcliente = '$this->codcliente' order by p.fecaprob desc;";
         * 
         */
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropuestasxAprobGerenteByCod() {
        //$sql = "SELECT codprop, codcliente, nomcliente, descripcion, descuento, preconfirmado, (7) preaprox, preambt, factoraprob, 10, ha, 11,     12, asunto, coduse, vendedor, elaboradopor,           18  cultivo, variedad, efenologica, zona, 22, lugar, demo, condiciones from propdb10 where codprop = '$this->codprop' order by fecreg desc;";
        $sql = "SELECT codprop, codcliente, nomcliente, descripcion, fecreg, contactos, asunto, coduse, vendedor, elaboradopor, cultivo, variedad, efenologica, zona, lugar, demo, condiciones, obs_atec, fpago, intereses, trato, numdespacho, codvendedor from propdb10 where codprop = '$this->codprop' order by fecreg desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getCorreoByCodVendedor() {
        $sql = "select pz.codpersona, nombre, apellido, email, pz.codjefe
                from hs_epddb02 as pz
                JOIN hs_psndb01 as p ON p.codpersona = pz.codpersona
                WHERE p.codpersona = '$this->codvendedor';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getItemByCodProp() {
        $sql = "SELECT coditem, codprop, itemdesc, coduse, fecreg, descuento, pcc, pca, precioambt, fa, ha, plantilla, nitrogeno, pud, estado, modificado, incluyeigv, valigv, pup, verfc from propdb12 where codprop = '$this->codprop' order by fecreg asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getComentariosByCodItem() {
        $sql = "SELECT codigo, codprop, coditem, comentario, c.desuse, c.coduse, c.usemod, c.fecreg, c.fecmod, u.imagen
                FROM propdb15 as c JOIN aausdb01 as u ON c.coduse = u.coduse 
                WHERE coditem = '$this->coditem' order by c.fecreg asc;";
        //$sql = "SELECT codigo, codprop, coditem, comentario, desuse, coduse, usemod, fecreg, fecmod from propdb15 where coditem = '$this->coditem' order by fecreg asc;";        
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropuestasPendientes() {
        $sql = "SELECT codprop, codcliente, nomcliente, descripcion, fecreg, fpago, demo, vendedor from propdb10 order by fecreg desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function lastIDCultivo() {
        $sql = "select max(codele) from altbdb01 where codtab = 'TC'  limit 1";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista[0];
    }

    function lastIDVariedad($codcultivo) {
        $sql = "SELECT max(codigo) FROM alvadb01 where trim(codcate) = '$codcultivo';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista[0];
    }

    function lastIDEfenologica() {
        $sql = "select max(codele) from altbdb01 where codtab = 'EF'  limit 1";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista[0];
    }

    function lastIDCultivoByDesele() {
        $sql = "SELECT codele from altbdb01 where codtab = 'TC' and TRIM(desele) = '$this->cultivo';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista[0];
    }

    //Insertar comentarios de Item
    function insert_propdb15() {
        $sql = "INSERT INTO propdb15(codprop, coditem, comentario, desuse, coduse) values ('$this->codprop', '$this->coditem', '$this->comentario', '$this->desuse', '$this->domuser')";
        $result = $this->consultas($sql);
        return $result;
    }

    function update_propdb15() {
        $sql = "UPDATE propdb15 SET "
                . "codprop = '$this->codprop', "
                . "coditem = '$this->coditem', "
                . "comentario = '$this->comm_comentario', "
                . "usemod = '$this->domuser', "
                . "fecmod = now() "
                . "WHERE codigo = '$this->comm_codigo';";
        $result = $this->consultas($sql);
        return $result;
    }

    function delete_propdb15() {
        $sql = "DELETE from propdb15 where coditem = '$this->coditem';";
        $result = $this->consultas($sql);
        return $result;
    }

    function delete_propdb15ByCodigo() {
        $sql = "DELETE from propdb15 where codigo = '$this->codcomentario';";
        $result = $this->consultas($sql);
        return $result;
    }

    function insert_variedad($codcate, $codigo) {
        $sql = "INSERT INTO alvadb01(codcate, codigo, nombre, fecreg, coduse, codcia) values ('$codcate', '$codigo', '$this->variedad', now(), '$this->domuser', '01')";
        $result = $this->consultas($sql);
        return $result;
    }

    function insert_cultivo($codele) {
        $sql = "INSERT INTO altbdb01(codtab, codele, desele, coduse, fecreg, codcia) values ('TC', '$codele', '$this->cultivo', '$this->domuser', now(), '01')";
        $result = $this->consultas($sql);
        return $result;
    }

    function insert_efenologica($codele) {
        $sql = "INSERT INTO altbdb01(codtab, codele, desele, coduse, fecreg, codcia) values ('EF', '$codele', '$this->efenologica', '$this->domuser', now(), '01')";
        $result = $this->consultas($sql);
        return $result;
    }

    function registrarCultivo() {
        $cod = $this->lastIDCultivo();
        $codele = trim($cod) + 1;
        if ($codele < '10') {
            echo '<br/>es menor a 10';
            $codele = '0' . $codele;
        } else {
            echo '<br/>NO es menor a 10';
        }
        $this->insert_cultivo($codele);
    }

    function registrarVariedad() {
        $codcate = $this->lastIDCultivoByDesele();
        $cod = $this->lastIDVariedad(trim($codcate));
        if ($cod) {
            $result_explode = explode('-', $cod);
            $codvar = $result_explode[1];
            $codvarnew = trim($codvar) + 1;
        } else {
            $codvarnew = '100';
        }
        $codigo = trim($codcate) . '-' . $codvarnew;
        $this->insert_variedad($codcate, $codigo);
    }

    function registrarEfenologica() {
        $cod = $this->lastIDEfenologica();
        $codele = trim($cod) + 1;
        $this->insert_efenologica($codele);
    }

    function insertPropxAprob() {
        $sql = "INSERT INTO propdb10(codprop, codcliente, nomcliente, contactos, asunto, descripcion, cultivo, variedad, efenologica, coduse, fecreg, vendedor, elaboradopor, demo, obs_atec, fpago, trato, numdespacho, condiciones, codvendedor) VALUES('$this->codprop', '$this->codcliente', '$this->nomcliente', '$this->contactos', '$this->asunto',  '$this->descripcion', '$this->cultivo', '$this->variedad', '$this->efenologica', '$this->domuser', now(), '$this->nomvendedor', '$this->elaboradopor', '$this->demo', '$this->obs_atec', '$this->fpago', '$this->trato', '$this->numdespacho', '$this->condiciones', '$this->codvendedor');";
        $result = $this->consultas($sql);
        return $result;
    }

    function insert_propdb13($codnut, $unidad, $orden, $fc) {
        $sql = "INSERT INTO propdb13(codprop, coditem, codnut, unidad, orden, coduse, fc) VALUES ('$this->codprop', '$this->coditem', '$codnut', '$unidad', '$orden', '$this->domuser', '$fc');";
        $result = $this->consultas($sql);
        return $result;
    }

    function getUnidades() {
        $sql = "SELECT codprop, coditem, codnut, unidad, fc from propdb13 where codprop = '$this->codprop' and coditem = '$this->coditem' order by orden;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function update_propdb10() {
        $sql = "UPDATE propdb10 SET "
                . "codprop = '$this->codprop', "
                . "codcliente = '$this->codcliente', "
                . "nomcliente = '$this->nomcliente', "
                . "asunto = '$this->asunto', "
                . "descripcion = '$this->descripcion', "
                . "cultivo = '$this->cultivo', "
                . "variedad = '$this->variedad', "
                . "efenologica = '$this->efenologica', "
                . "contactos = '$this->contactos', "
                . "elaboradopor = '$this->elaboradopor', "
                . "vendedor = '$this->asesor', "
                . "zona = '$this->zona', "
                . "obs_atec = '$this->obs_atec', "
                . "lugar = '$this->lugar', "
                . "demo = '$this->demo', "
                . "fpago = '$this->fpago', "
                . "usemod = '$this->domuser', "
                . "fecmod = now() "
                . "WHERE codprop = '$this->codpropold';";
        $result = $this->consultas($sql);
        return $result;
    }

    function deletePropxAprob() {
        $sql = "DELETE FROM propdb10 WHERE codprop = '$this->codprop' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function getDetallePropxAprobGerenteByCodProp() {
        $sql = "SELECT codprop, codprod, nombre, cantidad, costo, costototal, dp.umedida, dp.coduse, dp.fecreg, dp.taplicacion, dp.ordenta, dp.ordenprod, preciodcto, dp.congelado
                FROM propdb11 as dp JOIN alardb01 as p ON p.codigo = dp.codprod
                WHERE codprop = '$this->codprop' and coditem = '$this->coditem' order by dp.ordenta asc, p.orden asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getProdxPrecioByCod() {
        $sql = "SELECT codigo, codcate, nombre, codigoprov, umedida, stkmin, stkmax, pventa, observa, palmacen, peso, umed_com, lithec, descorto, codlis, precio, desele, p.orden
                FROM alardb01 as p JOIN lista_precio2 as l ON p.codigo = l.codigoprod 
                JOIN altbdb01 as c ON c.codele = p.codcate
                WHERE p.codigo = '$this->codprod' AND c.codtab= 'CF' ORDER BY codcate, codigo, codlis;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //insert propdb11
    function insertPropxAprobDetalle() {
        $sql = "INSERT INTO propdb11(codprop, codprod, coditem, cantidad, costo, costototal, umedida, coduse, fecreg, taplicacion, ordenta, ordenprod, preciodcto, cantidadtotal, congelado) VALUES('$this->codprop', '$this->codprod', '$this->coditem',  '$this->cantidad', '$this->costo', '$this->costototal', '$this->umedida', '$this->domuser', now(), '$this->taplicacion', '$this->ordenta', '$this->ordenprod', '$this->preciodcto', '$this->cantidadtotal', '$this->congelado');";
        $result = $this->consultas($sql);
        return $result;
    }

    //Insert Productos Redondeados
    function insert_propdb14($codprod, $cantidad1, $cantidad2, $umedida1, $umedida2, $preciou, $preciodcto, $preciototal, $factorb, $ordendesp) {
        $sql = "INSERT INTO propdb14(codprop, codprod, coditem, cantidad1, cantidad2, umedida1, umedida2, preciou, preciodcto, preciototal, factorb, ordenprod, coduse) values ('$this->codprop', '$codprod', '$this->coditem', '$cantidad1', '$cantidad2', '$umedida1', '$umedida2', '$preciou', '$preciodcto', '$preciototal', '$factorb', '$ordendesp', '$this->domuser');";
        $result = $this->consultas($sql);
        return $result;
    }

    function getRedondeoByCodProp() {
        $sql = "select codprop, codprod, nombre as nomprod, coditem, cantidad1, cantidad2, umedida1, umedida2, preciou, preciodcto, preciototal, factorb, ordenprod, d.coduse 
            FROM propdb14 as d JOIN alardb01 as p ON d.codprod = p.codigo
                where codprop = '$this->codprop' and coditem = '$this->coditem' order by p.orden asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //update propdb11, anteriormente era updatePropxAprobDetalle()
    function update_propdb11() {
        $sql = "UPDATE propdb11 SET "
                . "codprop = '$this->codprop', "
                . "codprod = '$this->codprod', "
                . "cantidad = '$this->cantidad', "
                . "costo = '$this->costo', "
                . "costototal = '$this->costototal', "
                . "taplicacion = '$this->taplicacion', "
                . "ordenta = '$this->ordenta', "
                . "ordenprod = '$this->ordenprod', "
                . "preciodcto = '$this->preciodcto', "
                . "cantidadtotal = '$this->cantidadtotal', "
                . "umedida = '$this->umedida', "
                . "usemod = '$this->domuser', "
                . "fecmod = now() "
                . "WHERE codprop = '$this->codpropold' and codprod = '$this->codprod' and coditem = '$this->coditem' and taplicacion = '$this->taplicacion';";
        $result = $this->consultas($sql);
        return $result;
    }

    //insert propdb12
    function insertItem() {
        $sql = "INSERT INTO propdb12(coditem, codprop, itemdesc, coduse, fecreg, descuento, pcc, pca, precioambt, fa, ha, nitrogeno, plantilla, pud, estado, modificado, incluyeigv, valigv, pup, verfc) VALUES('$this->coditem', '$this->codprop', '$this->itemdesc', '$this->domuser', now(), '$this->descuento', '$this->pcc', '$this->pca', '$this->precioAMBT', '$this->fa', '$this->ha', '$this->nitrogeno', '$this->plantilla', '$this->pud', '$this->estadoitem', '$this->modificado', '$this->incluyeigv', '$this->valigv', '$this->pup', '$this->verfc');";
        $result = $this->consultas($sql);
        return $result;
    }

    //**** ELIMINAR ESTE METODO. PORQUE LAS CONDICIONES LO MANEJAMOS EN UN SOLO CAMPO DE TEXTO.
    //insert prop17
    function insert_propdb17() {
        $sql = "INSERT INTO propdb17(codprop, condicion, orden, coduse) VALUES('$this->codprop', '$this->cond_text', '$this->cond_orden', '$this->domuser');";
        $result = $this->consultas($sql);
        return $result;
    }

    //update propdb12 anteriormente updateItem()
    function update_propdb12() {
        $sql = "UPDATE propdb12 SET "
                . "codprop = '$this->codprop', "
                . "itemdesc = '$this->itemdesc', "
                . "descuento = '$this->descuento', "
                . "pcc = '$this->pcc', "
                . "pca = '$this->pca', "
                . "precioambt = '$this->precioAMBT', "
                . "fa = '$this->fa', "
                . "ha = '$this->ha', "
                . "nitrogeno = '$this->nitrogeno', "
                . "plantilla = '$this->plantilla', "
                . "pud = '$this->pud', "
                . "estado = '$this->estadoitem', "
                . "modificado = '$this->modificado', "
                . "usemod = '$this->domuser', "
                //. "verfc = '$this->verfc', "
                . "fecmod = now() "
                . "WHERE coditem = '$this->coditem';";
        $result = $this->consultas($sql);
        return $result;
    }

    //update propdb13
    function update_propdb13() {
        $sql = "UPDATE propdb13 SET "
                . "codprop = '$this->codprop', "
                . "unidad = '$this->unidad', "
                . "factor = '$this->factor', "
                . "orden = '$this->ordenund', "
                . "usemod = '$this->domuser', "
                . "fecmod = now() "
                . "WHERE codprop = '$this->codpropold' and coditem = '$this->coditem' and codnut = '$this->codnut';";
        $result = $this->consultas($sql);
        return $result;
    }

    function update_propdb14() {
        $sql = "UPDATE propdb14 SET "
                . "codprop = '$this->codprop', "
                . "codprod = '$this->codprod', "
                . "cantidad1 = '$this->dis_cantidad1', "
                . "cantidad2 = '$this->dis_cantidad2', "
                . "umedida1 = '$this->dis_umedida1', "
                . "umedida2 = '$this->dis_umedida2', "
                . "preciou = '$this->dis_preciou', "
                . "preciodcto = '$this->dis_preciodcto', "
                . "preciototal = '$this->dis_preciototal', "
                . "factorb = '$this->dis_factorb', "
                . "ordenprod = '$this->dis_ordenprod', "
                . "usemod = '$this->domuser', "
                . "fecmod = now() "
                . "WHERE codprop = '$this->codpropold' and codprod = '$this->codprod' and coditem = '$this->coditem';";
        $result = $this->consultas($sql);
        return $result;
    }

    //delete propdb12
    function delete_propdb12ByCodProp() {
        $sql = "DELETE FROM propdb12 WHERE codprop = '$this->codprop';";
        $result = $this->consultas($sql);
        return $result;
    }

    //delete propdb12 by codprop
    function delete_propdb11ByCodProp() {
        $sql = "DELETE FROM propdb11 WHERE codprop = '$this->codprop';";
        $result = $this->consultas($sql);
        return $result;
    }

    //delete producto de propdb11 by 
    function deletePropxAprobDetalle() {
        $sql = "DELETE FROM propdb11 WHERE codprop = '$this->codprop' and codprod = '$this->codprod';";
        $result = $this->consultas($sql);
        return $result;
    }

    function getestadoPropuesta($estado) {
        if ($estado == 'PENDIENTE') {
            return $texto = '<span class="label label-warning">P</span>';
        } elseif ($estado == 'APROBADO') {
            return $texto = '<span class="label label-success">A</span>';
        } else {
            return $texto = '<span class="label label-danger">N</span>';
        }
    }

    //Utilizada por: 
    //_propuestav2_reg.php
    function getTipoAplicacion() {
        $sql = "select codele, desele from altbdb01 WHERE codtab='TA' and trim(codele) <> '' ORDER BY codele";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getVariedadesByCultivo($codcate) {
        $sql = "SELECT DISTINCT v.codcate, v.codigo, v.nombre as variedad 
                FROM alvadb01 as v JOIN altbdb01 as c ON v.codcate = c.codele
                WHERE v.codcate = '$codcate' order by v.codigo;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getEtapaFenologica() {
        $sql = "SELECT codtab, codele, desele from altbdb01 where codtab = 'EF' and codele>= '01' order by desele";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function insert_intracliente_simple($ruc, $nomcliente, $abrev) {
        $sql = "INSERT INTO intracliente(codcliente, nombre, abrev, codcia, coduse, validado) values ('$ruc', '$nomcliente', '$abrev', '01', '$this->domuser', FALSE);";
        $result = $this->consultas($sql);
        return $result;
    }

    function existeCodPropuesta() {
        $sql = "select codprop from propdb10 where codprop = '$this->codprop';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function loadContactosByCodCliente() {
        $sql = "select nombre, cargo, telefono, email, codcontacto, celular from intracontacto where codcliente = '$this->codcliente' order by nombre";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function insert_intracontacto_simple() {
        $sql = "INSERT INTO intracontacto(codcliente, nombre, coduse, fecreg, validado) values ('$this->codcliente', '$this->contacto', '$this->domuser', now(), FALSE);";
        $result = $this->consultas($sql);
        return $result;
    }
    
    //Actualizar Estado Gerencial
    function updateEstadoGerencial(){
       $sql = "UPDATE propdb10 SET "
                . "estado_ger = '$this->estado_ger', "                
                . "fecmod = now() "
                . "WHERE codprop = '$this->codprop';";
        $result = $this->consultas($sql);
        return $result; 
    }

    //function mail_propxaprob_user()
    function sendmailPropxAprob() {
        require '../site/PHPMailer/class.phpmailer.php';
        $url1 = '<a target="_blank" href="http://agromicrob.ddns.net:8070/humasoft/site/_propuestav2_aprob02_verweb.php?cod=' . $this->codprop . '">' . $this->codprop . '</a>';
        $url2 = '<a target="_blank" href="http://agromicrob.ddns.net:8070/humasoft/site/_propuestav2.web.php">Ver Todas las Propuestas</a>';
        $body = '<div style="font-family: "><p>Se ha elaborado la siguiente propuesta, la cual está pendiente de Aprobación Gerencial.</p>'
                . '<table>'
                . '<tr><td style="width: 100px; background-color: #A9E2F3">Código</td><td>' . $url1 . '</td></tr>'
                . '<tr><td style="width: 100px; background-color: #A9E2F3">Cliente</td><td>' . strtoupper($this->nomcliente) . '</td></tr>'
                . '<tr><td style="width: 100px; background-color: #A9E2F3">Asesor</td><td>' . strtoupper($this->nomvendedor) . '</td></tr>'
                . '<tr><td>Cultivo</td><td>' . strtoupper($this->cultivo) . '</td></tr>'
                . '</table>'
                . '<br/><p>' . $url2 . '</p>'
                . '</div>';


        $message = "<html><body>";

        $message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";

        $message .= "<tr><td>";

        $message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";

        $message .= "<thead>
                        <tr height='80'>
                        <th colspan='4' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#333; font-size:34px;' >Huma Gro Perú</th>
                        </tr>
                    </thead>";

        $message .= "<tbody>
            
       <tr>
            <td colspan='4' style='padding:15px;'>
            <p style='font-size:15px;'>Se ha registrado la siguiente propuesta:</p>
            <hr />                        
            </td>
       </tr>
       <tr>
           <td colspan='4' style='padding:15px;'>               
               <table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:450px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CÓDIGO</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>" . $url1 . "</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CLIENTE</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>" . $this->nomcliente . "</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>ASESOR</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>" . $this->nomvendedor . "</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CULTIVO</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>" . $this->cultivo . "</td>
                 </tr>
               </table>
               <p>" . $url2 . "</p>
           </td>
       </tr>      
              </tbody>";

        $message .= "</table>";

        $message .= "</td></tr>";
        $message .= "</table>";

        $message .= "</body></html>";

        $mail = new PHPMailer();
        $mailremite = $_SESSION['email_usuario'];
        $nomremite = $_SESSION['nombreUsuario'];
        $mail->From = "$mailremite";
        $mail->FromName = "$nomremite";
        $mail->Subject = 'PROPUESTA POR APROBAR DE: ' . $this->nomcliente . ' - CÓDIGO: ' . $this->codprop;
        $mail->Body = $message;
        $mail->IsHTML(true);
        $mail->addAddress("$mailremite", "$nomremite");
        //$mail->addCC('aprobaciones@humagroperu.com', "Salvador Giha");
        $mail->addCC('reporteshumasoft@agromicrobiotech.com', "Jota Leder");
        $mail->addBCC('sistemas@agromicrobiotech.com', "Juan Leder"); //Copia oculta
        //$mail->addBCC('juanleder@gmail.com', "Juan Led");        
        $mail->Send();
    }

    function generarPropuestaenPDF() {
        ob_start();
        include(dirname(__FILE__) . '/_rep.semanal.2.php');
        $content = ob_get_clean();

// convert in PDF
        require_once(dirname(__FILE__) . './html2pdf_v4.03/html2pdf.class.php');
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'es', 'false', 'UTF-8');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('archivos/repgersemanal/' . $nomarchivo . '_v2.pdf', 'f');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //FALTA PONER EN PRODUCCION ESTE METODO
    function sendmail_propinsert_gerente() {
        require '../site/PHPMailer/class.phpmailer.php';
        $mail = new PHPMailer();
        $body = $this->bodymail_propinsert_gerente();
        $mailremite = $_SESSION['email_usuario'];
        $nomremite = $_SESSION['nombreUsuario'];
        $mail->From = "$mailremite";
        $mail->FromName = "$nomremite";
        $mail->Subject = 'PROPUESTA REGISTRADA NÚMERO: ' . $this->codprop;
        $mail->Body = $body;
        $mail->IsHTML(true);
        //$mail->addAddress('aprobaciones@humagroperu.com', "Salvador Giha");
        $mail->addAddress('reporteshumasoft@agromicrobiotech.com', "Juan Leder"); //Copia oculta
        //$mail->addBCC('juanleder@gmail.com', "Juan Led");        
        $mail->Send();
    }

    //FALTA PONER EN PRODUCCION ESTE METODO
    function bodymail_propinsert_gerente() {
        $url1 = 'http://agromicrob.ddns.net:8070/humasoft/site/_propuestav2_aprob02_verweb.php?cod=' . $this->codprop;
        $url2 = 'http://agromicrob.ddns.net:8070/humasoft/site/_propuestav2.web.php';

        $body = '<!DOCTYPE html>
            <html>
                <head>
                    <title>Propuesta Registrada</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina|Source+Sans+Pro" rel="stylesheet">
                    <style>
                        #contenedor { margin: auto; width: 70%;}
                        #head{ background-color: #395235; color: #fafafa; padding: 20px;}
                        #body {background: #d9e7dd; padding: 20px; font-family: "Source Sans Pro", sans-serif; }
                        .text_titulo { background-color: transparent; font-size: 12px; font-weight: bolder; font-family: "Baloo Bhaina", cursive;}
                        .btn { font-size: 12px; padding: 10px;  color: white; background-color: #46a45d; font-family: "Source Sans Pro", sans-serif; text-decoration: none; text-align: center;}            
                    </style>
                </head>
                <body>
                    <div id="contenedor">
                        <div id="head">                
                            <p class="text_titulo">
                                <span style="font-size: 20px;">HUMA GRO PERU</span><br/>
                                AGRO MICRO BIOTECH SAC
                            </p>
                        </div>
                        <div id="body">
                            <div>
                            ¡Felicitaciones! La Propuesta Nro: ' . $this->codprop . ', fue registrada con éxito.
                            </div>
                            <div>
                                <br/>
                                <a href="' . $url2 . '" target="_blank" class="btn">LISTAR PROPUESTAS</a>  <a href="' . $url1 . '" target="_blank" class="btn">VER PROPUESTA</a>
                            </div>
                        </div>            
                    </div>                            
                </body>
            </html>';
        return $body;
    }

    //Mensaje Respuesta al Aprobar o No Aprobar

    function sendmailMsjAprobacion() {
        require '../site/PHPMailer/class.phpmailer.php';
        $itemprop = $this->getItemByCodProp();
        $estado = 'APROBADO';
        $numero = count($itemprop);
        for ($i = 0; $i < count($itemprop); $i++) {
            $estado = $itemprop[$i][14];
            if ($estado == 'NO APROBADO') {
                break;
            }
        }
        $mail = new PHPMailer();
        $mailremite = $_SESSION['email_usuario'];
        $nomremite = $_SESSION['nombreUsuario'];
        $body = $this->bodyMailMsjAprobacion($itemprop);
        $mail->From = "$mailremite";
        $mail->FromName = "$nomremite";
        $mail->Subject = 'ACTUALIZACION DE ESTADO DE PROPUESTA';
        $mail->Body = $body;
        $mail->IsHTML(true);
        $mail->addAddress('areatecnica@agromicrobiotech.com', "Kateryn Mendoza Hinostroza");
        //if ($estado == 'APROBADO') {
        //  $mail->addCC('acomercial@agromicrobiotech.com', "Jennifer Rivera");
        //$mail->addCC('juanleder@gmail.com', "Juan Prueba");
        //}
        $mail->addBCC('reporteshumasoft@agromicrobiotech.com', "Juan Leder"); //Copia oculta
        $mail->Send();
    }
    
    function sendmailMsjAprobacionATaAC() {
        require '../site/PHPMailer/class.phpmailer.php';   
        
        $file_word = $this->searchFileProp('PROPUESTA EN WORD');
        $file_excel = $this->searchFileProp('PROPUESTA EN EXCEL');
        
        $mail = new PHPMailer();
        $mailremite = $_SESSION['email_usuario'];
        $nomremite = $_SESSION['nombreUsuario'];
        $body = $this->bodyMailMsjAprobacionATaAC();
        $mail->From = "$mailremite";
        $mail->FromName = "$nomremite";
        $mail->Subject = 'PROPUESTA APROBADA POR GERENCIA - '.$this->nomcliente;
        $mail->Body = $body;
        $mail->IsHTML(true);
        $mail->addAddress($this->mailpara);
        //$mail->addAddress('reporteshumasoft@agromicrobiotech.com', "Jenifer Rivera");        
        $archivo_word = '../site/archivos/propuestas/' . $file_word[2];
        $archivo_excel = '../site/archivos/propuestas/' . $file_excel[2];
        $mail->AddAttachment($archivo_word, $this->codprop);
        $mail->AddAttachment($archivo_excel, $this->codprop);
        //$mail->addBCC('reporteshumasoft@agromicrobiotech.com', "Juan Leder"); //Copia oculta
        if($mail->Send()){
            return true;
        }else{
            return false;
        }
    }

    function bodyMailMsjAprobacion($itemprop) {
        $body = '<!DOCTYPE html>
            <html>
                <head>
                    <title>Estado de Propuestas</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <style>
                        .container { font-family: sans-serif;}
                        .titulo {background-color: #00cccc; color: #f7f7f7; font-weight: bolder; padding: 10px; height:200mm; vertical-align: middle;}
                        .vendedor {color: blue; font-weight: bolder; }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="titulo">ESTADO DE PROPUESTA</div>                    
                        <p>Estimado(a) <span class="vendedor">' . $this->elaboradopor . '</span>, se le informa que se ha modificado el <strong>Estado de la Propuesta Nro. ' . $this->codprop . '</strong>, para:</p>';
        $iterador = 1;
        foreach ($itemprop as $value) {
            $body.= '<p><strong>ITEM ' . $iterador . ': ' . $value[14] . '</strong></p>';
            $body.= '<p style="text-decoration: underline; font-style: italic;" >Comentarios:</p>';
            $coditem = $value['coditem'];
            $this->__set('coditem', $coditem);
            $comentarios = $this->getComentariosByCodItem();
            $ncom = count($comentarios);
            if ($ncom > 0) {
                foreach ($comentarios as $comment) {
                    $body.= "<p style='font-size: 12px;'>" . $comment['comentario'] . "</p>";
                }
            } else {
                $body.= "<p style='font-size: 12px; color:red;'>No hay comentarios.</p>";
            }
            $iterador++;
        }

        $body.= ' </div>
                </body>
            </html>';
        return $body;
    }
    
    function bodyMailMsjAprobacionATaAC() {        
        
        $message = "<html><body>";

        $message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";

        $message .= "<tr><td>";

        $message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";

        $message .= "<thead>
                        <tr height='80'>
                        <th colspan='4' style='background-color:#45b000; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#fff; font-size:34px;' >Huma Gro Perú</th>
                        </tr>
                    </thead>";

        $message .= "<tbody>
            
       <tr>
            <td colspan='4' style='padding:15px;'>
            <p style='font-size:15px;'>Propuesta aprobada por Gerencia, el cual se detalla a continuación:</p>
            <hr />                        
            </td>
       </tr>
       <tr>
           <td colspan='4' style='padding:15px;'>               
               <table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:450px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CÓDIGO</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->codprop."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CLIENTE</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->nomcliente."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>ASESOR</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->nomvendedor."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CULTIVO</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->cultivo."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>                    
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>MENSAJE</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->mailmsj."</td>
                 </tr>
               </table> 
               
             </td>
           </tr>
        </tbody>";

        $message .= "</table>";
        $message .= "</td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";        
        return $message;
    }
    
    function bodyMsjAprobacionACaDESP() {        
        
        $message = "<html><body>";

        $message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";

        $message .= "<tr><td>";

        $message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";

        $message .= "<thead>
                        <tr height='80'>
                        <th colspan='4' style='background-color:#45b000; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#fff; font-size:34px;' >Huma Gro Perú</th>
                        </tr>
                    </thead>";

        $message .= "<tbody>
            
       <tr>
            <td colspan='4' style='padding:15px;'>
            <p style='font-size:15px;'>Propuesta Aprobada por el Cliente, el cual se detalla a continuación:</p>
            <hr />                        
            </td>
       </tr>
       <tr>
           <td colspan='4' style='padding:15px;'>               
               <table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:450px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CÓDIGO</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->codprop."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CLIENTE</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->nomcliente."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>ASESOR</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->nomvendedor."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CULTIVO</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->cultivo."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>                    
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>MENSAJE</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->mailmsj."</td>
                 </tr>
               </table> 
               
           </td>
       </tr>      
              </tbody>";

        $message .= "</table>";

        $message .= "</td></tr>";
        $message .= "</table>";

        $message .= "</body></html>";                
        
        return $message;
    }
    
    function bodyMsjAprobacionACaVEND() {        
        
        $message = "<html><body>";

        $message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";

        $message .= "<tr><td>";

        $message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";

        $message .= "<thead>
                        <tr height='80'>
                        <th colspan='4' style='background-color:#45b000; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#fff; font-size:34px;' >Huma Gro Perú</th>
                        </tr>
                    </thead>";

        $message .= "<tbody>
            
       <tr>
            <td colspan='4' style='padding:15px;'>
            <p style='font-size:15px;'>Se ha elaborado la siguiente propuesta:</p>
            <hr />                        
            </td>
       </tr>
       <tr>
           <td colspan='4' style='padding:15px;'>               
               <table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:450px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CÓDIGO</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->codprop."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CLIENTE</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->nomcliente."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>ASESOR</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->nomvendedor."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>CULTIVO</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->cultivo."</td>
                 </tr>
                 <tr height='50' style='font-family:Verdana, Geneva, sans-serif;'>                    
                    <td style='background-color:#00a2d1; text-align:center; color: #fff;'>MENSAJE</td>
                    <td style='background-color:#f5f5f5; text-align:center;'>".$this->mailmsj."</td>
                 </tr>
               </table> 
               
           </td>
       </tr>      
              </tbody>";

        $message .= "</table>";

        $message .= "</td></tr>";
        $message .= "</table>";

        $message .= "</body></html>";                
        
        return $message;
    }

    function mailPropuestaUpdate() {
        require '../site/PHPMailer/class.phpmailer.php';
        $url1 = '<a target="_blank" href="http://agromicrob.ddns.net:8070/humasoft/site/_propuestav2_aprob02_verweb.php?cod=' . $this->codprop . '">' . $this->codprop . '</a>';
        $url2 = '<a target="_blank" href="http://agromicrob.ddns.net:8070/humasoft/site/_propuestav2.web.php">Ver Todas las Propuestas</a>';
        $mail = new PHPMailer();
        $mailremite = $_SESSION['email_usuario'];
        $nomremite = $_SESSION['nombreUsuario'];
        $mail->From = "$mailremite";
        $mail->FromName = "$nomremite";
        $mail->Subject = 'SE MODIFICO LA PROPUESTA NÚMERO: ' . $this->codprop;
        $mail->Body = '<p>Se ha modificado la Propuesta Nro. ' . $url1 . '</p><p>' . $url2 . '</p>';
        $mail->IsHTML(true);
        $mail->addAddress("$mailremite", "$nomremite");
        $mail->addCC('aprobaciones@humagroperu.com', "Salvador Giha");
        $mail->addBCC('reporteshumasoft@agromicrobiotech.com', "Juan Leder"); //Copia oculta
        //$mail->addBCC('juanleder@gmail.com', "Juan Led");        
        $mail->Send();
    }

    function getItemPropuestaByCodProp() {
        $sql = "select coditem, codprop, itemdesc, estado, modificado, ha, precioambt, descuento, pup from  propdb12 where codprop = '$this->codprop' and pup = 'f';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function calcularPrecioAMBT($descuento, $preciorestado, $totalCongelado) {
        $dcto = (1 - ($descuento / 100));
        $precioAMBT = ($preciorestado * $dcto) + $totalCongelado;
        return $precioAMBT;
    }

    function obtenerPrefijoArchivo($tipoarchivo) {
        $prefijo = '';
        switch ($tipoarchivo) {
            case 'GUIA ORDEN DE COMPRA':
                $prefijo = 'OC1-';
                break;
            case 'FACTURA':
                $prefijo = 'FC1-';
                break;
            case 'GUIA DE REMISION':
                $prefijo = 'GR1-';
                break;
        }
        return $prefijo;
    }

    function calcularFactorAprobacion($precioAMBT, $precioTotalE) {
        $x = ($precioAMBT - $precioTotalE);
        if ($precioTotalE > 0) {
            $fag = ($x / $precioTotalE) * 100; //Factor Aprobacion Gerencial
        } else {
            $fag = 0;
        }
        $fau = ($fag - 25); //Factor Aprobacion Usuario    
        return $fau;
    }

    //Funcion por Refactorizar. la idea es que se ingresen los parametros y devuelva un arreglo.
    function agregarProductoAlCarrito($carrinho, $codprod, $cantidad, $tipoa, $ordenta, $precio, $congelado, $preciodcto, $factorb) {
        $this->__set('codprod', $codprod);
        $getproducto = $this->getProdxPrecioByCod();

        if ($getproducto) {
            $catprod = $getproducto[0]['codcate'];
            $nomcate = $getproducto[0]['desele'];
            $codprod = $getproducto[0]['codigo'];
            $nomprod = $getproducto[0]['nombre'];
            $umedida = $getproducto[0]['umedida'];
            $orden = $getproducto[0]['orden'];

            $precioA = $getproducto[0]['precio'];
            $precioB = $getproducto[1]['precio'];
            $precioC = $getproducto[2]['precio'];
            $precioD = $getproducto[3]['precio'];
            $precioE = $getproducto[4]['precio'];

            $indice = array_search(trim($codprod), array_column($carrinho, trim('codprod')), false);

            if (strlen($indice) == '') {   // ME PASE HORAS INVESTIGANDO COMO HACER QUE EL CERO NO TE TOME COMO VACIO "". SOLUCION UTILIZAR = strlen
                array_push($carrinho, array('ordenta' => $ordenta, 'tipoa' => trim($tipoa), 'ordenprod' => $orden, 'catprod' => trim($catprod), 'nomcate' => trim($nomcate), 'codprod' => trim($codprod), 'nomprod' => $nomprod, 'umedida' => $umedida, 'precio' => $precio, 'preciodcto' => $preciodcto, 'precioA' => $precioA, 'precioB' => $precioB, 'precioC' => $precioC, 'precioD' => $precioD, 'precioE' => $precioE, 'congelado' => $congelado, 'cantidad' => $cantidad, 'factorb' => $factorb));
            } elseif (trim($carrinho[$indice]['ordenta']) == trim($ordenta)) {
                echo '<script>';
                echo 'alert("Este producto ya esta en el carrito. Se actualizara la cantidad y precio");';
                echo '</script>';
                $carrinho[$indice]['cantidad'] = $cantidad;
                $carrinho[$indice]['precio'] = $precio;
                $carrinho[$indice]['preciodcto'] = $preciodcto;
                $carrinho[$indice]['congelado'] = $congelado;
                $carrinho[$indice]['factorb'] = $factorb;
            } else {
                array_push($carrinho, array('ordenta' => $ordenta, 'tipoa' => trim($tipoa), 'ordenprod' => $orden, 'catprod' => trim($catprod), 'nomcate' => trim($nomcate), 'codprod' => trim($codprod), 'nomprod' => $nomprod, 'umedida' => $umedida, 'precio' => $precio, 'preciodcto' => $preciodcto, 'precioA' => $precioA, 'precioB' => $precioB, 'precioC' => $precioC, 'precioD' => $precioD, 'precioE' => $precioE, 'congelado' => $congelado, 'cantidad' => $cantidad, 'factorb' => $factorb));
            }
        }
        return $carrinho;
    }

    //Funcion para Obtener preciodescuento para Productos PUP (Precio Unitario P)
    function obtenerPrecioDctoPUP() {
        $sql = "select l.codigoprod, p.nombre, l.precio from alardb01 as p JOIN lista_precio2 as l ON l.codigoprod = p.codigo where codlis = '61' and codigoprod = '$this->codprod';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getCondiciones() {
        $condiciones = array(
            "Precios no incluyen IGV.",
            "El precio total de esta propuesta ya está con descuento de paquete, por tanto este descuento de paquete no aplica para la venta de productos por separado. Los volúmenes y productos que forman parte de los paquetes aprobados por los clientes son considerados ventas finales. No son desglosables.",
            "El pedido es por el total de productos presupuestados, al que se le aplica el descuento dentro de la propuesta, cualquier cambio que se realice luego de aprobado el programa, si no se respetan el despacho programado, la empresa considerará los precios sin descuento.",
            "El descuento de esta propuesta es independiente de otras propuestas, debido al volumen de compra (numero de Has, cantidad y litros de productos, etc.) El descuento aplica para el área presupuestada como mínimo.",
            "Los precios pueden variar de una propuesta más reciente a otra anterior, debido al incremento de precios en los insumos.",
            "Forma de pago: A tratar.",
            "Validez de oferta 10 días.",
            "Flete puesto en fundo: a tratar. Si la entrega se coordinara en fundo, la entrega de mercadería se hará en un solo envío, si el cliente deseara el envío fraccionado deberá adicionar un cargo mínimo de 120 nuevos soles o el equivalente al envío.",
            "La propuesta del presente programa está hecha en base a la fertilización convencional que es información proporcionada por el cliente, no por recomendación nuestra, pero si se le puede adicionar productos específicos para hacer mejoras en los cultivos. Por ello si hubiese algún cambio en la fertilización convencional del campo testigo, si hubiese testigo, favor de comunicárnoslo para realizar los cambios respectivos en los campos con Nutrición Micro Carbono HUMA GRO. Si observara alguna deficiencia en los campos con nuestros productos avísenos para hacer los reajustes necesarios.",
            "El presente programa puede incluir Nutrición Micro Carbono HUMA GRO foliar pero no las aplicaciones correspondientes al control de plagas y enfermedades (es un programa netamente nutricional).",
            "Las cantidades \"TOTAL Lt/Ha\" son las cantidades cotizadas por el área que figura en el cuadro anteriormente mencionado serán redondeadas a galoneras de 9.46LT/10LT si fuera necesario.",
            "Si tiene algún comentario no dude en comunicarse con nosotros al (01)368-3531, RPC 962383835, escríbenos a acomercial@agromicrobiotech.com o visite nuestra página web www.NutricionMicroCarbono.com.",
            "Para la venta final se considerará la suma total del redondeo por despachar."
        );

        return $condiciones;
    }

    function getCondicionesByCodProp() {
        $sql = "select codigo, codprop, condicion, orden from propdb17 where codprop = '$this->codprop' order by orden asc;";
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

    function consultaPropxClixEcomer($estado) {
        $sql = "select a.codprop, codcliente, nomcliente, a.fecreg, cultivo,  variedad, contactos, elaboradopor, vendedor, demo, fpago, b.estado
                from propdb10 as a JOIN propdb16 as b ON a.codprop = b.codprop
                where a.codcliente = '$this->codcliente' and b.estado = '$estado'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //SI EL ESTADO COMERCIAL ES TODOS
    function consultaPropxCli() {
        $sql = "select a.codprop, codcliente, nomcliente, a.fecreg, cultivo,  variedad, contactos, elaboradopor, vendedor, demo, fpago, b.estado
                from propdb10 as a JOIN propdb16 as b ON a.codprop = b.codprop
                where a.codcliente = '$this->codcliente';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
