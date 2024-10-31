<?php
// Incluir la librería de PhpSpreadsheet
require '../../vendor/autoload.php'; // Si instalaste PhpSpreadsheet con Composer
require($_SERVER['DOCUMENT_ROOT'] . "/dashboardGNP/lib/funciones.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Definir la función para establecer valores con formato
function setCellValueWithFormat($sheet, $cell, $value, $type = 'text', $bold = false, $borderStyle = null, $backgroundColor = null, $fontColor = null) {
    $sheet->setCellValue($cell, $value);

    // Establecer el formato según el tipo
    switch ($type) {
        case 'number':
            $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0');
            break;
        case 'currency':
            $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('$#,##0.00');
            break;
        case 'text':
        default:
            // No se necesita formato adicional
            break;
    }

    // Aplicar negrita si es necesario
    if ($bold) {
        $sheet->getStyle($cell)->getFont()->setBold(true);
    }

    // Establecer color de letra si se proporciona
    if ($fontColor) {
        $sheet->getStyle($cell)->getFont()->setColor(new Color($fontColor));
    }

    // Aplicar borde si se especifica
    if ($borderStyle) {
        $sheet->getStyle($cell)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => $borderStyle,
                    'color' => ['argb' => Color::COLOR_BLACK],
                ],
            ],
        ]);
    }

    // Establecer color de fondo si se proporciona
    if ($backgroundColor) {
        $sheet->getStyle($cell)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => $backgroundColor],
            ],
        ]);
    }
}

function formatNumber($number){
    $number = floatval(str_replace(',', '.', str_replace('.', '', $number)));
    return $number;
}

// Función para llenar los datos en una hoja
function fillData($sheet, &$rowNumber, $db, $idCam) {
    // Encabezados para la tabla
    setCellValueWithFormat($sheet, 'B' . $rowNumber, 'TICKET', 'text', true, Border::BORDER_THIN, 'FF0000FF', 'FFFFFFFF'); // Encabezado TICKET
    setCellValueWithFormat($sheet, 'C' . $rowNumber, 'MARGEN', 'text', true, Border::BORDER_THIN, 'FF0000FF', 'FFFFFFFF'); // Encabezado MARGEN
    setCellValueWithFormat($sheet, 'D' . $rowNumber, 'Valor Ud', 'text', true, Border::BORDER_THIN, 'FF0000FF', 'FFFFFFFF'); // Encabezado Valor Ud

    // Formatos para las celdas de datos
    $sheet->getStyle('B' . $rowNumber)->getNumberFormat()->setFormatCode('#,##0'); // Formato para MARGEN
    $sheet->getStyle('C' . $rowNumber)->getNumberFormat()->setFormatCode('#,##0'); // Formato para MARGEN
    $sheet->getStyle('D' . $rowNumber)->getNumberFormat()->setFormatCode('#,##0'); // Formato para Valor Ud

    // Inicializar la fila de datos
    $rowNumber++;

    // Loop para obtener los datos de la tabla
    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = 1 AND car_id = 1");

    while ($dis = $db->fetch_array($datos_incentivos_staff)) {
        if(!empty($dis["inc_campana"])){
            setCellValueWithFormat($sheet, 'C3', 'CAMPAÑA', 'text', true); // Encabezado CAMPAÑA
            setCellValueWithFormat($sheet, 'D3', $dis['inc_campana'], 'text'); // Valor de CAMPAÑA
        }
        if(!empty($dis["inc_gerente"])){
            setCellValueWithFormat($sheet, 'C4', 'SEGMENTO', 'text', true); // Encabezado SEGMENTO
            setCellValueWithFormat($sheet, 'D4', $dis['inc_gerente'], 'text'); // Valor de SEGMENTO
        }
        if(!empty($dis["inc_operacion"])){
            setCellValueWithFormat($sheet, 'C5', 'JEFE', 'text', true); // Encabezado JEFE
            setCellValueWithFormat($sheet, 'D5', $dis['inc_operacion'], 'text'); // Valor de JEFE
        }
        if(!empty($dis["inc_segmento"])){
            setCellValueWithFormat($sheet, 'C6', 'OPERACIÓN', 'text', true); // Encabezado OPERACIÓN
            setCellValueWithFormat($sheet, 'D6', $dis['inc_segmento'], 'text'); // Valor de OPERACIÓN

            if(!empty($dis["inc_mes"])){
                setCellValueWithFormat($sheet, 'C7', 'MES', 'text', true); // Encabezado MES
                setCellValueWithFormat($sheet, 'D7', $dis['inc_mes'], 'text'); // Valor de MES
            }
        }

        // Recorre los detalles del incentivo y escríbelos en el archivo Excel
        $detalle_incentivos_ticket = $db->query('SELECT incd_ticket, incd_margen, incd_vlrUd FROM tb_incentivos_asesores_detalle WHERE inc_id = ' . $dis[0]);

        while ($detInc = $db->fetch_array($detalle_incentivos_ticket)) {
            // Escribir los valores en las celdas usando la nueva función

            $margen = formatNumber($detInc['incd_margen']);
            $valorUd = formatNumber($detInc['incd_vlrUd']);

            setCellValueWithFormat($sheet, 'B' . $rowNumber, floatval($detInc['incd_ticket']), 'currency');
            setCellValueWithFormat($sheet, 'C' . $rowNumber, $margen, 'currency');
            setCellValueWithFormat($sheet, 'D' . $rowNumber, $valorUd, 'currency');
            
            $rowNumber++; // Ir a la siguiente fila
        }
    }

    // Ajustar columnas
    foreach (range('A', 'Z') as $columnID) { // Ajustar columnas
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Aplicar formato al cuerpo de la tabla (centrar y agregar borde)
    for ($i = 9; $i < $rowNumber; $i++) {
        foreach (range('B', 'D') as $columnID) {
            $sheet->getStyle($columnID . $i)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => Color::COLOR_BLACK],
                    ],
                ],
            ]);
        }
    }
}

