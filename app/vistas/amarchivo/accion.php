<?php 
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 30/09/2020
 */

include_once("../../modelos/Basedatos.php");
include_once("../../modelos/ArchivoCargado.php");
include_once("../../controladores/AmarchivoControl.php");
include_once("../../../configuracion.php");

$Control = new AmarchivoControl();
$datos = data_submitted();

// Verificamos que los campos sean validos
if ($Control->validar($datos, $_FILES["archivo"]))
{
    // Si se carga, regresamos a la vista contenido
    if ($Control->cargar($datos, $_FILES["archivo"]))
    {
        header("Location: ../compartirarchivo/index.php?id=".$Control->get_archivoCargado()->get_id());
        die;
    } 
    // Si hay un error, vuelvo al formulario
    else
    {
        header("Location: ../amarchivo/index.php?error=true");
        die;
    }
}