<?php

// function setCellValueWithFormat($sheet, $cell, $value, $type = 'text', $bold = false, $borderStyle = null, $backgroundColor = null) {
//     $sheet->setCellValue($cell, $value);

//     // Establecer el formato según el tipo
//     switch ($type) {
//         case 'number':
//             $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0');
//             break;
//         case 'currency':
//             $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('$#,##0.00');
//             break;
//         case 'text':
//         default:
//             // No se necesita formato adicional
//             break;
//     }

//     // Aplicar negrita si es necesario
//     if ($bold) {
//         $sheet->getStyle($cell)->getFont()->setBold(true);
//     }

//     // Aplicar borde si se especifica
//     if ($borderStyle) {
//         $sheet->getStyle($cell)->applyFromArray([
//             'borders' => [
//                 'allBorders' => [
//                     'borderStyle' => $borderStyle,
//                     'color' => ['argb' => Color::COLOR_BLACK],
//                 ],
//             ],
//         ]);
//     }

//     // Establecer color de fondo si se proporciona
//     if ($backgroundColor) {
//         $sheet->getStyle($cell)->applyFromArray([
//             'fill' => [
//                 'fillType' => Fill::FILL_SOLID,
//                 'startColor' => ['argb' => $backgroundColor],
//             ],
//         ]);
//     }
// }
