<?php

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 24/10/2020
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
    public function validar($datos, $archivo = false)
    {
        // Valido que existan valores
        if (!isset($datos['nombre']) || !isset($datos['descripcion']) || !isset($datos['icono']) || $archivo === null) {
            $this->set_error('Uno ó más datos no se cargaron correctamente.');
            return false;
        }

        // Valido que el campo 'nombre' no esté vacío
        if (strlen($datos['nombre']) == 0) {
            $this->set_error('El campo "nombre" no debe quedar vacío.');
            return false;
        }

        if ($archivo != false) {
            // Valido la extensión del archivo
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $extensiones_permitidas = array(
                'jpg', 'png', 'jpeg', 'gif', 'svg', 'webp', 'bpm', 'tiff',
                'doc', 'docx', 'odt', 'rtf', 'txt', 'docm', 'dot', 'dotx', 'dotm',
                'pdf',
                'xls', 'xlsx', 'xlsm', 'xltx', 'xlt', 'ods',
                'zip', 'rar', '7z', 'tar', 'hz', 'bin'
            );

            if (!in_array(strtolower($extension), $extensiones_permitidas)) {
                $this->set_error("Tipo de archivo no permitido: {$extension}");
                return false;
            }
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
        # Creamos el obj modelo y seteamos los datos
        $ArchivoCargado = new ArchivoCargado();
        $ArchivoCargado->cargar($datos["ruta"] . '/' . $datos["nombre"], $datos["descripcion"], $datos["icono"], '', '0', '0', '', '', '', $datos["usuario"]);

        // Cargamos los datos a la tabla archivocargado
        if (!$ArchivoCargado->insertar()) {
            $this->set_error($ArchivoCargado->get_error());
            return false;
        }

        // Creamos el obj modelo y seteamos los datos
        $ArchivoCargadoEstado = new ArchivoCargadoEstado();
        $ArchivoCargadoEstado->cargar('Archivo recien cargado, aún no compartido.', '', '', '1', '1', $ArchivoCargado->get_id());

        // Cargamos los datos a la tabla archivocargadoestado
        if (!$ArchivoCargadoEstado->insertar()) {
            $ArchivoCargado->eliminar(); // eliminamos lo cargado previamente
            $this->set_error($ArchivoCargadoEstado->get_error());
            return false;
        }

        // Copiamos el archivo y cargamos info
        $ruta_archivo = "../../../archivos/{$datos['ruta']}/{$datos['nombre']}";
        if (!copy($archivo['tmp_name'], $ruta_archivo)) {
            $ArchivoCargado->eliminar();       // eliminamos lo cargado previamente
            $ArchivoCargadoEstado->eliminar(); // .
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
        // Modelos a usar
        $ArchivoCargado = new ArchivoCargado();

        // Buscamos la tupla en la BD
        if (!$ArchivoCargado->buscar($datos['id'])) {
            $this->set_error('No se encontró registro para modificar.');
            return false;
        }

        // Seteamos nuevos datos
        $linkViejo = $ArchivoCargado->get_linkAcceso();
        $linkNuevo = dirname($datos["ruta"]) . '/' . $datos["nombre"];
        $ArchivoCargado->set_descripcion($datos['descripcion']);
        $ArchivoCargado->set_usuario($datos['usuario']);
        $ArchivoCargado->set_icono($datos['icono']);
        $ArchivoCargado->set_nombre($datos['nombre']);
        $ArchivoCargado->set_linkAcceso($linkNuevo);

        // Modificamos el archivo local
        if (!rename('../../../archivos/' . $linkViejo, '../../../archivos/' . $linkNuevo)) {
            $this->set_error('No se pudo modificar el archivo en el servidor.');
            return false;
        }

        // Modificamos la BD
        if (!$ArchivoCargado->modificar()) {
            $this->set_error('No se pudo modificar la Base de Datos.');
            rename('../../../archivos/' . $linkNuevo, '../../../archivos/' . $linkViejo);
            return false;
        }

        // Operación exitosa
        $this->set_error('');
        $this->set_archivoCargado($ArchivoCargado);
        return true;
    }

    /**
     * Esta función retorna la información obtenida de las tablas "archivocargado" segun 'id' ó 'linkacceso'
     * @param mixed $datos [clave, ruta o id]
     * 
     * @return array 
     */
    public function get_info($datos, $idUsuario)
    {
        // Modelos a usar
        $ArchivoCargado = new ArchivoCargado();

        // Arreglo base a retornar
        $arreglo = array(
            'nombre' => "1234.png",
            'descripcion' => "<b>E</b>sta es una descripción genérica, si lo necesita la puede <i>cambiar</i>.",
            'icono' => "",
            'clave' => 0,
            'ruta' => "$idUsuario/archivos",
            'id' => null
        );

        // Si la página se cargó sin parámetros
        if (count($datos) == 0) {
            if (isset($datos['ruta']))
                $arreglo['ruta'] = $datos['ruta'];
            return $arreglo;
        }

        // Si está el parámetro 'clave' y 'ruta' (venimos de 'contenido')
        if (isset($datos['clave'])) {
            if (isset($datos['ruta']))
                $arreglo['ruta'] = $datos['ruta'];
            return $arreglo;
        }

        // SI busco por ID
        if (isset($datos['id'])) {
            // Busco registro en la tabla 'archivocargadoestado'
            if (!$ArchivoCargado->buscar($datos['id'])) {
                $this->set_error("No se encontró un registro con la id: {$datos['id']}");
                return $arreglo;
            }
        }

        $arreglo['nombre'] = $ArchivoCargado->get_nombre();
        $arreglo['descripcion'] = $ArchivoCargado->get_descripcion();
        $arreglo['icono'] = $ArchivoCargado->get_icono();
        $arreglo['clave'] = 1;
        $arreglo['ruta'] = $ArchivoCargado->get_linkAcceso();
        $arreglo['id'] = $ArchivoCargado->get_id();

        return $arreglo;
    }



    /**
     * Métodos de acceso
     */
    public function set_error($data) { $this->error = $data; }
    public function set_archivoCargado($data) { $this->archivoCargado = $data; }
    public function set_archivoCargadoEstado($data) { $this->archivoCargadoEstado = $data; }
    public function get_error() { return $this->error; }
    public function get_archivoCargado() { return $this->archivoCargado; }
    public function get_archivoCargadoEstado() { return $this->archivoCargadoEstado; }
    public function __toString()
    {
        return  "Objeto AmarchivoControl:
                 <br> Error: $this->get_error()
                 <br> ArchivoCargado: $this->get_archivoCargado()
                 <br> ArchivoCargadoEstado: $this->get_archivoCargadoEstado()";
    }
}
