<?php

    /*=============================================
        TODO: Zona Horaria
    =============================================*/

    date_default_timezone_set('America/Mexico_City');

    /*=============================================
        TODO: Mostrar errores
    =============================================*/

    ini_set('display_errors', 1);
    ini_set("log_errors", 1);
    ini_set("error_log",  "C:/xampp/htdocs/JR/PERSONAL_Marketplace_Admin/php_error_log");

    /*=============================================
        TODO: CORS
    =============================================*/

    /* TODO: Permitir el acceso de otro origen */

    /* header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('content-type: application/json; charset=utf-8'); */

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: POST, PUT');

    /*=============================================
        TODO: Requerimientos
    =============================================*/

    require_once "controllers/template.controller.php";
    require_once "controllers/curl.controller.php";

    $index = new TemplateController();
    $index -> index();

?>
