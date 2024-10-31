<?php

//$import_archive = $_SERVER['DOCUMENT_ROOT'];
$links = "http://".$_SERVER['HTTP_HOST']."/dashboardGNP/";

/* Incluye el archivo de la conexion */
if(empty($action)){
    $action = false;
}
if(empty($_GET["action"])){
    $_GET["action"] = false;
}
//echo $_SERVER['DOCUMENT_ROOT']. "/dashboardGNP/lib/conex.php";
require_once($_SERVER['DOCUMENT_ROOT'] . "/dashboardGNP/lib/conex.php");
$db = new MySQL();
$NumeroVariables = count($_POST);
$NombreVariables = array_keys($_POST); // obtiene los nombres de las varibles
$ValoresVariables = array_values($_POST); // obtiene los valores de las varibles
for ($i = 0; $i < $NumeroVariables; $i++) { // crea las variables y les asigna el valor
  ${$NombreVariables[$i]} = $ValoresVariables[$i];
}

if(!empty($_SESSION["id_usuario"])){
    $iduser = $_SESSION["id_usuario"];
}
/* Ingluye los archivos de utilidades necesarias como el Enc, el buscar texto*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/dashboardGNP/lib/controllers/controller_general.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/dashboardGNP/lib/controllers/controller_incentivos.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/dashboardGNP/lib/controllers/controller_excel.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/dashboardGNP/lib/controllers/controller_pdf.php");