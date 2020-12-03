<?php 

include_once('../../../utiles/funciones.php');
include_once('../../modelos/BaseDatos.php');
include_once("../../modelos/Usuario.php");
include_once('../../modelos/UsuarioRol.php');
include_once('../../modelos/Rol.php');
include_once("../../controladores/RegistroControl.php");
include_once("../../controladores/SessionControl.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - registro
///// File: /app/vistas/accion/registro.php
///// Date: 03/12/2020
///// Description:
////////// Acción para el formulario de registro de usuario nuevo
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

$control = new RegistroControl();

// Información del formulario
$datos = data_submitted();

// Valido la informaciónd el formulario
if ( !$control->validar($datos) )
{
    header("Location: ../usuario.php?error={$control->get_error()}");
    die();
}

// Registro en la base de datos
if ( !$control->registrar($datos) )
{
    header("Location: ../usuario.php?error={$control->get_error()}");
    die();
}

// Inicio session
$session = new SessionControl();

// Valido los datos en la BD
if ($session->entrar($datos['usuario'], $datos['contraseña']))
{
    header('Location: ../compartidos.php?exito=Bienvenido+:)');
    die();

}

// No se logró iniciar session, vuelvo a login.php
$mensaje = "Usuario registrado! Ya puedes inciar sessión.";
header("Location: ../login.php?aviso=$mensaje");
die();