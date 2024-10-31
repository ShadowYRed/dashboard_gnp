<?php

//ACCION PARA CREAR UNA NUEVA TABLA
if($action == "addTablaIncentivos"){

    // Crear la base de las columnas y valores para la consulta SQL
    $columnasSql = "inc_gerente, inc_operacion, inc_segmento, inc_encabezado, inc_fila, inc_orden, inc_cargo";
    $valoresSql = "'$gerente', '$operacion', '$segmento', '$encabezado', '$fila', '$orden', '$inc_cargo'";

    // Contador de columnas dinámicas (desde inc_columna1 hasta inc_columnaX)
    $maxColumns = 20; // Suponiendo que el máximo es 20 columnas

    for ($i = 1; $i <= $maxColumns; $i++) {
        // Verificar si la columna existe (por si no se generan todas)
        $columnaVar = 'inc_columna' . $i;
        if (isset($columnaVar) && !empty($columnaVar)) {
            $columnasSql .= ", inc_columna$i";  // Agregar la columna
            $valoresSql .= ", '" . $columnaVar . "'";  // Agregar el valor
        }
    }

    // Añadir las fechas de creación y actualización
    $columnasSql .= ", inc_created_at, inc_update_at, car_id";
    $valoresSql .= ", NOW(), NOW(), '$id_campania'";

    // Construir la consulta final
    $sql = "INSERT INTO tb_incentivos ($columnasSql) VALUES ($valoresSql)";

    // Ejecutar la consulta
    if ($db->query($sql)) {
        echo $sql;
        $alerta = AlertaGeneral("Listo", "Tabla creada con exito", "success", "");
    } else {
        $alerta = AlertaGeneral("Error", "No se pudo guardar los datos", "error", "");
    }
}

//ACCIÓN QUE ACTUALIZA LAS TABLAS
elseif($action == "updateIncentivos"){
    // Encontrar dinámicamente todas las columnas 'incd_colX'
    $columnData = [];
    $columnCount = 0;

    // Detectar cuántas columnas existen (máximo hasta 20)
    for ($i = 1; $i <= 20; $i++) {
        $colName = "incd_col$i"; // Crear nombre de columna dinámicamente
        if (isset($_POST[$colName])) {
            $columnData[] = $_POST[$colName]; // Guardar las columnas que existen
            $columnCount++;
        } else {
            break; // Si una columna no existe, paramos la detección
        }
    }

    // Iniciar la tabla HTML
    #echo "<table border='1' style='position: fixed; z-index: 1000; right: 0;'>";
    #echo "<tr><th colspan='{$columnCount}'>$columnHeader</th></tr>"; // Encabezado general
    
    // Encabezados de las columnas
    #echo "<tr>";
    $colCont = 1;
    $campsRows = "";
    $valsRows = "";
    for ($i = 0; $i < $columnCount; $i++) {
        $campsRows .= "inc_columna$colCont = '{$inc_columna[$i]}'"; if($colCont != $columnCount){ $campsRows .= ","; } 
        #echo "<th>{$inc_columna[$i]} inc_columna$colCont </th>"; // Los nombres de las columnas
        $colCont++;
    }
    #echo "</tr>";
    $db->query("UPDATE tb_incentivos SET inc_update_at = NOW(), inc_encabezado = '$columnHeader', $campsRows WHERE inc_id = '$inc_id'");

    // Contar cuántas filas tenemos en las columnas detectadas
    $rowCount = count($columnData[0]); // Contamos filas en la primera columna

    // Generar las filas de la tabla
    $db->query("DELETE FROM tb_incentivos_detalle WHERE inc_id = '$inc_id'");

    for ($row = 0; $row < $rowCount; $row++) {
        $colContb = 1;
        $campsRows = "";
        $valsRows = "";
        #echo "<tr>";
        for ($col = 0; $col < $columnCount; $col++) {
            $campsRows .= "incd_col$colContb"; if($colContb != $columnCount){ $campsRows .= ","; } 
            $valsRows .= "'{$columnData[$col][$row]}'"; if($colContb != $columnCount){ $valsRows .= ","; } 

            // echo "<td>{$columnData[$col][$row]}     incd_col$colContb</td>"; // Imprimir el valor de cada columna
            $colContb++;
        }
        // echo "</tr>";
        $db->query("INSERT INTO tb_incentivos_detalle (inc_id, $campsRows) VALUES ('$inc_id', $valsRows)");
    }

    $alerta = AlertaGeneral("Listo", "Tabla Actualizada con exito", "success", "");

    // echo "</table>";
}

