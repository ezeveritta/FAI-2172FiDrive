<?php 
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 23/09/2020
 */

$Titulo = "Alta-Mod Archivo"; 
include_once("../estructura/cabecera.php");
?>

<!-- Contenido -->
<div class="col-md-10 col-xs-12">
    <div class="row h-100">
        <div class="col-sm-12 my-3">
            
            <div class="card card-block w-75 mx-auto" id="contenedor">
                <form class="form w-100" action="accion.php" method="post" enctype="multipart/form-data">
                    <div class="row p-3">
                        <h5 class="mt-3 text-center w-100">Alta - Modificación de Archivo</h5>

                        <div class="form-group col-sm-8">
                            <h6><label class="" for="nombre">Nombre de Archivo</label></h6>
                            <input type="text" name="nombre" class="form-control" id="nombre" value="1234.png">
                        </div>

                        <div class="form-group col-sm-4">
                            <h6><label class="" for="usuario">Usuario</label></h6>
                            <select name="usuario" id="usuario" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="visitante">Visitante</option>
                                <option value="usted">usted</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-12">
                            <h6 class="w-100">Seleccione icono para usar</h6>
                            
                            <label for="icono_imagen" class="border rounded p-2 mr-2">
                                <input type="checkbox" name="icono_imagen" id="icono_imagen">
                                <i class="fas fa-image"></i>
                                Imagen
                            </label>
                            
                            <label for="icono_zip" class="border rounded p-2 mr-2">
                                <input type="checkbox" name="icono_zip" id="icono_zip">
                                <i class="fas fa-file-archive"></i>
                                Zip
                            </label>

                            <label for="icono_doc" class="border rounded p-2 mr-2">
                                <input type="checkbox" name="icono_doc" id="icono_doc">
                                <i class="fas fa-file-word"></i>
                                Doc
                            </label>

                            <label for="icono_pdf" class="border rounded p-2 mr-2">
                                <input type="checkbox" name="icono_pdf" id="icono_pdf">
                                <i class="fas fa-file-pdf"></i>
                                PDF
                            </label>

                            <label for="icono_xls" class="border rounded p-2 mr-2">
                                <input type="checkbox" name="icono_xls" id="icono_xls">
                                <i class="fas fa-file"></i>
                                XLS
                            </label>
                        </div>
                        

                        <div class="form-group col-sm-12">
                            <h6><label class="" for="clave">Clave de Archivo</label></h6>
                            <input type="password" name="clave" class="form-control" id="clave">
                        </div>

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
@media (max-width: 576px)
{ 
    #contenedor {
        width: 100%!important;
    }
}
</style>


<?php 
include_once("../estructura/pie.php");
?>
