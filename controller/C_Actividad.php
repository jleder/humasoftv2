<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Menu.php';

class C_Actividad {

    //Escriba tus variables
    private $codigo;
    private $codempresa;
    private $lugar;
    private $tactividad;
    private $nomtitular;
    private $fecinicio;
    private $horainicio;
    private $horafin;
    private $descripcion;
    private $adjunto1;
    private $user;

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

    function generarCodActividad() {
        $sql = "select codigo from intraactividad group by codigo, fecreg ORDER BY fecreg desc limit 1;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $num = 'AMBT-1001';
        if ($lista) {
            $result_explode = explode('-', $lista[0]);
            $nsp = $result_explode[1];
            $numero = ($nsp) + 1;
            $num = ('AMBT-' . $numero);
            $existe = 1;
            while ($existe != 0) {
                $existe = $this->validarCodActividad($num);
                if ($existe != 0) {
                    $numero++;
                    $num = (1 + $numero);
                }
            }
        }
        return $num;
    }

    function validarCodActividad($num) {
        $sql = "select count(codigo) from intraactividad where codigo = '$num';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $rpta = trim($lista[0]);
        return $rpta;
    }

    function regActividad() {
        $sql = "INSERT INTO intraactividad(codigo, codempresa, lugar, nomtitular, fecinicio, horainicio, horafin, descripcion, adjunto1, coduse, tactividad) values ('$this->codigo', '$this->codempresa', '$this->lugar', '$this->nomtitular', '$this->fecinicio', '$this->horainicio', '$this->horafin', '$this->descripcion', '$this->adjunto1', '$this->user', '$this->tactividad');";
        $result = $this->consultas($sql);
        return $result;
    }

    function insert_intravisitas() {
        $sql = "INSERT INTO intravisitas(codigo, fecinicio, horainicio, horafin, tipo, coduse) values ('$this->codigo', '$this->fecinicio', '$this->horainicio', '$this->horafin', '3', '$this->user');";
        $result = $this->consultas($sql);
        return $result;
    }

    function modActividad() {

        $sql = "UPDATE intraactividad SET "
                . "codempresa = '$this->codempresa', "
                . "lugar = '$this->lugar', "
                . "nomtitular = '$this->nomtitular', "
                . "fecinicio = '$this->fecinicio', "
                . "horainicio = '$this->horainicio', "
                . "horafin = '$this->horafin', "
                . "tactividad = '$this->tactividad', "
                . "descripcion = '$this->descripcion', "
                . "adjunto1 = '$this->adjunto1', "
                . "fecmod = now(), "
                . "usemod = '$this->user' "
                . "WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function update_intravisitas() {
        $sql = "UPDATE intravisitas SET "
                . "fecinicio = '$this->fecinicio', "
                . "horainicio = '$this->horainicio', "
                . "horafin = '$this->horafin' "
                . "WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function getTipoActividad($name, $class, $onchange, $onblur, $onclick) {
        $select = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '" onchange="' . $onchange . '" onblur="' . $onblur . '" onclick="' . $onclick . '" >
                        <option value="Entrega de Facturas">Entrega de Facturas</option>
                        <option value="Recojo de Facturas">Recojo de Facturas</option>
                        <option value="Entrega de Productos">Entrega de Productos</option>
                        <option value="Recojo de Productos">Recojo de Productos</option>
                        <option value="Entrega de Letras">Entrega de Letras</option>
                        <option value="Recojo de Letras">Recojo de Letras</option>
                        <option value="Participación en Eventos">Participación en Eventos (Férias, Seminarios, etc.)</option>
                        <option value="Trabajo de Escritorio">Trabajo de Escritorio</option>
                        <option value="Otro">Otro (Especificar)</option>                        
                    </select>';
        return $select;
    }
    
    function getTipoActividad_Only($name, $class, $onchange, $onblur, $onclick) {
        $select = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '" onchange="' . $onchange . '" onblur="' . $onblur . '" onclick="' . $onclick . '" >
                        <option value="Actividad Diaria">Actividad Diaria</option>                        
                        <option value="Otro">Otro (Especificar)</option>                        
                    </select>';
        return $select;
    }

