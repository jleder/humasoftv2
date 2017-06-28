<?php

//require_once '../model/Cliente.php';
//require_once '../database/Conexion.php';
require_once 'PHPExcel-1.8/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
//$objCliente = new C_Cliente();
$user = 'postgres';
$passwd = '123456';
$db = 'BIOTECH';
$port = 5432;
$host = 'localhost';
$strCnx = "host=$host port=$port dbname=$db user=$user password=$passwd";
$link = pg_connect($strCnx);

$codpersona = $_GET['cod1'];
$codviatico = $_GET['cod2'];
$total_ingreso = 0;
$total_egreso = 0;
$saldo_anterior = 0;
$saldo_final = 0;


//Consulta para obtener el viatico
$sql1 = "SELECT codviatico, codpersona, periodo_mes, periodo_ano, cargo, saldo FROM hs_vtcdb01 WHERE codviatico = '$codviatico'";
//Consulta para obtener datos de la persona
$sql2 = "SELECT p.codpersona, nombre, apellido, dni, fecnac, sexo, telefono, celular, email, foto, direccion, dist, prov, dep, salario, cargo, fecingreso, profesion, tipo 
                FROM hs_psndb01 as p JOIN hs_epddb01 as e ON e.codpersona = p.codpersona WHERE p.codpersona = '$codpersona'";
//Consultar Egresos - Detalle de Viatico
$sql3 = "SELECT v.coddetalle, codviatico, codtipo, desele, fecha, doctipo, docnum, proveedor, concepto, valor, igv, valigv, pventa, codzona, nomzona, codsubzona, nomsubzona, dist, prov, dep, kmcierre, kmrecorrido, galones, pgalon, placa
                FROM hs_vtcdb02 as v
                JOIN altbdb01 as t ON t.codele = v.codtipo
                LEFT JOIN hs_vtcdb03 as c ON c.coddetalle = v.coddetalle
                WHERE codtab = 'TV' and codviatico = '$codviatico' order by fecha asc;";
//Tipo de Categoria
$sql4 = "SELECT codtab, codele, desele FROM altbdb01 WHERE codtab = 'TV' order by codele;";
//Conbsultar Ingresos
$sql5 = "SELECT codigo, codviatico, fecha, descripcion, valor, coduse FROM hs_vtcdb04 WHERE codviatico = '$codviatico' order by fecha asc;";

function listarEgresosxClasificacion($link, $codviatico, $codtipo) {
    $sql = "SELECT codtipo, sum(valor), sum(valigv), sum(pventa)
                FROM hs_vtcdb02 as v
                JOIN altbdb01 as t ON t.codele = v.codtipo
                WHERE codtab = 'TV' and codviatico = '$codviatico' and codtipo = '$codtipo' group by codtipo order by codtipo asc;";
    $res = pg_query($link, $sql);
    $lista = pg_fetch_row($res);
    return $lista;
}

$res1 = pg_query($link, $sql1);
$res2 = pg_query($link, $sql2);
$listaDetalleViaticoComb = pg_query($link, $sql3);
$listaIngreso = pg_query($link, $sql5);
$listaTipoViaticos = pg_query($link, $sql4);



$listPeriodoViatico = pg_fetch_row($res1);
$listEmpleado = pg_fetch_row($res2);

$saldo_anterior = $listPeriodoViatico[5];

//INICIO DE ESTILOS **********************************************
$styleArray = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    )
);

//FIN DE ESTILOS **********************************************
// Set document properties
$objPHPExcel->getProperties()->setCreator("Agro Micro Biotech SAC")
        ->setLastModifiedBy("Agro Micro Biotech SAC")
        ->setTitle("Rendicion de Viaticos")
        ->setSubject("Viaticos por Periodo de " . $listEmpleado[1] . ' ' . $listEmpleado[2])
        ->setDescription("Viaticos")
        ->setKeywords("humasoft juan leder intranet")
        ->setCategory("Reporte Viatico");

//SET CONFIGURATION PAGE
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

//AJUSTAR PARA 1 PAG DE ANCHO POR 1 PAGINA DE ALTO
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

//ENCABEZADO Y PIE DE PAGINA
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&HIntranet Humasoft');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . 'Agro Micro Biotech SAC' . '&RPage &P of &N');

//DEFINIR LOCAL, PARA QUE LAS FORMULAS SE ADAPTEN
$locale = 'Es';
$validLocale = PHPExcel_Settings::setLocale($locale);
if (!$validLocale) {
    echo 'Unable to set locale to ' . $locale . " - reverting to en_us<br />\n";
}


