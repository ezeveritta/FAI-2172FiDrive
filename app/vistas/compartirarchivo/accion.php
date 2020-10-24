<?php 
include_once("../../controladores/CompartirArchivoControl.php");
include_once('../../modelos/BaseDatos.php');
include_once('../../modelos/ArchivoCargado.php');
include_once('../../modelos/ArchivoCargadoEstado.php');
include_once("../../../configuracion.php");

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 30/09/2020
 */

// datos: usuario, vencimiento, limite, proteger, contraseña, enlace, id
$datos = data_submitted();

// Objeto Control
$control = new CompartirArchivoControl();

// Verificamos que los campos sean validos
if ($control->validar($datos))
{
    // Si se carga, regresamos a la vista contenido
    if ($control->cargar($datos))
    {
        header("Location: ../contenido/index.php?carpeta=".$control->get_ruta());
        die;
    } 
    // Si hay un error, vuelvo al formulario
    else
    {
        header("Location: ./compartirarchivo/index.php?error=true");
        die;
    }
} else { echo "nope <br><br>"; print_r($datos);}

?>