<?php

include_once('../BaseDatos.php');
include_once('../ArchivoCargadoEstado.php');

/////////////////////////////////////////////////////
/* MÉTODO: BUSCAR

$ACE = new ArchivoCargadoEstado();
$ACE->buscar('1');

echo "<br><br>" . $ACE; */

/////////////////////////////////////////////////////
/* MÉTODO: INSERTAR

$ACE = new ArchivoCargadoEstado();
$ACE->cargar('pruebadescripción', '1999-12-21', '2014-11-12', '1', '2', '1');

echo "<br><br>" . $ACE->insertar();*/

/////////////////////////////////////////////////////
/* MÉTODO: MODIFICAR */

$ACE = new ArchivoCargadoEstado();
$ACE->buscar('1');
$ACE->set_descripcion('testmodificar');

echo "<br><br>" . $ACE->modificar();

/////////////////////////////////////////////////////
/* MÉTODO: ELIMINAR 

$ACE = new ArchivoCargadoEstado();
$ACE->buscar('2');

echo "<br><br>" . $ACE->eliminar(); */

/////////////////////////////////////////////////////
/* MÉTODO: LISTAR */
$ACE = ArchivoCargadoEstado::listar();

foreach($ACE as $ace)
{ 
    echo "<br><br>" . $ace->__toString();
}