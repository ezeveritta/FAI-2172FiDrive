<?php
# Configuración de la página
include_once("../../configuracion.php");
include_once("../../utiles/session.php");
$datos = data_submitted();

# Cargo clases a utilizar
include_once("../modelos/EstadoTipos.php");
include_once("../modelos/ArchivoCargado.php");
include_once("../modelos/ArchivoCargadoEstado.php");
include_once("../controladores/CompartirArchivoControl.php");
$control = new CompartirArchivoControl();

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - compartirarchivo
///// File: /app/vistas/compartirarchivo.php
///// Date: 23/09/2020
///// Description:
////////// Vista donde el usuario puede compartir un archivo
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////
// Verifico acceso a la vista //////////////////////////////////////////////////////////////////////
if (!$logueado)
{
    header('Location: login.php');
    die();
}

# Si no hay identificador del archivo, vuelvo a la vista "compartidos"
if ( !isset($datos['id']) ) {
    header( "Location: compartidos.php?error=Se esperaba un identificador." );
    die;
}

# Verifico que se encontró un registro en la BD
if (null === $info = $control->get_info($datos)) {
    header( "Location: compartidos.php?error={$control->get_error()}" );
    die;
}

# Defino variables para mayor comodidad
$id          = $info['id'];
$nombre      = nombreArchivo($info['nombre']);
$user        = $info['usuario'];
$limite      = $info['limite'];
$contraseña  = $info['contraseña'];
$enlace      = $info['enlace'];
$date        = new DateTime($info['fechaFin']);
$vencimiento = ($info['fechaFin'] != '0000-00-00 00:00:00') ? $date->diff(new DateTime('now'))->format("%d") : '0';

# Configuración de la vista
$CONFIG["titulo"] = "Compartir Archivo - FAI-2172";
$CONFIG["extensiones"]["md5"] = true;

# Inicio HTML
include_once("estructura/cabecera.php");

# Elemento 'alerta'
echo get_aviso($datos);
?>
        <!-- Contenido -->
        <div class="col-md-10">
            <div class="row h-100">
                <div class="col-sm-12 my-5">

                    <div class="card card-block w-75 mx-auto" id="contenedor">
                        <form class="form w-100" action="accion/compartirarchivo.php" method="post" enctype="multipart/form-data">
                            <div class="row p-4">
                                <h4 class="text-center w-100 pb-3">Compartir Archivo</h4>

                                <div class="form-group mt-2 col-sm-6">
                                    <h6><label class="">Nombre de Archivo</label></h6>
                                    <div class="border rounded form-control"><b><?php echo $nombre ?></b></div>
                                </div>

                                <div class="form-group mt-2 col-sm-6">
                                    <h6><label class="" for="usuario">Usuario</label></h6>
                                    <div class="border rounded form-control"><b><?php echo $user ?></b></div>
                                    <input type="hidden" name="usuario" value="<?php echo $usuario->get_id() ?>">
                                </div>

                                <div class="form-group mt-2 col-sm-6">
                                    <h6><label class="" for="vencimiento">Cantidad de días a compartir</label></h6>
                                    <input type="number" name="vencimiento" class="form-control" id="vencimiento" placeholder="Cantidad de días disponibles." value="<?php echo $vencimiento; ?>">
                                </div>

                                <div class="form-group mt-2 col-sm-6">
                                    <h6><label class="" for="limite">Limite de descargas</label></h6>
                                    <input type="number" name="limite" class="form-control" id="limite" placeholder="Cantidad de descargas disponibles." value="<?php echo $limite ?>">
                                </div>


                                <div class="input-group mt-2 col-sm-12">
                                    <h6 class="w-100">Proteger con contraseña</h6>
                                    <div class="input-group-prepend">
                                        <label for="proteger" class="input-group-text">
                                            <input type="checkbox" data-toggle="input" name="proteger" id="proteger" aria-label="Checkbox for following text input" class="mr-2" <?php if ($contraseña != '') echo "checked"; ?>>
                                            Proteger
                                        </label>
                                    </div>
                                    <input type="text" id="contraseña" name="contraseña" <?php echo ($contraseña == '') ? 'disabled="disabled"' : 'value="' . $contraseña . '"'; ?> class="form-control" placeholder="Ingrese contraseña" aria-label="Text input with checkbox">
                                    <div id="seguridad"></div>
                                </div>



                                <div class="form-group mt-5 col-sm-12">
                                    <h6><label class="">Enlace para compartir</label></h6>
                                    <div class="border rounded form-control">
                                        <?php if ($enlace != '') { ?>
                                            <a href="https://localhost/FAI2172-FiDrive/app/vistas/descargar.php?linkacceso=<?php echo $enlace ?>" target="_blank" id="enlace" class="col col-11 block"><?php echo 'https://fidrive.fai2172/descargar.php?linkacceso=' . $enlace; ?></a>
                                        <?php } else { 
                                            ?>
                                            <a href="#" target="_blank" id="enlace" class="col col-11 block"></a>
                                        <?php } ?>
                                        <input type="hidden" name="enlace" id="enlace_input" value="<?php echo $enlace ?>">
                                    </div>
                                </div>

                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <div class="col-sm-4 mt-1">
                                    <button type="button" class="border btn btn-default btn-lg w-100" id="btnHash">Generar Hash</button>
                                </div>

                                <div class="col-sm-8 mt-1">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
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
        // Verificar seguridad de contraseña
        $("#contraseña").keyup(function() {

        });

        // Generar un hash
        $("#btnHash").on('click', function() {
            var nombreDeArchivo = "<?php echo $nombre; ?>",
                cantidadDescargas = $("#limite").val(),
                cantidadDias = $("#vencimiento").val(),
                valor = "9007199254740991";

            var hashLink = (cantidadDias != "0" || cantidadDescargas != "0") ?
                CryptoJS.MD5(nombreDeArchivo + cantidadDescargas + cantidadDias).toString() :
                CryptoJS.MD5(nombreDeArchivo + valor).toString();

            $("#enlace").html('<a href="https://localhost/FAI2172-FiDrive/app/vistas/descargar.php?linkacceso=' + hashLink + '" target="_blanck">https://localhost/descargar.php?linkacceso=' + hashLink + '</a>');
            $("#enlace_input").val(hashLink);
        });
    });

    $(document).ready(function(){

        // Cambiar uso del input "contraseña"

        $("#proteger").click(function(){
          
            if(!this.checked)
            {
              $("#contraseña").attr('disabled', 'disabled');
            } else{
              $("#contraseña").removeAttr('disabled');
            }
        });

        // Integrar editor texto summernote
        $('#descripcion').summernote({
          airMode: true
        });
      });
</script>


<?php
include_once("estructura/pie.php");
?>