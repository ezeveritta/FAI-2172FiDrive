<?php

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 19/11/2020
 */

class CompartidosControl
{
    private $error;

    public function __construct()
    {
        $this->error = '';
    }

    /**
     * Esta función obtiene todo el contenido de la base de datos que tiene estado "compartido"
     * @param string $idusuario  : para filtrar cuales archivos mostrar
     * @return mixed null|array
     */
    public function obtenerCompartidos($idusuario)
    {
        $respuesta = null;

        // Obtengo de la BD los archivos compartidos
        $ArchivoCargadoEstado = new ArchivoCargadoEstado();
        $arregloCompartidos   = $ArchivoCargadoEstado->listar("idestadotipos=2 AND idusuario=$idusuario");

        // Si el método da error, lo muestro.
        if (is_string($arregloCompartidos)) {
            $this->set_error($arregloCompartidos);
            return false;
        }

        // Obtengo el listado de carpetas y archivos
        if (count($arregloCompartidos) > 0)
        {
            return $arregloCompartidos;
        }

        return $respuesta; // null
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
                    $tamaño = folderSize('../../../' . $path);
                    array_push($temp_carpetas, ['nombre' => $nombre, 'tamaño' => $tamaño]);
                }

                // Por cada ARCHIVO en $contenido, obtengo su peso y lo guardo en el arreglo temporal
                foreach ($contenido['archivos'] as $nombre) {
                    $path = "$ruta/$nombre";
                    $tamaño = filesize('../../../' . $path);
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
                          <a href="./compartidos.php?carpeta=';
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
     * Éste método retorna un string HTML correspondiente a una archivo
     * @param array $ruta
     * @return string
     */
    public static function html_archivo($id, $archivo)
    {
        $HTML = '';
        $nombre       = $archivo->get_archivoCargado()->get_nombre();
        $linkAcceso   = $archivo->get_archivoCargado()->get_linkAcceso();
        $idArchivoCargado = $archivo->get_archivoCargado()->get_id();
        $nombre           = $archivo->get_archivoCargado()->get_nombre();

        // Obtenemos el tipo de archivo para mostrar el icono que le corresponde
        $extension   = pathinfo("$nombre")["extension"];
        $tipoArchivo = tipo_archivo($extension);

        // Escribimos el HTML// custom-folder
        $HTML .= '<li class="list-group-item border m-2 custom-item bg-light archivo">';

        $HTML .= '<div class="dropdown opciones" style="right: -5px; top: 3px; position: absolute; display: none;">
                            <button type="button" class="float-right btn bg-transparent" id="item_' . $id . '_opciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v text-center" style="margin-right: -3px"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="item_' . $id . '_opciones">
                                <div class="dropdown-item abrir">
                                    <a href="descargar.php?linkacceso='.$linkAcceso.'" target="_blanck" class="btn bg-transparent btn-abrir">
                                        <i class="fa fa-download text-muted"></i>
                                        Descargar
                                    </a>
                                </div>
                                <div class="dropdown-item">
                                    <form action="amarchivo.php" method="get">
                                        <input type="hidden" name="id" value="' . $idArchivoCargado . '">
                                        <button type="submit" class="btn bg-transparent">
                                            <i class="fa fa-edit text-muted"></i>
                                            Editar
                                        </button>
                                    </form>
                                </div>
                                <div class="dropdown-item">
                                    <form action="compartirarchivo.php" method="post">
                                        <input type="hidden" name="id" value="' . $idArchivoCargado . '">
                                        <button type="submit" class="btn bg-transparent">
                                            <i class="fa fa-link text-muted"></i>
                                            Compartir
                                        </button>
                                    </form>
                                </div>
                                <div class="dropdown-item">
                                    <form action="eliminararchivo.php" method="get">
                                        <input type="hidden" name="id" value="' . $idArchivoCargado . '">
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
            ? '<div class="h-75 mb-2"><img src="../../archivos/' . $nombre . '"></img></div>'
            : '<div class="h1 h-75 icono"><i class="fa fa-' . icono_archivo($tipoArchivo) . '"></i></div>';

        $HTML .=    '<div class="w-100 titulo" >' . texto_limitado( nombreArchivo($nombre) ) . '</div></li>';

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
