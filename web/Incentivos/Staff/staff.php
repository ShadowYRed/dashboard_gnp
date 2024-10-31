<?php
include('../../navs/header.php');
?>

    <div class="pagetitle">
      <h1>Staff</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
          <li class="breadcrumb-item active">Staff</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    
      <div class="card">
        <div class="card-body mt-3">
          <h5>Campañas</h5>
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
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false" tabindex="-1">Afinity</button>
            </li>
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
                      $cargos = $db->query("SELECT*FROM tb_cargos WHERE lin_id ='". $ln[0] ."'");
                      $contCar1 = 1;
                      while ($ca = $db->fetch_array($cargos)) {
                        if($contCar1 == 1){ $show = "active"; }else{ $show = ""; }
                    ?>
                    <button class="nav-link <?php echo $show; ?>" id="v-pills-<?php echo $ca[3]; ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?php echo $ca[3]; ?>" type="button" role="tab" aria-controls="v-pills-<?php echo $ca[3]; ?>" aria-selected="true"><?php echo $ca[2]; ?></button>
                    <?php $contCar1++; } ?>
                  </div>
                  <?php
                    $cargos2 = $db->query("SELECT*FROM tb_cargos WHERE lin_id ='". $ln[0] ."'");
                    $contCar2 = 1;
                    while ($ca = $db->fetch_array($cargos2)) {
                      if($contCar2 == 1){ $show = "active show"; }else{ $show = ""; }
                  ?>
                  <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade <?php echo $show; ?>" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                      <div class="row">
                        <div class="col-12">
                          <div class="card w-maxcontent">
                            <div class="card-body">
                              <div class="card-header">INCENTIVOS - OCTUBRE - 2024</div>
                            <?php
                            for($iDiv = 1; $iDiv<=10; $iDiv++){
                              $datos_incentivos_staff = $db->query("SELECT * FROM tb_incentivos WHERE inc_fila = $iDiv AND car_id = ". $ca[0]);
                              echo "<div class='d-flex'>";
                              while($dis = $db->fetch_array($datos_incentivos_staff)) {
                            ?>
                            <?php
                            ?>
                              <form action="#" method="post" class="p-relative m-lr-1">
                                <ul class="mt-2 mh-4r">
                                  <?php

                                  if(!empty($dis["inc_gerente"])){
                                    echo '<li><strong>GERENTE CUENTA: </strong>'.$dis["inc_gerente"].'</li>';
                                  }
                                  if(!empty($dis["inc_operacion"])){
                                    echo '<li><strong>OPERACIÓN: </strong>'.$dis["inc_operacion"].'</li>';
                                  }
                                  if(!empty($dis["inc_segmento"])){
                                    echo '<li><strong>SEGMENTO: </strong>'.$dis["inc_segmento"].'</li>';
                                  }

                                  ?>
                                </ul>
                                <table border="1" class="mt-3" id="facturacion-table-<?php echo $dis[0]; ?>">
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
                                            echo '
                                            <th class="th-ins">
                                              <input type="text" class="form-control th-header" name="inc_columna[]" value="' . $dis[$columna] . '">
                                            </th>
                                            ';
                                        }
                                      }
                                    ?>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php 
                                    $detalle_incentivos = $db->query('SELECT*FROM tb_incentivos_detalle WHERE  inc_id = '. $dis[0]);
                                    $ContDetalleIncentivo = $db->HallaValorUnico('SELECT COUNT(inc_id) FROM tb_incentivos_detalle WHERE  inc_id = '. $dis[0]);
                                    if(empty($ContDetalleIncentivo)){
                                      if($ContDetalleIncentivo == 0 || empty($ContDetalleIncentivo)) {
                                        for ($i = 1; $i <= $contCol; $i++) {
                                          $columna2 = "incd_col" . $i;
                                          // Comprobar si la columna tiene datos
  
                                          echo '
                                          <td class="td-ins">
                                            <input type="text" class="form-control precio" name="'.$columna2.'[]">
                                          </td>
                                          ';
                                        }
                                      }
                                    }
                                    while($detInc = $db->fetch_array($detalle_incentivos)){
                                      echo "<tr>";
                                      $contTbody = 0;
                                      for ($i = 1; $i <= 20; $i++) {
                                        $columna2 = "incd_col" . $i;
                                        // Comprobar si la columna tiene datos

                                        if (!empty($detInc[$columna2])) {
                                          $contTbody++;
                                          echo '
                                          <td class="td-ins">
                                            <input type="text" class="form-control precio" name="'.$columna2.'[]" value="' . $detInc[$columna2] . '">
                                          </td>
                                          ';
                                        }
                                      }
                                      
                                      echo "<script>console.log('$contCol')</script>";
                                        
                                      
                                      echo "</tr>";
                                    }
                                    ?>
                                  </tbody>
                                </table>
                                <button class="btn btn-success btn-add-column" id="add-column-<?php echo $dis[0]; ?>" type="button"><i class="bi bi-plus"></i></button>
                                <button class="btn btn-success btn-del-column" id="del-column-<?php echo $dis[0]; ?>" type="button"><i class="bi bi-bookmark-dash"></i></button>
                                <a href="?action=deleteInc&id=<?php echo $dis[0]; ?>&state=0" class="btn btn-warning btn-eliminar"><i class="bi bi-trash"></i></a>

                                <input type="hidden" name="inc_id" value="<?php echo $dis[0]; ?>">
                                <input type="hidden" name="action" value="updateIncentivos">
                                <button class="btn btn-success btn-guardar" type="submit"><i class="bi bi-floppy"></i></button>
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
                      <button type="button" class="btn btn-warning btn-add" data-bs-toggle="modal" data-bs-target="#scrollingModal"><i class="bi bi-plus"></i>
                      </button>
                      <div class="modal modal-lg fade" id="scrollingModal" tabindex="-1">
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
                                      <label for="">Fila</label>
                                      <?php 
                                      $fila = $db->HallaValorUnico("SELECT inc_fila FROM tb_incentivos  WHERE car_id = ". $ca[0] ." ORDER BY inc_fila DESC LIMIT 1"); 
                                      ?>
                                      <select name="fila" class="form-control" id="fila">
                                        <?php
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

                                  <div class="row" id="columnas-container">
                                      <div class="col-6">
                                          <label for="">Columna 1</label>
                                          <input type="text" class="form-control" name="inc_columna1">
                                      </div>
                                      <div class="col-6">
                                          <label for="">Columna 2</label>
                                          <input type="text" class="form-control" name="inc_columna2">
                                      </div>
                                  </div>

                                  <button type="button" class="btn btn-success mt-2" id="add-column">Agregar Columna</button>
                                  <button type="button" class="btn btn-danger mt-2" id="remove-column">Eliminar Última Columna</button>
                              </div>

                              <div class="mt-3">
                                  <input type="hidden" name="action" value="addTablaIncentivos">
                                  <input type="hidden" name="id_campania" value="1">
                                  <input type="hidden" name="id_segmento" value="1">
                                  <input type="hidden" name="anio" value="2024">
                                  <input type="hidden" name="mes" value="01">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                  <button type="submit" class="btn btn-primary">Guardar</button>
                              </div>
                          </form>

                          <script>
                              let columnCount = 2; // Contador para las columnas
                              const maxColumns = 20; // Máximo de columnas permitidas

                              // Botón para agregar columna
                              document.getElementById('add-column').addEventListener('click', function() {
                                  if (columnCount < maxColumns) {
                                      columnCount++;
                                      const newColumn = document.createElement('div');
                                      newColumn.classList.add('col-6'); // Añadir clase col-6 a cada nueva columna
                                      newColumn.innerHTML = `
                                          <label for="">Columna ${columnCount}</label>
                                          <input type="text" class="form-control" name="inc_columna${columnCount}">
                                      `;
                                      document.getElementById('columnas-container').appendChild(newColumn);
                                  } else {
                                      alert('No se pueden agregar más de 20 columnas.');
                                  }
                              });

                              // Botón para eliminar la última columna
                              document.getElementById('remove-column').addEventListener('click', function() {
                                  if (columnCount > 2) {
                                      const container = document.getElementById('columnas-container');
                                      container.removeChild(container.lastElementChild); // Eliminar última columna agregada
                                      columnCount--;
                                  } else {
                                      alert('Debe haber al menos 2 columnas.');
                                  }
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