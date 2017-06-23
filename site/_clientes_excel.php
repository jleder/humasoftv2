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

$sql = "select * from public.v_listaclientes;";
$res = pg_query($link, $sql);

//$lista_cli = $objCliente->exportarClientes();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Set document properties
$objPHPExcel->getProperties()->setCreator("Juan Leder")
        ->setLastModifiedBy("Juan Leder")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Lista de Clientes de Agro Micro Biotech")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");

//Set styles
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'LISTA DE CLIENTES');
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
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


//$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)
//                                ->setName('Verdana')
//                                ->setSize(10)
//                                ->getColor()->setRGB('6F6F6F');
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', 'N')
        ->setCellValue('B2', 'Razon Social')
        ->setCellValue('C2', 'RUC o DNI')
        ->setCellValue('D2', 'Codigo')
        ->setCellValue('E2', 'Dirección Fiscal')
        ->setCellValue('F2', 'Telefono')
        ->setCellValue('G2', 'Zona')
        ->setCellValue('H2', 'Distrito')
        ->setCellValue('I2', 'Provincia')
        ->setCellValue('J2', 'Departamento');

$objPHPExcel->getActiveSheet()
        ->getStyle('A2:J2')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFEEEEEE');

$objPHPExcel->getActiveSheet()->setAutoFilter('A2:J427');

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
    ),
);

$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray);


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

$fila_inicio = 3;
$corredor = $fila_inicio;
$contador = 1;
while ($lista = pg_fetch_array($res)) {
    $zona = '';
    if (!empty($lista['zona'])) {
        $zona = $lista['zona'] . ' - ' . $lista['subzona'];
    }
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $corredor, $contador)
            ->setCellValue('B' . $corredor, trim($lista['nombre']))
            ->setCellValue('C' . $corredor, trim($lista['codcliente']))
            ->setCellValue('D' . $corredor, trim($lista['abrev']))
            ->setCellValue('E' . $corredor, trim($lista['direccion']))
            ->setCellValue('F' . $corredor, trim($lista['telefono']))
            ->setCellValue('G' . $corredor, $zona)
            ->setCellValue('H' . $corredor, trim($lista['ciudad']))
            ->setCellValue('I' . $corredor, trim($lista['provincia']))
            ->setCellValue('J' . $corredor, trim($lista['departamento']));

    $corredor++;
    $contador++;
}
$fila_fin = $corredor;
$styleArray = array(
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

$objPHPExcel->getActiveSheet()->getStyle('A' . $fila_inicio . ':J' . $fila_fin)->applyFromArray($styleArray);
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
$objPHPExcel->getActiveSheet()->setTitle('Clientes');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (OpenDocument)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Clientes.xls"');
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
