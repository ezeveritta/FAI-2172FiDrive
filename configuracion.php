<?php

# Horario Argentina
date_default_timezone_set('America/Argentina/Buenos_Aires');
$GLOBALS['ROOT'] =$_SERVER['DOCUMENT_ROOT'] ."/FAI-2172FiDrive/";

# Incluyo funciones de uso común
include_once("utiles/funciones.php");
include_once('app/controladores/SessionControl.php');

# Configuraciónes varias
$CONFIG = [
    "titulo"        => "FiDrive FAI-2172",
    "cabecera"      => true,
    "menu"          => true,
    "pie"           => true,
    "validator"     => [false, ""],
    "extensiones"   => [
        "summernote" => false,
        "md5"        => false
    ]
];

?>