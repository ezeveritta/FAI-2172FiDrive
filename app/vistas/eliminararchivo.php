<?php
# Configuración de la página
include_once("../../configuracion.php");
include_once("../../utiles/session.php");
$datos = data_submitted();

# Cargo contenido
include_once("../modelos/EstadoTipos.php");
include_once("../modelos/ArchivoCargado.php");
include_once("../modelos/ArchivoCargadoEstado.php");
include_once("../controladores/EliminarArchivoControl.php");
$control = new EliminarArchivoControl();

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - amarchivo
///// File: /app/vistas/eliminararchivo.php
///// Date: 30/09/2020
///// Description:
////////// Vista donde el usuario puede eliminar un archivo
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
    header("Location: compartidos.php?error=Se esperaba un identificador.");
    die;
}

#  Verifico que se encontró un registro en la BD
if ( null === $info = $control->get_info($datos) ) {
    header("Location: contenido.php?error={$control->get_error()}");
    die;
}

# Defino variables para mayor comodidad
$idArchivoCargado       = $info['idArchivoCargado'];
$idArchivoCargadoEstado = $info['idArchivoCargadoEstado'];
$archivo = $info['archivo'];
$nombre  = nombreArchivo($info['nombre']);
$user  = $info['usuario'];

# Configuración de la vista
$CONFIG["titulo"] = "Eliminar Archivo - FAI-2172";

# Inicio HTML
include_once("estructura/cabecera.php");
echo get_aviso($datos); 
?>

<!-- Contenido -->
<div class="col-md-10">
    <div class="row h-100">
        <div class="col-sm-12 my-5">

            <div class="card card-block w-75 mx-auto" id="contenedor">
                <form name="eliminarArchivo" id="eliminarArchivo" class="form w-100" action="accion/eliminararchivo.php" method="post" data-toggle="validator">
                    <div class="row p-4">
                        <h4 class="text-center w-100 pb-3">Eliminar las opciones de compartir un Archivo</h4>

                        <div class="form-group mt-2 col-sm-6">
                            <h6><label class="">Nombre de Archivo</label></h6>
                            <div class="border rounded form-control"><b><?php echo ($nombre) ? $nombre : "1234.png" ?></b></div>
                        </div>

                        <div class="form-group mt-2 col-sm-6">
                            <h6><label class="" for="usuario">Usuario</label></h6>
                            <div class="border rounded form-control"><b><?php echo $user ?></b></div>
                            <input type="hidden" name="usuario" value="<?php echo $usuario->get_id() ?>">
                        </div>

                        <div class="form-group mt-2 col-sm-12">
                            <h6><label class="" for="motivo">Motivo de eliminación</label></h6>
                            <textarea name="motivo" id="motivo" class="form-control" rows="6" style="min-height:55px" autofocus require></textarea>
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
    @media (max-width: 576px) {
        #contenedor {
            width: 100% !important;
        }
    }
</style>

<?php
include_once("estructura/pie.php");
?>