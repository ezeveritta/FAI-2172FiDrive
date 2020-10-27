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
        $this->error = '';
        $this->ArchivoCargado = new ArchivoCargado();
        $this->ArchivoCargadoEstado = new ArchivoCargadoEstado();
    }

    /**
     * Éste método valida que la información sea la esperada
     * @param array $datos Tiene todos los datos a subir a la bd
     * @param file $archivo Contiene el archivo a copiar
     * 
     * @return boolean
     */
    public function validar($datos, $archivo)
    {
        // Valido que existan valores
        if (!isset($datos['nombre']) || !isset($datos['usuario']) || !isset($datos['descripcion']) || !isset($datos['icono']) || $archivo == null)
        {
            $this->set_error('Uno ó más datos no se cargaron correctamente.');
            return false;
        }
        
        // Valido que el campo nombre no esté vacío
        if (strlen($datos['nombre']) == 0)
        {
            $this->set_error('El campo "nombre" no debe quedar vacío.');
            return false;
        }

        // Valido la extensión del archivo
        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $extensiones_permitidas = array('jpg', 'png', 'jpeg', 'gif', 'svg', 'webp', 'bpm', 'tiff',
                                        'doc', 'docx', 'odt', 'rtf', 'txt', 'docm', 'dot', 'dotx', 'dotm',
                                        'pdf',
                                        'xls', 'xlsx', 'xlsm', 'xltx', 'xlt', 'ods',
                                        'zip', 'rar', '7z', 'tar', 'hz', 'bin');
                                        
        if (!in_array(strtolower($extension), $extensiones_permitidas))
        {
            $this->set_error("Tipo de archivo no permitido: {$extension}");
            return false;
        }
        
        // Validación correcta
        $this->set_error('');
        return true;
    }
    
    /**
     * Esta función carga los datos al servidor y copia el archivo
     * @param string $datos Tiene todos los datos a subir a la bd
     * @param file $archivo Contiene el archivo a copiar
     * 
     * @return boolean
     */
    public function cargar($datos, $archivo)
    {
        // Creamos el obj modelo y seteamos los datos
        $ArchivoCargado = new ArchivoCargado();
        $ArchivoCargado->cargar($datos["nombre"], $datos["descripcion"], $datos["icono"], $datos["nombre"], '0', '0', '', '', '', $datos["usuario"]);

        // Cargamos los datos a la tabla archivocargado
        if (!$ArchivoCargado->insertar())
        {
            $this->set_error($ArchivoCargado->get_error());
            return false;
        }

        // Creamos el obj modelo y seteamos los datos
        $ArchivoCargadoEstado = new ArchivoCargadoEstado();
        $ArchivoCargadoEstado->cargar('Archivo recien cargado, aún no compartido.', '', '', '1', '1', $ArchivoCargado->get_id());

        // Cargamos los datos a la tabla archivocargadoestado
        if (!$ArchivoCargadoEstado->insertar())
        {
            $archivoCargado->eliminar(); // eliminamos lo cargado previamente
            $this->set_error($ArchivoCargadoEstado->get_error());
            return false;
        }
        
        // Copiamos el archivo y cargamos info
        $ruta_archivo = "../../../{$datos['ruta']}/$datos{['nombre']}";
        if (!copy($archivo['tmp_name'], $ruta_archivo))
        {
            $archivoCargado->eliminar();       // eliminamos lo cargado previamente
            $archivoCargadoEstado->eliminar(); // .
            $this->set_error('No se pudo copiar el archivo al servidor.');
            return false;
        }

        // Operación exitosa
        $this->set_error('');
        $this->set_archivoCargado($ArchivoCargado);
        $this->set_archivoCargadoEstado($ArchivoCargadoEstado);
        return true;
    }

    /**
     * Esta función modifica los datos de la BD
     * @param array $datos Tiene todos los datos a subir a la bd
     * 
     * @return boolean
     */
    public function modificar($datos)
    {
        $operacion = false;

        // Cargamos info a la base de datos
        $ArchivoCargado = new ArchivoCargado();
        
        // Buscamos la tupla en la BD
        if ($ArchivoCargado->buscar($datos['id']))
        {
            $linkNuevo = dirname($datos["ruta"]).'/'.$datos["nombre"];
            $ArchivoCargado->set_descripcion($datos['descripcion']);
            $ArchivoCargado->set_usuario($datos['usuario']);
            $ArchivoCargado->set_icono($datos['icono']);
            $ArchivoCargado->set_nombre($datos['nombre']);
            rename('../../../'.$ArchivoCargado->get_linkAcceso(), '../../../'.$linkNuevo);
            $ArchivoCargado->set_linkAcceso($linkNuevo);

            if ($ArchivoCargado->modificar())
            {
                $this->set_archivoCargado($ArchivoCargado);
                $operacion = true;
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
     * @param string $datos [ruta o id]
     * 
     * @return array 
     */
    public function get_info($datos)
    {
        $arreglo = array();

        // Modelos a usar
        $ACE = new ArchivoCargadoEstado();
        $AC = new ArchivoCargado();

        // Si hay un id
        if (isset($datos['id']))
        {
            // Busco la información
            if ($ACE->buscar($datos['id']))
            {
                if ($AC->buscar($ACE->get_archivoCargado()->get_id()))
                {
                    $arreglo['nombre'] = $AC->get_nombre();
                    $arreglo['usuario'] = $AC->get_usuario()->get_id();
                    $arreglo['descripcion'] = $AC->get_descripcion();
                    $arreglo['icono'] = $AC->get_icono();
                    $arreglo['clave'] = 1; // Acción: MODIFICAR
                    $arreglo['ruta'] = $AC->get_linkAcceso();
                }
            }
        }
        else
        {
            $arreglo['nombre'] = null;
            $arreglo['usuario'] = null;
            $arreglo['descripcion'] = null;
            $arreglo['icono'] = null;
            $arreglo['clave'] = 0; // Acción: ALTA
            $arreglo['ruta'] = (isset($datos['ruta'])) ? $datos['ruta'] : 'archivos';
        }
        
        return $arreglo;
    }



    /**
     * Métodos de acceso
     */
    public function set_error ($data) { $this->error = $data; }
    public function set_archivoCargado ($data) { $this->archivoCargado = $data; }
    public function set_archivoCargadoEstado ($data) { $this->archivoCargadoEstado = $data; }
    public function get_error () { return $this->error; }
    public function get_archivoCargado () { return $this->archivoCargado; }
    public function get_archivoCargadoEstado () { return $this->archivoCargadoEstado; }
    public function __toString() 
    {
        return  "Objeto AmarchivoControl:
                 <br> Error: $this->get_error()
                 <br> ArchivoCargado: $this->get_archivoCargado()
                 <br> ArchivoCargadoEstado: $this->get_archivoCargadoEstado()";
    }
}