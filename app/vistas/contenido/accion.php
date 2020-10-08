<?php 
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 30/09/2020
 */

include_once("../../../configuracion.php");
include_once("../../controladores/ContenidoControl.php");

$Control = new ContenidoControl();

$datos = data_submitted();

// Creo la carpeta
$op = $Control->crearCarpeta($datos);

// Redirecciono a contenido
header("Location: index.php");
die();