//INSERT DE LSA TABLAS DE LOS ASESORES
elseif($action == "addTablaIncentivosAsesores"){

    // Crear la base de las columnas y valores para la consulta SQL
    $columnasSql = "inc_gerente, inc_operacion, inc_segmento, inc_encabezado, inc_fila, inc_orden, inc_cargo, inc_ticket, inc_principal, inc_vlrUnd, inc_mes, inc_anio, inc_campana, inc_tipo";
    $valoresSql = "'$gerente', '$operacion', '$segmento', '$encabezado', '$fila', '$orden', '$inc_cargo', '$inc_ticket', '0', '$inc_vlrUnd', '$inc_mes', '$inc_anio', '$inc_campana', '$inc_tipo'";

    // Contador de columnas dinámicas (desde inc_columna1 hasta inc_columnaX)
    $maxColumns = 20; // Suponiendo que el máximo es 20 columnas

    for ($i = 1; $i <= $maxColumns; $i++) {
        // Verificar si la columna existe en $_POST
        $columnaVar = 'inc_columna' . $i;
        if (isset($_POST[$columnaVar])) {
            $columnasSql .= ", inc_columna$i";  // Agregar la columna
            $valoresSql .= ", '" . $_POST[$columnaVar] . "'";  // Agregar el valor real
        }
    }

    // Añadir las fechas de creación y actualización
    $columnasSql .= ", inc_created_at, inc_update_at, car_id";
    $valoresSql .= ", NOW(), NOW(), '$id_campania'";

    // Construir la consulta final
    $sql = "INSERT INTO tb_incentivos_asesores ($columnasSql) VALUES ($valoresSql)";

    echo $sql;
    // Ejecutar la consulta
    if ($db->query($sql)) {
        echo $sql;
        $alerta = AlertaGeneral("Listo", "Tabla creada con exito", "success", "");
    } else {
        $alerta = AlertaGeneral("Error", "No se pudo guardar los datos", "error", "");
    }
}

//ACCIÓN QUE ACTUALIZA LAS TABLAS
elseif($action == "updateIncentivosAsesores"){
    // Encontrar dinámicamente todas las columnas 'incd_colX'
    $columnData = [];
    $columnCount = 0;

    // Detectar cuántas columnas existen (máximo hasta 20)
    for ($i = 1; $i <= 20; $i++) {
        $colName = "incd_col$i"; // Crear nombre de columna dinámicamente
        if (isset($_POST[$colName])) {
            $columnData[] = $_POST[$colName]; // Guardar las columnas que existen
            $columnCount++;
        } else {
            break; // Si una columna no existe, paramos la detección
        }
    }

    $colCont = 1;
    $campsRows = "";
    $valsRows = "";
    for ($i = 0; $i < $columnCount; $i++) {
        $campsRows .= "inc_columna$colCont = ' {$inc_columna[$i]} '"; 
        if($colCont != $columnCount){ $campsRows .= ","; } 
        $colCont++;
    }

    // Contar cuántas filas tenemos en las columnas detectadas
    $rowCount = count($columnData[0]); // Contamos filas en la primera columna

    // Generar las filas de la tabla
    $db->query("DELETE FROM tb_incentivos_asesores_detalle WHERE inc_id = '$inc_id'");

        for ($row = 0; $row < $rowCount; $row++) {
            $colContb = 1;
            $colContb2 = 1;
            $campsRows = "";
            $valsRows = "";
            $valsRowsArray = [];
            // ECHO $columnCount;
            for ($col = 0; $col < $columnCount; $col++) {
                // Guarda los valores en un array
                $valsRowsArray[] = $columnData[$col][$row];
                $colContb++;
            }

            for ($col = 0; $col < $columnCount; $col++) {
                if(!empty($columnData[$col][$row])){
                    // echo "<br>incd_col$colContb2 | {$columnData[$col][$row]} <br>";
                    $campsRows .= "incd_col$colContb2"; if($colContb2 != $columnCount){ $campsRows .= ","; } 
                    $valsRows .= "'{$columnData[$col][$row]}'"; if($colContb2 != $columnCount){ $valsRows .= ","; } 
                    // echo "<td>{$columnData[$col][$row]}     incd_col$colContb</td>"; // Imprimir el valor de cada columna
                }else{
                    $campsRows .= "incd_col$colContb2"; if($colContb2 != $columnCount){ $campsRows .= ","; } 
                    $valsRows .= "'0'"; if($colContb2 != $columnCount){ $valsRows .= ","; } 
                }
                // echo $colContb2; 
                $colContb2++;
            }
            // echo "</tr>";
            if($inc_principal > 0){
                $incd_ticket = 28494;
                // var_dump($valsRowsArray);
                // echo "<br>".intval($valsRowsArray[4]) ."/". intval($valsRowsArray[2])."<br>";
                if($row == 0){
                    $incd_vlrUd = $valsRowsArray[4];
                }else{
                    $incd_vlrUd = $valsRowsArray[4] / $valsRowsArray[2];
                }
                
                $incd_margen = intval($incd_ticket) * intval($valsRowsArray[2]);
                $incd_margen = number_format($incd_margen, 2, ',', '.'); // 2 decimales, ',' para decimales y '.' para miles
                $incd_vlrUd = number_format($incd_vlrUd, 2, ',', '.');   // 2 decimales, ',' para decimales y '.' para miles

                // echo "<br>margen: " . $incd_margen;
            }

            $db->query("INSERT INTO tb_incentivos_asesores_detalle (inc_id, incd_ticket, incd_margen, incd_vlrUd, $campsRows) VALUES ('$inc_id', '$incd_ticket', '$incd_margen', '$incd_vlrUd', $valsRows)");
        }

    $alerta = AlertaGeneral("Listo", "Tabla Actualizada con exito", "success", "");

    // echo "</table>";
}

