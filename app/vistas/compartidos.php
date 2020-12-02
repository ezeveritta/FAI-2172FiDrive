<?php

$sitio_titulo = "Contenido - FAI-2172";
include_once("estructura/cabecera.php");
include_once("../modelos/ArchivoCargadoEstado.php");
include_once("../modelos/ArchivoCargado.php");
include_once("../modelos/EstadoTipos.php");
include_once("../modelos/BaseDatos.php");
include_once("../controladores/CompartidosControl.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - compartidos
///// File: /app/vistas/compartidos.php
///// Date: 19/11/2020
///// Description:
////////// Vista donde el usuario vé los archivos que cargó
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

// Verifico si el cliente está logeado
if (!SessionControl::validar())
{
    header('Location: login.php');
    die();
}

$control = new CompartidosControl();

// Datos de Get&Post
$datos = data_submitted();

// Obtengo un array de contenido ["archivos"]
$contenido = $control->obtenerCompartidos($idusuario);

// Si retorna "false": muestro error y seteo contenido=null
if ($contenido === false) {
    $contenido = null;
    $datos['error'] = $control->get_error();
}

// Reordeno el contenido
if (isset($datos['orden']) &&  isset($datos['direccion']))
    $contenido = $control->ordenarContenido("archivos", $contenido, $datos['orden'], $datos['direccion']);

echo get_aviso($datos); 
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
                        echo $control->html_navegacion("archivos");
                        ?>
                    </div>
                </div>

                <nav class="navbar navbar-expand-lg" style="margin-left: -10px">
                    <ul class="navbar-nav" id="menuOpciones">

                        <!-- Cargar Archivo -->
                        <li class="nav-item">
                            <form action="amarchivo.php" method="post">
                                <input type="hidden" name="ruta" value="<?php echo "archivos" ?>">
                                <input type="hidden" name="clave" value="0">
                                <button type="submit" class="btn btn-sm ml-3 p-2" style="border-radius: 10px; background: #d4cea3; color: #fff">
                                    <i class="fa fa-upload pl-4"></i>
                                    <span style="padding-right: 6px; margin-left: -4px">Subir Archivo</span>
                                </button>
                            </form>
                        </li>

                        <!-- Ordenar -->
                        <li class="nav-item dropdown ml-3">
                            <button type="button" class="btn btn-sm p-2" id="ordenar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 10px; background: white; border: 1px solid grey; color: #444">
                                <i class="fa fa-filter pl-4"></i>
                                <span>Ordenar</span>
                                <i class="fa fa-sort-down" style="padding-left: 25px; transform: translateY(-2px);"></i>
                            </button>

                            <div class="dropdown-menu mt-2" aria-labelledby="ordenar" id="ordenarDropdown" style="border-radius: 10px;">
                                <a href="./compartidos.php?carpeta=<?php echo $ruta; ?>&orden=nombre&direccion=descendente">
                                    <i class="fa fa-sort-alpha-down ml-2"></i>
                                    Nombre
                                </a>
                                <a href="./compartidos.php?carpeta=<?php echo $ruta; ?>&orden=nombre&direccion=ascendente">
                                    <i class="fa fa-sort-alpha-down-alt ml-2"></i>
                                    Nombre
                                </a>
                                <a href="./compartidos.php?carpeta=<?php echo $ruta; ?>&orden=tamaño&direccion=descendente">
                                    <i class="fa fa-sort-amount-up ml-2"></i>
                                    Tamaño
                                </a>
                                <a href="./compartidos.php?carpeta=<?php echo $ruta; ?>&orden=tamaño&direccion=ascendente">
                                    <i class="fa fa-sort-amount-down-alt ml-2"></i>
                                    Tamaño
                                </a>
                            </div>
                            <style>
                                #ordenarDropdown form>div>div {
                                    padding: 4px !important;
                                }

                                #ordenarDropdown a {
                                    display: block;
                                    padding: 10px 5px;
                                    color: grey;
                                }

                                #ordenarDropdown {
                                    padding: 0px 15px !important;
                                }
                            </style>
                        </li>
                    </ul>
                </nav>


                <ul class="list-group list-group-horizontal align-items-stretch flex-wrap text-center ft-explorer-grid-container border-0" id="contenido">

                    <?php
                    // Verifico si hay contenido en la carpeta
                    if ($contenido === null) {
                        echo '<h4 class="text-muted w-100 text-center m-4">No hay contenido</h4>';
                    } else {
                        // Indice para los IDs
                        $idElemento = 1;

                        // Recorremos el arreglo de archivos e insertamos un HTML correspondiente
                        foreach ($contenido as $archivo) {
                            // Insertamos html del archivo
                            echo $control->html_archivo($idElemento, $archivo);
                            $idElemento++;
                        }
                    }
                    ?>
                </ul>

                <style>
                    #contenido {
                        margin-left: -2px;
                    }

                    .custom-item {
                        width: 184px;
                        height: 140px;
                        padding: 0px 0px -4px 0px;
                        cursor: pointer;
                        font-weight: 500;
                    }

                    .custom-item .titulo {
                        color: #252525 !important;
                    }

                    .custom-item .icono {
                        transform: translateY(20px);
                    }

                    .custom-item:hover .opciones {
                        display: inline-block !important;
                    }

                    .custom-item img {
                        max-height: 100% !important;
                        max-width: 100% !important;
                        border-radius: 5px;
                        transform: translateX(-5px);
                    }

                    .custom-folder .icono {
                        color: #555;
                    }

                    ul a>i {
                        margin-left: -15px;
                        margin-right: 15px;
                    }

                    ul button>i {
                        margin-left: -14px;
                        margin-right: 14px;
                    }

                    ul .opciones {
                        position: fixed;
                        top: 0;
                        right: 0;
                    }

                    .custom-item.selected {
                        border: 1px solid #C6C8DF !important;
                        background: #E6E8F7 !important;
                    }

                    .custom-item.selected.archivo {
                        border: 1px solid #e0d6ca !important;
                        background: #f2efe4 !important;
                    }

                    ul>* {
                        border-radius: 10px !important;
                    }

                    #nuevaCarpetaDropdown {
                        width: 300px !important;
                        padding-bottom: 0px;
                    }

                    @media (max-width: 470px) {
                        ul .custom-item {
                            width: 100% !important;
                        }

                        .custom-item .opciones {
                            display: inline-block;
                        }
                    }

                    @media (max-width: 768px) {
                        ul .custom-item {
                            width: 46%;
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

        #menuOpciones {
            width: 100%;
        }

        #menuOpciones {
            float: left;
        }

        #menuOpciones button span {
            display: none;
        }

        #menuOpciones button .fa-sort-down {
            display: none;
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
include_once("estructura/pie.php");
?>