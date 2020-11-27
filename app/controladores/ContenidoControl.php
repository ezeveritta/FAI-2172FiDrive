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
     * Esta función crea un archivo comprimido con la informacion pasada por parametro
     * @param array $datos Contiene todos los datos provenientes del formulario
     * 
     * @return boolean
     */
    public function comprimir($datos)
    {
        // Validamos la información
        if (!isset($datos['item_1'])) {
            $this->set_error("No se especificó un archivo.");
            return false;
        }

        // Obtengo los archivos a descargar
        $arreglo_items = array();
        foreach ($datos as $key => $valor) {
            $exp_key = explode('_', $key);
            if ($exp_key[0] == 'item') {
                array_push($arreglo_items, $valor);
            }
        }

        // Definimos la ruta donde crear el archivo comprimido
        $rutaDestino = "../../../archivos/temporales";
        $rutaArchivos = "{$datos['ruta']}";
        $exclusiveLength = 9;

        // Definimos las variables a utilizar
        $ZIP = new ZipArchive();
        $fecha = new DateTime();
        $nombreZip = 'FiDrive_descarga_' . $fecha->format("Y-m-d_H-i-s") . '.zip';
        $comentario = "Ésta es una descripción.";

        // Creamos el archivo Zip
        if ($ZIP->open($rutaDestino . '/' . $nombreZip, ZIPARCHIVE::CREATE) === false) 
        {
            $this->set_error("Error al generar archivo comprimido.");
            return false;
        }

        // Añadimos los archivos
        foreach ($arreglo_items as $item) {
            $rutaItem = '../../../' . $rutaArchivos . '/' . $item;
            echo "<br>$rutaItem";
            $rutaLocal = substr($rutaItem, $exclusiveLength, strlen($rutaItem));

            // Si es una carpeta
            if (is_dir($rutaItem)) {
                $this->folderToZip($rutaItem, $item, $ZIP, $exclusiveLength);
            }

            // Si es un archivo, lo añadimos
            else {
                $ZIP->addFile($rutaItem, $rutaLocal);
            }
        }

        // Guardamos el archivo
        $ZIP->setArchiveComment($comentario);
        $ZIP->close();

        // Operación exitosa
        $this->set_error('');
        return $nombreZip;
    }

    private function folderToZip($folder, $nombre, &$zipFile, $exclusiveLength)
    {
        // Abro la carpeta
        $handle = opendir($folder);

        // Por cada archivo dentro
        while (false !== $f = readdir($handle)) {
            
            if ($f != '.' && $f != '..') {

                $filePath = "$folder/$f";

                // Remove prefix from file path before add to zip.
                $localPath = substr($filePath, $exclusiveLength, strlen($filePath));

                if (is_file($filePath)) {
                    $zipFile->addFile($filePath, $localPath);
                } elseif (is_dir($filePath)) {
                    // Add sub-directory.
                    $zipFile->addEmptyDir($localPath);
                    $this->folderToZip($filePath, $nombre, $zipFile, $exclusiveLength);
                }
            }
        }
        closedir($handle);
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
        if (!isset($datos['nombre']) || !isset($datos['ruta'])) {
            $this->set_error("No se especificó un nombre.");
            return false;
        }

        // Validamos el nombre de la carpeta
        if (strpbrk($datos['nombre'], "\\/?%*:|\"<>")) {
            $this->set_error("Nombre contiene caracteres no admitidos.");
            return false;
        }

        // Definimos la ruta a crear
        $ruta = "../../../{$datos['ruta']}/{$datos['nombre']}";

        // Creamos la carpeta
        if (!mkdir($ruta, 0777)) {
            $this->set_error("Error al crear carpeta.");
            return false;
        }

        // Operación exitosa
        $this->set_error('');
        return true;
    }

    /**
     * Esta función obtiene todo el contenido de una carpeta
     * @param array $datos Contiene la información de la carpeta actual
     * 
     * @return mixed bool|null|array
     */
    public function abrirDirectorio($ruta)
    {
        $respuesta = null;
        $ruta = '../../' . $ruta;

        // Abro el directorio
        $direccion = opendir($ruta);

        // Si no se encuentra directorio
        if ($direccion === false) {
            $this->set_error("Error al abrir la carpeta.");
            return false;
        }

        // Obtengo el listado de carpetas y archivos
        $archivos = array();
        $carpetas = array();

        while (($temp = readdir($direccion)) !== false) {
            if ($temp !=="." && $temp !== ".." && $temp !== "temporales" && !is_dir($ruta . '/' . $temp))    // Si es archivo
                array_push($archivos, $temp);
            if ($temp !== "." && $temp !== ".." && $temp !== "temporales" && is_dir($ruta . '/' . $temp))     // Si es carpeta
                array_push($carpetas, $temp);
        }

        // Verifico si la carpeta está vacía o tiene contenido
        if (count($archivos) > 0 || count($carpetas) > 0) {
            $respuesta = ["carpetas" => $carpetas, "archivos" => $archivos];
        }

        return $respuesta;
    }

    /**
     * Esta función reordena el contenido de una carpeta segun los parámetros indicados
     * @param array $contenido Arreglo de carpetas y archivos a ordenar
     * @param string $orden Si se ordena por orden alfabetico, por tamaño o fecha
     * @param string $direccion Si se ordena valores ascendentes o descendentes
     * 
     * @return array
     */
    public function ordenarContenido($ruta, $contenido, $orden = 'nombre', $direccion = 'descendente')
    {
        if ($contenido == null) {
            $this->set_error('No hay contenido.');
            return false;
        }

        switch ($orden) {
            case 'nombre':
                if ($direccion == 'ascendente') {
                    rsort($contenido['carpetas']);
                    rsort($contenido['archivos']);
                } elseif ($direccion == 'descendente') {
                    sort($contenido['carpetas']);
                    sort($contenido['archivos']);
                }
                break;

            case 'tamaño':
                $temp_carpetas = array();
                $temp_archivos = array();

                // Por cada CARPETA en $contenido, obtengo su peso y lo guardo en el arreglo temporal
                foreach ($contenido['carpetas'] as $nombre) {
                    $path = "$ruta/$nombre";
                    $tamaño = folderSize('../../' . $path);
                    array_push($temp_carpetas, ['nombre' => $nombre, 'tamaño' => $tamaño]);
                }

                // Por cada ARCHIVO en $contenido, obtengo su peso y lo guardo en el arreglo temporal
                foreach ($contenido['archivos'] as $nombre) {
                    $path = "$ruta/$nombre";
                    $tamaño = filesize('../../' . $path);
                    array_push($temp_archivos, ['nombre' => $nombre, 'tamaño' => $tamaño]);
                }

                // Ordenamos
                if ($direccion == 'descendente') {
                    array_multisort(array_column($temp_carpetas, "tamaño"), SORT_DESC, $temp_carpetas);
                    array_multisort(array_column($temp_archivos, "tamaño"), SORT_DESC, $temp_archivos);
                } else if ($direccion == 'ascendente') {
                    array_multisort(array_column($temp_carpetas, "tamaño"), SORT_ASC, $temp_carpetas);
                    array_multisort(array_column($temp_archivos, "tamaño"), SORT_ASC, $temp_archivos);
                }

                // retornamos el arreglo $contenido con el nuevo orden
                $contenido['carpetas'] = array();
                $contenido['archivos'] = array();
                foreach ($temp_carpetas as $carpeta) {
                    array_push($contenido['carpetas'], $carpeta['nombre']);
                }
                foreach ($temp_archivos as $archivo) {
                    array_push($contenido['archivos'], $archivo['nombre']);
                }
                break;
        }

        return $contenido;
    }

    /**
     * Éste método retorna un string HTML correspondiente al navbar de carpetas
     * @param string $ruta
     * @return string
     */
    public static function html_navegacion($ruta)
    {
        // Divido las rutas en un array
        $arregloDirecciones = explode('/', $ruta);

        // Por cada item, creo su elemento html
        $HTML = '<style>.icono-direcciones{color: #888;}</style>';
        foreach ($arregloDirecciones as $indice => $nombreDirectorio) {
            // Omito los directorios sin nombre (doble barra)
            if ($nombreDirectorio != '') {
                $HTML .= '<i class="fa fa-chevron-right px-2 icono-direcciones"></i>
                          <a href="./contenido.php?carpeta=';
                // Valor de href
                for ($f = 0; $f <= $indice; $f++) {
                    $HTML .=  "{$arregloDirecciones[$f]}/";
                }
                $HTML .=  '" style="color: #555">' . "$nombreDirectorio</a>";
            }
        }

        return $HTML;
    }

    /**
     * Éste método retorna un string HTML correspondiente a una carpeta
     * @param array $ruta
     * @return string
     */
    public static function html_carpeta($id, $ruta, $nombre)
    {
        $HTML   =   '<li class="list-group-item border m-2 custom-folder bg-light folder custom-item">
                        <div class="opciones dropdown" style="right: -5px; top: 3px; position: absolute; display: none;">
                                <button type="button" class="float-right btn bg-transparent" id="item_' . $id . '_opciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="item_' . $id . '_opciones">
                                    <div class="dropdown-item abrir">
                                        <a href="./contenido.php?carpeta=' . $ruta . '/' . $nombre . '&accion=abrirCarpeta" class="text-dark btn-abrir">
                                            <i class="fa fa-folder-open text-muted"></i>
                                            Abrir
                                        </a>
                                    </div>
                                    <div class="dropdown-item">
                                        <a href="./compartirarchivo.php?archivo=' . $ruta . '/' . $nombre . '" class="text-dark">
                                            <i class="fa fa-link text-muted"></i>
                                            Compartir
                                        </a>
                                    </div>
                                    <div class="dropdown-item">
                                        <a href="./eliminararchivo.php?archivo=' . $ruta . '/' . $nombre . '" class="text-danger">
                                            <i class="fa fa-trash-alt"></i>
                                            Eliminar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <div class="h1 h-75 icono"><i class="fa fa-folder"></i></div>
                        <div class="titulo">' . texto_limitado($nombre) . '</div></li>';

        return $HTML;
    }


    /**
     * Éste método retorna un string HTML correspondiente a una archivo
     * @param array $ruta
     * @return string
     */
    public static function html_archivo($id, $ruta, $nombre)
    {
        $HTML = '';

        // Obtenemos el tipo de archivo para mostrar el icono que le corresponde
        $extension = pathinfo("$ruta/$nombre")["extension"];
        $tipoArchivo = tipo_archivo($extension);

        // Escribimos el HTML// custom-folder
        $HTML .= '<li class="list-group-item border m-2 custom-item bg-light archivo">';

        $HTML .= '<div class="dropdown opciones" style="right: -5px; top: 3px; position: absolute; display: none;">
                            <button type="button" class="float-right btn bg-transparent" id="item_' . $id . '_opciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v text-center w-100"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="item_' . $id . '_opciones">
                                <div class="dropdown-item abrir">
                                    <a href="../../' . $ruta . '/' . $nombre . '" target="_blanck" class="btn bg-transparent btn-abrir">
                                        <i class="fa fa-download text-muted"></i>
                                        Descargar
                                    </a>
                                </div>
                                <div class="dropdown-item">
                                    <form action="./amarchivo.php" method="get">
                                        <input type="hidden" name="archivo" value="' . $ruta . '/' . $nombre . '">
                                        <button type="submit" class="btn bg-transparent">
                                            <i class="fa fa-edit text-muted"></i>
                                            Editar
                                        </button>
                                    </form>
                                </div>
                                <div class="dropdown-item">
                                    <form action="./compartirarchivo.php" method="post">
                                        <input type="hidden" name="archivo" value="' . $ruta . '/' . $nombre . '">
                                        <button type="submit" class="btn bg-transparent">
                                            <i class="fa fa-link text-muted"></i>
                                            Compartir
                                        </button>
                                    </form>
                                </div>
                                <div class="dropdown-item">
                                    <form action="./eliminararchivo.php" method="get">
                                        <input type="hidden" name="archivo" value="' . $ruta . '/' . $nombre . '">
                                        <button type="submit" class="btn bg-transparent text-danger">
                                            <i class="fa fa-trash-alt"></i>
                                            <span>Eliminar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>';

        // Si el archivo es una imagen, la mostramos en lugar de un icono
        $HTML .= ($tipoArchivo == 'imagen')
            ? '<div class="h-75 mb-2"><img src="../../' . $ruta . '/' . $nombre . '"></img></div>'
            : '<div class="h1 h-75 icono"><i class="fa fa-' . icono_archivo($tipoArchivo) . '"></i></div>';

        $HTML .=    '<div class="w-100 titulo" >' . texto_limitado($nombre) . '</div></li>';

        return $HTML;
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
