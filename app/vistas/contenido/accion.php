<?php

include_once("../../../configuracion.php");
include_once("../../controladores/ContenidoControl.php");

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 30/09/2020
 */

$control = new ContenidoControl();
$datos = data_submitted();

// Verifico
if (!isset($datos['accion'])) {
    header("Location: index.php?error=Ocurrió un error inesperado.");
    die();
}

// Aplico
switch ($datos['accion']) {
    case 'crearCarpeta':
        // Creo la carpeta
        if (!$control->crearCarpeta($datos)) {
            header("Location: index.php?error={$control->get_error()}.");
            die();
        }

        // Operación exitosa, retorno a la vista anterior
        header("Location: index.php?carpeta=" . $datos["ruta"]);
        die();

        break;

    case 'abrirCarpeta':
        // Redirecciono a la vista 'contenido' con la ruta nueva
        header("Location: index.php?carpeta=" . $datos["carpeta"]);
        die();
        break;
}
