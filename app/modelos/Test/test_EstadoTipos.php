<?php

include_once('../BaseDatos.php');
include_once('../EstadoTipos.php');

/////////////////////////////////////////////////////
/* MÉTODO: BUSCAR

$U = new Usuario();
$U->buscar('1');

echo "<br><br>" . $U->__toString(); */

/////////////////////////////////////////////////////
/* MÉTODO: INSERTAR

$ET = new EstadoTipos();
$ET->cargar('descripción test', '1');

echo "<br><br>" . $ET->insertar(); */

/////////////////////////////////////////////////////
/* MÉTODO: MODIFICAR 

$ET = new EstadoTipos();
$ET->buscar('6');
$ET->set_descripcion('testmodificar');

echo "<br><br>" . $ET->modificar(); */

/////////////////////////////////////////////////////
/* MÉTODO: ELIMINAR 

$ET = new EstadoTipos();
$ET->buscar('6');

echo "<br><br>" . $ET->eliminar(); */

/////////////////////////////////////////////////////
/* MÉTODO: LISTAR */
$ET = EstadoTipos::listar();

foreach($ET as $et)
{ 
    echo "<br><br>" . $et->__toString();
}