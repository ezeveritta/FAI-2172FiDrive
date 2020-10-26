<?php 
$Titulo = "Compartir Archivo"; 
include_once("../estructura/cabecera.php");
include_once("../../controladores/CompartirArchivoControl.php");
include_once("../../modelos/BaseDatos.php");
include_once("../../modelos/Usuario.php");
include_once("../../modelos/ArchivoCargado.php");
include_once("../../modelos/ArchivoCargadoEstado.php");

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 23/09/2020
*/

// Obtengo data
$datos = data_submitted();

// SI NO HAY UN CAMPO "id" REGRESO A LA PÁGINA "contenido"
if (!isset($datos['id']) && !isset($datos['archivo']))
{
    header('Location: ../contenido');
    die;
}
// PERO SI ESTÁ EL VALOR, PROSIGO CON EL FORMULARIO
else
{
    // Creo el controlador para manejar los datos
    $control = new CompartirArchivoControl();

    // Obtengo la información que se usará en la página
    $info = $control->get_info($datos);

    // Defino las variables a utilizar en la página
    if ($info != null)
    {
    $id = $info['id'];
    $nombre = $info['nombre'];
    $usuario = $info['usuario'];
    $limite = $info['limite'];
    $contraseña = $info['contraseña'];
    $enlace = $info['enlace'];
    // cantidad días
    $date = new DateTime($info['fechaFin']);
    $vencimiento = $date->diff(new DateTime('now'))->format("%d");
    ?>

    <!-- Contenido -->
    <div class="col-md-10">
        <div class="row h-100">
            <div class="col-sm-12 my-5">
                
                <div class="card card-block w-75 mx-auto" id="contenedor">
                    <form class="form w-100" action="accion.php" method="post" enctype="multipart/form-data">
                        <div class="row p-4">
                            <h4 class="text-center w-100 pb-3">Compartir Archivo</h4>

                            <div class="form-group mt-2 col-sm-6">
                                <h6><label class="">Nombre de Archivo</label></h6>
                                <div class="border rounded form-control"><b><?php echo $nombre ?></b></div>
                            </div>

                            <div class="form-group mt-2 col-sm-6">
                                <h6><label class="" for="usuario">Usuario</label></h6>
                                <select name="usuario" id="usuario" class="form-control">
                                    <?php
                                    foreach (Usuario::listar() as $user)
                                    {
                                        $selected = ($user->get_id() == $usuario) ? 'selected="selected"' : '';
                                        echo '<option value="'.$user->get_id().'" '.$selected.'>'.$user->get_apellido().'</option>';
                                    }
                                    ?>
                                </select>
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
                                <input type="text" id="contraseña" name="contraseña" <?php echo ($contraseña == '') ? 'disabled="disabled"' : 'value="'.$contraseña.'"'; ?> class="form-control" placeholder="Ingrese contraseña" aria-label="Text input with checkbox">
                                <div id="seguridad"></div>
                            </div>

                            

                            <div class="form-group mt-5 col-sm-12">
                                <h6><label class="">Enlace para compartir</label></h6>
                                <div class="border rounded form-control">
                                    <?php if ($enlace != '') { ?>
                                    <a href="https://localhost/FAI2172-FiDrive/<?php echo $enlace; ?>" target="_blank" id="enlace" class="col col-11 block"><?php echo 'https://localhost/'.$enlace; ?></a>
                                    <?php } else { ?>
                                    <a href="#" target="_blank" id="enlace" class="col col-11 block"></a>
                                    <?php } ?>
                                    <input type="hidden" name="enlace" id="enlace_input" value="">
                                </div>
                            </div>

                            <input type="hidden" name="id" value="<?php echo $datos["id"] ?>">
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


    <style>
    @media (max-width: 576px)
    { 
        #contenedor {
            width: 100%!important;
        }
    }
    </style>

    <script>
    $(document).ready(function(){
        // Verificar seguridad de contraseña
        $("#contraseña").keyup(function(){
            
        });

        // Generar un hash
        $("#btnHash").on('click', function(){
            var nombreDeArchivo   = "<?php echo $nombre; ?>",
                cantidadDescargas = $("#limite").val(),
                cantidadDias      = $("#vencimiento").val(),
                valor = "9007199254740991";

            var hashLink = (cantidadDias != "0"|| cantidadDescargas != "0") 
                        ? CryptoJS.MD5(nombreDeArchivo + cantidadDescargas + cantidadDias).toString()
                        : CryptoJS.MD5(nombreDeArchivo + valor).toString();
            
            $("#enlace").html('<a href="https://localhost/FAI2172-FiDrive/'+hashLink+'" target="_blanck">https://localhost/'+hashLink+'</a>');
            $("#enlace_input").val(hashLink);
        });
    });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>

<?php
    include_once("../estructura/pie.php");  
}
}
?>
