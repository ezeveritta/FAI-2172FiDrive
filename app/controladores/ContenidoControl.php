<?php
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 07/10/2020
 */

class ContenidoControl
{
    private $error;

    public function __construct()
    {
        $this->error = '';
    }

    /**
     * Esta función crea una carpeta en la ruta pasada por parametro y el nombre.
     * @param array $datos Contiene todos los datos provenientes del formulario
     * 
     * @return boolean
     */
    public function crearCarpeta($datos)
    {
        // Validamos la información
        if (!isset($datos['nombre']) || !isset($datos['ruta']))
        {
            $this->set_error("No se especificó un nombre.");
            return false;
        }

        // Validamos el nombre de la carpeta
        if (strpbrk($datos['nombre'], "\\/?%*:|\"<>"))
        {
            $this->set_error("Nombre contiene caracteres no admitidos.");
            return false;
        }

        // Definimos la ruta a crear
        $ruta = "../../../{$datos['ruta']}/{$datos['nombre']}";
        
        // Creamos la carpeta
        if (!mkdir($ruta, 0777))
        {
            $this->set_error("Error al crear carpeta.");
            return false;
        }
        
        // Operación exitosa
        $this->set_error('');
        return true;
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

    /**
     * Métodos de Acceso
     */
    public function get_error() { return $this->error; }
    public function set_error($data) { $this->error = $data; }
    public function __toString()
    {
        return "Objeto ContenidoControl:
                <br> Error: {$this->get_error()}";
    }
}