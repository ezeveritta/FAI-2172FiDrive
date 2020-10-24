<?php
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: /10/2020
 */

class AmarchivoControl
{
    private $error;
    private $archivoCargado;
    private $archivoCargadoEstado;

    public function __construct()
    {
        $this->ArchivoCargado = new ArchivoCargado();
    }

    /**
     * Esta valida que la información sea la esperada
     * @param file $archivo Contiene el archivo a copiar
     * @param string $datos Tiene todos los datos a subir a la bd
     * 
     * @return boolean
     */
    public function validar($datos, $archivo)
    {
        $operacion = true;

        // Validamos
        $operacion = (isset($datos["nombre"]) && isset($datos["usuario"]) && isset($datos["descripcion"]) && isset($datos["icono"]))
                    ? true : false;
        
        // Funcion incompleta, se continua para la proxima entrega si la catedra lo requiere
        echo $operacion;
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
        $ArchivoCargado = new ArchivoCargado();
        
        $ArchivoCargado->cargar($datos["nombre"], $datos["descripcion"], $datos["icono"], $datos["ruta"], '0', '0', '', '', '', $datos["usuario"]);
        
        // Copiamos el archivo y cargamos info
        if ($ArchivoCargado->insertar() && $this->subir($archivo, $datos))
        {
            // Ahora insertamos en la tabla archivocargadoestado
            $ACE = new ArchivoCargadoEstado();
            $ACE->cargar('', '', '', '1', '1', $ArchivoCargado->get_id());
            if ($ACE->insertar())
            {
                $operacion = true;
                $this->set_archivoCargado($ArchivoCargado);
                $this->set_archivoCargadoEstado($ACE);
            }
        }

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

    /**
     * Esta función retorna la información obtenida de las tablas "archivocargado" y "archivocargadoestado" segun la id
     * @param string $id idarchivocargadoestado
     * 
     * @return array 
     */
    public function get_info($id)
    {
        $arreglo = null;

        // Modelos a usar
        $ACE = new ArchivoCargadoEstado();
        $AC = new ArchivoCargado();

        if ($ACE->buscar($id))
        {
            if ($AC->buscar($ACE->get_archivoCargado()->get_id()))
            {
                $arreglo['nombre'] = $AC->get_nombre();
                $arreglo['usuario'] = $ACE->get_usuario()->get_id();
                $arreglo['contraseña'] = $AC->get_protegidoClave();
                $arreglo['limite'] = $AC->get_cantidadDescarga();
                $arreglo['enlace'] = $AC->get_linkAcceso();
                $arreglo['fechaFin'] = $AC->get_fechaFinCompartir();
            }
        }
        return $arreglo;
    }


    public function set_error ($data) { $this->error = $data; }
    public function set_archivoCargado ($data) { $this->archivoCargado = $data; }
    public function set_archivoCargadoEstado ($data) { $this->archivoCargadoEstado = $data; }
    public function get_error () { return $this->error; }
    public function get_archivoCargado () { return $this->archivoCargado; }
    public function get_archivoCargadoEstado () { return $this->archivoCargadoEstado; }
}