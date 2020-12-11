<?php

# Configuración de la página
include_once("../../configuracion.php");
include_once("../../utiles/session.php");

# Verifico si hay una sesión logeada
if ($logueado)
{
    header('Location: compartidos.php');
    die();
}

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - usuario
///// File: /app/vistas/usuario.php
///// Date: 03/12/2020 - 15:08
///// Description:
////////// Vista donde el cliente puede registrarse en la base de datos como usuario.
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

# Configuración de la vista
$CONFIG["titulo"] = "Usuario - FAI-2172";
$CONFIG["cabecera"] = false;
$CONFIG["menu"] = false;
$CONFIG["pie"] = false;

# Inicio HTML
include_once("estructura/cabecera.php");

?>
        <!-- Contenido -->
        <div class="col-md-12 col-xs-12">
            <div class="h-100">
                <div class="justify-content-right">

                    <!-- Cabecera simple -->
                    <div class="d-block w-100 navbar navbar-light flex-md-nowrap p-3">
                        <div class="w-100 d-flex justify-content-center">
                            <div class="ml-5 pt-2">
                                <a href="login.php" class="text-white text-SansiteSwashed">FiDrive</a>
                            </div>
                            <div class="mr-3 pt-2">
                                <a href="https://github.com/ezeveritta/FAI-2172FiDrive" class="d-inline-block text-white ml-5 mr-3 text-SansiteSwashed">GitHub</a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex p-5 w-100 float-right" id="contenedor">

                        <!-- Registrarse -->
                        <div class="login pt-4 pb-5 px-5 mx-auto w-50" id="card_registro">
                            <form action="accion/registro.php" method="post" class="form">
                                <h3 class="text-center">Registro</h3>
                                <div class="row">
                                    <div class="form-group mt-3 col-sm-6">
                                        <h6><label class="" for="nombre">Nombre</label></h6>
                                        <input type="text" name="nombre" class="form-control" id="nombre">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group mt-3 col-sm-6">
                                        <h6><label class="" for="apellido">Apellido</label></h6>
                                        <input type="text" name="apellido" class="form-control" id="apellido">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group mt-1 col-sm-12">
                                        <h6><label class="" for="usuario">Nombre de usuario</label></h6>
                                        <input type="text" name="usuario" class="form-control" id="usuario">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <h6><label class="" for="contraseña">Contraseña</label></h6>
                                        <input type="text" name="contraseña" class="form-control" id="contraseña">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-larg w-100">Registrar</button>

                                <span class="mt-3 d-block text-center">
                                    ¿Ya tienes una cuenta? <a href="login.php" id="btn_registrar">Entrar</a>.
                                </span>
                            </form>
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
        background-image: url('../../publico/imagenes/bg-7.jpg');
        background-repeat: no-repeat;
        background-position: bottom;
        filter: grayscale(.2) brightness(1.1);
        background-size: cover;
        border: none!important;
    }

    #card_registro {
        backdrop-filter: blur(6px) brightness(1.1);
    }

    #card_registro {
        border-radius: 22px;
        box-shadow: 1px 6px 12px rgba(0,0,0,0.15);
    }

    @media (max-width: 576px) {
        #contenedor {
            width: 100% !important;
        }
    }
</style>

<script>

</script>

<?php
include_once("estructura/pie.php");
?>