//Set styles
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
$objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'RENDICIÓN GASTOS POR VIÁTICOS');
$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//Fila2
$objPHPExcel->getActiveSheet()->mergeCells('C2:E2');
$objPHPExcel->getActiveSheet()->mergeCells('C3:E3');
$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Persona')->setCellValue('C2', $listEmpleado[1] . ' ' . $listEmpleado[2]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'Periodo')->setCellValue('C3', $listPeriodoViatico[2] . '/' . $listPeriodoViatico[3]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', 'Cargo')->setCellValue('C4', $listEmpleado[15]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5', 'Saldo Anterior')->setCellValue('C5', $listPeriodoViatico[5]);

$corredor = 8;
//INICIO DE TABLA DE INGRESOS
$tabla_ingreso_inicio = $corredor;

$objPHPExcel->getActiveSheet()->getRowDimension($corredor)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->mergeCells('A' . $corredor . ':G' . $corredor);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $corredor, 'TABLA DE INGRESOS');
$objPHPExcel->getActiveSheet()->getStyle('A' . $corredor . ':G' . $corredor)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A' . $corredor . ':G' . $corredor)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()
        ->getStyle('A' . $corredor . ':G' . $corredor)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setARGB('#2ECC71');


$corredor++;

$objPHPExcel->getActiveSheet()->getRowDimension($corredor)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);

$objPHPExcel->getActiveSheet()->getRowDimension($corredor)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->mergeCells('C' . $corredor . ':F' . $corredor);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $corredor, 'ITEM')
        ->setCellValue('B' . $corredor, 'FECHA')
        ->setCellValue('C' . $corredor, 'DESCRIPCION')
        ->setCellValue('G' . $corredor, 'VALOR');

$objPHPExcel->getActiveSheet()
        ->getStyle('A' . $corredor . ':G' . $corredor)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFEEEEEE');

//$corredor++;
$item_ingreso = 0;
while ($listaI = pg_fetch_array($listaIngreso)) {
    $corredor++;
    $item_ingreso++;
    $objPHPExcel->getActiveSheet()->mergeCells('C' . $corredor . ':F' . $corredor);
    $objPHPExcel->setActiveSheetIndex(0)
            //->setCellValue('A'.$corredor)->setValueExplicit($contador, PHPExcel_Cell_DataType::TYPE_NUMERIC)
            ->setCellValue('A' . $corredor, $item_ingreso)
            ->setCellValue('B' . $corredor, trim($listaI['fecha']))
            ->setCellValue('C' . $corredor, trim($listaI['descripcion']))
            ->setCellValue('G' . $corredor, trim($listaI['valor']));


    $objPHPExcel->getActiveSheet()->getStyle('A' . $corredor)->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

    $objPHPExcel->getActiveSheet()->getStyle('A' . $corredor)
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->getStyle('G' . $corredor)->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

    $objPHPExcel->getActiveSheet()->getStyle('G' . $corredor)
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $total_ingreso+= $listaI['valor'];
}
$tabla_ingreso_fin = $corredor;
$objPHPExcel->getActiveSheet()->getStyle('A' . $tabla_ingreso_inicio . ':G' . $tabla_ingreso_fin)->applyFromArray($styleArray);
//FIN DE TABLA INGRESO

$corredor+=3;

$objPHPExcel->getActiveSheet()->getRowDimension($corredor)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->mergeCells('A' . $corredor . ':N' . $corredor);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $corredor, 'TABLA DE EGRESOS');
$objPHPExcel->getActiveSheet()->getStyle('A' . $corredor . ':N' . $corredor)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A' . $corredor . ':N' . $corredor)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()
        ->getStyle('A' . $corredor . ':N' . $corredor)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setARGB('#2ECC71');

$corredor++;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $corredor, 'ITEM')
        ->setCellValue('B' . $corredor, 'FECHA DOC')
        ->setCellValue('C' . $corredor, 'DOC TIPO')
        ->setCellValue('D' . $corredor, 'DOC NUM')
        ->setCellValue('E' . $corredor, 'RAZON SOCIAL')
        ->setCellValue('F' . $corredor, 'DETALLE / CONCEPTO')
        ->setCellValue('G' . $corredor, 'ZONA DE GASTO')
        ->setCellValue('H' . $corredor, 'KM CIERRE')
        ->setCellValue('I' . $corredor, 'KM RECORRIDO')
        ->setCellValue('J' . $corredor, 'GALONES')
        ->setCellValue('K' . $corredor, 'PRECIO X GAL')
        ->setCellValue('L' . $corredor, 'VALOR')
        ->setCellValue('M' . $corredor, 'IGV')
        ->setCellValue('N' . $corredor, 'PRECIO VENTA');

$objPHPExcel->getActiveSheet()->getStyle('A' . $corredor . ':N' . $corredor)->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()
        ->getStyle('A' . $corredor . ':N' . $corredor)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFEEEEEE');

$objPHPExcel->getActiveSheet()->getRowDimension($corredor)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(TRUE);


$filtro_inicio = $corredor;






