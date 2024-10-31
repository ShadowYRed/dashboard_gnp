<?php
include('../../navs/header.php');

$meses = [
  1 => 'ENERO', 
  2 => 'FEBRERO', 
  3 => 'MARZO', 
  4 => 'ABRIL', 
  5 => 'MAYO', 
  6 => 'JUNIO', 
  7 => 'JULIO', 
  8 => 'AGOSTO', 
  9 => 'SEPTIEMBRE', 
  10 => 'OCTUBRE', 
  11 => 'NOVIEMBRE', 
  12 => 'DICIEMBRE'
];

$anio_actual = date('Y');
if(!isset($_GET["mes_busqueda"])){
  
  // Obtener el mes actual en español y en mayúsculas
  $mes_busqueda = $meses[(int)date('n')];
  $anio_busqueda = date('Y');
}else{
  $mes_busqueda = $_GET["mes_busqueda"];
  $anio_busqueda = $_GET["anio_busqueda"];
}
// echo $mes_busqueda ." / ". $anio_busqueda;
?>

    <div class="pagetitle">
      <h1>Asesores</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
          <li class="breadcrumb-item active">Asesores</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    
      <div class="card">
        <div class="card-body mt-3">
          <div class="d-flex">
            <div class="mr-2 text-left">
            <h5>Campañas</h5>
            </div>
            <div class="text-right">
              <form class="d-flex" action="" method="get" id="form-filtrado">
                <select class="form-control w-fitcontent m-2" name="mes_busqueda" id="mes_busqueda">
                    <option <?php echo ($mes_busqueda == 'ENERO') ? 'selected' : ''; ?>>ENERO</option>
                    <option <?php echo ($mes_busqueda == 'FEBRERO') ? 'selected' : ''; ?>>FEBRERO</option>
                    <option <?php echo ($mes_busqueda == 'MARZO') ? 'selected' : ''; ?>>MARZO</option>
                    <option <?php echo ($mes_busqueda == 'ABRIL') ? 'selected' : ''; ?>>ABRIL</option>
                    <option <?php echo ($mes_busqueda == 'MAYO') ? 'selected' : ''; ?>>MAYO</option>
                    <option <?php echo ($mes_busqueda == 'JUNIO') ? 'selected' : ''; ?>>JUNIO</option>
                    <option <?php echo ($mes_busqueda == 'JULIO') ? 'selected' : ''; ?>>JULIO</option>
                    <option <?php echo ($mes_busqueda == 'AGOSTO') ? 'selected' : ''; ?>>AGOSTO</option>
                    <option <?php echo ($mes_busqueda == 'SEPTIEMBRE') ? 'selected' : ''; ?>>SEPTIEMBRE</option>
                    <option <?php echo ($mes_busqueda == 'OCTUBRE') ? 'selected' : ''; ?>>OCTUBRE</option>
                    <option <?php echo ($mes_busqueda == 'NOVIEMBRE') ? 'selected' : ''; ?>>NOVIEMBRE</option>
                    <option <?php echo ($mes_busqueda == 'DICIEMBRE') ? 'selected' : ''; ?>>DICIEMBRE</option>
                </select>

                <select class="form-control w-fitcontent m-2" name="anio_busqueda" id="anio_busqueda">
                    <option <?php echo ($anio_busqueda == '2024') ? 'selected' : ''; ?>>2024</option>
                    <option <?php echo ($anio_busqueda == '2025') ? 'selected' : ''; ?>>2025</option>
                    <option <?php echo ($anio_busqueda == '2026') ? 'selected' : ''; ?>>2026</option>
                    <option <?php echo ($anio_busqueda == '2027') ? 'selected' : ''; ?>>2027</option>
                    <option <?php echo ($anio_busqueda == '2028') ? 'selected' : ''; ?>>2028</option>
                    <option <?php echo ($anio_busqueda == '2029') ? 'selected' : ''; ?>>2029</option>
                    <option <?php echo ($anio_busqueda == '2030') ? 'selected' : ''; ?>>2030</option>
                    <option <?php echo ($anio_busqueda == '2031') ? 'selected' : ''; ?>>2031</option>
                    <option <?php echo ($anio_busqueda == '2032') ? 'selected' : ''; ?>>2032</option>
                    <option <?php echo ($anio_busqueda == '2033') ? 'selected' : ''; ?>>2033</option>
                    <option <?php echo ($anio_busqueda == '2034') ? 'selected' : ''; ?>>2034</option>
                    <option <?php echo ($anio_busqueda == '2035') ? 'selected' : ''; ?>>2035</option>
                </select>

                <button type="submit" id="form-filtrado-btn" class="m-2 btn btn-success"> 
                    <i class="bi bi-search"></i> 
                </button>
              </form>
            </div>
            <div>
              <form class="d-flex" action="" method="get" id="generado-pdf">
                <select class="form-control w-fitcontent m-2" name="reporte" id="reporte">
                <option value="all">Guardar todos los reportes</option>
                <option value="movil">Guardar todo Movil</option>
                <option value="hogar">Guardar todo Hogar</option>
                <option value="tyt">Guardar todo T&T</option>
                  <?php 
                  $camapanias = $db->query("SELECT*FROM tb_campania");
                  while($camps = $db->fetch_array($camapanias)){
                    echo "<option value='".$camps[0]."'>".$camps[2]."</option>";
                  }
                  ?>
                </select>

                <button type="submit" id="generado-pdf-btn" class="m-2 btn btn-danger"> 
                    <i class="bi bi-file-earmark-bar-graph-fill"></i> 
                </button>
              </form>
            </div>
            <div>
              <form class="d-flex" action="" method="get" id="generado-pdf">

                <select class="form-control w-fitcontent m-2" name="mes_nuevo" id="mes_nuevo">
                      <option <?php echo ($mes_busqueda == 'ENERO') ? 'selected' : ''; ?>>ENERO</option>
                      <option <?php echo ($mes_busqueda == 'FEBRERO') ? 'selected' : ''; ?>>FEBRERO</option>
                      <option <?php echo ($mes_busqueda == 'MARZO') ? 'selected' : ''; ?>>MARZO</option>
                      <option <?php echo ($mes_busqueda == 'ABRIL') ? 'selected' : ''; ?>>ABRIL</option>
                      <option <?php echo ($mes_busqueda == 'MAYO') ? 'selected' : ''; ?>>MAYO</option>
                      <option <?php echo ($mes_busqueda == 'JUNIO') ? 'selected' : ''; ?>>JUNIO</option>
                      <option <?php echo ($mes_busqueda == 'JULIO') ? 'selected' : ''; ?>>JULIO</option>
                      <option <?php echo ($mes_busqueda == 'AGOSTO') ? 'selected' : ''; ?>>AGOSTO</option>
                      <option <?php echo ($mes_busqueda == 'SEPTIEMBRE') ? 'selected' : ''; ?>>SEPTIEMBRE</option>
                      <option <?php echo ($mes_busqueda == 'OCTUBRE') ? 'selected' : ''; ?>>OCTUBRE</option>
                      <option <?php echo ($mes_busqueda == 'NOVIEMBRE') ? 'selected' : ''; ?>>NOVIEMBRE</option>
                      <option <?php echo ($mes_busqueda == 'DICIEMBRE') ? 'selected' : ''; ?>>DICIEMBRE</option>
                  </select>

                  <select class="form-control w-fitcontent m-2" name="anio_nuevo" id="anio_nuevo">
                      <option <?php echo ($anio_busqueda == '2024') ? 'selected' : ''; ?>>2024</option>
                      <option <?php echo ($anio_busqueda == '2025') ? 'selected' : ''; ?>>2025</option>
                      <option <?php echo ($anio_busqueda == '2026') ? 'selected' : ''; ?>>2026</option>
                      <option <?php echo ($anio_busqueda == '2027') ? 'selected' : ''; ?>>2027</option>
                      <option <?php echo ($anio_busqueda == '2028') ? 'selected' : ''; ?>>2028</option>
                      <option <?php echo ($anio_busqueda == '2029') ? 'selected' : ''; ?>>2029</option>
                      <option <?php echo ($anio_busqueda == '2030') ? 'selected' : ''; ?>>2030</option>
                      <option <?php echo ($anio_busqueda == '2031') ? 'selected' : ''; ?>>2031</option>
                      <option <?php echo ($anio_busqueda == '2032') ? 'selected' : ''; ?>>2032</option>
                      <option <?php echo ($anio_busqueda == '2033') ? 'selected' : ''; ?>>2033</option>
                      <option <?php echo ($anio_busqueda == '2034') ? 'selected' : ''; ?>>2034</option>
                      <option <?php echo ($anio_busqueda == '2035') ? 'selected' : ''; ?>>2035</option>
                  </select>

                <input type="hidden" name="action" value="nuevoMes">
                <input type="hidden" name="mes_actual" value="<?php echo $mes_busqueda; ?>">
                <input type="hidden" name="anio_actual" value="<?php echo $anio_busqueda?>">
                <button type="submit" id="generado-pdf-btn" class="m-2 btn btn-warning" style="width: max-content;"> 
                    <i class="bi bi-file-earmark-bar-graph-fill">Duplicar Mes</i> 
                </button>
              </form>
            </div>
          </div>
          
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
            <?php
            $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio");
            $contline = 1;
            while ($ln = $db->fetch_array($lineas_negocio)) {
              if($contline == 1){ $show = "active"; }else{ $show = ""; }
            ?>
            <li class="nav-item" role="presentation">
              <button class="nav-link <?php echo $show; ?>" id="<?php echo $ln[2] ?>-tab" data-bs-toggle="tab" data-bs-target="#bordered-<?php echo $ln[2] ?>" type="button" role="tab" aria-controls="<?php echo $ln[2] ?>" aria-selected="true"><?php echo $ln[1] ?></button>
            </li>
            <?php $contline++; } ?>
          </ul>
          <div class="tab-content pt-2" id="borderedTabContent">
            <?php
              $lineas_negocio = $db->query("SELECT*FROM tb_linea_negocio");
              $contLn = 1;
              while ($ln = $db->fetch_array($lineas_negocio)) {
                if($contLn == 1){ $show = "active show"; }else{ $show = ""; }
              ?>
              <div class="tab-pane fade <?php echo $show; ?>" id="bordered-<?php echo $ln[2] ?>" role="tabpanel" aria-labelledby="<?php echo $ln[2] ?>-tab">
                <!--SEGMENTOS-->
                <div class="d-flex align-items-start">
                  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <?php
                      $cargos = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."'");
                      $contCar1 = 1;
                      while ($ca = $db->fetch_array($cargos)) {
                        if($contCar1 == 1){ $show = "active"; }else{ $show = ""; }
                    ?>
                    <button class="nav-link <?php echo $show; ?>" id="v-pills-<?php echo $ca[3]; ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?php echo $ca[3]; ?>" type="button" role="tab" aria-controls="v-pills-<?php echo $ca[3]; ?>" aria-selected="true"><?php echo $ca[2]; ?></button>
                    <?php $contCar1++; } ?>
                  </div>
                  <?php
                    $cargos2 = $db->query("SELECT*FROM tb_campania WHERE lin_id ='". $ln[0] ."'");
                    $contCar2 = 1;
                    while ($ca = $db->fetch_array($cargos2)) {
                      if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
                  ?>
                  <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade <?php echo $show; ?>" id="v-pills-<?php echo $ca[3]; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $ca[3]; ?>-tab">
                      <div class="row">
                        <div class="col-12">
                          <div class="card w-maxcontent">
                            <div class="card-body">
                              <div class="card-header">
                                <a href="../../pdf/pdf_prueba.php?campania=<?php echo $ca[0] ?>&mes_busqueda=<?php echo $mes_busqueda; ?>&anio_busqueda=<?php echo $anio_busqueda?>" id="generado-pdf-btn" class="m-2 btn btn-danger"> 
                                  <i class="bi bi-file-earmark-bar-graph-fill"></i> 
                                </a>
                                INCENTIVOS - OCTUBRE - 2024
                              </div>
                            <?php
                            for($iDiv = 1; $iDiv<=10; $iDiv++){
                              $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos_asesores WHERE inc_fila = $iDiv AND car_id = ". $ca[0] . " AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda' ");
                              echo "<div class='d-flex'>";
                              while($dis = $db->fetch_array($datos_incentivos_staff)) {
                            ?>
                            <?php
                            ?>
                              <form action="#" method="post" class="p-relative m-lr-1">
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
                                  if(!empty($dis["inc_ticket"])){
                                    echo '
                                    <li>
                                      <div class="d-flex" style="width: 20rem;">
                                        <strong style="width: -webkit-fill-available">Valor Ticket:</strong> <input type="text" class="form-control" name="inc_ticket" value="'.$dis['inc_ticket'].'"> 
                                      </div>
                                    </li>';
                                  }

                                  ?>
                                </ul>
                                <div class="d-flex">
                                  <?php 
                                  $contTicket = $db->HallaValorUnico('SELECT COUNT(incd_ticket) FROM tb_incentivos_asesores_detalle WHERE  inc_id = '. $dis[0]).'  AND inc_mes = "'.$mes_busqueda.'" AND inc_anio = "'.$anio_busqueda.'" '; 
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
                                                  <textarea disabled class="precio" id="">'. $detInc["incd_ticket"] . '</textarea>
                                                </td>
                                                ';
                                                echo '
                                                <td class="td-ins td-ticket">
                                                  <textarea disabled class="precio" id="">'. $detInc["incd_margen"] . '</textarea>
                                                </td>
                                                ';
                                                echo '
                                                <td class="td-ins td-ticket">
                                                  <textarea disabled class="precio" id="">'. $detInc["incd_vlrUd"] . '</textarea>
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
                                                  <textarea disabled class="precio" id="">'. $detInc["incd_ticket"] . '</textarea>
                                                </td>
                                                ';
                                                echo '
                                                <td class="td-ins td-ticket">
                                                  <textarea disabled class="precio" id="">'. $detInc["incd_margen"] . '</textarea>
                                                </td>
                                                ';
                                            echo "</tr>";
                                          }
                                        ?>
                                      </tbody>
                                    </table>
                                  </div>
                                  <?php } ?>
                                  <table border="1" class="mt-3 <?php if($dis["inc_tipo" == "3"]){ echo "tabla-condiciones"; }?> " id="facturacion-table-<?php echo $dis[0]; ?>">
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
                                          <input type="text" class="form-control th-header" name="columnHeader" value="<?php echo $dis['inc_encabezado']; ?>">
                                        </th>
                                        <?php } ?>
                                      </tr>
                                      <tr>
                                      <?php 
                                        for ($i = 1; $i <= 20; $i++) {
                                          $columna = "inc_columna" . $i;
                                          
                                          // Comprobar si la columna tiene datos
                                          if (!empty($dis[$columna])) {
                                            if($dis[$columna] == "ACTIVAS1" || $dis[$columna] == "PRINCIPALES1" || $dis[$columna] == "ADICIONALES1" || $dis[$columna] == "TRAMITADAS1" ){
                                              switch($dis[$columna]){
                                                case "ACTIVAS1": 
                                                  $colName = "ACTIVAS";
                                                break;
                                                case "PRINCIPALES1": 
                                                  $colName = "PRINCIPALES";
                                                break;
                                                case "ADICIONALES1": 
                                                  $colName = "ADICIONALES";
                                                break;
                                                case "TRAMITADAS1": 
                                                  $colName = "TRAMITADAS";
                                                break;
                                              }
                                              echo '
                                              <th class="th-ins" colspan= "2">
                                                <input type="text" class="form-control th-header" name="inc_columna[]" value="'.$colName.'">
                                              </th>
                                              ';
                                            }elseif($dis[$columna] == "ACTIVAS2" || $dis[$columna] == "PRINCIPALES2" || $dis[$columna] == "ADICIONALES2" || $dis[$columna] == "TRAMITADAS2"){

                                            }else{
                                              echo '
                                              <th class="th-ins">
                                                <input type="text" class="form-control th-header" name="inc_columna[]" value="' . $dis[$columna] . '">
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
                                              <textarea name="'.$columna2.'[]" class="precio" id=""></textarea>
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
                                          if($dis["inc_principal"] == "0"){
                                            for ($i = 1; $i <= 20; $i++) {
                                              $columna2 = "incd_col" . $i;
                                              // Comprobar si la columna tiene datos
      
                                              if (!empty($detInc[$columna2])) {
                                                $contTbody++;
                                                echo '
                                                <td class="td-ins">
                                                  <textarea name="'.$columna2.'[]" class="precio" id="">'. $detInc[$columna2] . '</textarea>
                                                  
                                                </td>
                                                ';
                                              }
                                            }
                                          }else{
                                            if (!empty($detInc[$columna2]) || $detInc[$columna2] == "0") {
                                              $contTbody++;
                                              if($columna2 == "incd_col4" && $dis["inc_principal"] != 2){
                                                
                                                $anteriorVal = str_replace('A', '', $detInc[$columna2]); // Elimina todas las letras 'A'
                                                $anteriorVal = trim($anteriorVal); // Elimina los espacios en blanco alrededor del texto

                                                
                                                // $valTexarea = "A ".$anteriorVal;
                                                if($contadorDatos == 0){
                                                  $valTexarea = "> ".$detInc[$columna2Ant];
                                                }else{
                                                  $id_anterior = $detInc[0]-1;
                                                  $valor_anterior = $db->HallaValorUnico("SELECT incd_col3 FROM tb_incentivos_asesores_detalle WHERE  inc_id = ".$dis[0]." AND incd_id = '$id_anterior'");
                                                  $anteriorVal = str_replace('A', '', $valor_anterior); // Elimina todas las letras 'A'
                                                  $anteriorVal2 = trim($anteriorVal); // Elimina los espacios en blanco alrededor del texto
                                                  $anteriorVal2 = intval($anteriorVal2);
                                                  // $anteriorVal3 = ($anteriorVal2 - 1);
                                                  $valTexarea = $dis["inc_principal"]." A ".($anteriorVal2-1);
                                                }
                                                echo '
                                                <td class="td-ins">
                                                    <textarea name="'.$columna2.'[]" class="precio" id="">' . $valTexarea . '</textarea>
                                                </td>
                                                ';
                                              }else{
                                                echo '
                                                <td class="td-ins">
                                                    <textarea name="'.$columna2.'[]" class="precio" id="" >' . $detInc[$columna2] . '</textarea>
                                                  
                                                </td>
                                                ';
                                              }
                                            }elseif($detInc[$columna2] == 0){
                                              $contTbody++;
                                              if($columna2 == "incd_col4" && $dis["inc_principal"] != 2){

                                                echo '
                                                <td class="td-ins">
                                                    <textarea name="incd_col4[]" class="precio" id="">' . $valTexarea . '</textarea>
                                                  
                                                </td>
                                                ';

                                              }elseif($columna2 == "incd_col3"){
                                                
                                                // echo '
                                                // <td class="td-ins" '.$union.'>
                                                //     <textarea name="incd_col3[]" class="precio" id="">' . $valTexarea . '</textarea>
                                                  
                                                // </td>
                                                // ';
                                                echo '
                                                <td class="td-ins" >
                                                    <textarea name="incd_col3[]" class="precio" id="">' . $valTexarea . '</textarea>
                                                  
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
                                  <button class="btn btn-success btn-add-column" id="add-column-<?php echo $dis[0]; ?>" type="button"><i class="bi bi-plus"></i></button>
                                  <button class="btn btn-success btn-del-column" id="del-column-<?php echo $dis[0]; ?>" type="button"><i class="bi bi-bookmark-dash"></i></button>
                                  <?php 
                                  if($dis["inc_principal"] != "1"){
                                  ?>
                                  <a href="?action=deleteInc&id=<?php echo $dis[0]; ?>&state=0" class="btn btn-warning btn-eliminar"><i class="bi bi-trash"></i></a>

                                  <?php } ?>
                                  <input type="hidden" name="inc_principal" value="<?php echo $dis["inc_principal"]; ?>">
                                  <input type="hidden" name="inc_id" value="<?php echo $dis[0]; ?>">
                                  <input type="hidden" name="action" value="updateIncentivosAsesores">
                                  <button class="btn btn-success btn-guardar" type="submit"><i class="bi bi-floppy"></i></button>
                                </div>
                              </form>
                              <script>
                                document.querySelector('#add-column-<?php echo $dis[0]; ?>').addEventListener('click', function (e) {
                                  e.preventDefault();

                                  // Seleccionar el cuerpo de la tabla
                                  const tableBody = document.querySelector('#facturacion-table-<?php echo $dis[0]; ?> tbody');

                                  // Seleccionar una de las filas existentes para clonarla
                                  const newRow = tableBody.rows[0].cloneNode(true);

                                  // Limpiar los valores de los inputs en la nueva fila
                                  const inputs = newRow.querySelectorAll('input');
                                  inputs.forEach(input => input.value = '');

                                  // Añadir la nueva fila al final del tbody
                                  tableBody.appendChild(newRow);
                                });
                                document.querySelector('#del-column-<?php echo $dis[0]; ?>').addEventListener('click', function (e) {
                                  e.preventDefault();

                                  const tableBody = document.querySelector('#facturacion-table-<?php echo $dis[0]; ?> tbody');
                                  const rowCount = tableBody.rows.length;

                                  // Asegurarse de que haya más de una fila antes de eliminar
                                  if (rowCount > 1) {
                                    tableBody.deleteRow(rowCount - 1); // Eliminar la última fila
                                  } else {
                                    alert('No puedes eliminar todas las filas.');
                                  }
                                });
                              </script>
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
                      </div>
                      <button type="button" class="btn btn-warning btn-add" data-bs-toggle="modal" data-bs-target="#scrollingModal<?php echo $ca[0]; ?>"><i class="bi bi-plus"></i>
                      </button>
                      <div class="modal modal-lg fade" id="scrollingModal<?php echo $ca[0]; ?>" tabindex="-1">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Agregar Tabla</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form action="" method="post">
                                <div class="row">
                                
                                    <div class="col-6">
                                        <label for="">MES</label>
                                        <select name="inc_mes" class="form-control" id="inc_mes<?php echo $ca[0]; ?>">
                                          <!-- Las opciones se generarán con JavaScript -->
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">AÑO</label>
                                        <input type="number" class="form-control" name="inc_anio" id="inc_anio" value="2024">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Tipo de Tabla</label>
                                        <select name="inc_tipo" class="form-control" id="inc_tipo">
                                          <option value="1">Normal</option>
                                          <option value="3">Condiciones</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Fila</label>
                                        <?php 
                                        $fila = $db->HallaValorUnico("SELECT inc_fila FROM tb_incentivos_asesores  WHERE car_id = ". $ca[0]  . " AND inc_mes = '$mes_busqueda ' AND inc_anio = '$anio_busqueda'  ORDER BY inc_fila DESC LIMIT 1"); 
                                        ?>
                                        <select name="fila" class="form-control">
                                          <?php
                                          $fill = "";
                                          for($fil = 1; $fill <= 10; $fill++){
                                            if($fill == $fila){
                                              $select = "selected";
                                            }else{
                                              $select = "";
                                            }
                                            echo '<option value="'.$fill.'" '.$select.'>'.$fill.'</option>';
                                          }
                                          ?>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Campaña</label>
                                        <input type="text" class="form-control" name="inc_campana">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Orden</label>
                                        <input type="number" class="form-control" name="orden" placeholder="Asignar orden de muestra de menor a mayor numericamente">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Segmento</label>
                                        <input type="text" class="form-control" name="segmento">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Cargo</label>
                                        <select name="inc_cargo" class="form-control" id="inc_cargo">
                                          <option value="JEFE">JEFE</option>
                                          <option value="GERENTE CUENTA">GERENTE CUENTA</option>
                                          <option value="JEFE CUENTA">JEFE CUENTA</option>
                                          <option value="JEFE OPERACIONES">JEFE OPERACIONES</option>
                                          <option value="COORDINADOR">COORDINADOR</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Encargado</label>
                                        <input type="text" name="gerente" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Operación</label>
                                        <input type="text" class="form-control" name="operacion">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Encabezado</label>
                                        <input type="text" class="form-control" name="encabezado">
                                    </div>

                                    <div class="row" id="columnas-container<?php echo $ca[0]; ?>">
                                        <div class="col-6">
                                            <label for="">Columna 1</label>
                                            <input type="text" class="form-control" name="inc_columna1">
                                        </div>
                                        <div class="col-6">
                                            <label for="">Columna 2</label>
                                            <input type="text" class="form-control" name="inc_columna2">
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-success mt-2" id="add-column-form-<?php echo $ca[3]; ?>">Agregar Columna</button>
                                    <button type="button" class="btn btn-danger mt-2" id="remove-column-form-<?php echo $ca[3]; ?>">Eliminar Última Columna</button>
                                </div>

                                <div class="mt-3">
                                    <input type="hidden" name="action" value="addTablaIncentivosAsesores">
                                    <input type="hidden" name="id_campania" value="<?php echo $ca[0]; ?>">
                                    <input type="hidden" name="id_segmento" value="1">
                                    <input type="hidden" name="anio" value="2024">
                                    <input type="hidden" name="mes" value="01">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                              </form>

                              <script>
                                  let columnCount<?php echo $ca[3]; ?> = 2; // Contador para las columnas
                                  const maxColumns<?php echo $ca[3]; ?> = 20; // Máximo de columnas permitidas

                                  // Botón para agregar columna
                                  document.getElementById('add-column-form-<?php echo $ca[3]; ?>').addEventListener('click', function() {
                                      if (columnCount<?php echo $ca[3]; ?> < maxColumns<?php echo $ca[3]; ?>) {
                                          columnCount<?php echo $ca[3]; ?>++;
                                          const newColumn = document.createElement('div');
                                          newColumn.classList.add('col-6'); // Añadir clase col-6 a cada nueva columna
                                          newColumn.innerHTML = `
                                              <label for="">Columna ${columnCount<?php echo $ca[3]; ?>}</label>
                                              <input type="text" class="form-control" name="inc_columna${columnCount<?php echo $ca[3]; ?>}">
                                          `;
                                          document.getElementById('columnas-container<?php echo $ca[0]; ?>').appendChild(newColumn);
                                      } else {
                                          alert('No se pueden agregar más de 20 columnas.');
                                      }
                                  });

                                  // Botón para eliminar la última columna
                                  document.getElementById('remove-column-form-<?php echo $ca[3]; ?>').addEventListener('click', function() {
                                      if (columnCount<?php echo $ca[3]; ?> > 2) {
                                          const container = document.getElementById('columnas-container<?php echo $ca[0]; ?>');
                                          container.removeChild(container.lastElementChild); // Eliminar última columna agregada
                                          columnCount<?php echo $ca[3]; ?>--;
                                      } else {
                                          alert('Debe haber al menos 2 columnas.');
                                      }
                                  });
                                  // Crear un array con los nombres de los meses
                                  const meses<?php echo $ca[0]; ?> = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
                                  
                                  // Obtener el mes actual (0 = Enero, 11 = Diciembre)
                                  const mesActual<?php echo $ca[0]; ?> = new Date().getMonth();
                                  
                                  // Obtener el elemento select
                                  const selectMeses<?php echo $ca[0]; ?> = document.getElementById('inc_mes<?php echo $ca[0]; ?>');
                                  
                                  // Generar las opciones del select
                                  meses<?php echo $ca[0]; ?>.forEach((mes, index) => {
                                    const option = document.createElement('option');
                                    option.value = mes;
                                    option.text = mes;
                                    // Seleccionar el mes actual
                                    if (index === mesActual<?php echo $ca[0]; ?>) {
                                      option.selected = true;
                                    }
                                    selectMeses<?php echo $ca[0]; ?>.appendChild(option);
                                  });
                              </script>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                      Nesciunt totam et. Consequuntur magnam aliquid eos nulla dolor iure eos quia. Accusantium distinctio omnis et atque fugiat. Itaque doloremque aliquid sint quasi quia distinctio similique. Voluptate nihil recusandae mollitia dolores. Ut laboriosam voluptatum dicta.
                    </div>
                  </div>
                  </div>
                  <?php $contCar2++; } ?>
                          
              </div>
              <div class="tab-pane fade" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">
                Nesciunt totam et. Consequuntur magnam aliquid eos nulla dolor iure eos quia. Accusantium distinctio omnis et atque fugiat. Itaque doloremque aliquid sint quasi quia distinctio similique. Voluptate nihil recusandae mollitia dolores. Ut laboriosam voluptatum dicta.
              </div>
              <div class="tab-pane fade" id="bordered-contact" role="tabpanel" aria-labelledby="contact-tab">
                Saepe animi et soluta ad odit soluta sunt. Nihil quos omnis animi debitis cumque. Accusantium quibusdam perspiciatis qui qui omnis magnam. Officiis accusamus impedit molestias nostrum veniam. Qui amet ipsum iure. Dignissimos fuga tempore dolor.
              </div>
              </div><!-- End Bordered Tabs -->
              
            <?php $contLn++; } ?>
          </div>
        </div>
      </div>

    </section>

<?php
include('../../navs/footer.php');
?>
<script>

$(document).ready(function () {
    $("form").on("submit", function (event) {
        event.preventDefault();  // Evitar el envío normal del formulario

        let formData = $(this).serialize();  // Serializar los datos del formulario

        $.ajax({
            url: "asesores.php",  // URL del archivo PHP que procesará el formulario
            method: "POST",
            data: formData,  // Datos serializados del formulario
            success: function (response) {
                // Acciones en caso de éxito
                document.querySelector('input[name="encabezado"]').value = '';
                document.querySelector('input[name="inc_columna1"]').value = '';
                document.querySelector('input[name="inc_columna2"]').value = '';
                alert("Formulario enviado correctamente.");

                console.log(response); // Puedes usar esto para depurar la respuesta
            },
            error: function (xhr, status, error) {
                // Acciones en caso de error
                alert("Hubo un error al enviar el formulario.");
                console.log(xhr.responseText);  // Depuración del error
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function() {
    // Escucha el evento de cambio de pestaña
    document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tab) {
        tab.addEventListener('shown.bs.tab', function(e) {
            var activeTab = e.target.getAttribute('href');
            localStorage.setItem('activeTab', activeTab); // Guarda la pestaña activa
        });
    });

    // Al cargar la página, revisa si hay una pestaña activa guardada
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        var tab = new bootstrap.Tab(document.querySelector('a[href="' + activeTab + '"]'));
        tab.show(); // Restaura la pestaña activa
    }
});

</script>
<script>
document.getElementById("form-filtrado").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío tradicional del formulario
    const mes = document.getElementById("mes_busqueda").value;
    const anio = document.getElementById("anio_busqueda").value;
    
    // Recargar la página con los parámetros seleccionados
    window.location.href = `?mes_busqueda=${encodeURIComponent(mes)}&anio_busqueda=${encodeURIComponent(anio)}`;
});
document.getElementById("generado-pdf").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío tradicional del formulario
    const reporte = document.getElementById("reporte").value;
    const anio = "<?php echo $anio_busqueda; ?>";
    const mes = "<?php echo $mes_busqueda; ?>";
    
    // Recargar la página con los parámetros seleccionados
    window.location.href = `../../pdf/pdf_prueba.php?campania=${encodeURIComponent(reporte)}&mes_busqueda=${encodeURIComponent(mes)}&anio_busqueda=${encodeURIComponent(anio)}`;
});
</script>