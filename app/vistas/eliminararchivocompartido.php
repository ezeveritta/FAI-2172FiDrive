<?php 

$sitio_titulo = "Eliminar Archivo Compartido - FAI-2172";
include_once("estructura/cabecera.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - eliminararchivocompartido
///// File: /app/vistas/estructura/eliminararchivocompartido.php
///// Date: 23/09/2020
///// Description:
////////// Vista donde el usuario puede eliminar la capacidad de compartir de un archivo
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

// Verifico si el cliente está logeado
if (!$loggeado)
{
    header('Location: login.php');
    die();
}

// Errores, alertas, exitos
echo get_aviso($datos);
?>

<div class="col-md-10">
    <div class="row h-100">
        <div class="col-sm-12 my-5">
            
            <div class="card card-block w-75 mx-auto" id="contenedor">
                <form class="form w-100" action="accion.php" method="post" enctype="multipart/form-data">
                    <div class="row p-4">
                        <h4 class="text-center w-100 pb-3">Eliminar las opciones de compartir un Archivo</h4>

                        
                        <div class="form-group mt-2 col-sm-6 col-xs-12">
                            <h6><label class="">Nombre de Archivo</label></h6>
                            <div class="border rounded form-control"><b>1234.png</b></div>
                        </div>

                        <div class="form-group mt-2 col-sm-6 col-xs-12">
                            <h6><label class="">Cantidad de veces compartido</label></h6>
                            <div class="border rounded form-control"><b>32</b></div>
                        </div>

                        <div class="form-group mt-2 col-sm-12">
                            <h6><label class="" for="usuario">Usuario</label></h6>
                            <select name="usuario" id="usuario" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="visitante">Visitante</option>
                                <option value="usted">usted</option>
                            </select>
                        </div>

                        <div class="form-group mt-2 col-sm-12">
                            <h6><label class="" for="motivo">Motivo de ya no compartir</label></h6>
                            <textarea name="motivo" id="motivo" class="form-control" rows="6" style="min-height:55px"></textarea>
                        </div>

                        <div class="col-sm-12 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Guardar</button>
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
