<?php

include_once("../../controladores/SessionControl.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - logout
///// File: /app/vistas/accion/logout.php
///// Date: 27/11/2020 - 16:40
///// Description:
////////// Acción para cerrar la sesión
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

// Cierro sesión
$session = new SessionControl();
$session->cerrar();

header('Location: ../login.php');
die();