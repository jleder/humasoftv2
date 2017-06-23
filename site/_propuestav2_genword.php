<?php
require_once dirname(__FILE__) . '/phpword/PHPWord-master/src/PhpWord/Autoloader.php';

use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

Autoloader::register();
Settings::loadConfig();

//Datos para Consultas
$codprop = $_GET['codprop'];

date_default_timezone_set("America/Bogota");
include_once '../controller/C_GenerarWord.php';
$prop = new C_Propuesta();
$prod = new C_Producto();

$prop->__set('codprop', $codprop);
$propuesta = $prop->getPropuestasxAprobGerenteByCod();
$detitem = $prop->getItemByCodProp();

//Propiedades del  Documento
$sectionStyle = array(
    'marginLeft' => 1522,
    'marginRight' => 1665,
    'marginTop' => 1225,
    'marginBottom' => 1425,
    'headerHeight' => 570,
    'footerHeight' => 570,
);

$phpWord = new PhpOffice\PhpWord\PhpWord();
$section = $phpWord->addSection($sectionStyle);

$header = $section->addHeader();
$header->addWatermark('img/iconos/logo24.jpg', array('height' => 1000, 'marginTop' => 0, 'marginLeft' => 0));

//Encabezado de Página
$header2 = $section->addHeader();
$tableh = $header2->addTable();
$tableh->addRow();
$tableh->addCell(3990)->addImage('img/iconos/logo1.jpg', array('width' => 210, 'height' => 75, 'align' => 'left'));
$tableh->addCell(3990)->addImage('img/iconos/logo2.jpg', array('width' => 95, 'height' => 75, 'align' => 'center'));
$tableh->addCell(3990)->addImage('img/iconos/logo3.jpg', array('width' => 140, 'height' => 75, 'align' => 'right'));
/* $tableh->addCell(1500)->addImage(
  'img/iconos/logo1.jpg',
  array('width' => 80, 'height' => 80, 'align' => 'left')
  );
  $tableh->addCell(1500)->addImage(
  'img/iconos/logo2.jpg',
  array('width' => 80, 'height' => 80, 'align' => 'right')
  );
  $tableh->addCell(1500)->addImage(
  'img/iconos/logo3.jpg',
  array('width' => 80, 'height' => 80, 'align' => 'right')
  );
 */
// Add header for all other pages




$condiciones = $propuesta[16];
$condicion = explode('-/', $propuesta[16]);

//$section->addListItem('Hola Como estas.', 'TYPE_ALPHANUM');
$phpWord->addFontStyle('myOwnStyle', array('name' => 'Times New Roman', 'color' => '0000FF', 'size' => 8));
$phpWord->addFontStyle('jlpStyle', array('size' => 8, 'allCaps' => true));

$font_condicion = array('name' => 'Times New Roman', 'size' => 8);
$font_lista = array('name' => 'Times New Roman', 'size' => 8);
$font_subtitulo = array('bold' => true, 'name' => 'Times New Roman', 'size' => 10, 'italic' => true, 'underline' => true);
$font_normal = array('name' => 'Times New Roman', 'size' => 10);
$font_negrita = array('bold' => true, 'name' => 'Times New Roman', 'size' => 10);
//$font_subtitulo = array('bold' => true, 'name' => 'Times New Roman', 'size' => 10, 'italic' => true, 'underline' => 'dotted');
//allcaps => true: convierte el texto en mayuscula
//$fontes = array('bold' => true, 'italic' => true, 'size' => 16, 'allCaps' => true, 'doubleStrikethrough' => true);
$phpWord->addParagraphStyle('myOwnStyleP', array('spaceAfter' => 0, 'align' => 'center'));
$phpWord->addNumberingStyle(
        'multilevel', array(
    'type' => 'multilevel',
    'levels' => array(
        array('pStyle' => 'myOwnStyleP', 'format' => 'lowerLetter', 'font' => 'Times New Roman', 'text' => '%1.', 'left' => 570, 'hanging' => 360, 'tabPos' => 570),
        array('format' => 'decimal', 'text' => '%2.', 'left' => 1080, 'hanging' => 360, 'tabPos' => 1080),
    ),
        )
);
$predefinedMultilevel = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER_NESTED);

