<?php
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 07/10/2020
 */

class ContenidoControl
{
    /**
     * Esta función crea una carpeta en la ruta pasada por parametro y el nombre.
     * @param array $datos Contiene todos los datos provenientes del formulario
     * 
     * @return boolean
     */
    public static function crearCarpeta($datos)
    {
        $operacion = false;
        $nombre = $datos["nombre"];
        $ruta = '../../../' . $datos["ruta"] . '/' . $nombre;

        // Verificamos los datos
        if ($nombre != null)
        {
            // Creamos la carpeta
            $evento = mkdir($ruta, 0777);
            $operacion = true;
        }

        return $operacion;
    }

    /**
     * Esta función obtiene todas las carpetas y archivos de una carpeta
     * @param array $datos Contiene la información de la carpeta actual
     * 
     * @return boolean
     */
    public static function abrirDirectorio($ruta)
    {
        $respuesta = false;
        $ruta = '../../../' . $ruta . '/';

        $direccion = opendir($ruta);
        $archivos = array();
        $carpetas = array();

        // Obtener listado de carpetas y archivos
        while (($temp = readdir($direccion)) !== false)
        {
            if ($temp !== "." && $temp !== ".." && !is_dir($ruta.'/'.$temp))
                array_push($archivos, $temp);
            if ($temp !== "." && $temp !== ".." && is_dir($ruta.'/'.$temp))
                array_push($carpetas, $temp);
        }

        // Verifico si la carpeta está vacía o tiene contenido
        if (count($archivos) > 0 || count($carpetas) > 0)
        {
            $respuesta = ["carpetas" => $carpetas, "archivos" => $archivos];
        } 

        return $respuesta;
    }
}