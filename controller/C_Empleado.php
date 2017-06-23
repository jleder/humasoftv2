<?php

$estado_session = session_status();
date_default_timezone_set("America/Bogota");
?>
<script type='text/javascript'>
    //    setTimeout("document.getElementById('mensaje').style.visibility='hidden'", 1000);
    $("#mensaje").delay(2000).hide(1000);
</script>
<?php

$obj = new C_Login();
if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'login':
           
        default:
            break;
    }
}