// Crear un nuevo archivo Excel
$spreadsheet = new Spreadsheet();

// CREACION DE TODAS LAS HOJAS
$HojasQuery = $db->query("SELECT * FROM tb_campania");

while ($hoja = $db->fetch_array($HojasQuery)) {
    switch ($hoja[4]) {
        case "MOVIL":
            $color = "2F75B5"; // Azul
            break;
        case "HOGAR":
            $color = "C00000"; // Rojo
            break;
        case "T&T":
            $color = "548235"; // Verde
            break;
        default:
            $color = "FFFFFF"; // Color por defecto (blanco si no coincide)
            break;
    }

    // Crear una nueva hoja
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($hoja["cam_nombre"]);
    $sheet->getTabColor()->setARGB($color);
    
    // Aplicar estilo de fondo
    $sheet->getStyle('A1:Z100')->applyFromArray([
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['argb' => 'FFFFFFFF'], // Blanco
        ],
    ]);

    // Llenar datos en la hoja
    // Variables para controlar las filas y columnas en el Excel
    $rowNumber = 9;
    fillData($sheet, $rowNumber, $db, $hoja[0]); // Usar la nueva hoja en lugar de la activa
}


// Crear hoja "MIGRACIÓN"
// $sheetMigracion = $spreadsheet->createSheet();
// $sheetMigracion->setTitle('MIGRACIÓN');
// $sheetMigracion->getStyle('A1:Z100')->applyFromArray([
//     'fill' => [
//         'fillType' => Fill::FILL_SOLID,
//         'startColor' => ['argb' => 'FFFFFFFF'], // Azul
//     ],
// ]);


// Llenar datos en la hoja "MIGRACIÓN"
// $rowNumber = 9; // Reiniciar el contador de filas para la nueva hoja
// fillData($sheetMigracion, $rowNumber, $db);

// Establecer el encabezado para descargar el archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="incentivos_asesores.xlsx"');
header('Cache-Control: max-age=0');

// Escribir el archivo Excel y enviarlo al navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
