<?php 
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 23/09/2020
 */

$Titulo = "Compartir Archivo"; 
include_once("../estructura/cabecera.php");

$hayArchivo = isset($_POST["archivo"]);
if ($hayArchivo)
    $file = $_POST["archivo"];

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
                            <div class="border rounded form-control"><b><?php echo ($hayArchivo) ? $file : "1234.png"?></b></div>
                        </div>

                        <div class="form-group mt-2 col-sm-6">
                            <h6><label class="" for="usuario">Usuario</label></h6>
                            <select name="usuario" id="usuario" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="visitante">Visitante</option>
                                <option value="usted">usted</option>
                            </select>
                        </div>

                        <div class="form-group mt-2 col-sm-6">
                            <h6><label class="" for="vencimiento">Vencimiento</label></h6>
                            <input type="number" name="vencimiento" class="form-control" id="vencimiento" placeholder="Cantidad de días disponibles.">
                        </div>

                        <div class="form-group mt-2 col-sm-6">
                            <h6><label class="" for="limite">Limite de descargas</label></h6>
                            <input type="number" name="limite" class="form-control" id="limite" placeholder="Cantidad de descargas disponibles.">
                        </div>


                        <div class="input-group mt-2 col-sm-12">
                            <h6 class="w-100">Proteger con contraseña</h6>
                            <div class="input-group-prepend">
                                <label for="proteger" class="input-group-text">
                                    <input type="checkbox" data-toggle="input" name="proteger" id="proteger" aria-label="Checkbox for following text input" class="mr-2">
                                    Proteger
                                </label>
                            </div>
                            <input type="text" id="contraseña" disabled="disabled" class="form-control" placeholder="Ingrese contraseña" aria-label="Text input with checkbox">
                        </div>

                        <div class="form-group mt-5 col-sm-12">
                            <h6><label class="">Enlace para compartir</label></h6>
                            <div class="border rounded form-control"><a href="#" target="_blank" rel="noopener noreferrer">Abrir enlace</a></div>
                        </div>

                        <div class="col-sm-4 mt-1">
                            <button type="button" class="border btn btn-default btn-lg w-100">Generar Hash</button>
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

<?php 
include_once("../estructura/pie.php");
?>
