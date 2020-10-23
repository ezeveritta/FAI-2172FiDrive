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

// Verifico que acción se quiere realizaar
/////////// ABRIR DIRECTORIO
if (isset($datos["carpeta"]))
{
    // Cargo la página "contenido" y seteo la ruta a abrir
    $ruta = $datos["carpeta"];
    include_once("index.php");
} 
/////////// NUEVA CARPETA
else
{
    // Creo la carpeta
    $op = $Control->crearCarpeta($datos);

    // Redirecciono a contenido
    header("Location: accion.php?nuevaRuta=".$datos["ruta"]);
    die();
}
