<?php

# Configuración de la página
include_once("../../configuracion.php");
$CONFIG["titulo"] = "Descargar Archivo - FAI-2172";
$CONFIG["menu"] = false;
$CONFIG["pie"] = false;

# Cargo contenido
include_once("estructura/cabecera.php");
include_once("../modelos/EstadoTipos.php");
include_once("../modelos/ArchivoCargado.php");
include_once("../modelos/ArchivoCargadoEstado.php");
include_once("../controladores/DescargaControl.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - descargar
///// File: /app/vistas/descargar.php
///// Date: 04/12/2020 - 15:13
///// Description:
////////// Vista donde el cliente puede descargar un archivo que fue compartido
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

# obtengo data de POST/GET
$datos = data_submitted();

if (isset($datos['linkacceso']))
{
    $control = new DescargaControl();
    $habilitado = false;

    # obtengo información a mostrar
    $habilitado = $control->info($datos['linkacceso']);
    $info = $control->get_info();
}
?>

        <!-- Contenido -->
        <div class="col-md-12 col-xs-12">
            <div class="h-100">
                <div class="">

                    <div class="d-flex p-5 w-100" id="contenedor">

                        <div class="pt-4 pb-5 px-5 w-100 d-flex justify-content-center" id="card_descargar">
                            <!-- Buscar Archivo -->
                            <?php if (!isset($datos['linkacceso'])) { ?>

                            <form action="accion/descargar.php" method="post" class="form w-75 text-center">
                                <h3>Descargar Archivo</h3>

                                <div class="form-group">
                                    <h6><label class="" for="contraseña">Link del archivo</label></h6>
                                    <input type="text" name="hash" class="form-control" id="hash">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-larg w-100">Buscar Archivo</button>
                            </form>

                            <!-- Descargar Archivo -->
                            <?php } else { ?>
                            
                            <form action="accion/descargar.php" method="post" class="form w-75 text-center">
                                <?php if (!$habilitado) { ?>
                                <div class="alert alert-danger d-block mt-2 text-center" role="alert">
                                    <?php echo $control->get_error() ?>
                                </div>
                                <?php } ?>
                                <div class="row mt-3">
                                    <!-- imagen -->
                                    <div class="col-sm-4">
                                        <?php
                                            $extension   = pathinfo($info["nombre"])["extension"];
                                            $tipoArchivo = tipo_archivo($extension);

                                            echo ($tipoArchivo == 'imagen')
                                                ? "<div class=\"h-75 mb-2\"><img src=\"../../archivos/{$info['path']}\" id=\"archivo_imagen\"></img></div>"
                                                : "<div class=\"h1 h-75 icono\"><i class=\"fa fa-{icono_archivo($tipoArchivo)}\"></i></div>";
                                        ?>
                                    </div>
                                    <!-- info -->
                                    <div class="col-sm-8 text-left d-flex flex-column">
                                        <ul style="list-style-type: none">
                                            <?php
                                                echo "
                                                    <li><b>Nombre:</b> {$info['nombre']}</li>
                                                    <li><b>Usuario:</b> {$info['usuario']}</li>
                                                    <li><b>Descripción:</b> {$info['descripcion']}</li>
                                                "
                                            ?>
                                        </ul>
                                        <?php  if ($habilitado) {?>
                                        <button type="submit" class="mt-auto btn btn-primary btn-larg w-100">Descargar</button>
                                        <?php } else { ?>
                                        <button type="submit" class="mt-auto btn btn-primary btn-larg w-100" disabled="disabled">Descarga no disponible</button>
                                        <?php } ?>
                                    </div>
                                </div>
                                
                            </form>

                            <style>
                                #archivo_imagen {
                                    width: 100%;
                                }
                            </style>

                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    #master {
        transform: translateY(6px);
        background-image: url('../../publico/imagenes/bg-1.jpg');
        background-repeat: no-repeat;
        background-position: bottom;
        filter: grayscale(.2) brightness(1.1);
        background-size: cover;
        border: none!important;
    }

    #card_descargar {
        backdrop-filter: blur(6px) brightness(1.1);
    }

    #card_descargar {
        border-radius: 22px;
        box-shadow: 1px 6px 12px rgba(0,0,0,0.15);
    }
</style>

<script>

</script>

<?php
include_once("estructura/pie.php");
?>