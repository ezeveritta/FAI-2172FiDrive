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

class CompartirArchivoControl
{
    /**
     * Esta función
     * @param array $datos Contiene todos los datos provenientes del formulario
     * 
     * @return boolean
     */
    public function verificar($datos)
    {
        $operacion = false;

        // Verificamos los datos
        if ($datos["nombre"] != null)
            $operacion = true;

        // ..

        return $operacion;
    }
}