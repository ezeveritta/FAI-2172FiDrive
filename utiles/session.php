<?php

include_once('../controladores/SessionControl.php');
include_once('../../utiles/funciones.php');
include_once("../modelos/BaseDatos.php");
include_once("../modelos/Usuario.php");
include_once("../modelos/UsuarioRol.php");
include_once("../modelos/Rol.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - session
///// File: /utiles/session.php
///// Date: 10/12/2020 16:10
///// Description:
////////// Éste archivo inicia una session y setea la info común de cada vista
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

# Controlador de sesión
$session = new SessionControl();

# Variables a utilizar en las vistas
$esAdmin  = false;
$logueado = false;

# Si está logeado, obtengo la información principal del usuario
if ($session->validar())
{
    $logueado = true;
    // Datos del usuario
    $idusuario  = $session->get_idUsuario();
    $usuario    = $session->get_usuario();
    $esAdmin    = $session->esAdministrador();
}
?>