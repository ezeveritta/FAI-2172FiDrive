<?php 

include_once("../../../configuracion.php");
include_once('../../modelos/BaseDatos.php');
include_once("../../modelos/EstadoTipos.php");
include_once('../../modelos/ArchivoCargado.php');
include_once('../../modelos/ArchivoCargadoEstado.php');
include_once("../../controladores/AmarchivoControl.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - amarchivo
///// File: /app/vistas/accion/amarchivo.php
///// Date: 30/09/2020
///// Description:
////////// Acción para la vista 'amarchivo'
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////


$control = new AmarchivoControl();
$datos = data_submitted();


if (!isset($datos['accion']))
{
    header( "Location: ../amarchivo.php?error=No se especifica si es Alta o Modificación" );
    die;
}

// Realizamos Alta o Modificación según el valor del campo 'accion'
switch ($datos['accion'])
{
    case 'Alta':

        // Validamos
        if (!$control->validar($datos, $_FILES["archivo"]))
        {
            header( "Location: ../amarchivo.php?clave=0&error={$control->get_error()}" );
            die;
        }
        // Cargamos la información y el archivo
        if (!$control->cargar($datos, $_FILES["archivo"]))
        {
            header( "Location: ../amarchivo.php?clave=0&error={$control->get_error()}" );
            die;
        } 
        // Cambiamos a la página compartirarchivo
        header( "Location: ../compartirarchivo.php?id={$control->get_archivoCargado()->get_id()}" );
        die;
    break;

    case 'Modificar':

        // Validamos
        if (!$control->validar($datos, false)) {
            header( "Location: ../amarchivo.php?id={$datos['id']}&error={$control->get_error()}" );
            die;
        }
        
        // Cargamos la información y el archivo
        if (!$control->modificar($datos))
        {
            header( "Location: ../amarchivo.php?id={$datos['id']}&error={$control->get_error()}" );
            die;
        }

        // Cambiamos a la página contenido
        $ruta = dirname($control->get_archivoCargado()->get_linkAcceso());
        header( "Location: ../compartidos.php?carpeta={$ruta}&exito=Archivo cargado correctamente." );
        die;
    break;
}