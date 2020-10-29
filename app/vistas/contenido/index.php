<?php

$Titulo = "Contenido";
include_once("../estructura/cabecera.php");
include_once("../../controladores/ContenidoControl.php");

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 07/10/2020
 */

// Datos de Get&Post
$datos = data_submitted();
$control = new ContenidoControl();

// Carpeta Actual
$ruta = (isset($datos['carpeta'])) ? limpiarRuta($datos['carpeta']) : 'archivos';
// Limpio las dobles barras (//) que a veces quedan


// Obtengo un array de contenido ["carpetas", "archivos"]
$contenido = ContenidoControl::abrirDirectorio($ruta);

?>

<!-- Contenido -->
<div class="col-md-10 col-xs-12">
    <div class="row h-100">
        <div class="col-sm-12 my-3">

            <div class="w-100 mx-auto mb-2 border-none" id="contenedor">

                <!-- Barra de direcciones -->
                <div class="w-100 mt-2">
                    <div class="mr-3 h6">
                        <?php
                        echo $control->html_navegacion($ruta);
                        ?>
                    </div>
                </div>

                <nav class="navbar navbar-expand-lg">

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: -10px;">
                        <ul class="navbar-nav">

                            <!-- Nueva Carpeta -->
                            <li class="nav-item dropdown">
                                <button type="button" class="btn btn-sm p-2" id="nuevaCarpeta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 10px; background: #98b5c2; color: #fff">
                                    <i class="fa fa-folder-plus pl-4"></i>
                                    Nueva carpeta
                                    <i class="fa fa-sort-down" style="padding-left: 25px; transform: translateY(-2px);"></i>
                                </button>

                                <div class="dropdown-menu mt-2" aria-labelledby="nuevaCarpeta" id="nuevaCarpetaDropdown" style="border-radius: 10px;">
                                    <form action="accion.php" method="post" class="mt-1">
                                        <div class="row px-2">
                                            <div class="form-group col-sm-8">
                                                <label for="nombre"><b>Nombre:</b></label>
                                                <input type="text" class="form-control" id="nombre" name="nombre">
                                            </div>
                                            <input type="hidden" name="ruta" value="<?php echo $ruta ?>">
                                            <input type="hidden" name="accion" value="crearCarpeta">
                                            <div class="col-sm-4">
                                                <label for=""></label>
                                                <button type="submit" class="btn btn-block mt-2 w-100 pb-2" style="border-radius: 10px; background: #98b5c2; color: #fff; border: none;">Crear</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <style>
                                    #nuevaCarpetaDropdown form>div>div {
                                        padding: 4px !important;
                                    }

                                    #nuevaCarpetaDropdown {
                                        padding: 0px 15px !important;
                                    }
                                </style>
                            </li>

                            <!-- Cargar Archivo -->
                            <li class="nav-item">
                                <form action="../amarchivo/index.php" method="post">
                                    <input type="hidden" name="ruta" value="<?php echo $ruta ?>">
                                    <input type="hidden" name="clave" value="0">
                                    <button type="submit" class="btn btn-sm ml-3 p-2" style="border-radius: 10px; background: #d4cea3; color: #fff">
                                        <i class="fa fa-upload pl-4"></i>
                                        <span style="padding-right: 6px; margin-left: -4px">Subir Archivo</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>


                <ul class="list-group list-group-horizontal align-items-stretch flex-wrap text-center ft-explorer-grid-container border-0" id="contenido">

                    <?php
                    // Verifico si hay contenido en la carpeta
                    if ($contenido === false) {
                        echo '<h4 class="text-muted w-100 text-center m-4">No hay contenido</h4>';
                    } else {
                        // Indice para los IDs
                        $idItem = 1;

                        // Recorremos el arreglo de carpetas e insertamos un HTML correspondiente
                        foreach ($contenido["carpetas"] as $nombre) {
                            // Insertamos html de la carpeta
                            echo $control->html_carpeta($idItem, $ruta, $nombre);
                            $idItem++;
                        }

                        // Recorremos el arreglo de archivos e insertamos un HTML correspondiente
                        foreach ($contenido["archivos"] as $nombre) {
                            // Insertamos html del archivo
                            echo $control->html_archivo($idItem, $ruta, $nombre);
                            $idItem++;
                        }
                    }
                    ?>
                </ul>

                <style>
                    #contenido {
                        margin-left: -2px;
                    }

                    .custom-item {
                        cursor: pointer;
                    }

                    .custom-item .icono {
                        transform: translateY(20px);
                    }
                    
                    .custom-item:hover .opciones {
                        display: inline-block !important;
                    }

                    .custom-folder img {
                        height: 100% !important;
                        border-radius: 5px;
                    }

                    ul a>i {
                        margin-left: -15px;
                        margin-right: 15px;
                    }

                    ul button>i {
                        margin-left: -14px;
                        margin-right: 14px;
                    }

                    ul .custom-folder {
                        width: 184px;
                        height: 140px;
                        padding: 0px 0px -4px 0px;
                    }

                    ul .opciones {
                        position: fixed;
                        top: 0;
                        right: 0;
                    }

                    ul>.selected {
                        border: 1px solid #C6C8DF !important;
                        background: #E6E8F7 !important;
                    }

                    ul>* {
                        border-radius: 10px !important;
                    }

                    #nuevaCarpetaDropdown {
                        width: 300px !important;
                        padding-bottom: 0px;
                    }

                    @media only screen and (max-width: 576px) {
                        ul .custom-folder {
                            width: 100%;
                        }
                    }

                    @media only screen and (max-width: 768px) {
                        ul .custom-folder {
                            width: 31.111%;
                        }
                    }
                </style>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 576px) {
        #contenedor {
            width: 100% !important;
        }
    }
</style>

<script>
    $(document).ready(function() {

        /** Esta función agrega estilo al elemento seleccionado
         */
        function seleccionarElemento(elemento) {
            elemento.addClass('selected');
        }

        /** Ésta función quita estilo a todos los elementos
         */
        function deselccionarElemento(elemento) {
            elemento.removeClass('selected');
        }

        // Éste evento selecciona el elemento clickeado
        $("#contenido > *").on('click', function() {
            deselccionarElemento($("#contenido > *"));
            seleccionarElemento($(this));
        });

        // Ésta función abre el elemento seleccionado
        $("#contenido > *").on('dblclick', function() {
            // Obtengo la ruta del elemento
            let ruta = $(this).find('.btn-abrir').attr('href');

            // Si es una carpeta, cambio la url de la página
            if ($(this).hasClass('folder')) {
                $(location).attr('href', ruta);
                return false;
            }

            // Si es archivo, lo abro en otra pestaña
            window.open(ruta, '_blank');
            return false;
        });

        // Ésta función deselecciona todos los elementos cuando se hace click en un espacio en blanco
        $("#contenido").on('click', function(e) {
            if ($(e.target).hasClass('list-group')) {
                deselccionarElemento($(this).children());
            }
        });

    });
</script>

<?php
include_once("../estructura/pie.php");
?>