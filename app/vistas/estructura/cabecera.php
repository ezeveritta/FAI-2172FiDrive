<?php

include_once('../controladores/SessionControl.php');
include_once('../../utiles/funciones.php');
include_once("../modelos/BaseDatos.php");
include_once("../modelos/Usuario.php");
include_once("../modelos/UsuarioRol.php");
include_once("../modelos/Rol.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - cabecera
///// File: /app/vistas/estructura/cabecera.php
///// Date: //2020
///// Description:
////////// Header común para usar en las vistas.
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

$session = new SessionControl();

$esAdmin  = false;
$logueado = false;

# Si está logeado, obtengo la información principal del usuario
if ($session->validar())
{
    $logueado = true;
    // Datos del usuario
    $idusuario  = $session->get_idUsuario();
    $usuario    = $session->get_usuario();
    //$rol        = $session->get_rol();
    $esAdmin    = $session->esAdministrador();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?PHP echo $CONFIG["titulo"] ?></title>

    <!-- Dependencias -->
    <script src="../../publico/js/jquery/jquery-3.5.1.min.js"></script>
    <script src="../../publico/js/popper/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="../../publico/js/bootstrap/bootstrap.bundle.min.js"></script>


    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../publico/css/bootstrap/bootstrap.min.css">
    <script src="../../publico/js/bootstrap/bootstrapValidator.js"></script>

    <!-- Iconos -->
    <link rel="stylesheet" href="../../publico/css/iconos/all.min.css">

    <!-- Fuentes -->
    <style>
        .text-SansiteSwashed {
            font-size: 1.3em;
            font-family: SansitaSwashed;
        }
        @font-face {
            font-family: SansitaSwashed;
            src: url('../../publico/css/fuentes/SansitaSwashed-Medium.ttf');
        }
    </style>

    <?php
    if ($CONFIG['extensiones']['summernote']) 
    { ?>
        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <?php
    } 
    ?>

</head>

<body style="height: 100vh">

    <?php
    # Cargo cabecera
    if ($CONFIG["cabecera"]) { ?>

    <div class="navbar navbar-light bg-white flex-md-nowrap p-1 text-light" style="box-shadow: 3px 0px 8px rgba(0,0,0,0.1)">
        <div class="w-100 d-flex justify-content-between">
            <div class="">
                <h5 class="ml-5 pt-2"><a href="login.php" class="text-muted" style="font-family: SansitaSwashed">FiDrive</a></h5>
            </div>
            <div class="mr-3 pt-2">
                <?php
                if ($logueado)
                {
                    if ($esAdmin)
                    {
                ?>

                <!-- opciones de administrador -->
                <div class="nav_usuario d-inline-block">
                    <li class="dropdown">
                        <a class="dropdown-toggle text-muted" href="#" id="menu_usuario" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Panel administrador
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="menu_usuario">
                            <a class="dropdown-item" href="abmusuario.php">
                                <i class="fa fa-users pr-2"></i>
                                ABM Usuarios
                            </a>
                        </div>
                    </li>
                </div>

                <?php } ?>

                <!-- opciones de cuenta -->
                <div class="nav_usuario d-inline-block">
                    <li class="dropdown">
                        <a class="dropdown-toggle text-dark" href="#" id="menu_usuario" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @<?php echo $usuario->get_login() ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="menu_usuario">
                            <a class="dropdown-item" href="contenido.php">
                                <i class="fa fa-folder-open pr-2"></i>
                                Contenido
                            </a>
                            <a class="dropdown-item" href="compartidos">
                                <i class="fa fa-share-alt pr-2"></i>
                                Compartidos
                            </a>
                            <a class="dropdown-item" href="amarchivo">
                                <i class="fa fa-file-upload pr-2"></i>
                                Subir Archivo
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="accion/logout.php">
                                <i class="fa fa-sign-out-alt pr-2"></i>
                                Cerrar Sesión
                            </a>
                        </div>
                    </li>
                </div>

                <?php 
                } 
                ?>
                <a href="https://github.com/ezeveritta/FAI-2172FiDrive" class="d-inline-block text-muted ml-5 mr-3">GitHub</a>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- Contenido -->
    <div class="container-fluid mt-3" id="master" style="border-radius: 15px; border: 1px solid #ddd; width: calc(100% - 40px); height: auto!important; min-height: 85vh;">
        <div class="row" style="height: auto; min-height: 80vh;">

    <?php
    # Cargo menú lateral
    if ($CONFIG["menu"]) 
    {
        include_once("menu.php");
    }
    ?>