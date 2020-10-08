<?php
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 07/10/2020
 */

 //  amarchivo.php
 //  Nombre del Archivo no debe quedar vació.
 //  La descripción del Archivo, es contenido enriquecido, buscar un editor para cargarlo
 //  Agregar siempre la siguiente descripción por defecto:  Esta es una descripción genérica, si lo necesita la puede cambiar.
 //  El usuario debe ser Seleccionado
 //  El icono, debería ser sugerido teniendo en cuenta la extensión del archivo seleccionado. Todo esto usado JavaScript.
 //  Si el campo Clave, es igual a cero, al submitir el formulario, se debe enviar el parámetro accion = Alta, caso contrario debe enviar en el parámetro accion = Modificar

class ContenidoControl
{
    /**
     * Esta función
     * @param array $datos Contiene todos los datos provenientes del formulario
     * 
     * @return boolean
     */
    public function crearCarpeta($datos)
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
}