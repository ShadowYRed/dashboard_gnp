<?php
require($_SERVER['DOCUMENT_ROOT'] . "/dashboardGNP/lib/funciones.php");
if(empty($ocultar_menu)){
  $ocultar_menu = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>GNP</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= $links; ?>assets/img/favicon.png" rel="icon">
  <link href="<?= $links; ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= $links; ?>assets/vendor/DataTables/datatables.min.css" rel="stylesheet">
  <link href="<?= $links; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= $links; ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= $links; ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= $links; ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?= $links; ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?= $links; ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= $links; ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= $links; ?>assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body <?php echo $body_ocultar_menu; ?> >

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="<?= $links; ?>index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">GNP Dashboard</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <!-- <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form> -->
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
   <?php 
   if($ocultar_menu == True){}else{ 
    ?>
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="<?= $links; ?>index.php">
          <i class="bi bi-grid"></i>
          <span>Inicio</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-heading">Reportes</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#incentivos-nav" data-bs-toggle="collapse" href="<?= $links; ?>#">
          <i class="bi bi-menu-button-wide"></i><span>Incentivos</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="incentivos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= $links; ?>web/Incentivos/Asesores/asesores.php">
              <i class="bi bi-circle"></i><span>Asesores</span>
            </a>
          </li>
          <li>
            <a href="<?= $links; ?>web/Incentivos/Staff/staff.php">
              <i class="bi bi-circle"></i><span>Staff</span>
            </a>
          </li>
        </ul>
      </li><!-- End incentivos Nav -->

      <li class="nav-heading">Gestiones</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?= $links; ?>web/usuarios/usuarios.php">
          <i class="bi bi-people-fill"></i>
          <span>Usuarios</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?= $links; ?>web/roles/roles.php">
          <i class="bi bi-bookmark"></i>
          <span>Roles</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class="nav-heading">Generalidades</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?= $links; ?>pages-login.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->
<?php } ?>
  <main id="main" class="main">