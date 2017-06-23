<?php
$accion = $_GET['cod1'];

switch ($accion) {
    case 'LoadProvincia':
        include '../controller/C_Cliente.php';
        $ubi = new Ubicacion();
        $coddepa = $_GET['cod2'];
        $list_prov = $ubi->getProvByDepa($coddepa);
        ?>  
        Provincia
        <select id="provincia" name="provincia" onchange="loadDistByProv()" class="form-control">
            <option value="0">seleccione...</option>                                                    
            <?php
            foreach ($list_prov as $prov) {
                echo '<option value="' . $prov['codprov'] . '">' . $prov['provincia'] . '</option>';
            }
            ?>
        </select>
        <script>
            function Select2Test() {
                $("#provincia").select2();
            }
            $(document).ready(function () {
                LoadSelect2Script(Select2Test);
                WinMove();
            });

        </script>

        <?php
        break;

    case 'LoadDistrito':
        include '../controller/C_Cliente.php';
        $ubi = new Ubicacion();
        $codprov = $_GET['cod2'];
        $list_dist = $ubi->getDistByProv($codprov);
        ?>  
        Distrito
        <select id="ciudad" name="ciudad" class="form-control" onchange="">
            <option value="0">seleccione...</option>
            <?php
            foreach ($list_dist as $dist) {
                echo '<option value="' . $dist['coddist'] . '">' . $dist['distrito'] . '</option>';
            }
            ?>
        </select>
        <script>
            function Select2Test() {
                $("#ciudad").select2();
            }
            $(document).ready(function () {
                LoadSelect2Script(Select2Test);
                WinMove();
            });

        </script>

        <?php
        break;
}

