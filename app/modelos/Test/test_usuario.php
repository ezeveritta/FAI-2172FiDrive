<?php

include_once('../BaseDatos.php');
include_once('../Usuario.php');

/////////////////////////////////////////////////////
/* MÉTODO: BUSCAR

$U = new Usuario();
$U->buscar('1');

echo "<br><br>" . $U->__toString(); */

/////////////////////////////////////////////////////
/* MÉTODO: INSERTAR

$U = new Usuario();
$U->cargar('prueba', 'test', 'logg', 'unaclaveindesifrablemd5', '0');

echo "<br><br>" . $U->insertar(); */

/////////////////////////////////////////////////////
/* MÉTODO: MODIFICAR 

$U = new Usuario();
$U->buscar('3');
$U->set_nombre('testmodificar');

echo "<br><br>" . $U->modificar(); */

/////////////////////////////////////////////////////
/* MÉTODO: ELIMINAR 

$U = new Usuario();
$U->buscar('3');

echo "<br><br>" . $U->eliminar();  */

/////////////////////////////////////////////////////
/* MÉTODO: LISTAR */
$Us = Usuario::listar();

foreach($Us as $u)
{ 
    echo "<br><br>" . $u->__toString();
}