elseif($action == "nuevoMes"){
    // $insentivos_asesores = $db->query("
    //     SELECT 
    //         inc_id, car_id, inc_fila, inc_orden, inc_cargo, inc_gerente, inc_operacion, inc_segmento, inc_campana, inc_encabezado, 
    //         inc_columna1, inc_columna2, inc_columna3, inc_columna4, inc_columna5, 
    //         inc_columna6, inc_columna7, inc_columna8, inc_columna9, inc_columna10, 
    //         inc_columna11, inc_columna12, inc_columna13, inc_columna14, inc_columna15, 
    //         inc_columna16, inc_columna17, inc_columna18, inc_columna19, inc_columna20, 
    //         inc_principal, inc_ticket, inc_vlrUnd, '$mes_nuevo' AS inc_mes, '$anio_nuevo' AS inc_anio, inc_created_at, inc_update_at, inc_tipo
    //     FROM tb_incentivos_asesores
    //     WHERE inc_mes = '$mes_actual' AND inc_anio = '$anio_actual';
    // ");
    
    // while($ins_ase = $db->fetch_array($insentivos_asesores)){
    //     $db->query("
    //         INSERT INTO tb_incentivos_asesores (
    //             car_id, inc_fila, inc_orden, inc_cargo, inc_gerente, inc_operacion, inc_segmento, inc_campana, inc_encabezado, 
    //             inc_columna1, inc_columna2, inc_columna3, inc_columna4, inc_columna5, 
    //             inc_columna6, inc_columna7, inc_columna8, inc_columna9, inc_columna10, 
    //             inc_columna11, inc_columna12, inc_columna13, inc_columna14, inc_columna15, 
    //             inc_columna16, inc_columna17, inc_columna18, inc_columna19, inc_columna20, 
    //             inc_principal, inc_ticket, inc_vlrUnd, inc_mes, inc_anio, inc_created_at, inc_update_at, inc_tipo
    //         )
    //         SELECT 
    //             '".$ins_ase["car_id"]."' AS car_id, inc_fila, inc_orden, inc_cargo, inc_gerente, inc_operacion, inc_segmento, inc_campana, inc_encabezado, 
    //             inc_columna1, inc_columna2, inc_columna3, inc_columna4, inc_columna5, 
    //             inc_columna6, inc_columna7, inc_columna8, inc_columna9, inc_columna10, 
    //             inc_columna11, inc_columna12, inc_columna13, inc_columna14, inc_columna15, 
    //             inc_columna16, inc_columna17, inc_columna18, inc_columna19, inc_columna20, 
    //             inc_principal, inc_ticket, inc_vlrUnd, '$mes_nuevo' AS inc_mes, '$anio_nuevo' AS inc_anio, inc_created_at, inc_update_at, inc_tipo
    //         FROM tb_incentivos_asesores
    //         WHERE inc_mes = '$mes_actual' AND inc_anio = '$anio_actual' AND car_id = '".$ins_ase["car_id"]."';
    //     ");

    //     $inc_id = $db->HallaValorUnico("SELECT inc_id FROM tb_incentivos_asesores ORDER BY inc_id DESC LIMIT 1;");
    //     $inc_id = $inc_id+1;
    //     $insentivos_asesores_detalle = $db->query("SELECT*FROM tb_incentivos_asesores_detalle WHERE inc_id = '".$ins_ase[0]."' ");

    //     while($ins_ase_det = $db->fetch_array($insentivos_asesores_detalle)){
    //         $db->query("
    //             INSERT INTO tb_incentivos_asesores_detalle (
    //                 incd_id, inc_id, 
    //                 incd_col1, incd_col2, incd_col3, incd_col4, incd_col5, 
    //                 incd_col6, incd_col7, incd_col8, incd_col9, incd_col10, 
    //                 incd_col11, incd_col12, incd_col13, incd_col14, incd_col15, 
    //                 incd_col16, incd_col17, incd_col18, incd_col19, incd_col20, 
    //                 incd_ticket, incd_margen, incd_vlrUd, incd_created_at, incd_updated_at
    //             )
    //             SELECT 
    //                 '".$ins_ase["car_id"]."' AS car_id, inc_fila, inc_orden, inc_cargo, inc_gerente, inc_operacion, inc_segmento, inc_campana, inc_encabezado, 
    //                 inc_columna1, inc_columna2, inc_columna3, inc_columna4, inc_columna5, 
    //                 inc_columna6, inc_columna7, inc_columna8, inc_columna9, inc_columna10, 
    //                 inc_columna11, inc_columna12, inc_columna13, inc_columna14, inc_columna15, 
    //                 inc_columna16, inc_columna17, inc_columna18, inc_columna19, inc_columna20, 
    //                 inc_principal, inc_ticket, inc_vlrUnd, '$mes_nuevo' AS inc_mes, '$anio_nuevo' AS inc_anio, inc_created_at, inc_update_at, inc_tipo
    //             FROM tb_incentivos_asesores_detalle
    //             WHERE car_id = '".$ins_ase["car_id"]."';
    //         ");
    //     }
    // }

    // //Insertar La información
    // $db->query("
    //     INSERT INTO tb_incentivos_asesores (
    //         car_id, inc_fila, inc_orden, inc_cargo, inc_gerente, inc_operacion, inc_segmento, inc_campana, inc_encabezado, 
    //         inc_columna1, inc_columna2, inc_columna3, inc_columna4, inc_columna5, 
    //         inc_columna6, inc_columna7, inc_columna8, inc_columna9, inc_columna10, 
    //         inc_columna11, inc_columna12, inc_columna13, inc_columna14, inc_columna15, 
    //         inc_columna16, inc_columna17, inc_columna18, inc_columna19, inc_columna20, 
    //         inc_principal, inc_ticket, inc_vlrUnd, inc_mes, inc_anio, inc_created_at, inc_update_at, inc_tipo
    //     )
    //     SELECT 
    //         car_id, inc_fila, inc_orden, inc_cargo, inc_gerente, inc_operacion, inc_segmento, inc_campana, inc_encabezado, 
    //         inc_columna1, inc_columna2, inc_columna3, inc_columna4, inc_columna5, 
    //         inc_columna6, inc_columna7, inc_columna8, inc_columna9, inc_columna10, 
    //         inc_columna11, inc_columna12, inc_columna13, inc_columna14, inc_columna15, 
    //         inc_columna16, inc_columna17, inc_columna18, inc_columna19, inc_columna20, 
    //         inc_principal, inc_ticket, inc_vlrUnd, '$mes_nuevo' AS inc_mes, '$anio_nuevo' AS inc_anio, inc_created_at, inc_update_at, inc_tipo
    //     FROM tb_incentivos_asesores
    //     WHERE inc_mes = '$mes_actual' AND inc_anio = '$anio_actual';
    // ");
}