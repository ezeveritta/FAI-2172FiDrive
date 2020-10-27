<?php 

include_once("../../../configuracion.php");
include_once("../../controladores/AmarchivoControl.php");
include_once('../../modelos/BaseDatos.php');
include_once('../../modelos/ArchivoCargado.php');
include_once('../../modelos/ArchivoCargadoEstado.php');

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 30/09/2020
*/

$control = new AmarchivoControl();
$datos = data_submitted();

if (!isset($datos['accion']))
{
    header( "Location: ../amarchivo/index.php?error=No se especifica si es Alta o Modificación" );
    die;
}

// Realizamos Alta o Modificación según el valor del campo 'accion'
switch ($datos['accion'])
{
    case 'Alta':
        // Validamos
        if (!$control->validar($datos, $_FILES["archivo"]))
        {
            header( "Location: ../amarchivo/index.php?error={$control->get_error()}" );
            die;
        }
        // Cargamos la información y el archivo
        if (!$control->cargar($datos, $_FILES["archivo"]))
        {
            header( "Location: ../amarchivo/index.php?error={$control->get_error()}" );
            die;
        } 
        // Cambiamos a la página compartirarchivo
        header( "Location: ../compartirarchivo/index.php?id={$control->get_archivoCargado()->get_id()}" );
        die;
    break;

    case 'Modificar':
        // Validamos
        if (!$control->validar($datos))
        {
            header( "Location: ../amarchivo/index.php?error={$control->get_error()}" );
            die;
        }
        // Cargamos la información y el archivo
        if (!$control->modificar($datos))
        {
            header( "Location: ../amarchivo/index.php?error={$control->get_error()}" );
            die;
        } 
        // Cambiamos a la página contenido
        $ruta = dirname($control->get_archivoCargado()->get_linkAcceso());
        header( "Location: ../compartirarchivo/index.php?id={$control->get_archivoCargado()->get_id()}" );
        die;
    break;
}