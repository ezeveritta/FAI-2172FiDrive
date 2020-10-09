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