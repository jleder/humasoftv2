<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';

class C_Login {

    //put your code here
    private $usuario;
    private $clave;

    public function __get($atrb) {
        return $this->$atrb;
    }

    public function __set($atrb, $val) {
        $this->$atrb = $val;
    }

    function validarLogin() {
        $sql = "SELECT coduse, desuse, imagen, email, externo, store FROM aausdb01 WHERE trim(coduse)='$this->usuario' and trim(pwduse)='$this->clave'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function validarNewLogin() {
        $sql = "SELECT u.coduse, desuse, imagen, email, codpersona, codrol FROM aausdb01 as u
                JOIN aauxrdb01 as r ON r.coduse = u.coduse 
                WHERE activo = true and  trim(u.coduse)='$this->usuario' and trim(pwduse)='$this->clave';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function esUsuarioActivo() {
        $sql = "SELECT activo FROM aausdb01 WHERE trim(coduse)='$this->usuario' and trim(pwduse)='$this->clave'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function insertOpenSystem() {
        $sql = "INSERT INTO aausdb02(coduse, entrada) values (trim('$this->usuario'), now())";
        $result = $this->consultas($sql);
        return $result;
    }

    function insertExitSystem() {

        $sql = "INSERT INTO aausdb02(coduse, salida) values (trim('$this->usuario'), now())";
        $result = $this->consultas($sql);
        return $result;
    }

    function getAccesos() {
        $sql = "SELECT id, coduse, entrada, salida FROM aausdb02 order by id desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getAccesos2() {
        $sql = "SELECT id, a.coduse, u.desuse, entrada, salida FROM aausdb02 as a JOIN aausdb01 as u ON a.coduse = u.coduse order by entrada desc limit 10";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getCodAsesor() {
        $sql = "SELECT dni FROM vsvedb02 WHERE trim(usuario) = '$this->usuario';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista[0];
    }

    function getCodStore($nomcontacto) {
        $sql = "SELECT codstore FROM stordb02 WHERE trim(nombre) = '$nomcontacto';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista[0];
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

}
?>
<script type='text/javascript'>
    //    setTimeout("document.getElementById('mensaje').style.visibility='hidden'", 1000);
    $("#mensaje").delay(2000).hide(1000);</script>
<?php
$obj = new C_Login();
if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {
        case 'login':

            //$date = date("y/m/d H:i:s");
            $obj->__set('usuario', trim($_POST['uss']));
            $obj->__set('clave', trim($_POST['pas']));

            $rpta = $obj->validarNewLogin();
            //$rpta = $obj->validarLogin();
            if ($rpta) {

                //$activo = $obj->esUsuarioActivo();
                //if ($activo[0]) {

                $obj->insertOpenSystem();
                $_SESSION['conectado'] = true;
                $_SESSION['usuario'] = $_POST['uss'];
                $_SESSION['nombreUsuario'] = $rpta[1];
                $_SESSION['foto'] = $rpta[2];
                $_SESSION['email_usuario'] = $rpta[3];
                $_SESSION['codpersona'] = $rpta[4];
                $_SESSION['codrol'] = $rpta[5];
                ?>
                <script language="JavaScript" type="text/javascript">
                    location.href = 'site/Dashboard.php';
                </script>                        
                <?php
            } else {
                ?>
                <div class="alert-danger" style="vertical-align: middle;" id="mensaje">Usuario o contraseña incorrecta.</div>
                <?php
            }
            break;

        case 'logintwo':
            $obj->__set('usuario', trim($_POST['uss']));
            $obj->__set('clave', trim($_POST['pas']));
            $opcion = trim($_POST['opcion']);
            $codigo = trim($_POST['codigo']);

            $rpta = $obj->validarLogin();

            if ($rpta) {
                $obj->insertOpenSystem();
                $_SESSION['conectado'] = true;
                $_SESSION['usuario'] = $_POST['uss'];
                $_SESSION['conectado'] = 'SI';
                $_SESSION['nombreUsuario'] = $rpta[1];
                $_SESSION['foto'] = $rpta[2];
                $_SESSION['email_usuario'] = $rpta[3];
                if ($opcion == 'APROBAR') {
                    ?>
                    <script language="JavaScript" type="text/javascript">
                        location.href = '../site/_propuestav2_aprob02_verweb.php?cod=<?php echo $codigo; ?>';
                    </script>
                    <?php
                }
            } else {
                ?>
                <div class="alert-danger" style="vertical-align: middle;" id="mensaje">Usuario o contraseña incorrecta.</div>
                <?php
            }
            break;

        case 'LoginEditAsesor':

            $usuario = $_SESSION['usuario'];
            $clave = trim($_POST['clave']);

            $obj->__set('usuario', trim($usuario));
            $obj->__set('clave', trim($clave));

            $rpta = $obj->validarLogin();
            if ($rpta) {
                ?>
                <script language="JavaScript" type="text/javascript">
                    alert("Gracias!!");
                    from_unico("", "principal", "_asesor_edit.php");
                </script>                        
                <?php
            } else {
                ?>
                <script language="JavaScript" type="text/javascript">
                    alert("Contraseña Incorrecta, vuelve a intentarlo.");
                </script>                        
                <?php
            }
            break;

        default:
            break;
    }
}    