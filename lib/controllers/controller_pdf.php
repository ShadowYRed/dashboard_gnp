<?php

function generarPDF($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda ){

    if($action == "Especifico"){
        //$condicional_incentivos = "AND inc_id = $inc_id";
        $condicional_incentivos = "";
    }else{
        $condicional_incentivos = "";
    }

              $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
              $contLn = 1;
              while ($ln = $db->fetch_array($lineas_negocio)) {
                if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
              ?>
                  <?php
                    $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
                    $contCar2 = 1;
                    while ($ca = $db->fetch_array($cargos2)) {
                      if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
                  ?>
                     <div class="row">
                        <div class="col-12">
                          <div class="card w-maxcontent">
                            <div class="card-body">
                              <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                            <?php
                            for($iDiv = 1; $iDiv<=10; $iDiv++){
                                // echo ("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = ". $cam_id. " $condicional_incentivos");
                              $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = ". $cam_id. "  AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda' $condicional_incentivos");
                              echo "<div class='d-flex'>";
                              while($dis = $db->fetch_array($datos_incentivos_staff)) {
                            ?>
                            <?php
                            ?>
                              <div class="p-relative m-lr-1">
                                <ul class="mt-2 mh-4r">
                                  <?php
                                  
                                  if(!empty($dis["inc_campana"])){
                                    echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                                  }
                                  if(!empty($dis["inc_gerente"])){
                                    echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                                  }
                                  if(!empty($dis["inc_operacion"])){
                                    echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                                  }
                                  if(!empty($dis["inc_segmento"])){
                                    echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                                      
                                    if(!empty($dis["inc_mes"])){
                                      echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                                    }
                                  }

                                  ?>
                                </ul>
                                <div class="d-flex">
                                  <?php 
                                  $contTicket = $db->HallaValorUnico('SELECT COUNT(incd_ticket) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]).' '; 
                                  if($contTicket > 0 && $dis["inc_principal"] == "1"){
                                  ?>
                                  <div>
                                    <table class="custom-table mt-3 mr-2" border="1">
                                      <thead>
                                          <tr>
                                              <th class="pd-ticket">TICKET</th>
                                              <th>MARGEN</th>
                                              <th>Vlr Ud</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php 
                                          $detalle_incentivos_ticket = $db->query('SELECT incd_ticket, incd_margen, incd_vlrUd FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                          
                                          while($detInc = $db->fetch_array($detalle_incentivos_ticket)){
                                            echo "<tr>";
                                                echo '
                                                <td class="td-ins td-ticket">
                                                  '. $detInc["incd_ticket"] . '
                                                </td>
                                                ';
                                                echo '
                                                <td class="td-ins td-ticket">
                                                  '. $detInc["incd_margen"] . '
                                                </td>
                                                ';
                                                echo '
                                                <td class="td-ins td-ticket">
                                                  '. $detInc["incd_vlrUd"] . '
                                                </td>
                                                ';
                                            echo "</tr>";
                                          }
                                        ?>
                                      </tbody>
                                    </table>
                                  </div>
                                  <?php }elseif($contTicket > 0 && $dis["inc_principal"] == "2"){ ?>
                                  <div>
                                    <table class="custom-table mt-3 mr-2" border="1">
                                      <thead>
                                          <tr>
                                              <th class="pd-ticket">TICKET</th>
                                              <th>MARGEN</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php 
                                          $detalle_incentivos_ticket = $db->query('SELECT incd_ticket, incd_margen, incd_vlrUd FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                          
                                          while($detInc = $db->fetch_array($detalle_incentivos_ticket)){
                                            echo "<tr>";
                                                echo '
                                                <td class="td-ins td-ticket">
                                                  '. $detInc["incd_ticket"] . '
                                                </td>
                                                ';
                                                echo '
                                                <td class="td-ins td-ticket">
                                                  '. $detInc["incd_margen"] . '
                                                </td>
                                                ';
                                            echo "</tr>";
                                          }
                                        ?>
                                      </tbody>
                                    </table>
                                  </div>
                                  <?php } ?>
                                  <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                                    <thead>
                                      <tr>
                                        <?php 
                                          $contCol = 0;
                                          for ($i = 1; $i <= 20; $i++) {
                                            $columna = "inc_columna" . $i;
                                            
                                            // Comprobar si la columna tiene datos
                                            if (!empty($dis[$columna])) {
                                              $contCol++;
                                            }
                                          }
                                        ?>
                                        <?php if(!empty($dis['inc_encabezado'])){ ?>
                                        <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                          <?php echo $dis['inc_encabezado']; ?>
                                        </th>
                                        <?php } ?>
                                      </tr>
                                      <tr>
                                      <?php 
                                        for ($i = 1; $i <= 20; $i++) {
                                          $columna = "inc_columna" . $i;
                                          
                                          // Comprobar si la columna tiene datos
                                          if (!empty($dis[$columna])) {
                                            if($dis[$columna] == "ACTIVAS1"){
                                              echo '
                                              <th class="th-ins" colspan= "2">
                                                ACTIVAS
                                              </th>
                                              ';
                                            }elseif($dis[$columna] == "ACTIVAS2"){

                                            }else{
                                              echo '
                                              <th class="th-ins">
                                                ' . $dis[$columna] . '
                                              </th>
                                              ';
                                            }
                                          }
                                        }
                                      ?>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                      $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                      $ContDetalleIncentivo = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                      if(empty($ContDetalleIncentivo)){
                                        if($ContDetalleIncentivo == 0 || empty($ContDetalleIncentivo)) {
                                          for ($i = 1; $i <= $contCol; $i++) {
                                            $columna2 = "incd_col" . $i;
                                            // Comprobar si la columna tiene datos
                                            echo '
                                            <td class="td-ins">
                                              
                                            </td>
                                            ';
                                          }
                                        }
                                      }
                                      $contadorDatos = 0;
                                      while($detInc = $db->fetch_array($detalle_incentivos)){
                                        echo "<tr>";
                                        $contTbody = 0;
                                        for ($i = 1; $i <= 20; $i++) {
                                          $columna2 = "incd_col" . $i;
                                          $iA = $i-1;
                                          $columna2Ant = "incd_col" . $iA;
                                          // Comprobar si la columna tiene datos
                                        if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.' ">
                                                  '. $detInc[$columna2] . '
                                                  
                                                </td>
                                                ';
                                              }
                                            }
                                          }else{
                                            if (!empty($detInc[$columna2]) || $detInc[$columna2] == "0") {
                                              $contTbody++;
                                              if($columna2 == "incd_col4"){
                                                $anteriorVal = str_replace('A', '', $detInc[$columna2]); // Elimina todas las letras 'A'
                                                $anteriorVal = trim($anteriorVal); // Elimina los espacios en blanco alrededor del texto

                                                
                                                $valTexarea = "A ".$anteriorVal;
                                                if($contadorDatos == 0){
                                                  $valTexarea = "> ".$detInc[$columna2Ant];
                                                }
                                                echo '
                                                <td class="td-ins">
                                                    ' . $valTexarea . '
                                                </td>
                                                ';
                                              }else{
                                                echo '
                                                <td class="td-ins">
                                                    ' . $detInc[$columna2] . '
                                                  
                                                </td>
                                                ';
                                              }
                                            }elseif($detInc[$columna2] == 0){
                                              $contTbody++;
                                              if($columna2 == "incd_col4"){
                                                $anteriorVal = str_replace('A', '', $detInc[$columna2Ant]); // Elimina todas las letras 'A'
                                                $anteriorVal = trim($anteriorVal); // Elimina los espacios en blanco alrededor del texto

                                                $valTexarea = "A ".$anteriorVal;
                                                if($contadorDatos == 0){
                                                  $valTexarea = " > ".$detInc[$columna2Ant];
                                                }
                                                echo '
                                                <td class="td-ins">
                                                    ' . $valTexarea . '
                                                  
                                                </td>
                                                ';
                                              }elseif($columna2 == "incd_col3"){
                                                
                                                // echo '
                                                // <td class="td-ins" '.$union.'>
                                                //     ' . $valTexarea . '
                                                  
                                                // </td>
                                                // ';
                                                echo '
                                                <td class="td-ins" >
                                                    ' . $valTexarea . '
                                                  
                                                </td>
                                                ';
                                              }
                                            }
                                          }
                                        }
                                          
                                        
                                        echo "</tr>";
                                        $contadorDatos++;
                                      }
                                      ?>
                                    </tbody>
                                  </table>
                                </div>
                                    </div>
                              <?php 
                              }
                              echo "</div>";
                            } 
                            ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-6">
                        </div>
                  <?php $contCar2++; } ?>
            <?php
            $contLn++; } 
}