// Lists
$section->addText(htmlspecialchars('Lima, ' . date("d/m/Y", strtotime($propuesta[4]))), $font_normal, array('spaceAfter' => 0, 'align' => 'right'));
$section->addText(htmlspecialchars($propuesta[0]), $font_normal, array('spaceAfter' => 0, 'align' => 'right'));

$section->addText(htmlspecialchars($propuesta[20] . ' ' . $propuesta[5]), $font_normal, array('spaceAfter' => 0));
$section->addText(htmlspecialchars($propuesta[2]), $font_normal, array('spaceAfter' => 0));
$section->addText();
$section->addText(htmlspecialchars('Presente'), $font_normal, array('spaceAfter' => 10));
$section->addText(htmlspecialchars('Asunto: ' . $propuesta[6]), $font_normal, array('spaceAfter' => 0));
$section->addText();
$section->addText(htmlspecialchars($propuesta[3]), $font_normal, array('spaceAfter' => 0));

$ndetitem = count($detitem);
if ($ndetitem > 0) {
    foreach ($detitem as $item) {
        $section->addText();
        $section->addText(htmlspecialchars($item['itemdesc']), $font_normal, array('spaceAfter' => 100));

        $prop->__set('coditem', $item['coditem']);
        $ha = $item['ha'];
        $dcto = $item['descuento'];
        $plantilla = $item['plantilla'];
        $nitrogeno = $item['nitrogeno'];
        $pud = $item['pud'];
        $incluyeigv = $item['incluyeigv'];
        $valigv = $item['valigv'];
        $pup = $item['pup'];


        if ($plantilla == "HECTAREA PAQ") {

            if ($pup == 't') {
                
                $carrito = $prop->getDetallePropxAprobGerenteByCodProp();
                
                
                
                
                

                //FIN DE PRECIO UNITARIO CON DESCUENTO POR PRODUCTO
            } else {
                $carrito = $prop->getDetallePropxAprobGerenteByCodProp();

                //*****MOSTRAR UNIDADES
                $vectorund = $prop->getUnidades();
                $aplicaciones = array_unique(array_column($carrito, 'taplicacion'));

                $section->addText();
                $section->addText(htmlspecialchars('Análisis Económico'), $font_subtitulo, array('spaceAfter' => 10));
                $styleTable = array('borderSize' => 2, 'borderColor' => '000000', 'cellMargin' => 40);
                //$styleTable = array('borderSize' => 1, 'borderColor' => '006699');
                $styleFirstRow = array('borderBottomSize' => 4, 'borderBottomColor' => '0000FF', 'bgColor' => 'A5DB72');
                //$styleFirstRow = array('bgColor' => 'A5DB72');
                $styleCell = array('valign' => 'center');
                $styleCellBTLR = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
                $fontStyle = array('bold' => true, 'size' => 7);
                $parrafoCentro = array('align' => 'center', 'spaceAfter' => 5, 'spaceBefore' => 10);
                $parrafoLeft = array('align' => 'left', 'spaceAfter' => 5, 'spaceBefore' => 10);
                $parrafoRight = array('align' => 'right', 'spaceAfter' => 5, 'spaceBefore' => 10);
                $fontStyleBody = array('size' => 7);
                $phpWord->addTableStyle('Fancy Table2', $styleTable, $styleFirstRow);
                $table = $section->addTable('Fancy Table2');

                $table->addRow();
                $table->addCell(1750, $styleCell)->addText(htmlspecialchars('Aplicación'), $fontStyle, $parrafoCentro);
                $table->addCell(2750, $styleCell)->addText(htmlspecialchars('Producto'), $fontStyle, $parrafoCentro);
                $table->addCell(1000, $styleCell)->addText(htmlspecialchars('Lts/Ha'), $fontStyle, $parrafoCentro);
                $table->addCell(1000, $styleCell)->addText(htmlspecialchars('Lts/Ha'), $fontStyle, $parrafoCentro);
                $table->addCell(1000, $styleCell)->addText(htmlspecialchars('Precio Unit'), $fontStyle, $parrafoCentro);
                if ($pud == 't') {
                    $table->addCell(1000, $styleCell)->addText(htmlspecialchars('Precio U Dscto'), $fontStyle, $parrafoCentro);
                }
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('Precio Total'), $fontStyle, $parrafoCentro);

                $total_general = 0;
                $indice = 0;
                $indice_aplicacion = 0;

                foreach ($carrito as $productos) {

                    $ltxha = $productos['cantidad'] * $ha;
                    if ($pud == 'f') {
                        $precio_total = $ltxha * $productos['costo'];
                    } else {
                        $precio_total = $ltxha * $productos['preciodcto'];
                    }
                    $total_general+=$precio_total;
                    //Generacion de Filas de Tabla                    
                    $table->addRow(1);
                    $table->addCell(1750)->addText(htmlspecialchars($productos['taplicacion']), $fontStyleBody, $parrafoLeft);
                    $table->addCell(2750)->addText(htmlspecialchars($productos['nombre']), $fontStyleBody, $parrafoLeft);
                    $table->addCell(1000)->addText(htmlspecialchars(number_format($productos['cantidad'], 2)), $fontStyleBody, $parrafoCentro);
                    $table->addCell(1000)->addText(htmlspecialchars(number_format($ltxha, 2)), $fontStyleBody, $parrafoCentro);
                    $table->addCell(1000)->addText(htmlspecialchars('$' . number_format($productos['costo'], 2)), $fontStyleBody, $parrafoRight);
                    if ($pud == 't') {
                        $table->addCell(1000)->addText(htmlspecialchars('$' . number_format($productos['preciodcto'], 2)), $fontStyleBody, $parrafoRight);
                    }
                    $table->addCell(2000)->addText(htmlspecialchars('$' . number_format($precio_total, 2)), $fontStyleBody, $parrafoRight);
                }

                $cellColSpan = array('gridSpan' => 2, 'valign' => 'center', 'borderLeftSize' => 0, 'borderBottomSize' => 0);
                $cellColSpan3 = array('gridSpan' => 3, 'valign' => 'center', 'borderLeftSize' => 0, 'borderBottomSize' => 0);
                $cell17 = array('borderLeftSize' => 0);
                $cellHCentered = array('align' => 'center');


                if ($pud <> 't') {
                    $table->addRow(0);
                    $table->addCell(4500, $cellColSpan)->addText(htmlspecialchars(''), $fontStyleBody, $parrafoLeft);
                    $table->addCell(2000, $cellColSpan)->addText(htmlspecialchars(''), $fontStyleBody, $parrafoLeft);
                    $table->addCell(1000, $cell17)->addText(htmlspecialchars('Sub Total'), $fontStyleBody, $parrafoCentro);
                    $table->addCell(2000, $cell17)->addText(htmlspecialchars('$' . number_format($total_general, 2)), $fontStyleBody, $parrafoRight);
                }

                $table->addRow(0);
                if ($pud == 't') {
                    $table->addCell(550, $cellColSpan3)->addText(htmlspecialchars(''), $fontStyleBody, $parrafoLeft);
                } else {
                    $table->addCell(450, $cellColSpan)->addText(htmlspecialchars(''), $fontStyleBody, $parrafoLeft);
                }
                $table->addCell(2000, $cellColSpan)->addText(htmlspecialchars('Precio con descuento'), $fontStyleBody, $parrafoCentro);
                $table->addCell(1000)->addText(htmlspecialchars('Total'), $fontStyleBody, $parrafoCentro);
                $table->addCell(2000)->addText(htmlspecialchars('$' . number_format($item['precioambt'], 2)), $fontStyleBody, $parrafoRight);

                if ($ha > 1) {

                    $precxha = $item['precioambt'] / $ha;
                    $table->addRow(0);



                    if ($pud == 't') {
                        $table->addCell(5500, $cellColSpan3)->addText(htmlspecialchars(''));
                        $table->addCell(2000, $cellColSpan3)->addText(htmlspecialchars('Precio con descuento / Hectárea'), $fontStyleBody, $parrafoCentro);
                    } else {
                        $table->addCell(4500, $cellColSpan)->addText(htmlspecialchars(''));
                        $table->addCell(2000, $cellColSpan3)->addText(htmlspecialchars('Precio con descuento / Hectárea'), $fontStyleBody, $parrafoCentro);
                    }                    
                    $table->addCell(2000)->addText(htmlspecialchars('$' . number_format($precxha, 2)), $fontStyleBody, $parrafoRight);
                }
                $section->addText();

                //*********************************************
                //TABLA DE REDONDEO
                $section->addText(htmlspecialchars('Redondeo por Despachar'), $font_subtitulo, array('spaceAfter' => 10));
                $detredondeo = $prop->getRedondeoByCodProp();
                $tabler = $section->addTable('Fancy Table2');

                $tabler->addRow();
                $tabler->addCell(2750, $styleCell)->addText(htmlspecialchars('Productos Huma Gro'), $fontStyle, $parrafoCentro);
                $tabler->addCell(1000, $styleCell)->addText(htmlspecialchars('Bidones'), $fontStyle, $parrafoCentro);
                $tabler->addCell(1000, $styleCell)->addText(htmlspecialchars('Litros'), $fontStyle, $parrafoCentro);
                $tabler->addCell(1000, $styleCell)->addText(htmlspecialchars('Precio Unit'), $fontStyle, $parrafoCentro);
                if ($pud == 't') {
                    $tabler->addCell(1000, $styleCell)->addText(htmlspecialchars('Precio Unit Dscto'), $fontStyle, $parrafoCentro);
                }
                $tabler->addCell(2000, $styleCell)->addText(htmlspecialchars('Precio Total'), $fontStyle, $parrafoCentro);

                $precio_total_desp = 0;
                $ptotal_desp = 0;
                $ncarritodesp = count($detredondeo);
                //$color = colorFilaInicio();
                if ($ncarritodesp > 0) {

                    foreach ($detredondeo as $productodesp) {

                        $nomproducto = trim($productodesp['nomprod']);
                        $bidones = $productodesp['cantidad1']; //bidones
                        $litrosdesp = $productodesp['cantidad2']; //litros
                        $precio1 = $productodesp['preciou']; //precio unitario
                        $precio2 = $productodesp['preciodcto']; // precio unitario con descuento

                        if ($pud == 't') {
                            $ptotal_desp = $litrosdesp * $precio2; //total litros * precio descuento unitario, el precio unitario descuento puede ser el mismo que el precio unitario.                            
                        } else {
                            $ptotal_desp = $litrosdesp * $precio1;
                        }
                        //$ptotal_desp = $litrosdesp * $precio2;  
                        $precio_total_desp+= $ptotal_desp;

                        //******* Aplicando Asteriscos
                        $asterisco = '**';
                        if ($productodesp['factorb'] == '9.46') {
                            $asterisco = '*';
                        }
                        $tabler->addRow();
                        $tabler->addCell(2750, $styleCell)->addText(htmlspecialchars($nomproducto . ' ' . $asterisco), $fontStyleBody, $parrafoLeft);
                        $tabler->addCell(1000, $styleCell)->addText(htmlspecialchars(number_format($bidones, 2)), $fontStyleBody, $parrafoCentro);
                        $tabler->addCell(1000, $styleCell)->addText(htmlspecialchars(number_format($litrosdesp, 2)), $fontStyleBody, $parrafoCentro);
                        $tabler->addCell(1000, $styleCell)->addText(htmlspecialchars('$' . number_format($precio1, 2)), $fontStyleBody, $parrafoRight);
                        if ($pud == 't') {
                            $tabler->addCell(1000, $styleCell)->addText(htmlspecialchars('$' . number_format($precio2, 2)), $fontStyleBody, $parrafoRight);
                        }
                        $tabler->addCell(2000, $styleCell)->addText(htmlspecialchars('$' . number_format($ptotal_desp, 2)), $fontStyleBody, $parrafoRight);
                    }
                    if ($pud == 'f') {
                        $tabler->addRow();
                        $tabler->addCell(4750, $cellColSpan3)->addText(htmlspecialchars(''), $fontStyleBody, $parrafoLeft);
                        $tabler->addCell(1000)->addText(htmlspecialchars('Sub Total'), $fontStyleBody, $parrafoCentro);
                        $tabler->addCell(1000)->addText(htmlspecialchars('$' . number_format($precio_total_desp, 2)), $fontStyleBody, $parrafoRight);
                    }
                    $precio_totalcongelado = 0;
                    $preciorestado2 = ($precio_total_desp - $precio_totalcongelado);

                    if ($pud == 't') {
                        $precioAMBT2 = $prop->calcularPrecioAMBT(0, $preciorestado2, $precio_totalcongelado);
                    } else {
                        $precioAMBT2 = $prop->calcularPrecioAMBT($dcto, $preciorestado2, $precio_totalcongelado);
                    }

                    $tabler->addRow();
                    if ($pud == 't') {
                        $tabler->addCell(2750)->addText(htmlspecialchars(''), $fontStyleBody, $parrafoLeft);
                    }
                    $tabler->addCell(3000, $cellColSpan3)->addText(htmlspecialchars('Precio Redondeado con descuento'), $fontStyleBody, $parrafoCentro);
                    $tabler->addCell(1000)->addText(htmlspecialchars('Total'), $fontStyleBody, $parrafoCentro);
                    $tabler->addCell(1000)->addText(htmlspecialchars('$' . number_format($precioAMBT2, 2)), $fontStyleBody, $parrafoRight);

                    //INCLUIR IGV
                    $igv = 0;
                    if ($incluyeigv == 't') {
                        $igv = ($precioAMBT2 * $valigv) / 100;
                        $pagototal = $precioAMBT2 + $igv;

                        $tabler->addRow();
                        if ($pud == 't') {
                            $tabler->addCell(2750)->addText(htmlspecialchars(''), $fontStyleBody, $parrafoLeft);
                        }
                        $tabler->addCell(3000, $cellColSpan3)->addText(htmlspecialchars(''), $fontStyleBody, $parrafoLeft);
                        $tabler->addCell(1000)->addText(htmlspecialchars('IGV'), $fontStyleBody, $parrafoCentro);
                        $tabler->addCell(1000)->addText(htmlspecialchars('$'.number_format($igv, 2)), $fontStyleBody, $parrafoRight);
                        
                        $tabler->addRow();
                        if ($pud == 't') {
                            $tabler->addCell()->addText(htmlspecialchars(''), $fontStyleBody, $parrafoLeft);
                        }
                        $tabler->addCell(3000, $cellColSpan3)->addText(htmlspecialchars(''), $fontStyleBody, $parrafoLeft);
                        $tabler->addCell(1000)->addText(htmlspecialchars('Total a Pagar'), $fontStyleBody, $parrafoCentro);
                        $tabler->addCell(1000)->addText(htmlspecialchars('$'.number_format($pagototal, 2)), $fontStyleBody, $parrafoRight);                        
                    }
                    
                    $section->addText();
                    $section->addText(htmlspecialchars('(*) Bidones de 9.46 Litros.'), $fontStyleBody, array('spaceAfter' => 0));
                    $section->addText(htmlspecialchars('(**) Bidones de 10.00 Litros.'), $fontStyleBody, array('spaceAfter' => 0));
                }
            }
        }
    }
}


$paragraphStyleItem = array('spaceAfter' => 0, 'align' => 'justify');
$section->addText();
$section->addText(htmlspecialchars('Condiciones Técnicas y de Ventas:'), $font_subtitulo);
for ($i = 0; $i < count($condicion); $i++) {
    $section->addListItem(htmlspecialchars(trim($condicion[$i])), 0, $font_condicion, 'multilevel', $paragraphStyleItem);
}
$section->addTextBreak(1);
$section->addText(htmlspecialchars('Cordialmente,'), $font_normal, array('spaceAfter' => 0));
$section->addText(htmlspecialchars('Agro Micro Biotech S.A.C.'), $font_negrita);



//Descargar Archivo
$file = $codprop . '.docx';
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$xmlWriter->save("php://output");
