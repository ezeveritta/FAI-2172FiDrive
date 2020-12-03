<?php

$sitio_titulo = "Usuario - FAI-2172";
include_once("estructura/cabecera.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - usuario
///// File: /app/vistas/usuario.php
///// Date: 03/12/2020 - 15:08
///// Description:
////////// Vista donde el cliente puede registrarse en la base de datos como usuario.
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////


# Verifico si hay una sesión logeada
if (SessionControl::validar())
{
    header('Location: compartidos.php');
    die();
}

?>
<!-- Contenido -->
<div class="col-md-10 col-xs-12">
    <div class="row h-100">
        <div class="col-sm-12 my-3">

            <div class="w-100 mb-2 d-flex justify-content-center p-3" id="contenedor">

                <!-- Registrarse -->
                <div class="login w-75 pt-4 pb-5 px-5" id="card_registro">
                    <form action="accion/registro.php" method="post" class="form w-50 float-right">
                        <h3>Registro</h3>
                        <div class="form-group mt-3">
                            <h6><label class="" for="usuario">Nombre de usuario</label></h6>
                            <input type="text" name="usuario" class="form-control" id="usuario">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group mt-3">
                            <h6><label class="" for="nombre">Nombre</label></h6>
                            <input type="text" name="nombre" class="form-control" id="nombre">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group mt-3">
                            <h6><label class="" for="apellido">Apellido</label></h6>
                            <input type="text" name="apellido" class="form-control" id="apellido">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <h6><label class="" for="contraseña">Contraseña</label></h6>
                            <input type="text" name="contraseña" class="form-control" id="contraseña">
                            <div class="invalid-feedback"></div>
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


<style>
    #card_registro {
        background: url('../../publico/imagenes/bg-03.jpg');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        border-radius: 18px;
        box-shadow: 1px 6px 12px rgba(0,0,0,0.15);
    }
    @media (max-width: 576px) {
        #contenedor {
            width: 100% !important;
        }

        #menuOpciones {
            width: 100%;
        }

        #menuOpciones {
            float: left;
        }

        #menuOpciones button span {
            display: none;
        }

        #menuOpciones button .fa-sort-down {
            display: none;
        }
    }
</style>

<script>

</script>

<?php
include_once("estructura/pie.php");
?>