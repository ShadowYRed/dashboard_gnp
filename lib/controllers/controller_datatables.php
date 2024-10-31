<?php
include("../conex.php");
$db = new MySQL();
header( 'Content-Type: application/json; charset=UTF-8' );
// Mostrar errores en PHP
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

$user = "admin";
$db = "dashboard_gnp";
$password = "Control2023*.";
$host = "172.20.100.33";
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See https://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - https://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
function utf8ize( $data ) {
    if ( is_array( $data ) ) {
        foreach ( $data as $key => $value ) {
            $data[ $key ] = utf8ize( $value );
        }
    } elseif ( is_string( $data ) ) {
        return mb_convert_encoding( $data, 'UTF-8', 'ASCII' );
    }
    return $data;
}

function detect_encoding( $data ) {
    if ( is_array( $data ) ) {
        foreach ( $data as $key => $value ) {
            detect_encoding( $value );
        }
    } elseif ( is_string( $data ) ) {
        echo "String: " . $data . " - Encoding: " . mb_detect_encoding( $data ) . "<br>";
    }
}
// SQL server connection information
$dbDetails = array(
    'user' => $user,
    'pass' => $password,
    'db' => $db,
    'host' => $host,
    'charset' => 'utf8mb4' // Depending on your PHP and MySQL config, you may need this
);

if ( $_GET[ "action" ] == "usuarios" ) {

    // DB table to use 
    $table = 'usuarios a';

    // Table's primary key 
    $primaryKey = 'a.id_usuario ';

    // Array of database columns which should be read and sent back to DataTables. 
    // The `db` parameter represents the column name in the database.  
    // The `dt` parameter represents the DataTables column identifier. 
    $columns = array(
        array( 'db' => 'id_usuario', 'dt' => 0 ),
        array( 'db' => 'nombres', 'dt' => 1 ),
        array( 'db' => 'nombre_user', 'dt' => 2 ),
        array( 'db' => 'membresia', 'dt' => 3 ),
        array( 'db' => 'email', 'dt' => 4 ),
        array( 'db' => 'cedula', 'dt' => 10 ),
        array( 'db' => 'patrocinador_nombre', 'dt' => 5 ),
        array( 'db' => 'tipo_usuario', 'dt' => 6 ),
        array( 'db' => 'Estado', 'dt' => 7 ),
        array( 'db' => 'total_puntos', 'dt' => 8 ),
        array( 'db' => 'patrocinados_count', 'dt' => 9 ),
        array(
            'db' => 'id_usuario',
            'dt' => 11,
            'formatter' => function ( $d, $row ) {
                return '
                <a href="editar_usuario.php?action=edit&id='.$d.'" class="btn btn-primary"> <i class="bi bi-pencil-square"></i></a>
                <a href="editar_usuario.php?action=activar&id='.$d.'" class="btn btn-danger"> <i class="bi bi-trash"></i></a>
                ';
            }
        )
    );
    header( 'Content-Type: application/json; charset=UTF-8' );

    // Include SQL query processing class 
    require 'ssp.class.php';

    $var = SSP::simpleCliente( $_GET, $dbDetails, $table, $primaryKey, $columns );
    //echo var_dump($var);
    //echo "==";

    $data = utf8ize( $var );
    //detect_encoding($data);
    //var_dump($data);
    // Output data as json format 
    //echo "==";

    $json = json_encode( $data, JSON_UNESCAPED_UNICODE );

    // Verificar errores de JSON
    if ( $json === false ) {

        //    header('Content-Type: application/json; charset=UTF-8');
        echo 'Error en la codificación JSON: ' . json_last_error_msg();
    } else {
        // Establecer el encabezado Content-Type a JSON y UTF-8
        header( 'Content-Type: application/json; charset=UTF-8' );
        echo $json;
    }
}


if ( $_GET[ "action" ] == "roles" ) {

    // DB table to use 
    $table = 'tb_roles a';

    // Table's primary key 
    $primaryKey = 'a.rol_id ';

    // Array of database columns which should be read and sent back to DataTables. 
    // The `db` parameter represents the column name in the database.  
    // The `dt` parameter represents the DataTables column identifier. 
    $columns = array(
        array( 'db' => 'rol_id', 'dt' => 0 ),
        array( 'db' => 'rol_nombre', 'dt' => 1 ),
        array( 'db' => 'rol_created_at', 'dt' => 2 ),
        array( 'db' => 'rol_update_at', 'dt' => 3 ),
        array(
            'db' => 'rol_id',
            'dt' => 4,
            'formatter' => function ( $d, $row ) {
                return '
                <a href="editar_usuario.php?action=edit&id='.$d.'" class="btn btn-primary"> <i class="bi bi-pencil-square"></i></a>
                <a href="editar_usuario.php?action=activar&id='.$d.'" class="btn btn-danger"> <i class="bi bi-trash"></i></a>
                ';
            }
        )
    );
    header( 'Content-Type: application/json; charset=UTF-8' );

    // Include SQL query processing class 
    require 'ssp.class.php';

    $var = SSP::simpleRoles( $_GET, $dbDetails, $table, $primaryKey, $columns );
    //echo var_dump($var);
    //echo "==";

    $data = utf8ize( $var );
    //detect_encoding($data);
    //var_dump($data);
    // Output data as json format 
    //echo "==";

    $json = json_encode( $data, JSON_UNESCAPED_UNICODE );

    // Verificar errores de JSON
    if ( $json === false ) {

        //    header('Content-Type: application/json; charset=UTF-8');
        echo 'Error en la codificación JSON: ' . json_last_error_msg();
    } else {
        // Establecer el encabezado Content-Type a JSON y UTF-8
        header( 'Content-Type: application/json; charset=UTF-8' );
        echo $json;
    }
}