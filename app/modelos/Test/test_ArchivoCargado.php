<?php

include_once('../BaseDatos.php');
include_once('../ArchivoCargado.php');
include_once('../Usuario.php');

/////////////////////////////////////////////////////
/* MÉTODO: BUSCAR 

$U = new Usuario();
$U->buscar('1');

echo "<br><br>" . $U->__toString(); */

/////////////////////////////////////////////////////
/* MÉTODO: INSERTAR 

$AC = new ArchivoCargado();
$AC->cargar('test3', 'desc', 'iconazo', 'linkaazo', '4', '13', '2015-12-05 12:35', '2021-12-13 13:14:15', '1324658791', '2');

echo "<br><br>" . $AC->insertar();*/

/////////////////////////////////////////////////////
/* MÉTODO: MODIFICAR 

$AC = new ArchivoCargado();
$AC->buscar('1');
$AC->set_nombre('testmodificar');

echo "<br><br>" . $AC->modificar();*/

/////////////////////////////////////////////////////
/* MÉTODO: ELIMINAR 

$AC = new ArchivoCargado();
$AC->buscar('1');

echo "<br><br>" . $AC->eliminar();  */

/////////////////////////////////////////////////////
/* MÉTODO: LISTAR */
$AC = ArchivoCargado::listar();

foreach($AC as $ac)
{ 
    echo "<br><br>" . $ac->__toString();
}