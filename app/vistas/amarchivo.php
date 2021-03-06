<?php
# Configuración de la página
include_once("../../configuracion.php");
include_once("../../utiles/session.php");
$datos = data_submitted();

# Cargo contenido
include_once("../modelos/EstadoTipos.php");
include_once("../modelos/ArchivoCargado.php");
include_once("../modelos/ArchivoCargadoEstado.php");
include_once("../controladores/AmarchivoControl.php");
$control = new AmarchivoControl();

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - amarchivo
///// File: /app/vistas/amarchivo.php
///// Date: 23/09/2020
///// Description:
////////// Vista donde el usuario puede dar de alta un archivo ó bien modificar uno existente
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////
// Verifico acceso a la vista //////////////////////////////////////////////////////////////////////
if (!$logueado)
{
    header('Location: login.php');
    die();
}

# Obtengo la información para utilizar en la página
$info = $control->get_info($datos, $usuario->get_id());

# Seteo esa info en variables para mayor comodidad
$ruta = $info['ruta'];
$nombre = $info['nombre'];
$descripcion = $info['descripcion'];
$icono = $info['icono'];
$clave = $info['clave'];
$id = $info['id'];

# Configuración de la vista
$CONFIG["titulo"] = "Alta-Modificación - FAI-2172";
$CONFIG["extensiones"]["summernote"] = true;

# Inicio HTML
include_once("estructura/cabecera.php");
echo get_aviso($datos); 
?>

        <!-- Contenido -->
        <div class="col-md-10 col-xs-12">
            <div class="row h-100">
                <div class="col-sm-12 my-3">

                    <div class="card card-block w-75 mx-auto" id="contenedor">
                        <form id="form_amarchivo" class="form w-100" action="accion/amarchivo.php" method="post" enctype="multipart/form-data" data-toggle="validator">
                            <div class="row p-3">
                                <?php
                                if ($clave == 0) {
                                ?>
                                    <h5 class="mt-3 text-center w-100">Alta de Archivo</h5>
                                    <div class="form-group col-sm-12">
                                        <h6><label class="" for="archivo">Selecciona un archivo</label></h6>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-inputl" id="archivo" name="archivo" required>
                                            <label class="custom-file-label border" for="archivo" id="archivo_label">Selecciona un archivo...</label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                <?php
                                } else {
                                ?>
                                <h5 class="mt-3 text-center w-100">Modificación de Archivo</h5>
                                <?php } ?>

                                <div class="form-group col-sm-8">
                                    <h6><label class="" for="nombre">Nombre de Archivo</label></h6>
                                    <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo ($clave != 0) ? $nombre : "1234.png" ?>">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <h6><label class="" for="usuario">Usuario</label></h6>
                                    <div class="border rounded form-control"><b><?php echo $usuario->get_login() ?></b></div>
                                    <input type="hidden" name="usuario" value="<?php echo $usuario->get_id() ?>">
                                </div>

                                <div class="form-group col-sm-12">
                                    <h6><label class="" for="descripcion">Descripción de Archivo</label></h6>
                                    <div class="border p-2">
                                        <?php $text = ($descripcion != null) ? $descripcion : '<p><b>Esta es una descripción genérica</b></p><p>si lo necesita la puede cambiar.</p>'; ?>
                                        <textarea name="descripcion" id="descripcion" class=""><?php echo $text; ?></textarea>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <h6 class="w-100"><b>Seleccione icono para usar</b></h6>

                                    <label for="icono_imagen" class="border rounded p-2 mr-2">
                                        <input type="radio" name="icono" value="imagen" id="icono_imagen" <?php if ($icono == 'imagen') echo 'checked'; ?>>
                                        <i class="fas fa-image"></i>
                                        Imagen
                                    </label>

                                    <label for="icono_zip" class="border rounded p-2 mr-2">
                                        <input type="radio" name="icono" value="zip" id="icono_zip" <?php if ($icono == 'zip') echo 'checked'; ?>>
                                        <i class="fas fa-file-archive"></i>
                                        Zip
                                    </label>

                                    <label for="icono_doc" class="border rounded p-2 mr-2">
                                        <input type="radio" name="icono" value="doc" id="icono_doc" <?php if ($icono == 'doc') echo 'checked'; ?>>
                                        <i class="fas fa-file-word"></i>
                                        Doc
                                    </label>

                                    <label for="icono_pdf" class="border rounded p-2 mr-2">
                                        <input type="radio" name="icono" value="pdf" id="icono_pdf" <?php if ($icono == 'pdf') echo 'checked'; ?>>
                                        <i class="fas fa-file-pdf"></i>
                                        PDF
                                    </label>

                                    <label for="icono_xls" class="border rounded p-2 mr-2">
                                        <input type="radio" name="icono" value="xls" id="icono_xls" <?php if ($icono == 'xls') echo 'checked'; ?>>
                                        <i class="fas fa-file"></i>
                                        XLS
                                    </label>

                                    <div class="invalid-feedback"></div>
                                </div>

                                <?php $accion = ($clave == "0") ? "Alta" : "Modificar" ?>
                                <input type="hidden" name="accion" id="accion" value="<?php echo $accion ?>">
                                <input type="hidden" name="ruta" value="<?php echo $ruta ?>">
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-lg mt-3 mb-3 w-100">Enviar</button>
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
    .custom-file-label::after {
        content: "Seleccione un archivo";
    }

    @media (max-width: 576px) {
        #contenedor {
            width: 100% !important;
        }
    }
</style>

<script>
    $(document).ready(function() {

        // Cuando se selecciona un archivo
        $("#archivo").change(function() {
            var ext = $(this).val().split('.').pop().toLowerCase();
            var nombre = $(this).val().split('\\').pop();

            // Seteamos el input nombre
            $("#nombre").val(nombre);
            $("#archivo_label").html(nombre);

            // Seteamos el radio correspondiente
            // Imagen
            if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "gif" || ext == "svg" || ext == "webp" || ext == "bpm" || ext == "tiff") {
                $('#icono_imagen').prop('checked', true);
            } else

                // Documento
                if (ext == "doc" || ext == "docx" || ext == "odt" || ext == "rtf" || ext == "txt" || ext == "docm" || ext == "dot" || ext == "dotx" || ext == "dotm") {
                    $('#icono_doc').prop('checked', true);
                } else

                    // PDF
                    if (ext == "pdf") {
                        $('#icono_pdf').prop('checked', true);
                    } else

                        // XLS
                        if (ext == "xls" || ext == "xlsx" || ext == "xlsm" || ext == "xltx" || ext == "xlt" || ext == "ods") {
                            $('#icono_xls').prop('checked', true);
                        } else

                            // ZIP
                            if (ext == "zip" || ext == "rar" || ext == "7z" || ext == "tar" || ext == "hz" || ext == "bin") {
                                $('#icono_zip').prop('checked', true);
                            }
        });

        $('#descripcion').summernote({
            lang: 'es-ES',
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<?php
include_once("estructura/pie.php");
?>