<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Reportes.php';
include '../model/Menu.php';

$obj = new C_Reportes();

if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {
        case 'RegRepTecnico':

            //$codrep = $obj->generarCodRepComercial($tipovisita);
            $codrep = trim(strtoupper($_POST['codrep']));
            //Averiguar si ya existe este codrep
            $existe = $obj->validarCodRep($codrep);
            if ($existe) {
                ?>
                <script>
                    alert("Los sentimos. No se pudo registrar, porque este número de visita ya existe. Por favor vuelva a ingresar sus datos."); 
                </script>                                
                <?php
                return false;
            } else {


                //CREACION DE BANDERAS
                $crearcliente = FALSE;
                $crearfundo = FALSE;
                $crearlote = FALSE;
                $crearcontacto = FALSE;
                $msjSucess = '</div><div class="alert alert-success" id="mensaje">EN HORA BUENA!! Sus datos fueron enviados al servidor.</div>';
                $msjError = '<div class="alert alert-danger" id="mensaje"><p>ERROR!! Por favor verificar sus datos.</p>';

                //REGISTRO EN CASO OPTIMO
                $tipovisita = $_POST['atendido'];
                //$codrep = $obj->generarCodRepTecnico($tipovisita); // Se vuelve a generar en caso de que alguien haya registrado con el mismo numero mientras se creaba el rep tecnico
                $con = new Conexion();
                $trans_fechavisita = trim($_POST['fechavisita']);                
                $fecvisita = $con->transformDDMMAAtoAAMMDD($trans_fechavisita);
                
                

                $obj->__set('codrep', trim(strtoupper($codrep)));
                $obj->__set('codcliente', trim(strtoupper($_POST['codcliente'])));
                $obj->__set('codfundo', trim($_POST['codfundo']));
                $obj->__set('codlotehuma', trim($_POST['codlotehuma']));
                $obj->__set('codlotetestigo', trim($_POST['codlotetestigo']));
                $obj->__set('contacto', trim(strtoupper($_POST['contacto'])));
                $obj->__set('fechavisita', trim($fecvisita));
                $obj->__set('horaingreso', "'" . trim($_POST['horaingreso']) . "'");
                $obj->__set('horasalida', "'" . trim($_POST['horasalida']) . "'");                
                $obj->__set('horaproxvis', "'" . trim($_POST['horaproxvis']) . "'");
                $obj->__set('propositovis', trim($_POST['propositovis']));
                $obj->__set('rubrica', trim(strtoupper($_POST['rubrica'])));
                $obj->__set('atendido', $tipovisita);
                $obj->__set('tipo', '1');
                $obj->__set('nota', trim(strtoupper($_POST['nota'])));
                $obj->__set('prueba', trim(strtoupper($_POST['prueba'])));
                $obj->__set('coduse', trim(strtoupper($_SESSION['usuario'])));

                if ($tipovisita == '3' || $tipovisita == '4') {
                    $obj->__set('obs', trim($_POST['obs']));
                }

                //VALIDANDO DATOS            
                if (!empty($_POST['rubrica2'])) {
                    $obj->__set('rubrica', trim($_POST['rubrica2']));
                }

                if (trim($_POST['codlotetestigo']) == 'ninguno') {
                    $obj->__set('codlotetestigo', 'NULL');
                }

                if (empty($_POST['fechaproxvis'])) {
                    $obj->__set('fechaproxvis', 'NULL');
                }else{
                    $trans_fechaproxvisita = trim($_POST['fechaproxvis']);
                    $fechaproxvis = $con->transformDDMMAAtoAAMMDD($trans_fechaproxvisita);
                    $obj->__set('fechaproxvis', "'" . trim($fechaproxvis) . "'");
                }

                if (trim($_POST['horaingreso']) == '00:00') {
                    $obj->__set('horaingreso', 'NULL');
                }
                if (trim($_POST['horasalida']) == '00:00') {
                    $obj->__set('horasalida', 'NULL');
                }
                if (trim($_POST['horaproxvis']) == '00:00') {
                    $obj->__set('horaproxvis', 'NULL');
                }

                //FIN DE VALIDACION                        
                //REGISTRANDO EN LA BD

                if (!empty(trim($_POST['ruc'])) || !empty(trim($_POST['nomcliente']))) {

                    $crearcliente = TRUE;
                    $ruc = trim($_POST['ruc']);
                    $nomcliente = trim($_POST['nomcliente']);
                    $obj->__set('nomcliente', $nomcliente);
                    $rptaCli = $obj->regClienteSimple($ruc, $nomcliente);
                    if ($rptaCli) {
                        //Crear Nuevo Fundo
                        $obj->__set('codcliente', trim(strtoupper($_POST['ruc'])));
                    }
                } else {
                    $obj->__set('nomcliente', $_POST['nomcliente2']);
                }
                if ($_POST['codfundo'] == 'nuevo') {

                    //Crear Nuevo Fundo                    
                    $nomfundo = trim(strtoupper($_POST['nomfundo']));
                    $rptaFdo = $obj->regFundoSimple($nomfundo);
                    if ($rptaFdo) {
                        $codfundo = $obj->getLastIDFundo();
                        $obj->__set('codfundo', trim($codfundo[0]));
                    } else {
                        $obj->__set('codfundo', 'NULL');
                    }
                }

                //Crear Nuevo Contacto
                if (!empty($_POST['newcontacto'])) {
                    $obj->__set('contacto', $_POST['newcontacto']);
                    $obj->__set('carcontacto', trim($_POST['carcontacto']));
                    $obj->__set('celcontacto', trim($_POST['celcontacto']));
                    $rptaCon = $obj->regContactoSimple();
                }

                //Crear Nuevo Lote Humagro           
                if (trim($_POST['codlotehuma']) == 'nuevo') {

                    $humanombre = trim($_POST['humanombre']);
                    $humahatotal = trim($_POST['humahatotal']);
                    $humahatrabajada = trim($_POST['humahatrabajada']);
                    $humatipocultivo = trim($_POST['humatipocultivo']);
                    $humatipocultivonew = trim($_POST['newcultivohuma']);
                    $humavariedad = trim($_POST['humavariedad']);
                    $humavariedadnew = trim($_POST['newvariedadhuma']);
                    $humapatron = trim($_POST['humapatron']);
                    $humapatronnew = trim($_POST['newpatronhuma']);
                    $humadensidad = trim($_POST['humadensidad']);
                    $humaedadcultivo = trim($_POST['humaedadcultivo']);
                    $humaefenologica = trim($_POST['humaefenologica']);
                    $humatriego = trim($_POST['humatriego']);
                    $humatsuelo = trim($_POST['humatsuelo']);
                    $humavolaguafoliar = trim($_POST['humavolaguafoliar']);
                    $humaum_volaguafoliar = trim($_POST['humaum_volaguafoliar']);

                    if (!empty($humatipocultivonew)) {
                        $humatipocultivo = $humatipocultivonew;
                    }
                    if (!empty($humavariedadnew)) {
                        $humavariedad = $humavariedadnew;
                    }
                    if (!empty($humapatronnew)) {
                        $humapatron = $humapatronnew;
                    }

                    $rptaLot = $obj->regLoteSimple($humanombre, $humahatotal, $humahatrabajada, $humatipocultivo, $humavariedad, $humapatron, $humadensidad, $humaedadcultivo, $humaefenologica, $humatriego, $humatsuelo, $humavolaguafoliar, $humaum_volaguafoliar);
                    if ($rptaLot) {
                        $codlotehuma = $obj->getLastIDLote();
                        $obj->__set('codlotehuma', trim($codlotehuma[0]));
                    }
                }

                //Crear Nuevo Lote Testigo
                if (trim($_POST['codlotetestigo']) == 'nuevo') {

                    $testnombre = trim($_POST['testnombre']);
                    $testhatotal = trim($_POST['testhatotal']);
                    $testhatrabajada = trim($_POST['testhatrabajada']);
                    $testtipocultivo = trim($_POST['testtipocultivo']);
                    $testtipocultivonew = trim($_POST['newcultivotest']);
                    $testvariedad = trim($_POST['testvariedad']);
                    $testvariedadnew = trim($_POST['newvariedadtest']);
                    $testpatron = trim($_POST['testpatron']);
                    $testpatronnew = trim($_POST['newpatrontest']);
                    $testdensidad = trim($_POST['testdensidad']);
                    $testedadcultivo = trim($_POST['testedadcultivo']);
                    $testefenologica = trim($_POST['testefenologica']);
                    $testtriego = trim($_POST['testtriego']);
                    $testtsuelo = trim($_POST['testtsuelo']);
                    $testvolaguafoliar = trim($_POST['testvolaguafoliar']);
                    $testum_volaguafoliar = trim($_POST['testum_volaguafoliar']);

                    if (!empty($testtipocultivonew)) {
                        $testtipocultivo = $testtipocultivonew;
                    }
                    if (!empty($testvariedadnew)) {
                        $testvariedad = $testvariedadnew;
                    }
                    if (!empty($testpatronnew)) {
                        $testpatron = $testpatronnew;
                    }

                    $rptaLot = $obj->regLoteSimple($testnombre, $testhatotal, $testhatrabajada, $testtipocultivo, $testvariedad, $testpatron, $testdensidad, $testedadcultivo, $testefenologica, $testtriego, $testtsuelo, $testvolaguafoliar, $testum_volaguafoliar);
                    if ($rptaLot) {
                        $codlotetest = $obj->getLastIDLote();
                        $obj->__set('codlotetestigo', trim($codlotetest[0]));
                    }
                }

                //*******************EN ANALISIS
                //Estos van a estar obligatoriamente.
                if (trim($_POST['codlotehuma']) <> 'NULL') {
                    $humarpta1 = trim($_POST['humarpta1']);
                    $humarpta2 = trim($_POST['humarpta2']);
                    $humarpta3 = trim($_POST['humarpta3']);
                    $humarpta = array($humarpta1, $humarpta2, $humarpta3);
                    $obj->__set('humarpta', $humarpta);
                }


                if (trim($_POST['codlotetestigo']) != 'ninguno') {
                    $testrpta1 = trim($_POST['testrpta1']);
                    $testrpta2 = trim($_POST['testrpta2']);
                    $testrpta3 = trim($_POST['testrpta3']);
                    $testrpta = array($testrpta1, $testrpta2, $testrpta3);
                    $obj->__set('testrpta', $testrpta);
                }


                $directorio = '../site/archivos/reptecnico/';
                $imagenes = $_FILES['imagenes']['name']; //nombre de archivo            
                //Obteniedo descripcion de los archivos subidos.
                $leyenda = $_POST['leyenda'];
                $tmpname = $_FILES['imagenes']['tmp_name']; //nombre temporal de la imagen            
                //Crear Rep Tecnico
                $rptaRep = $obj->regRepTecnicoMultiple01();
                if ($rptaRep) {
                    $obj->insertarAccion('Éxito al registrar un Rep. Técnico');
                    $obj->insert_intravisitas("1");
                    echo $msjSucess;
                    ?>
                    <script>
                        alert("Se registro con exito");//para mostrar despues de 3 segundos.                        
                        //from_unico('<?php //echo $codrep; ?>', 'ajax-content', '_reptecnicov2_ver.php');
                    </script>
                    <?php
                    //SUBIR IMAGENES
                    for ($i = 0; $i < count($imagenes); $i++) {
                        $img = $imagenes[$i];
                        if (!empty($img)) {
                            $nomaleat = $obj->generateRandomString(6);
                            $nomaleat.=$img;
                            $obj->registarArchivo($codrep, $nomaleat, $leyenda[$i]);
                            move_uploaded_file($tmpname[$i], "$directorio$nomaleat"); //movemos el archivo a la carpeta de destino                        
                        }
                    }

                    //Enviar e-mail
                    if (($_POST['prueba']) == 'SI') {
                        $obj->sendmailRegTecnico_Prueba();
                    } else {
                        $obj->sendmailRegTecnico();
                    }
                    ?>                    
                    <?php
                } else {
                    $obj->insertarAccion('Error al Registrar un Rep. Técnico');
                    ?>
                    <script>alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');</script>
                    <?php
                    echo $msjError;
                }
            }

            break;  //Fin RegRepTecnico

        case 'RegRepComercial':
            //$codrep = $obj->generarCodRepComercial($tipovisita);
            $codrep = trim(strtoupper($_POST['codrep']));
            //Averiguar si ya existe este codrep
            $existe = $obj->validarCodRep($codrep);
            if ($existe) {
                ?>
                <script>
                    alert("Los sentimos. No se pudo registrar, porque este número de visita ya existe. Por favor vuelva a ingresar sus datos.");                    
                </script>                
                <?php
            } else {

                //CREACION DE BANDERAS
                $crearcliente = FALSE;
                $crearfundo = FALSE;
                $crearlote = FALSE;
                $crearcontacto = FALSE;
                $msjSucess = '<div class="alert alert-success" id="mensaje">EN HORA BUENA!! Sus datos fueron enviados al servidor.</div>';
                $msjError = '<div class="alert alert-danger" id="mensaje"><p>ERROR!! Por favor verificar sus datos.</p>';

                //Extrayendo nombre de Contacto
                $contacto = $_POST['nomcontacto'];
                $result_explode = explode('-', $contacto);
                $nomcontacto = $result_explode[0];
                
                //Transformar Fecha Visita
                $con = new Conexion();
                $trans_fechavisita = trim($_POST['fechavisita']);                
                $fecvisita = $con->transformDDMMAAtoAAMMDD($trans_fechavisita);

                //REGISTRO EN CASO OPTIMO
                $tipovisita = $_POST['atendido'];

                $obj->__set('codrep', trim(strtoupper($codrep)));
                $obj->__set('atendido', $tipovisita);
                $obj->__set('codcliente', trim(strtoupper($_POST['codcliente'])));
                $obj->__set('codfundo', trim($_POST['codfundo']));
                $obj->__set('codcontacto', trim(strtoupper($_POST['contacto'])));
                $obj->__set('contacto', $nomcontacto);
                $obj->__set('celcontacto', trim($_POST['celcontacto']));
                $obj->__set('carcontacto', trim($_POST['carcontacto']));
                $obj->__set('fechavisita', trim($fecvisita));
                $obj->__set('horaingreso', "'" . trim($_POST['horaingreso']) . "'");
                $obj->__set('horasalida', "'" . trim($_POST['horasalida']) . "'");
                $obj->__set('zona', trim($_POST['zona']));
                $obj->__set('cultivo', trim($_POST['cultivo']));

                $obj->__set('prueba', trim(strtoupper($_POST['prueba'])));
                $obj->__set('coduse', trim(strtoupper($_SESSION['usuario'])));

                //Estos van a estar obligatoriamente.            
                $humarpta = $_POST['huma'];
                $obj->__set('humarpta', $humarpta);

                //Agendar proxima visita
                if (isset($_POST["proximavis"])) {
                    if ($_POST["proximavis"]) {
                        
                        $trans_fechaproxvis = trim($_POST['fechaproxvis']);                
                        $fechaproxvis = $con->transformDDMMAAtoAAMMDD($trans_fechaproxvis);
                        
                        
                        $obj->__set('localproxvis', trim($_POST['localproxvis']));
                        $obj->__set('fechaproxvis', "'" . trim($fechaproxvis). "'");
                        $obj->__set('horaproxvis', "'" . trim($_POST['horaproxvis']) . "'");
                        $obj->__set('propositovis', trim($_POST['propositovis']));
                        $obj->__set('proximavis', TRUE);
                    } else {
                        $obj->__set('proximavis', FALSE);
                    }
                } else {
                    $obj->__set('localproxvis', '');
                    $obj->__set('fechaproxvis', 'NULL');
                    $obj->__set('horaproxvis', 'NULL');
                    $obj->__set('propositovis', '');
                    $obj->__set('proximavis', FALSE);
                }


                $obj->__set('localvisita', $_POST['localvisita']);
                $obj->__set('tipo', '2'); //1 - Rep Tecnico. 2 - Rep Comercial                                    
                //VALIDANDO DATOS

                if (!empty(trim($_POST['zona2']))) {
                    $obj->__set('zona', trim($_POST['zona2']));
                }

                if (!empty(trim($_POST['cultivo2']))) {
                    $obj->__set('cultivo', trim($_POST['cultivo2']));
                }

                if (trim($_POST['horaingreso']) == '00:00') {
                    $obj->__set('horaingreso', 'NULL');
                }

                if (trim($_POST['horasalida']) == '00:00') {
                    $obj->__set('horasalida', 'NULL');
                }

                //FIN DE VALIDACION
                //REGISTRANDO EN LA BD

                if (!empty(trim($_POST['ruc'])) || !empty(trim($_POST['nomcliente']))) {

                    $crearcliente = TRUE;
                    $ruc = trim($_POST['ruc']);
                    $nomcliente = trim($_POST['nomcliente']);
                    $rptaCli = $obj->regClienteSimple($ruc, $nomcliente);
                    if ($rptaCli) {
                        $obj->__set('codcliente', trim(strtoupper($_POST['ruc'])));
                    }
                }

                if ($_POST['codfundo'] == 'nuevo') {

                    //Crear Nuevo Fundo                    
                    $nomfundo = trim(strtoupper($_POST['nomfundo']));
                    $rptaFdo = $obj->regFundoSimple($nomfundo);
                    if ($rptaFdo) {
                        $codfundo = $obj->getLastIDFundo();
                        $obj->__set('codfundo', trim($codfundo[0]));
                    } else {
                        $obj->__set('codfundo', 'NULL');
                    }
                }

                //Crear Nuevo Contacto
                if ($_POST['contacto'] == 'otro') {
                    $obj->__set('contacto', trim($_POST['newcontacto']));
                    $rptaCon = $obj->regContactoSimple();
                } else {
                    $obj->modContactoCel();
                }

                //SUBIENDO ARCHIVOS
                $directorio = '../site/archivos/repcomercial/';
                $imagenes = $_FILES['imagenes']['name'];
                $leyenda = $_POST['leyenda'];

                $tmpname = $_FILES['imagenes']['tmp_name']; //nombre temporal de la imagen  
                //Crear Rep Comercial
                $rptaRep = $obj->regRepComercialMultiple01();
                if ($rptaRep) {
                    $obj->insertarAccion('Éxito al registrar Rep. Comercial');
                    $obj->insert_intravisitas("2");

                   
                    for ($i = 0; $i < count($imagenes); $i++) {
                        $img = $imagenes[$i];
                        if (!empty($img)) {
                            $nomaleat = $obj->generateRandomString(6);
                            $nomaleat.=$img;
                            $obj->registarArchivo($codrep, $nomaleat, $leyenda[$i]);
                            move_uploaded_file($tmpname[$i], "$directorio$nomaleat"); //movemos el archivo a la carpeta de destino
                        }
                    }

                    //Enviar e-mail
                    if (($_POST['prueba']) == 'SI') {
                        $obj->sendmailRegComercial_Prueba();
                    } else {
                       $obj->sendmailRegComercial();
                    }
                    
                     echo $msjSucess;
                    ?>                
                    <script>
                        alert("Se registro con exito");
                        
//                        $(document).ready(function () {
//                            setTimeout(function () {
//                                from_unico('<?php echo $codrep; ?>', 'ajax-content', '_repcomercialv2_ver.php');
//                                $("#mensaje").fadeIn(1500);
//                            }, 2000);
//                        });
                    </script>                    
                    <?php                    
                } else {
                    $obj->insertarAccion('Error al registrar un Rep. Comercial');
                    ?>
                    <script>
                        alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');
                    </script>
                    <?php
                    echo $msjError;
                }
            }
            break;
        case 'EnviarPDFaCliente' :

            $correos = '';
            //REGISTRO EN CASO OPTIMO
            //$para = $_POST['para'];
            $obj->__set('nombre', trim(($_POST['nombre'])));
            $obj->__set('de', trim(($_POST['de'])));
            $obj->__set('codrep', trim(($_POST['codrep'])));
            $obj->__set('para', trim($_POST['mailpara']));
            $obj->__set('asunto', trim(($_POST['mailasunto'])));
            $obj->__set('msj', trim(($_POST['mailmsj'])));

            if (isset($_POST['correos'])) {
                $correos = $_POST['correos'];
            }

            $obj->sendmailRegTecnicotoClientes($correos);

            break;

        default:
            break;
    }
}