<?php

include_once("../../../configuracion.php");
include_once('../../modelos/BaseDatos.php');
include_once("../../modelos/EstadoTipos.php");
include_once('../../modelos/ArchivoCargado.php');
include_once('../../modelos/ArchivoCargadoEstado.php');
include_once("../../controladores/CompartirArchivoControl.php");

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 30/09/2020
 */

$control = new CompartirArchivoControl();
$datos = data_submitted();

// Verificamos que los campos sean validos
if (!$control->validar($datos))
{
    header( "Location: ../compartirarchivo.php?id={$datos['id']}&error={$control->get_error()}" );
    die;
}

// Si hay un error, vuelvo al formulario
if (!$control->cargar($datos))
{
    header( "Location: ../compartirarchivo.php?id={$datos['id']}&error={$control->get_error()}" );
    die;
} 

// Si se carga, regresamos a la vista contenido
header( "Location: ../compartidos.php?carpeta={$control->get_ruta()}&exito=Operación completada." );
die;