//$bordes = array(
//    'bordes'=> array(
//        'allborders'=> array(
//            'style'=> PHPExcel_Style_Border::BORDER_THIN,
//            'color'=> array('argb'=>'FF000000'),
//        )
//    ),
//);
//
//$objPHPExcel->getActiveSheet()
//        ->getStyle('A2:J2')
//        ->applyFromArray($bordes);

$fila_inicio = $corredor++;

$item_egreso = 0;
$valor_total = 0;
$valigv_total = 0;
$pventa_total = 0;
$corredor--;

while ($lista = pg_fetch_array($listaDetalleViaticoComb)) {
    $corredor++;
    $item_egreso++;
    $objPHPExcel->setActiveSheetIndex(0)
            //->setCellValue('A'.$corredor)->setValueExplicit($contador, PHPExcel_Cell_DataType::TYPE_NUMERIC)
            ->setCellValue('A' . $corredor, $item_egreso)
            ->setCellValue('B' . $corredor, trim($lista['fecha']))
            ->setCellValue('C' . $corredor, trim($lista['doctipo']))
            ->setCellValue('D' . $corredor, trim($lista['docnum']))
            ->setCellValue('E' . $corredor, trim($lista['proveedor']))
            ->setCellValue('F' . $corredor, trim($lista['concepto']))
            ->setCellValue('G' . $corredor, trim($lista['nomzona'] . ' - ' . $lista['nomsubzona']))
            ->setCellValue('H' . $corredor, trim($lista['kmcierre']))
            ->setCellValue('I' . $corredor, trim($lista['kmrecorrido']))
            ->setCellValue('J' . $corredor, trim($lista['galones']))
            ->setCellValue('K' . $corredor, trim($lista['pgalon']))
            ->setCellValue('L' . $corredor, trim($lista['valor']))
            ->setCellValue('M' . $corredor, trim($lista['valigv']))
            ->setCellValue('N' . $corredor, trim($lista['pventa']));

    $objPHPExcel->getActiveSheet()->getStyle('A' . $corredor)->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

    $objPHPExcel->getActiveSheet()->getStyle('A' . $corredor)
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->getStyle('H' . $corredor . ':N' . $corredor)->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

    $objPHPExcel->getActiveSheet()->getStyle('H' . $corredor . ':N' . $corredor)
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


    $valor_total+= $lista['valor'];
    $valigv_total+= $lista['valigv'];
    $pventa_total+= $lista['pventa'];
}
$fila_fin = $corredor;
$filtro_fin = $corredor - 1;
//Codigo para Aplicar filtro a los encabezado de columnas
$objPHPExcel->getActiveSheet()->setAutoFilter('A' . $filtro_inicio . ':N' . $filtro_fin);

$styleArray = array(
    'font' => array(
        'bold' => false,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
//        'bottom' => array(
//            'style' => PHPExcel_Style_Border::BORDER_THIN,
//        ),
//        'left' => array(
//            'style' => PHPExcel_Style_Border::BORDER_THIN,
//        ),
//        'right' => array(
//            'style' => PHPExcel_Style_Border::BORDER_THIN,
//        ),
    ),
);

//$objPHPExcel->getActiveSheet()->getStyle()->getBorders()->getAllBorders(PHPExcel_Style_Border::BORDER_THIN); ->NO FUNCIONA

$objPHPExcel->getActiveSheet()->getStyle('A' . $fila_inicio . ':N' . $fila_fin)->applyFromArray($styleArray);
$filatotal = $fila_fin + 1;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('L' . $filatotal, $valor_total)
        ->setCellValue('M' . $filatotal, $valigv_total)
        ->setCellValue('N' . $filatotal, $pventa_total);

$total_egreso = $pventa_total;

//$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)
//                                ->setName('Verdana')
//                                ->setSize(10)
//                                ->getColor()->setRGB('6F6F6F');


