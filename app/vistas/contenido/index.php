<?php 
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 07/10/2020
 */

$Titulo = "Contenido"; 
include_once("../estructura/cabecera.php");
include_once("../../controladores/ContenidoControl.php");

// Carpeta Actual
if (!isset($ruta))
    $ruta = "archivos";
$contenido = ContenidoControl::abrirDirectorio($ruta);

//print_r($archivos); // debug
?>

<!-- Contenido -->
<div class="col-md-10 col-xs-12">
    <div class="row h-100">
        <div class="col-sm-12 my-3">
            
            <div class="card card-block w-100 mx-auto mb-2" id="contenedor">

                <div class="w-100 mt-3 text-center">
                    <h3>Todo el Contenido</h3>
                </div>

                <nav class="navbar navbar-expand-lg navbar-light border-bottom pb-2">

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <!-- Nueva Carpeta -->
                            <li class="nav-item dropdown">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="nuevaCarpeta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Nueva carpeta</button>
                                
                                <div class="dropdown-menu" aria-labelledby="nuevaCarpeta" id="nuevaCarpetaDropdown">
                                    <form action="accion.php" method="post" class="">
                                        <div class="row px-2">
                                            <div class="form-group col-sm-8">
                                                <label for="nombre">Nombre de carpeta</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre">
                                            </div>
                                            <input type="hidden" name="ruta" value="<?php echo $ruta ?>">
                                            <div class="col-sm-4">
                                                <label for=""></label>
                                                <button type="submit" class="btn btn-success btn-block mt-2 w-100">Crear</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <!-- Cargar Archivo -->
                            <li class="nav-item">
                                <form action="../amarchivo" method="post">
                                    <input type="hidden" name="ruta" value="archivos">
                                    <input type="hidden" name="clave" value="0">
                                    <button type="submit" class="btn btn-default btn-sm ml-3">Subir Archivo</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="w-100 p-2 bg-light border-bottom">
                    <!-- Dirección -->
                    <div class="mr-3">
                        <?php 
                        // Separo la dirección por cada "/" y lo guardo en un array $links_filtro
                        $links = array_filter(explode('/',$ruta));

                        // Creo el link html de cada directorio
                        $out = array('<a href="accion.php?carpeta='.implode('/',$links).'/">'.basename($ruta).'</a>');
                        while((array_pop($links) and !empty($links))){
                            $out[] = '<a href="accion.php?carpeta='.implode('/',$links).'/">'.end($links).'</a>';
                        };
                        // Muestro los links ordenados
                        foreach(array_reverse($out) as $link)
                        {
                            echo '<i class="fa fa-chevron-right px-2"></i>
                                  '.$link;
                        }
                        ?>
                    </div>
                </div>

                <ul class="list-group list-group-horizontal align-items-stretch flex-wrap text-center ft-explorer-grid-container border-0">
                                        
                    <?php
                    // Verifico si hay contenido en la carpeta
                    if ($contenido === false)
                    {
                        echo '<h4 class="text-muted w-100 text-center m-4">No hay contenido</h4>';
                    } else {
                        // Indice para los IDs
                        $idItem = 1;
                        
                        // Recorremos el arreglo de carpetas e insertamos un HTML correspondiente
                        foreach($contenido["carpetas"] as $nombre)
                        {
                            echo '<li class="list-group-item d-flex flex-column justify-content-around border m-2 custom-folder bg-light">'
                                .   '<div class="h1"><i class="fa fa-folder"></i></div>'
                                .   '<div class="row mt-2">'
                                .       '<div class="col col-sm-10">'.$nombre.'</div>'
                                .       '<div class="col col-sm-2 dropdown">'
                                .           '<button type="button" class="float-right btn bg-transparent" id="item_'.$idItem.'_opciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                .           '<i class="fa fa-ellipsis-v"></i></button>'
                                .           '<div class="dropdown-menu" aria-labelledby="item_'.$idItem.'_opciones">'
                                .               '<div class="dropdown-item">'
                                .                   '<form action="accion.php" method="post">'
                                .                       '<input type="hidden" name="carpeta" value="'.$ruta.'/'.$nombre.'">'
                                .                       '<button type="submit" class="btn bg-transparent">Abrir</button>'
                                .                   '</form>'
                                .               '</div>'
                                .               '<div class="dropdown-item">'
                                .                   '<form action="../compartirarchivo" method="post">'
                                .                       '<input type="hidden" name="archivo" value="'.$ruta.'/'.$nombre.'">'
                                .                       '<button type="submit" class="btn bg-transparent">Compartir</button>'
                                .                   '</form>'
                                .               '</div>'
                                .               '<div class="dropdown-item">'
                                .                   '<form action="../eliminararchivo" method="post">'
                                .                       '<input type="hidden" name="archivo" value="'.$ruta.'/'.$nombre.'">'
                                .                       '<button type="submit" class="btn bg-transparent text-danger"><span>Eliminar</span></button>'
                                .                   '</form>'
                                .               '</div>'
                                .           '</div>'
                                .      '</div>'
                                .   "</div>"
                                . "</li>";
                            $idItem++;
                        }

                        // Recorremos el arreglo de archivos e insertamos un HTML correspondiente
                        foreach($contenido["archivos"] as $nombre)
                        {
                            // Obtenemos el tipo de archivo para mostrar el icono que le corresponde
                            $ext = pathinfo($ruta.'/'.$nombre)["extension"];
                            $tipo = tipo_archivo($ext);

                            // Escribimos el HTML
                            echo '<li class="list-group-item d-flex flex-column justify-content-around border m-2 custom-folder bg-light">';

                            // Si el archivo es una imagen, la mostramos en lugar de un icono
                            if ($tipo != "imagen")
                            {
                                echo   '<div class="h1"><i class="fa fa-'.icono_archivo($tipo).'"></i></div>';
                            } else {
                                echo '<div><img src="../../../'.$ruta.'/'.$nombre.'" class="img-fluid w-75"></img></div>';
                            }

                            echo   '<div class="row mt-2">
                                        <div class="col col-10">'.$nombre.'</div>
                                        <div class="col col-2 dropdown">
                                            <button type="button" class="float-right btn bg-transparent" id="item_'.$idItem.'_opciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="item_'.$idItem.'_opciones">
                                                <div class="dropdown-item">
                                                    <a href="../../../'.$ruta.'/'.$nombre.'" target="_blanck" class="btn bg-transparent">
                                                        Abrir
                                                    </a>
                                                </div>
                                                <div class="dropdown-item">
                                                    <form action="../compartirarchivo" method="post">
                                                        <input type="hidden" name="archivo" value="'.$ruta.'/'.$nombre.'">
                                                        <button type="submit" class="btn bg-transparent">Compartir</button>
                                                    </form>
                                                </div>
                                                <div class="dropdown-item">
                                                    <form action="../eliminararchivo" method="post">
                                                        <input type="hidden" name="archivo" value="'.$ruta.'/'.$nombre.'">
                                                        <button type="submit" class="btn bg-transparent text-danger"><span>Eliminar</span></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>';
                            $idItem++;
                        }
                    }
                    ?>
                </ul>

                <style>
                ul .custom-folder {
                    width: 18%;
                    padding: 0px 0px -4px 0px;
                }
                ul .opciones {
                    position: fixed;
                    top: 0;
                    right: 0;
                }
                #nuevaCarpetaDropdown {
                    width: 300px!important;
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
@media (max-width: 576px)
{ 
    #contenedor {
        width: 100%!important;
    }
}
</style>

<script>
    
    $(document).ready({

        
    });
</script>

<?php 
include_once("../estructura/pie.php");
?>
