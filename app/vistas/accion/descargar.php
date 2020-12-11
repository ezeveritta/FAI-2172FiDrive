<?php
# Configuración de la página
include_once("../../../configuracion.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - descargar
///// File: /app/vistas/accion/descargar.php
///// Date: 27/11/2020 - 15:02
///// Description:
////////// Acción que redirecciona a la vista 'descargar' con el hash pasado por parámetro ó inicia
////////// descarga del archivo si está permitido
////////////////////////////////////////////////////////////////////////////////////////////////////

# Datos del formulario
$datos = data_submitted();

# Verifico los datos del formulario
if (isset($datos['hash']))
{
    header("Location: ../descargar.php?linkacceso={$datos['hash']}");
    die();
}