$styleTotal1 = array(
    'font' => array(
        'bold' => true,
        'size' => 11,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);

$objPHPExcel->getActiveSheet()->getStyle('L' . $filatotal . ':N' . $filatotal)->applyFromArray($styleTotal1);


//foreach ($lista_cli as $lista){
//    $objPHPExcel->setActiveSheetIndex(0)        
//        ->setCellValue('A'.$corredor, $contador)
//        ->setCellValue('B'.$corredor, 'Razon Social')
//        ->setCellValue('C'.$corredor, 'RUC o DNI')
//        ->setCellValue('D'.$corredor, 'Dirección Fiscal')
//        ->setCellValue('E'.$corredor, 'Telefono')
//        ->setCellValue('F'.$corredor, 'Fax')
//        ->setCellValue('G'.$corredor, 'Zona')
//        ->setCellValue('H'.$corredor, 'Distrito')
//        ->setCellValue('I'.$corredor, 'Provincia')        
//        ->setCellValue('J'.$corredor, 'Departamento');
//}
// Rename worksheet
$new_fila = $fila_fin + 5;
$objPHPExcel->getActiveSheet()->mergeCells('I' . $new_fila . ':K' . $new_fila);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('H' . $new_fila, 'Codigo')
        ->setCellValue('I' . $new_fila, 'Detalle')
        ->setCellValue('L' . $new_fila, 'Valor')
        ->setCellValue('M' . $new_fila, 'IGV')
        ->setCellValue('N' . $new_fila, 'Preco Venta');

$objPHPExcel->getActiveSheet()
        ->getStyle('H' . $new_fila . ':N' . $new_fila)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setARGB('c5ecd3');


$filatv_inicio = $new_fila + 1;
$corredortv = $filatv_inicio - 1;
$valortv_total = 0;
$valigvtv_total = 0;
$pventatv_total = 0;

while ($listatv = pg_fetch_array($listaTipoViaticos)) {
    $codtipo = $listatv['codele'];
    $totales = listarEgresosxClasificacion($link, $codviatico, $codtipo);
    $corredortv++;

    $objPHPExcel->getActiveSheet()->mergeCells('I' . $corredortv . ':K' . $corredortv);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H' . $corredortv, trim($listatv['codele']))
            ->setCellValue('I' . $corredortv, trim($listatv['desele']))
            ->setCellValue('L' . $corredortv, $totales[1])
            ->setCellValue('M' . $corredortv, $totales[2])
            ->setCellValue('N' . $corredortv, number_format($totales[3], 2));

    $objPHPExcel->getActiveSheet()->getStyle('H' . $corredortv)
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->getStyle('L' . $corredortv . ':N' . $corredortv)->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);



    $valortv_total += $totales[1];
    $valigvtv_total += $totales[2];
    $pventatv_total += $totales[3];
}
$objPHPExcel->getActiveSheet()->getStyle('H' . $filatv_inicio . ':N' . $corredortv)->applyFromArray($styleArray);

$filatotaltv = $corredortv + 1;

$objPHPExcel->setActiveSheetIndex(0)
        //->setCellValue('L' . $filatotaltv, '=SUMA(L'.$filatv_inicio.':L'.($filatotaltv-1).')')
        ->setCellValue('L' . $filatotaltv, $valortv_total)
        ->setCellValue('M' . $filatotaltv, $valigvtv_total)
        ->setCellValue('N' . $filatotaltv, $pventatv_total);

//$objPHPExcel->getActiveSheet()->getCell('L'.$filatotaltv)->getCalculatedValue();

$objPHPExcel->getActiveSheet()->getStyle('L' . $filatotaltv . ':N' . $filatotaltv)->applyFromArray($styleTotal1);

$styleArraytv = array(
    'font' => array(
        'bold' => false,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);

$saldo_final = ($saldo_anterior + $total_ingreso) - $total_egreso;

$filatotaltv+=3;
$fila_inicio = $filatotaltv;
$objPHPExcel->getActiveSheet()->getRowDimension($filatotaltv)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->mergeCells('I' . $filatotaltv . ':N' . $filatotaltv);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('I' . $filatotaltv, 'Saldo Final');
$objPHPExcel->getActiveSheet()->getStyle('I' . $filatotaltv . ':N' . $filatotaltv)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I' . $filatotaltv . ':N' . $filatotaltv)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$filatotaltv++;
$objPHPExcel->getActiveSheet()->mergeCells('I' . $filatotaltv . ':M' . $filatotaltv);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('I' . $filatotaltv, 'Saldo Anterior')
        ->setCellValue('N' . $filatotaltv, $saldo_anterior);

$filatotaltv++;
$objPHPExcel->getActiveSheet()->mergeCells('I' . $filatotaltv . ':M' . $filatotaltv);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('I' . $filatotaltv, 'Total Ingresos')
        ->setCellValue('N' . $filatotaltv, $total_ingreso);

$filatotaltv++;
$objPHPExcel->getActiveSheet()->mergeCells('I' . $filatotaltv . ':M' . $filatotaltv);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('I' . $filatotaltv, 'Total Egresos')
        ->setCellValue('N' . $filatotaltv, $total_egreso);

$filatotaltv++;
$objPHPExcel->getActiveSheet()->mergeCells('I' . $filatotaltv . ':M' . $filatotaltv);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('I' . $filatotaltv, 'Saldo Final')
        ->setCellValue('N' . $filatotaltv, $saldo_final);

$fila_fin = $filatotaltv;

$objPHPExcel->getActiveSheet()->getStyle('I' . $fila_inicio . ':N' . $fila_fin)->applyFromArray($styleArray);



$objPHPExcel->getActiveSheet()->setTitle('Viaticos');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (OpenDocument)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Viaticos.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
