<?php
include('../navs/header.php');
?>

    <div class="pagetitle">
      <h1>Roles</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
          <li class="breadcrumb-item active">Roles</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Lista de Roles</h5>

              <!-- Default Table -->
              <table class="table" id="rolDataList">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Creado</th>
                    <th scope="col">Actualizado</th>
                    <th scope="col">Herramientas</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>

        </div>
      </div>
    </section>
<?php
include('../navs/footer.php');
?>
<script>
$(document).ready(function(){
    $('#rolDataList').DataTable({
        "lengthChange": true,
		  "search": true,
		  "searching": true,
		  "bLengthChange" : true,
		  "order": [0, "asc"],
		  "bInfo" : false,
		  "language": {
		  "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
		  },
		  "drawCallback": function( settings ) {
			$('ul.pagination').addClass("pagination-sm");
		  },
          deferRender: true,
        "processing": true,
        "serverSide": true,
        "ajax": '../../lib/controllers/controller_datatables.php?action=roles',
    });
});
</script>