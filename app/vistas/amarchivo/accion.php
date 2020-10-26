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

// Datos del formulario
$datos = data_submitted();

$control = new AmarchivoControl();

// Realizamos Alta o Modificación según el valor del campo 'clave'
if (isset($datos['accion']))
{
    switch ($datos['accion'])
    {
        case 'Alta':
            if ($control->validar($datos))
            {
                // Si se carga, regresamos a la vista contenido
                if ($control->cargar($datos, $_FILES["archivo"]))
                {
                    header("Location: ../compartirarchivo/index.php?id=".$control->get_archivoCargadoEstado()->get_id());
                    die;
                } 
                // Si hay un error, vuelvo al formulario
                else
                {
                    header("Location: ../amarchivo/index.php?error=true");
                    die;
                }
            } else {
                //echo "<br><b>Error:</b> La validación fue incorrecta <br>" . print_r($datos);
            }
        break;

        case 'Modificar':
            if ($control->validar($datos))
            {
                // Si se carga, regresamos a la vista contenido
                if ($control->modificar($datos))
                {
                    $ruta = dirname($control->get_archivoCargado()->get_linkAcceso());
                    header("Location: ../contenido/index.php?carpeta=".$ruta);
                    die;
                } 
                // Si hay un error, vuelvo al formulario
                else
                {
                    header("Location: ../amarchivo/index.php?error=true");
                    die;
                }
            } else {
                //echo "<br><b>Error:</b> La validación fue incorrecta <br>" . print_r($datos);
            }
        break;
    }
}
