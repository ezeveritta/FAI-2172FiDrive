<?php
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: /10/2020
 */

class AmarchivoControl
{
    private $error;

    /**
     * Esta valida que la información sea la esperada
     * @param file $archivo Contiene el archivo a copiar
     * @param string $datos Tiene todos los datos a subir a la bd
     * 
     * @return boolean
     */
    public function validar($datos, $archivo)
    {
        $operacion = false;

        // Validamos
        if ($datos["nombre"] != null)
            $operacion = true;
        
        // Funcion incompleta, se continua para la proxima entrega si la catedra lo requiere

        return $operacion;
    }

    /**
     * Esta función copia el archivo pasado por parametros en la ruta especificada
     * @param file $archivo Contiene el archivo a copiar
     * @param string $datos Tiene todos los datos a subir a la bd
     * 
     * @return boolean
     */
    public function cargar($datos, $archivo)
    {
        $operacion = false;

        // Cargamos info a la base de datos
            //..
        // Copiamos el archivo
        if ($this->subir($archivo, $datos))
            $operacion = true;

        return $operacion;
    }


    /**
     * Esta función copia el archivo pasado por parametros en la ruta especificada
     * @param file $archivo Contiene el archivo a copiar
     * @param string $direccion la ruta donde se quiere copiar el archivo
     * 
     * @return boolean
     */
    public function subir($archivo, $datos)
    {
        $operacion = false;

        // Intentamos copiar el archivo al servidor.
        if (!copy($archivo['tmp_name'], "../../../".$datos["ruta"].'/'.$datos["nombre"]))
        {
            $this->set_error("ERROR: no se pudo cargar el archivo");
        } else
        {
            $operacion = true;
        }

        return $operacion;
    }


    public function set_error ($data) { $this->error = $data; }
}