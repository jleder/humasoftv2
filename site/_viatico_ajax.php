<?php
$accion = $_GET['cod1'];

switch ($accion) {
    case 'LoadCargo':
        include '../controller/C_Viaticos.php';
        $empleados = new Empleado();

        $codpersona = $_GET['cod2'];
        $empleados->__set('codpersona', $codpersona);
        $get = $empleados->listarEmpleadoByCod();
        $cargo = $get[15];
        ?>                  
        <input type = "text" name = "cargo" placeholder="Escribir Cargo" value = "<?php echo $cargo ?>" class="form-control" id="cargo" />
        <?php
        break;

    case 'LoadPeriodoByCodPersona':
        require_once '../controller/C_Viaticos.php';
        $viaticos = new Viatico();

        $codpersona = $_GET['cod2'];
        $viaticos->codpersona = $codpersona;
        $listaPeriodos = $viaticos->listarPerViaticoByCodPersona();
        ?>
        <select name="codviatico" id="codviatico" class="form-control">
            <option value="0">- Seleccione -</option>
            <?php
            foreach ($listaPeriodos as $valor) {
                ?>                                
                <option value="<?php echo trim($valor[0]); ?>"> <?php echo trim($valor[1] . '/' . $valor[2]); ?></option>
            <?php } ?>                                                    
        </select>         
        <?php
        break;
}

