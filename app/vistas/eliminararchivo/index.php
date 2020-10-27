<?php 

$Titulo = "Alta-Mod Archivo"; 
include_once("../estructura/cabecera.php");
include_once('../../modelos/BaseDatos.php');
include_once("../../modelos/Usuario.php");
include_once('../../modelos/ArchivoCargado.php');
include_once('../../modelos/ArchivoCargadoEstado.php');
include_once("../../controladores/EliminarArchivoControl.php");

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 30/09/2020
 */

$control = new EliminarArchivoControl();
$datos = data_submitted();

// Si no hay identificador del archivo, vuelvo a la vista "contenido"
if (!isset($datos['id']) && !isset($datos['archivo']))
{
    header("Location: ../contenido/index.php?error=Se esperaba un identificador.");
    die;
}

// Obtengo información de
$info = $control->get_info($datos);

// Verifico que se encontró un registro en la BD
if ($info == null)
{
    echo "..";
    //header("Location: ../contenido/index.php?error={$control->get_error()}");
    die;
}

// Defino variables para mayor comodidad
$idArchivoCargado = $info['idArchivoCargado'];
$idArchivoCargadoEstado = $info['idArchivoCargadoEstado'];
$archivo = $info['archivo'];
$nombre = $info['nombre'];
?>
<!-- Contenido -->
<div class="col-md-10">
    <div class="row h-100">
        <div class="col-sm-12 my-5">
            
            <div class="card card-block w-75 mx-auto" id="contenedor">
                <form name="eliminarArchivo" id="eliminarArchivo" class="form w-100" action="accion.php" method="post" data-toggle="validator">
                    <div class="row p-4">
                        <h4 class="text-center w-100 pb-3">Eliminar las opciones de compartir un Archivo</h4>

                        <div class="form-group mt-2 col-sm-12">
                            <h6><label class="">Nombre de Archivo</label></h6>
                            <div class="border rounded form-control"><b><?php echo ($nombre) ? $nombre : "1234.png"?></b></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group mt-2 col-sm-12">
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
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group mt-2 col-sm-12">
                            <h6><label class="" for="motivo">Motivo de eliminación</label></h6>
                            <textarea name="motivo" id="motivo" class="form-control" rows="6" style="min-height:55px"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <input type="hidden" name="idArchivoCargadoEstado" value="<?php echo $idArchivoCargadoEstado ?>">
                        <input type="hidden" name="idArchivoCargado" value="<?php echo $idArchivoCargado ?>">
                        <input type="hidden" name="archivo" value="<?php echo $archivo ?>">
                        <div class="col-sm-12 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Eliminar</button>
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