function pdfPortaMovil($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            $nom_archivo = $ca[2];
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    // echo ("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = ". $cam_id. " $condicional_incentivos");
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = 1  AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVOS
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0].' ');
                                $cont = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 0){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";
                                        }
                                        echo "<td class='td-ins'> $ ". number_format($detInc["incd_col5"], 0,  ",", ".") ." </td>";
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                    if($dis[$columna] == "ACTIVAS1"){
                                        echo '
                                        <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                        </th>
                                        ';
                                    }elseif($dis[$columna] == "ACTIVAS2"){

                                    }else{
                                        echo '
                                        <th class="th-ins">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.' ">
                                                '. $detInc[$columna2] . '
                                                
                                            </td>
                                            ';
                                            }
                                        }
                                        }else{
                                        if (!empty($detInc[$columna2]) || $detInc[$columna2] == "0") {
                                            $contTbody++;
                                            if($columna2 == "incd_col4"){
                                            $anteriorVal = str_replace('A', '', $detInc[$columna2]); // Elimina todas las letras 'A'
                                            $anteriorVal = trim($anteriorVal); // Elimina los espacios en blanco alrededor del texto

                                            
                                            $valTexarea = "A ".$anteriorVal;
                                            if($contadorDatos == 0){
                                                $valTexarea = "> ".$detInc[$columna2Ant];
                                            }
                                            echo '
                                            <td class="td-ins">
                                                ' . $valTexarea . '
                                            </td>
                                            ';
                                            }else{
                                            echo '
                                            <td class="td-ins">
                                                ' . $detInc[$columna2] . '
                                                
                                            </td>
                                            ';
                                            }
                                        }elseif($detInc[$columna2] == 0){
                                            $contTbody++;
                                            if($columna2 == "incd_col4"){
                                            $anteriorVal = str_replace('A', '', $detInc[$columna2Ant]); // Elimina todas las letras 'A'
                                            $anteriorVal = trim($anteriorVal); // Elimina los espacios en blanco alrededor del texto

                                            $valTexarea = "A ".$anteriorVal;
                                            if($contadorDatos == 0){
                                                $valTexarea = " > ".$detInc[$columna2Ant];
                                            }
                                            echo '
                                            <td class="td-ins">
                                                ' . $valTexarea . '
                                                
                                            </td>
                                            ';
                                            }elseif($columna2 == "incd_col3"){
                                            
                                            echo '
                                            <td class="td-ins" >
                                                ' . $valTexarea . '
                                                
                                            </td>
                                            ';
                                            }
                                        }
                                        }
                                    }
                                        
                                    
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfMigraMovil($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                    </th>
                                    <th class="th-ins">
                                        AHORA
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 0){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                    if($dis[$columna] == "ACTIVAS1"){
                                        echo '
                                        <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                        </th>
                                        ';
                                    }elseif($dis[$columna] == "ACTIVAS2"){

                                    }else{
                                        echo '
                                        <th class="th-ins">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.' ">
                                                '. $detInc[$columna2] . '
                                                
                                            </td>
                                            ';
                                            }
                                        }
                                        }else{
                                        if (!empty($detInc[$columna2]) || $detInc[$columna2] == "0") {
                                            $contTbody++;
                                            if($columna2 == "incd_col4"){
                                            $anteriorVal = str_replace('A', '', $detInc[$columna2]); // Elimina todas las letras 'A'
                                            $anteriorVal = trim($anteriorVal); // Elimina los espacios en blanco alrededor del texto

                                            
                                            $valTexarea = "A ".$anteriorVal;
                                            if($contadorDatos == 0){
                                                $valTexarea = "> ".$detInc[$columna2Ant];
                                            }
                                            echo '
                                            <td class="td-ins">
                                                ' . $valTexarea . '
                                            </td>
                                            ';
                                            }else{
                                            echo '
                                            <td class="td-ins">
                                                ' . $detInc[$columna2] . '
                                                
                                            </td>
                                            ';
                                            }
                                        }elseif($detInc[$columna2] == 0){
                                            $contTbody++;
                                            if($columna2 == "incd_col4"){
                                            $anteriorVal = str_replace('A', '', $detInc[$columna2Ant]); // Elimina todas las letras 'A'
                                            $anteriorVal = trim($anteriorVal); // Elimina los espacios en blanco alrededor del texto

                                            $valTexarea = "A ".$anteriorVal;
                                            if($contadorDatos == 0){
                                                $valTexarea = " > ".$detInc[$columna2Ant];
                                            }
                                            echo '
                                            <td class="td-ins">
                                                ' . $valTexarea . '
                                                
                                            </td>
                                            ';
                                            }elseif($columna2 == "incd_col3"){
                                            
                                            echo '
                                            <td class="td-ins" >
                                                ' . $valTexarea . '
                                                
                                            </td>
                                            ';
                                            }
                                        }
                                        }
                                    }
                                        
                                    
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfCaliPortaMovil($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 0){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                        echo '
                                        <th class="th-ins">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.' ">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfCaliMigraMovil($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                    </th>
                                    <th class="th-ins">
                                        AHORA
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 0){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                        echo '
                                        <th class="th-ins">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfCaliEliteMovil($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                    </th>
                                    <th class="th-ins">
                                        CONDICIONAL PORTAS
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 0){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'> ".$detInc["incd_col6"]." </td>";
                                        // echo "<td class='td-ins'> ".$detInc["incd_col5"]." </td>";
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfMovInboundMovil($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                    </th>
                                    <th class="th-ins">
                                        PORTA Y LN
                                    </th>
                                    <th class="th-ins">
                                        OTT
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                    <th class="th-ins">
                                        BONO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='$rowsFilas'> ".$detInc["incd_col6"]." </td>";
                                        }elseif($cont == $countFilas){
                                            echo "<td class='td-ins'> ".$detInc["incd_col6"]." </td>";
                                        }
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='$rowsFilas'> ".$detInc["incd_col7"]." </td>";
                                        }elseif($cont == $countFilas){
                                            echo "<td class='td-ins'> ".$detInc["incd_col7"]." </td>";
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";                                        
                                        if($cont < $countFilas){
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col8"]." </td>";
                                        }
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfAutoGeneracionMovil($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                    </th>
                                    <th class="th-ins">
                                        CON. PORTA Y LN
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='4'> ".$detInc["incd_col6"]." </td>";
                                        }elseif($cont > 4){
                                            echo "<td class='td-ins'> ".$detInc["incd_col6"]." </td>";
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfEcomMovWcbMovil($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                    </th>
                                    <th class="th-ins">
                                        CON. PORTA Y LN
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='3'> ".$detInc["incd_col6"]." </td>";
                                        }elseif($cont == 4){
                                            echo "<td class='td-ins' rowspan='3'> ".$detInc["incd_col6"]." </td>";
                                        }elseif($cont >= 7){
                                            echo "<td class='td-ins'> ".$detInc["incd_col6"]." </td>";
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfEcomMovMovil($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ACTIVAS
                                    </th>
                                    <th class="th-ins">
                                        PORTA Y LN
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='3'> ".$detInc["incd_col6"]." </td>";
                                        }elseif($cont == 4){
                                            echo "<td class='td-ins' rowspan='3'> ".$detInc["incd_col6"]." </td>";
                                        }elseif($cont > 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col6"]." </td>";
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfAutogeneracionHogar($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        PRINCIPALES
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfConverHogar($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        PRINCIPALES
                                    </th>
                                    <th class="th-ins">
                                        DENTRO DE BASE
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='7'> ".$detInc["incd_col6"]." </td>";
                                        }elseif($cont > 7){
                                            echo "<td class='td-ins'> ".$detInc["incd_col6"]." </td>";
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfConver2Hogar($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        PRINCIPALES
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfInboundHogar($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        PRINCIPALES
                                    </th>
                                    <th class="th-ins">
                                        COND. SRVADC
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                    <th class="th-ins">
                                        BONO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='6'> ".$detInc["incd_col6"]." </td>";
                                        }elseif($cont > 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col6"]." </td>";
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfWCBHogar($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        PRINCIPALES
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                    <th class="th-ins">
                                        BONO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                        if($cont < 7){
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";                                        
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col6"] ." </td>";                                        
                                        }
                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfEcomWSPHogar($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        PRINCIPALES
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                    <th class="th-ins">
                                        BONO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                        if($cont <= 6){
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";                                        
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col6"] ." </td>";                                        
                                        }
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfTiendaHogHogar($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        PRINCIPALES
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfDedicadasOutHogar($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ADICIONALES
                                    </th>
                                    <th class="th-ins">
                                        OTT
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='5'> ".$detInc["incd_col6"]." </td>";
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfDedicadasWCBHogar($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ADICIONALES
                                    </th>
                                    <th class="th-ins">
                                        OTT
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='6'> ".$detInc["incd_col6"]." </td>";
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfDedicadasWINHogar($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        ADICIONALES
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

//BASE DE TABLAS DE MOVIL Y TECNOLOGIAS JUNTAS
function pdfOutboundBtaTyT($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                        if($dis['inc_fila'] != "3"){
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "2" && $dis["inc_fila"] == "1" || $dis["inc_principal"] == "3"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3" ){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="14" class="th-ins">
                                    OUTBOUND BTA
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <th rowspan="2" class="th-ins" >PISO</th>
                                <th rowspan="2" class="th-ins" >TABLA</th>
                                <th rowspan="2" class="th-ins" >UNIDADES</th>
                                <th rowspan="1" class="th-ins" >CONDICIONAL</th>
                                <th colspan="5" class="th-ins" >CELULARES</th>
                                <th colspan="5" class="th-ins" >TECNOLOGIA</th>
                                </tr>
                                <tr>
                                    <th class="th-ins" >CLARO UP</th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna5']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna6']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna7']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna8']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna9']; ?></th>
                                    <th class="th-ins" >200.000 A 442.000</th>
                                    <th class="th-ins" >442.000 A 520.000</th>
                                    <th class="th-ins" >520.000 A 702.000</th>
                                    <th class="th-ins" >702.000 A 1.200.000</th>
                                    <th class="th-ins" >1.200.000 ></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $id_tecno = $dis[0]+1;
                                $detalle_incentivos = $db->query('SELECT a.*,  b.incd_col5 AS bincd_col5, b.incd_col6 AS bincd_col6, b.incd_col7 AS bincd_col7, b.incd_col8 AS bincd_col8, b.incd_col9 AS bincd_col9, b.incd_col10 AS bincd_col10, b.incd_col11 AS bincd_col11 FROM tb_incentivos_asesores_detalle a, tb_incentivos_asesores_detalle b WHERE  a.inc_id = '.$dis[0].' AND a.incd_col3 = b.incd_col3 AND b.inc_id = '.$id_tecno.' GROUP BY a.incd_col3  ORDER BY incd_col1 DESC');
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='5'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins'colspan='10'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";         
                                        }else{
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";    
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col9"], 0 , ",", ".")." </td>";          
                                        }
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='5'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins'colspan='10'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";         
                                        }else{
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";        
                                        }
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }elseif($dis["inc_principal"] != "2"){
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                        }
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfOutCaliTyT($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        TRAMITADAS
                                    </th>
                                    <th class="th-ins">
                                        MONTO
                                    </th>
                                    <th class="th-ins">
                                        CLARO UP
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'> ".$detInc["incd_col6"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='6'> ".$detInc["incd_col7"]." </td>";
                                        }elseif($cont > 6){
                                            echo "<td class='td-ins' rowspan='6'> ".$detInc["incd_col7"]." </td>";
                                        }
                                        
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfOutMedTyT($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins" colspan= "2">
                                        TRAMITADAS
                                    </th>
                                    <th class="th-ins">
                                        MONTO
                                    </th>
                                    <th class="th-ins">
                                        CLARO UP
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' colspan='2'> ".$detInc["incd_col4"]." </td>";
                                        }else{
                                            echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";                
                                        }
                                        echo "<td class='td-ins'> ".$detInc["incd_col6"]." </td>";
                                        if($cont == 1){
                                            echo "<td class='td-ins' rowspan='6'> ".$detInc["incd_col7"]." </td>";
                                        }elseif($cont > 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col7"]." </td>";
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfOtrosTyT($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                ?>
                <?php
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "1" || $dis["inc_principal"] == "2"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                    <th class="th-ins">
                                        PISO
                                    </th>
                                    <th class="th-ins">
                                        TABLA
                                    </th>
                                    <th class="th-ins">
                                        PRINCIPALES
                                    </th>
                                    <th class="th-ins">
                                        INCENTIVO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }else{
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfInboundTyT($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                        if($dis['inc_fila'] != "3"){
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "2" && $dis["inc_fila"] == "1" || $dis["inc_principal"] == "3"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3" ){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="14" class="th-ins">
                                    INBOUND
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <th rowspan="2" class="th-ins" >PISO</th>
                                <th rowspan="2" class="th-ins" >TABLA</th>
                                <th rowspan="2" class="th-ins" >UNIDADES</th>
                                <th rowspan="1" colspan="2" class="th-ins" >CONDICIONAL</th>
                                <th colspan="5" class="th-ins" >CELULARES</th>
                                <th colspan="3" class="th-ins" >TECNOLOGIA</th>
                                </tr>
                                <tr>
                                    <th class="th-ins" >CLARO UP</th>
                                    <th class="th-ins" >REFERIDOS TENDERETE</th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna6']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna7']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna8']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna9']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna10']; ?></th>
                                    <th class="th-ins" >99.000 A 499.999</th>
                                    <th class="th-ins" >500.000 A 999.999</th>
                                    <th class="th-ins" >1.000.000 ></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $id_tecno = $dis[0]+1;
                                $detalle_incentivos = $db->query('SELECT a.*,  b.incd_col5 AS bincd_col5, b.incd_col6 AS bincd_col6, b.incd_col7 AS bincd_col7, b.incd_col8 AS bincd_col8, b.incd_col9 AS bincd_col9, b.incd_col10 AS bincd_col10, b.incd_col11 AS bincd_col11 FROM tb_incentivos_asesores_detalle a, tb_incentivos_asesores_detalle b WHERE  a.inc_id = '.$dis[0].' AND a.incd_col3 = b.incd_col3 AND b.inc_id = '.$id_tecno.' GROUP BY a.incd_col3  ORDER BY incd_col1 DESC');
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins'> ".$detInc["incd_col5"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='5'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins' rowspan='5'> ".$detInc["incd_col5"]." </td>";   
                                            echo "<td class='td-ins'colspan='10'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";         
                                        }else{
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col10"], 0 , ",", ".")." </td>";    
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col8"], 0 , ",", ".")." </td>";     
                                        }
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='5'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins'colspan='10'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";         
                                        }else{
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";        
                                        }
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }elseif($dis["inc_principal"] != "2"){
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                        }
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfAutogeneracionTyT($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                        if($dis['inc_fila'] != "3"){
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "2" && $dis["inc_fila"] == "1" || $dis["inc_principal"] == "3"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3" ){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="15" class="th-ins">
                                    AUTOGENERACION T&T
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <th rowspan="2" class="th-ins" >PISO</th>
                                <th rowspan="2" class="th-ins" >TABLA</th>
                                <th rowspan="2" class="th-ins" >UNIDADES</th>
                                <th rowspan="1" colspan="2" class="th-ins" >CONDICIONAL</th>
                                <th colspan="5" class="th-ins" >CELULARES</th>
                                <th colspan="5" class="th-ins" >TECNOLOGIA</th>
                                </tr>
                                <tr>
                                    <th class="th-ins" >CLARO UP</th>
                                    <th class="th-ins" >REFERIDOS TENDERETE</th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna6']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna7']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna8']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna9']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna10']; ?></th>
                                    <th class="th-ins" >200.000 A 442.000</th>
                                    <th class="th-ins" >442.000 A 520.000</th>
                                    <th class="th-ins" >520.000 A 702.000</th>
                                    <th class="th-ins" >702.000 A 1.200.000</th>
                                    <th class="th-ins" >1.200.000 ></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $id_tecno = $dis[0]+1;
                                $detalle_incentivos = $db->query('SELECT a.*,  b.incd_col5 AS bincd_col5, b.incd_col6 AS bincd_col6, b.incd_col7 AS bincd_col7, b.incd_col8 AS bincd_col8, b.incd_col9 AS bincd_col9, b.incd_col10 AS bincd_col10, b.incd_col11 AS bincd_col11 FROM tb_incentivos_asesores_detalle a, tb_incentivos_asesores_detalle b WHERE  a.inc_id = '.$dis[0].' AND a.incd_col3 = b.incd_col3 AND b.inc_id = '.$id_tecno.' GROUP BY a.incd_col3  ORDER BY incd_col1 DESC');
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 5){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins'> ".$detInc["incd_col5"]." </td>";
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='4'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins' rowspan='4'> ".$detInc["incd_col5"]." </td>";    
                                            
                                        }
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";     
                                        echo "<td class='td-ins'>$ ".number_format($detInc["incd_col10"], 0 , ",", ".")." </td>";    
                                        echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col6"], 0 , ",", ".")." </td>";     
                                        echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col7"], 0 , ",", ".")." </td>";     
                                        echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col8"], 0 , ",", ".")." </td>";      
                                        echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col9"], 0 , ",", ".")." </td>";     
                                        echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col10"], 0 , ",", ".")." </td>";    
                                    
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='5'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";         
                                        }else{
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";        
                                        }
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }elseif($dis["inc_principal"] != "2"){
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                        }
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfEcomINyWCBTyT($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                        if($dis['inc_fila'] != "3"){
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "2" && $dis["inc_fila"] == "1" || $dis["inc_principal"] == "3"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3" ){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="14" class="th-ins">
                                    OUTBOUND BTA
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <th rowspan="2" class="th-ins" >PISO</th>
                                <th rowspan="2" class="th-ins" >TABLA</th>
                                <th rowspan="2" class="th-ins" >UNIDADES</th>
                                <th rowspan="1" class="th-ins" >CONDICIONAL</th>
                                <th colspan="5" class="th-ins" >CELULARES</th>
                                <th colspan="5" class="th-ins" >TECNOLOGIA</th>
                                </tr>
                                <tr>
                                    <th class="th-ins" >REFERIDOS TENDERETE</th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna5']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna6']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna7']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna8']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna9']; ?></th>
                                    <th class="th-ins" >99.000 A 499.999</th>
                                    <th class="th-ins" >500.000 A 999.999</th>
                                    <th class="th-ins" >1.000.000 ></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $id_tecno = $dis[0]+1;
                                $detalle_incentivos = $db->query('SELECT a.*,  b.incd_col5 AS bincd_col5, b.incd_col6 AS bincd_col6, b.incd_col7 AS bincd_col7, b.incd_col8 AS bincd_col8, b.incd_col9 AS bincd_col9, b.incd_col10 AS bincd_col10, b.incd_col11 AS bincd_col11 FROM tb_incentivos_asesores_detalle a, tb_incentivos_asesores_detalle b WHERE  a.inc_id = '.$dis[0].' AND a.incd_col3 = b.incd_col3 AND b.inc_id = '.$id_tecno.' GROUP BY a.incd_col3  ORDER BY incd_col1 DESC');
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 7){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='6'> ".$detInc["incd_col4"]." </td>";   
                                            // echo "<td class='td-ins'colspan='10'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";         
                                        }
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";    
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col7"], 0 , ",", ".")." </td>";     
                                        
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='5'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins'colspan='10'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";         
                                        }else{
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";        
                                        }
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }elseif($dis["inc_principal"] != "2"){
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                        }
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfEcomWhatsappTyT($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                        if($dis['inc_fila'] != "3"){
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "2" && $dis["inc_fila"] == "1" || $dis["inc_principal"] == "3"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3" ){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="14" class="th-ins">
                                    OUTBOUND BTA
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <th rowspan="2" class="th-ins" >PISO</th>
                                <th rowspan="2" class="th-ins" >TABLA</th>
                                <th rowspan="2" class="th-ins" >UNIDADES</th>
                                <th rowspan="1" class="th-ins" >CONDICIONAL</th>
                                <th colspan="5" class="th-ins" >CELULARES</th>
                                <th colspan="5" class="th-ins" >TECNOLOGIA</th>
                                </tr>
                                <tr>
                                    <th class="th-ins" >REFERIDOS TENDERETE</th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna5']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna6']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna7']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna8']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna9']; ?></th>
                                    <th class="th-ins" >99.000 A 499.999</th>
                                    <th class="th-ins" >500.000 A 999.999</th>
                                    <th class="th-ins" >1.000.000 ></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $id_tecno = $dis[0]+1;
                                $detalle_incentivos = $db->query('SELECT a.*,  b.incd_col5 AS bincd_col5, b.incd_col6 AS bincd_col6, b.incd_col7 AS bincd_col7, b.incd_col8 AS bincd_col8, b.incd_col9 AS bincd_col9, b.incd_col10 AS bincd_col10, b.incd_col11 AS bincd_col11 FROM tb_incentivos_asesores_detalle a, tb_incentivos_asesores_detalle b WHERE  a.inc_id = '.$dis[0].' AND a.incd_col3 = b.incd_col3 AND b.inc_id = '.$id_tecno.' GROUP BY a.incd_col3  ORDER BY incd_col1 DESC');
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 7){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='6'> ".$detInc["incd_col4"]." </td>";   
                                            // echo "<td class='td-ins'colspan='10'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";         
                                        }
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";    
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col7"], 0 , ",", ".")." </td>";     
                                        
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='5'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins'colspan='10'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";         
                                        }else{
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";        
                                        }
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }elseif($dis["inc_principal"] != "2"){
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                        }
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}

function pdfEcomCarritoTyT($db, $ln, $cam_id, $inc_id, $action, $mes_busqueda, $anio_busqueda){

    $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio WHERE lin_id = $ln");
    $contLn = 1;
    while ($ln = $db->fetch_array($lineas_negocio)) {
    if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
    ?>
        <?php
        $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."' AND cam_id = $cam_id");
        $contCar2 = 1;
        while ($ca = $db->fetch_array($cargos2)) {
            if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
        ?>
            <div class="row">
            <div class="col-12">
                <div class="card w-maxcontent">
                <div class="card-body">
                    <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                <?php
                for($iDiv = 1; $iDiv<=10; $iDiv++){
                    $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = $cam_id AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'");
                    echo "<div class='d-flex'>";
                    while($dis = $db->fetch_array($datos_incentivos_staff)) {
                        if($dis['inc_fila'] != "3"){
                ?>
                    <div class="p-relative m-lr-1">
                    <ul class="mt-2 mh-4r">
                        <?php
                        
                        if(!empty($dis["inc_campana"])){
                        echo '<li><strong>CAMPAÑA: </strong>'.$dis["inc_campana"].'</li>';
                        }
                        if(!empty($dis["inc_gerente"])){
                        echo '<li><strong>'.$dis["inc_cargo"].': </strong>'.$dis["inc_gerente"].'</li>';
                        }
                        if(!empty($dis["inc_operacion"])){
                        echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                        }
                        if(!empty($dis["inc_segmento"])){
                        echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                            
                        if(!empty($dis["inc_mes"])){
                            echo '<li><strong>MES: </strong>'.$dis["inc_mes"].'</li>';
                        }
                        }

                        ?>
                    </ul>
                    <div class="d-flex">

                        <?php
                        if($dis["inc_principal"] == "2" && $dis["inc_fila"] == "1" || $dis["inc_principal"] == "3"){
                        ?> 
                            <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3" ){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    // Comprobar si la columna tiene datos
                                    if (!empty($dis[$columna])) {
                                        $contCol++;
                                    }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="14" class="th-ins">
                                    OUTBOUND BTA
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <th rowspan="2" class="th-ins" >PISO</th>
                                <th rowspan="2" class="th-ins" >TABLA</th>
                                <th rowspan="2" class="th-ins" >UNIDADES</th>
                                <th rowspan="1" class="th-ins" >CONDICIONAL</th>
                                <th colspan="5" class="th-ins" >CELULARES</th>
                                <th colspan="5" class="th-ins" >TECNOLOGIA</th>
                                </tr>
                                <tr>
                                    <th class="th-ins" >REFERIDOS TENDERETE</th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna5']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna6']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna7']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna8']; ?></th>
                                    <th class="th-ins" ><?php echo $dis['inc_columna9']; ?></th>
                                    <th class="th-ins" >99.000 A 499.999</th>
                                    <th class="th-ins" >500.000 A 999.999</th>
                                    <th class="th-ins" >1.000.000 ></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $id_tecno = $dis[0]+1;
                                $detalle_incentivos = $db->query('SELECT a.*,  b.incd_col5 AS bincd_col5, b.incd_col6 AS bincd_col6, b.incd_col7 AS bincd_col7, b.incd_col8 AS bincd_col8, b.incd_col9 AS bincd_col9, b.incd_col10 AS bincd_col10, b.incd_col11 AS bincd_col11 FROM tb_incentivos_asesores_detalle a, tb_incentivos_asesores_detalle b WHERE  a.inc_id = '.$dis[0].' AND a.incd_col3 = b.incd_col3 AND b.inc_id = '.$id_tecno.' GROUP BY a.incd_col3  ORDER BY incd_col1 DESC');
                                $countFilas = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                $cont = 1;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 7){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='6'> ".$detInc["incd_col4"]." </td>";   
                                            // echo "<td class='td-ins'colspan='10'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";         
                                        }
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";    
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["bincd_col7"], 0 , ",", ".")." </td>";     
                                        
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    $rowsFilas = $countFilas -1;
                                    echo "<tr>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col1"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col2"]." </td>";
                                        echo "<td class='td-ins'> ".$detInc["incd_col3"]." </td>";
                                        
                                        if($cont == 6){
                                            echo "<td class='td-ins'> ".$detInc["incd_col4"]." </td>";   
                                        } 
                                        if( $cont == 1){
                                            echo "<td class='td-ins' rowspan='5'> ".$detInc["incd_col4"]." </td>";   
                                            echo "<td class='td-ins'colspan='10'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";         
                                        }else{
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col5"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col6"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col7"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col8"], 0 , ",", ".")." </td>";     
                                            echo "<td class='td-ins'>$ ".number_format($detInc["incd_col9"], 0 , ",", ".")." </td>";        
                                        }
                                                                        
                                        
                                    echo "</tr>";
                                    $cont++;
                                }
                                ?>
                            </tbody>
                            </table>
                        <?php
                        }elseif($dis["inc_principal"] != "2"){
                        ?>
                        <table border="1" class="mt-3 <?php if($dis["inc_tipo"] == "3"){ echo "tabla-condiciones"; }else{ echo "tabla-condiciones";  }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
                            <thead>
                                <tr>
                                <?php 
                                    $contCol = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna = "inc_columna" . $i;
                                    
                                        // Comprobar si la columna tiene datos
                                        if (!empty($dis[$columna])) {
                                            $contCol++;
                                        }
                                    }
                                ?>
                                <?php if(!empty($dis['inc_encabezado'])){ ?>
                                <th colspan="<?php echo $contCol; ?>" class="th-ins">
                                    <?php echo $dis['inc_encabezado']; ?>
                                </th>
                                <?php } ?>
                                </tr>
                                <tr>
                                <?php 
                                for ($i = 1; $i <= 20; $i++) {
                                    $columna = "inc_columna" . $i;
                                    
                                    if (!empty($dis[$columna])) {
                                        echo '
                                        <th class="th-ins ">
                                        ' . $dis[$columna] . '
                                        </th>
                                        ';
                                    }
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]);
                                    
                                if($dis["inc_tipo"] == "3"){ $tl =  "t-l"; }else{ $tl = ""; }
                                $contadorDatos = 0;
                                while($detInc = $db->fetch_array($detalle_incentivos)){
                                    echo "<tr>";
                                    $contTbody = 0;
                                    for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        $iA = $i-1;
                                        $columna2Ant = "incd_col" . $iA;
                                        // Comprobar si la columna tiene datos
                                        if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                                $columna2 = "incd_col" . $i;
                                                // Comprobar si la columna tiene datos

                                                if (!empty($detInc[$columna2])) {
                                                    $contTbody++;
                                                    echo '
                                                    <td class="td-ins '.$tl.'">
                                                        '. $detInc[$columna2] . ' 
                                                    </td>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $contadorDatos++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                    <?php 
                        }
                    }
                    echo "</div>";
                } 
                ?>
                </div>
                </div>
            </div>
            <div class="col-6">
            </div>
        <?php $contCar2++; } ?>
<?php
$contLn++; } 
}