<?php 
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 23/09/2020
 */

$Titulo = "Alta-Mod Archivo"; 
include_once("../estructura/cabecera.php");

$hayArchivo = isset($_POST["archivo"]);
$hayRuta = isset($_POST["ruta"]);
if ($hayArchivo)
    $file = $_POST["archivo"];
if ($hayRuta)
    $ruta = $_POST["ruta"];

?>

<?php
    // Si hay un archivo cargado..
    if( isset($_FILES["archivo"]))
    {
        $clave = 1; // Modificación
        $ext = pathinfo($_FILES["archivo"], PATHINFO_EXTENSION);
        echo $ext;
    }
?>

<!-- Contenido -->
<div class="col-md-10 col-xs-12">
    <div class="row h-100">
        <div class="col-sm-12 my-3">
            
            <div class="card card-block w-75 mx-auto" id="contenedor">
                <form id="form_amarchivo" class="form w-100" action="accion.php" method="post" enctype="multipart/form-data" data-toggle="validator">
                    <div class="row p-3">
                        <h5 class="mt-3 text-center w-100">Alta - Modificación de Archivo</h5>

                        <?php
                        if(!$hayArchivo)
                        {
                        ?>
                        <div class="form-group col-sm-12">
                            <h6><label class="" for="archivo">Selecciona un archivo</label></h6>
                            <div class="custom-file">
                                <input type="file" class="custom-file-inputl" id="archivo" required>
                                <label class="custom-file-label border" for="archivo" id="archivo_label">Selecciona un archivo...</label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <div class="form-group col-sm-8">
                            <h6><label class="" for="nombre">Nombre de Archivo</label></h6>
                            <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo ($hayArchivo) ? $file : "1234.png" ?>">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group col-sm-4">
                            <h6><label class="" for="usuario">Usuario</label></h6>
                            <select name="usuario" id="usuario" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="visitante">Visitante</option>
                                <option value="usted">usted</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group col-sm-12">
                            <h6><label class="" for="descripcion">Descripción de Archivo</label></h6>
                            <div class="border p-2">
                                <textarea name="descripcion" id="descripcion" class=""><p><b>Esta es una descripción genérica</b></p><p>si lo necesita la puede cambiar.</p></textarea>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group col-sm-12">
                            <h6 class="w-100"><b>Seleccione icono para usar</b></h6>
                            
                            <label for="icono_imagen" class="border rounded p-2 mr-2">
                                <input type="radio" name="icono" value="imagen" id="icono_imagen">
                                <i class="fas fa-image"></i>
                                Imagen
                            </label>
                            
                            <label for="icono_zip" class="border rounded p-2 mr-2">
                                <input type="radio" name="icono" value="zip" id="icono_zip">
                                <i class="fas fa-file-archive"></i>
                                Zip
                            </label>

                            <label for="icono_doc" class="border rounded p-2 mr-2">
                                <input type="radio" name="icono" value="doc" id="icono_doc">
                                <i class="fas fa-file-word"></i>
                                Doc
                            </label>

                            <label for="icono_pdf" class="border rounded p-2 mr-2">
                                <input type="radio" name="icono" value="pdf" id="icono_pdf">
                                <i class="fas fa-file-pdf"></i>
                                PDF
                            </label>

                            <label for="icono_xls" class="border rounded p-2 mr-2">
                                <input type="radio" name="icono" value="xls" id="icono_xls">
                                <i class="fas fa-file"></i>
                                XLS
                            </label>

                            <div class="invalid-feedback"></div>
                        </div>
                        
        
                        <input type="hidden" name="accion" id="accion" value="<?php echo $clave ?>">
                        <input type="hidden" name="ruta" value="<?php echo $ruta?>">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-lg mt-3 mb-3 w-100">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<style>
.custom-file-label::after{
    content: "Seleccione un archivo";
}
@media (max-width: 576px)
{ 
    #contenedor {
        width: 100%!important;
    }
}
</style>

<script>
    $(document).ready(function () {

        // Cuando se selecciona un archivo
        $("#archivo").change(function () {
            var ext = $(this).val().split('.').pop().toLowerCase();
            var nombre = $(this).val().split('\\').pop();

            // Seteamos el input nombre
            $("#nombre").val(nombre);
            $("#archivo_label").html(nombre);

            // Seteamos el radio correspondiente
            // Imagen
            if(ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "gif" || ext == "svg" || ext == "webp" || ext == "bpm" || ext == "tiff")
            {
                $('#icono_imagen').prop('checked', true);
            } else
            // Documento
            if(ext == "doc" || ext == "docx" || ext == "odt" || ext == "rtf" || ext == "txt" || ext == "docm" || ext == "dot" || ext == "dotx" || ext == "dotm")
            {
                $('#icono_doc').prop('checked', true);
            } else
            // PDF
            if(ext == "pdf")
            {
                $('#icono_pdf').prop('checked', true);
            } else
            // XLS
            if(ext == "xls" || ext == "xlsx" || ext == "xlsm" || ext == "xltx" || ext == "xlt" || ext == "ods")
            {
                $('#icono_xls').prop('checked', true);
            } else
            // ZIP
            if(ext == "zip" || ext == "rar" || ext == "7z" || ext == "tar" || ext == "hz" || ext == "bin")
            {
                $('#icono_zip').prop('checked', true);
            }
        });

    });
</script>


<?php 
include_once("../estructura/pie.php");
?>
