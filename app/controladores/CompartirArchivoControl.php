<?php
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: /10/2020
 */

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