    function editTipoActividad($name, $class, $onchange, $onblur, $onclick, $valor) {
        $select = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '" onchange="' . $onchange . '" onblur="' . $onblur . '" onclick="' . $onclick . '" >
                        <option value="' . $valor . '">' . $valor . '</option>
                        <option value="">..::Cambiar por::..</option>
                        <option value="Recojo de Facturas">Recojo de Facturas</option>
                        <option value="Entrega de Productos">Entrega de Productos</option>
                        <option value="Recojo de Productos">Recojo de Productos</option>
                        <option value="Entrega de Letras">Entrega de Letras</option>
                        <option value="Recojo de Letras">Recojo de Letras</option>
                        <option value="Participación en Eventos">Participación en Eventos (Férias, Seminarios, etc.)</option>
                        <option value="Trabajo de Escritorio">Trabajo de Escritorio</option>
                        <option value="Otro">Otro (Especificar)</option>                        
                    </select>';
        return $select;
    }

    function elimActividad() {
        $sql = "DELETE FROM intraactividad WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function delete_intravisitas() {
        $sql = "DELETE FROM intravisitas WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function getActividadByCod() {
        $sql = "SELECT codigo, codempresa, lugar, nomtitular, fecinicio, horainicio, horafin, descripcion, adjunto1, tactividad FROM intraactividad WHERE codigo = '$this->codigo'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getActividad() {
        $sql = "SELECT codigo, a.codempresa, e.descia, lugar, nomtitular, fecinicio, horainicio, horafin, descripcion, adjunto1, tactividad
                FROM intraactividad AS a JOIN bhmcdb01 as e ON a.codempresa = e.codcia where coduse = '$this->user' order by fecinicio desc, horainicio asc limit 25";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getCompania() {
        $sql = "SELECT codcia, descia FROM bhmcdb01";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getClientes() {
        $sql = "select c.codcliente as id, c.nombre as cliente  from intracliente as c order by c.nombre asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }
    
    function getClienteAMBT() {
        $sql = "select c.codcliente as id, c.nombre as cliente  from intracliente as c where codcliente= '20478013206' order by c.nombre asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function generarHora($name, $class) {
        $select = ' <select name="' . $name . '" id="' . $name . '" class="' . $class . '">
                        <option value="00:00">..::Seleccione</option>
                        <option value="06:00">06:00</option>
                        <option value="06:15">06:15</option>
                        <option value="06:30">06:30</option>
                        <option value="06:45">06:45</option>
                        <option value="07:00">07:00</option>
                        <option value="07:15">07:15</option>
                        <option value="07:30">07:30</option>
                        <option value="07:45">07:45</option>
                        <option value="08:00">08:00</option>
                        <option value="08:15">08:15</option>
                        <option value="08:30">08:30</option>
                        <option value="08:45">08:45</option>
                        <option value="09:00">09:00</option>
                        <option value="09:15">09:15</option>
                        <option value="09:30">09:30</option>
                        <option value="09:45">09:45</option>
                        <option value="10:00">10:00</option>
                        <option value="10:15">10:15</option>
                        <option value="10:30">10:30</option>
                        <option value="10:45">10:45</option>
                        <option value="11:00">11:00</option>
                        <option value="11:15">11:15</option>
                        <option value="11:30">11:30</option>
                        <option value="11:45">11:45</option>
                        <option value="12:00">12:00</option>
                        <option value="12:15">12:15</option>
                        <option value="12:30">12:30</option>
                        <option value="12:45">12:45</option>
                        <option value="12:00">12:00</option>
                        <option value="12:15">12:15</option>
                        <option value="12:30">12:30</option>
                        <option value="12:45">12:45</option>
                        <option value="13:00">13:00</option>
                        <option value="13:15">13:15</option>
                        <option value="13:30">13:30</option>
                        <option value="13:45">13:45</option>
                        <option value="14:00">14:00</option>
                        <option value="14:15">14:15</option>
                        <option value="14:30">14:30</option>
                        <option value="14:45">14:45</option>
                        <option value="15:00">15:00</option>
                        <option value="15:15">15:15</option>
                        <option value="15:30">15:30</option>
                        <option value="15:45">15:45</option>
                        <option value="16:00">16:00</option>
                        <option value="16:15">16:15</option>
                        <option value="16:30">16:30</option>
                        <option value="16:45">16:45</option>
                        <option value="17:00">17:00</option>
                        <option value="18:15">18:15</option>
                        <option value="18:30">18:30</option>
                        <option value="18:45">18:45</option>
                        <option value="19:00">19:00</option>
                        <option value="19:15">19:15</option>
                        <option value="19:30">19:30</option>
                        <option value="19:45">19:45</option>
                        <option value="20:00">20:00</option>
                        <option value="20:15">20:15</option>
                        <option value="20:30">20:30</option>
                        <option value="20:45">20:45</option>
                        <option value="21:00">21:00</option>
                        <option value="21:15">21:15</option>
                        <option value="21:30">21:30</option>
                        <option value="21:45">21:45</option>
                        <option value="22:00">22:00</option>
                      </select>';
        return $select;
    }

    function editarHora($name, $class, $valor) {
        $select = ' <select name="' . $name . '" id="' . $name . '" class="' . $class . '">
                        <option value="' . $valor . '">' . $valor . '</option>
                        <option value="00:00">..::Cambiar por</option>
                        <option value="06:00">06:00</option>
                        <option value="06:15">06:15</option>
                        <option value="06:30">06:30</option>
                        <option value="06:45">06:45</option>
                        <option value="07:00">07:00</option>
                        <option value="07:15">07:15</option>
                        <option value="07:30">07:30</option>
                        <option value="07:45">07:45</option>
                        <option value="08:00">08:00</option>
                        <option value="08:15">08:15</option>
                        <option value="08:30">08:30</option>
                        <option value="08:45">08:45</option>
                        <option value="09:00">09:00</option>
                        <option value="09:15">09:15</option>
                        <option value="09:30">09:30</option>
                        <option value="09:45">09:45</option>
                        <option value="10:00">10:00</option>
                        <option value="10:15">10:15</option>
                        <option value="10:30">10:30</option>
                        <option value="10:45">10:45</option>
                        <option value="11:00">11:00</option>
                        <option value="11:15">11:15</option>
                        <option value="11:30">11:30</option>
                        <option value="11:45">11:45</option>
                        <option value="12:00">12:00</option>
                        <option value="12:15">12:15</option>
                        <option value="12:30">12:30</option>
                        <option value="12:45">12:45</option>
                        <option value="12:00">12:00</option>
                        <option value="12:15">12:15</option>
                        <option value="12:30">12:30</option>
                        <option value="12:45">12:45</option>
                        <option value="13:00">13:00</option>
                        <option value="13:15">13:15</option>
                        <option value="13:30">13:30</option>
                        <option value="13:45">13:45</option>
                        <option value="14:00">14:00</option>
                        <option value="14:15">14:15</option>
                        <option value="14:30">14:30</option>
                        <option value="14:45">14:45</option>
                        <option value="15:00">15:00</option>
                        <option value="15:15">15:15</option>
                        <option value="15:30">15:30</option>
                        <option value="15:45">15:45</option>
                        <option value="16:00">16:00</option>
                        <option value="16:15">16:15</option>
                        <option value="16:30">16:30</option>
                        <option value="16:45">16:45</option>
                        <option value="17:00">17:00</option>
                        <option value="18:15">18:15</option>
                        <option value="18:30">18:30</option>
                        <option value="18:45">18:45</option>
                        <option value="19:00">19:00</option>
                        <option value="19:15">19:15</option>
                        <option value="19:30">19:30</option>
                        <option value="19:45">19:45</option>
                        <option value="20:00">20:00</option>
                        <option value="20:15">20:15</option>
                        <option value="20:30">20:30</option>
                        <option value="20:45">20:45</option>
                        <option value="21:00">21:00</option>
                        <option value="21:15">21:15</option>
                        <option value="21:30">21:30</option>
                        <option value="21:45">21:45</option>
                        <option value="22:00">22:00</option>
                      </select>';
        return $select;
    }

    function sendmailRegActividad() {
        require '../site/PHPMailer/class.phpmailer.php';
        $body = $this->bodyActividad();
        $mailremite = $_SESSION['email_usuario'];
        $nomremite = $_SESSION['nombreUsuario'];
        $mail = new PHPMailer();
        $mail->From = "$mailremite";
        $mail->FromName = "$nomremite";
        $mail->Subject = $this->nomtitular . ' - ACTIVIDAD N° ' . $this->codigo;
        $mail->Body = $body;
        $mail->IsHTML(true);
        $mail->addAddress($mailremite, $nomremite);
        $mail->addCC('isandoval@humagroperu.com', "Isabel Sandoval");
        $mail->addCC('reportes@humagroperu.com', "Salvador Giha");
//        $mail->addCC('acomercial@humagroperu.com', "Jennifer Rivera");
        $mail->addBCC('sistemas@humagroperu.com', "Juan Leder");
        $mail->Send();
    }

    function bodyActividad() {
        $lista = $this->getActividadByCod();
        $fechainicio = date("d/m/Y", strtotime($lista[4]));
        $horainicio = date("H:i", strtotime($lista[5]));
        $horafin = date("H:i", strtotime($lista[6]));
        $fecha = $fechainicio . ' ' . $horainicio . ' - ' . $horafin;

        $body = '<!DOCTYPE html>
            <html>
                <head>
                    <title>ACTIVIDAD APOYO OFICINA</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <style>
                        .container { font-family: sans-serif;}
                        .titulo {background-color: orange; color: blue; font-weight: bolder;}
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="titulo">ACTIVIDAD - APOYO A OFICINA</div>
                    <table>            
                        <tbody>
                            <tr>
                                <td>NRO ACTIVIDAD</td>
                                <td width="50px">:</td>
                                <td>' . $lista[0] . '</td>
                            </tr>
                            <tr>
                                <td>FECHA ACTIVIDAD</td>
                                <td width="50px">:</td>
                                <td>' . $fecha . '</td>
                            </tr>
                            <tr>
                                <td>ASESOR</td>
                                <td>:</td>
                                <td>' . $lista[3] . '</td>
                            </tr>
                            <tr>
                                <td>LUGAR DE ACTIVIDAD</td>
                                <td>:</td>
                                <td>' . $lista[2] . '</td>
                            </tr>
                            <tr>
                                <td>TIPO DE ACTIVIDAD</td>
                                <td>:</td>
                                <td>' . $lista[9] . '</td>
                            </tr>
                            <tr>
                                <td>DESCRIPCIÓN</td>
                                <td>:</td>
                                <td>' . $lista[7] . '</td>
                            </tr>                            
                        </tbody>
                    </table>                                        
            </div>
                </body>
            </html>';
        return $body;
    }

    function uploadFile($nomfile) {
        $directorio = '../site/archivos/actividades/';
        $file = $_FILES[$nomfile]['name'];
        if (!empty($_FILES[$nomfile]['name'])) {

            $tmpfile = $_FILES[$nomfile]['tmp_name']; //nombre temporal de la imagen                                                        
            move_uploaded_file($tmpfile, "$directorio$file"); //movemos el archivo a la carpeta de destino                

            $this->__set('adjunto1', $file);
            $this->insertarArchivos();
        }
    }

    function replaceFile($fileold, $nomfile) {
        $directorio = '../site/archivos/actividades/';
        $file = $_FILES[$nomfile]['name'];
        if (!empty($_FILES[$nomfile]['name'])) {

            //*************** Eliminar actual propuesta PDF
            if (!empty((trim($fileold)))) {
                $this->deleteURLFilePropAprob($fileold);
            }
            $tmpfile = $_FILES[$nomfile]['tmp_name']; //nombre temporal de la imagen                                    
            move_uploaded_file($tmpfile, "$directorio$file"); //movemos el archivo a la carpeta de destino                            
        }
    }

    function deleteURLFilePropAprob($file) {
        $ruta = '../site/archivos/actividades/';
        $dir = $ruta . $file;
        if (file_exists($dir)) {
            unlink($dir);
        }
    }

    function insertarArchivos() {
        $sql = "INSERT INTO intraarchivos(codigo, url) values ('$this->codigo', '$this->adjunto1');";
        $result = $this->consultas($sql);
        return $result;
    }

    //FUNCIONES BASURA

    /*
      function getSedes() {
      $sql = "SELECT codsede, dessede FROM bhmcdb03 WHERE codcia = trim('01')";
      $result = $this->consultas($sql);
      $lista = $this->n_Arreglo($result);
      return $lista;
      }
     */
}

$obj = new C_Actividad();
$con = new Conexion();
if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {
        case 'RegActividad':

            $codigo = trim(strtoupper($_POST['codigo']));

            $existe = $obj->validarCodActividad($codigo);

            if ($existe) {                
                echo '<script>
                        alert("LO SENTIMOS :(!! No se pudo registrar. Este codigo ya existe. Por favor aumente +1 al codigo.");
                        $("#codigo").focus();
                    </script>';                    
                
            } else {
                
                $fecha = trim(strtoupper($_POST['fecinicio']));
                $newfecha = $con->transformDDMMAAtoAAMMDD($fecha);

                $obj->__set('codigo', trim(strtoupper($codigo)));
                $obj->__set('codempresa', trim(strtoupper($_POST['codempresa'])));
                $obj->__set('lugar', trim(strtoupper($_POST['lugar'])));
                $obj->__set('nomtitular', trim(strtoupper($_POST['nomtitular'])));
                $obj->__set('fecinicio', trim($newfecha));
                $obj->__set('horainicio', trim(strtoupper($_POST['horainicio'])));
                //$obj->__set('fecfin', trim(strtoupper($_POST['fecfin'])));
                $obj->__set('horafin', trim(strtoupper($_POST['horafin'])));
                $obj->__set('tactividad', trim(strtoupper($_POST['tactividad'])));
                $obj->__set('descripcion', trim(strtoupper($_POST['descripcion'])));
                $obj->__set('user', trim(strtoupper($_SESSION['usuario'])));
                if (!empty($_POST['newlugar'])) {
                    $obj->__set('lugar', trim(strtoupper($_POST['newlugar'])));
                }
                if (!empty($_POST['tnewactividad'])) {
                    $obj->__set('tactividad', trim(strtoupper($_POST['tnewactividad'])));
                }
                $adjunto1 = $_FILES['adjunto1']['name'];
                $obj->__set('adjunto1', $adjunto1);

                $result = $obj->regActividad();
                if ($result) {
                    //Subir Archivo
                    if (isset($_FILES['adjunto1']['name'])) {
                        $obj->uploadFile('adjunto1');
                    }

                    //Insertar Visita
                    $obj->insert_intravisitas();


                    if ($_SESSION['usuario'] <> 'JLP') {

                        $obj->sendmailRegActividad();
                    }
                    echo 'OK';
                    
                } else {
                    echo 'Error';
                    
                }
            }

            break;

        case 'ActActividad':

            $obj->__set('codigo', trim(strtoupper($_POST['codigo'])));
            $obj->__set('codempresa', trim(strtoupper($_POST['codempresa'])));
            $obj->__set('lugar', trim(strtoupper($_POST['lugar'])));
            $obj->__set('nomtitular', trim(strtoupper($_POST['nomtitular'])));
            $obj->__set('fecinicio', trim(strtoupper($_POST['fecinicio'])));
            $obj->__set('horainicio', trim(strtoupper($_POST['horainicio'])));
            //$obj->__set('fecfin', trim(strtoupper($_POST['fecfin'])));
            $obj->__set('horafin', trim(strtoupper($_POST['horafin'])));
            $obj->__set('tactividad', trim(strtoupper($_POST['tactividad'])));
            $obj->__set('descripcion', trim(strtoupper($_POST['descripcion'])));
            $obj->__set('user', trim(strtoupper($_SESSION['usuario'])));
            $obj->__set('adjunto1', trim($_POST['adjunto1']));
            if (!empty($_POST['newlugar'])) {
                $obj->__set('lugar', trim(strtoupper($_POST['newlugar'])));
            }
            if (!empty($_POST['tnewactividad'])) {
                $obj->__set('tactividad', trim(strtoupper($_POST['tnewactividad'])));
            }
            if (!empty($_FILES['adjunto1_new']['name'])) {
                $newfile = $_FILES['adjunto1_new']['name'];
                $obj->__set('adjunto1', $newfile);
            }


            $result = $obj->modActividad();
            if ($result) {

                //Actualizar Visitas
                $obj->update_intravisitas();

                if (isset($_POST['adjunto1']) && isset($_FILES['adjunto1_new']['name'])) {
                    $fileold = $_POST['adjunto1'];
                    $obj->replaceFile($fileold, 'adjunto1_new');
                }
                echo ' 
                    <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se actualizo con éxito :) </div>                
                    <script>
                        alert("Se actulizo correctamente.");                        
                    </script>';
            } else {
               echo ' 
                    <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo actualizar. :(</div>
                    <script>
                        alert("ERROR :(!! No se pudo actualizar.");
                    </script>';
            }

            break;

        default:
            break;
    }
}