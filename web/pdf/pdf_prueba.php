<?php
$ocultar_menu = True;
if(isset($ocultar_menu)){
    $ocultar_menu == False;
    $body_ocultar_menu = "";
}else{
    $body_ocultar_menu = "class='toggle-sidebar'";
}
if(!isset($_GET["mes_busqueda"])){
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

// Obtener el mes actual en español y en mayúsculas
$mes_busqueda = $meses[(int)date('n')];
$anio_busqueda = date('Y');
}else{
$mes_busqueda = $_GET["mes_busqueda"];
$anio_busqueda = $_GET["anio_busqueda"];
}
include('../navs/header.php');
?>

<style>

/* .th-ins {
    background-color: red;
    color: white;
    border: 1px solid black;
    padding: 5px;
}

.pd-ticket {
    padding-top: 23px !important;
    padding-bottom: 20px !important;
}
.tabla-condiciones {
    width: fit-content;
    max-width: 50rem;
} */
.td-ins {
    min-width: 5rem;
}
.w-maxcontent {
    width: 100%;
}
.header{
    display: none!important;
}
#main {
    margin-top: 0px;
}
.mh-4r {
    min-height: 7.5rem;
}
.card {
    overflow-x: visible;
    background-color: transparent;
    box-shadow: none;
}
.card-header:first-child {
    background-color: transparent;
}
</style>
<?php
    $ln = "1";
    $cam_id = "1";
    $inc_id = "1";
    $action = "Especifico";
    // switch($_GET["campania"]){
    //     case "1":
    //         $nom_archivo = "Movil_Portabilidad";
    //         pdfPortaMovil($db, $ln, 1, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    //     break;
    //     case "2":
    //         $nom_archivo = "Movil_Migracion";
    //         pdfMigraMovil($db, $ln, 2, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    //     break;
    //     case "3":   
    //         $nom_archivo = "Movil_Portabilidad_Cali";
    //         pdfCaliPortaMovil($db, $ln, 3, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    //     break;
    //     case "4":
    //         $nom_archivo = "Movil_Migracion_Cali";
    //         pdfCaliMigraMovil($db, $ln, 4, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    //     break;
    //     case "5":   
    //         $nom_archivo = "Movil_Porta_Migra_Cali_Group";
    //         pdfCaliEliteMovil($db, $ln, 5, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    //     break;
    //     case "6":
    //         $nom_archivo = "Movil_Inbound";
    //         pdfMovInboundMovil($db, $ln, 6, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    //     break;
    //     case "7":
    //         $nom_archivo = "Movil_Autogeneracion";
    //         pdfAutoGeneracionMovil($db, $ln, 7, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    //     break;
    //     case "8":
    //         $nom_archivo = "Ecommerce_Movil_WCB";
    //         pdfEcomMovWcbMovil($db, $ln, 8, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    //     break;
    //     case "9":
    //         $nom_archivo = "Ecommerce_Movil_WhatsApp";
    //         pdfEcomMovMovil($db, $ln, 9, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    //     break;
    //     case "10":
    //         $nom_archivo = "Ecommerce_Movil_Tienda Movil";
    //         pdfEcomMovMovil($db, $ln, 10, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    //     break;
    //     case "11":

    //     break;
    //     case "12":

    //     break;
    //     case "13":

    //     break;
    //     case "14":

    //     break;
    //     case "15":

    //     break;
    //     case "16":

    //     break;
    //     case "17":

    //     break;
    //     case "18":

    //     break;
    //     case "19":

    //     break;
    //     case "20":

    //     break;
    //     case "21":

    //     break;
    //     case "22":

    //     break;
    //     case "23":

    //     break;
    //     case "24":

    //     break;
    //     case "25":

    //     break;
    //     case "26":

    //     break;
    //     case "27":

    //     break;
    //     case "28":

    //     break;
    //     case "29":

    //     break;
    //     case "30":

    //     break;
    // }
    
    $nom_archivo = "prueba";

    // pdfAutogeneracionHogar($db, $ln, 11, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfConverHogar($db, $ln, 12, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfConver2Hogar($db, $ln, 13, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfInboundHogar($db, $ln, 14, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfWCBHogar($db, $ln, 15, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfEcomWSPHogar($db, $ln, 16, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfTiendaHogHogar($db, $ln, 17, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfDedicadasOutHogar($db, $ln, 18, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfDedicadasWCBHogar($db, $ln, 19, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfDedicadasWINHogar($db, $ln, 20, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfOutboundBtaTyT($db, $ln, 21, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfOutCaliTyT($db, $ln, 22, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfOutMedTyT($db, $ln, 23, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfInboundTyT($db, $ln, 24, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfAutogeneracionTyT($db, $ln, 25, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfEcomINyWCBTyT($db, $ln, 26, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfEcomWhatsappTyT($db, $ln, 27, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    pdfEcomCarritoTyT($db, $ln, 28, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    // pdfOtrosTyT($db, $ln, 29, $inc_id, $action, $mes_busqueda, $anio_busqueda);
    
?>
           
<?php
include('../navs/footer.php');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('body').classList.toggle('toggle-sidebar')
});
// document.addEventListener("DOMContentLoaded", function() {
//     html2canvas(document.body, {
//         scale: 1, // Aumenta la resolución
//         useCORS: true, // Permitir cargar imágenes externas
//         scrollY: 0, // Evitar capturar desplazamiento
//         y: window.scrollY // Capturar desde el principio de la página
//     }).then(canvas => {
//         const imgData = canvas.toDataURL("image/png");
//         const pdf = new jspdf.jsPDF("p", "mm", "a4");

//         const pageWidth = pdf.internal.pageSize.getWidth();
//         const pageHeight = pdf.internal.pageSize.getHeight();

//         const imgWidth = pageWidth;
//         const imgHeight = (canvas.height * pageWidth) / canvas.width;

//         // Si la imagen es más alta que una página A4, ajustamos la altura
//         if (imgHeight > pageHeight) {
//             // Escalar para que quepa en una sola página
//             const ratio = pageHeight / imgHeight;
//             const adjustedWidth = imgWidth * ratio;
//             const adjustedHeight = imgHeight * ratio;

//             pdf.addImage(imgData, "PNG", 0, 0, adjustedWidth, adjustedHeight);
//         } else {
//             pdf.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);
//         }

//         // Guardar el PDF
//         pdf.save("<?php echo $nom_archivo; ?>.pdf");
//         location.replace('../Incentivos/Asesores/asesores.php');
//     });
// });
</script>