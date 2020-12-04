<?php

include_once("../../modelos/Usuario.php");
include_once("../../modelos/BaseDatos.php");
include_once("../../controladores/SessionControl.php");
include_once("../../../configuracion.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - login
///// File: /app/vistas/accion/login.php
///// Date: 27/11/2020 - 15:02
///// Description:
////////// Acción para buscar en la BD si los datos pasados por post/Get pertenecen a una cuenta
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

// Datos del formulario
$datos = data_submitted();

// Verifico los datos del formulario
if (!isset($datos['usuario']) || !isset($datos['contraseña']))
{
    header('Location: ../login.php?error=Datos+no+proporcionados!');
    die();
}

// Control
$session = new SessionControl();

// Verifico si hay una sesión activa
if ($session->validar())
{
    header('Location: ../compartidos.php');
    die();
}

// Valido los datos en la BD
if ($session->entrar($datos['usuario'], $datos['contraseña']))
{
    header('Location: ../compartidos.php');
    die();
}

// No se logró iniciar session, vuelvo a login.php
header('Location: ../login.php?error=Usuario+no+encontrado!');
die();