<?php
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 24/10/2020
 */

class CompartirArchivoControl
{
    private $ruta;

    /**
     * Esta función
     * @param array $datos Contiene todos los datos provenientes del formulario
     * 
     * @return boolean
     */
    public function validar($datos)
    {
        $operacion = false;

        // Verificamos los datos
        if (isset($datos['id']))
            $operacion = true;

        return $operacion;
    }

    /**
     * Esta función
     * @param array $datos Contiene todos los datos provenientes del formulario
     * 
     * @return boolean
     */
    public function cargar($datos)
    {
        // Definimos las variables para un uso mas cómodo
        $idACE = $datos['id'];
        $usuario = $datos['usuario'];
        $vencimiento = $datos['vencimiento'];
        $limite = $datos['limite'];
        $contraseña = $datos['contraseña'];
        $enlace = $datos['enlace'];
        $dateTime = new DateTime();

        // Variables de este método
        $operacion = false;
        $AC = new ArchivoCargado();
        $ACE = new ArchivoCargadoEstado();

        $ACE->buscar($idACE);
        $AC->buscar($ACE->get_archivoCargado()->get_id());

        // Completamos la información de la tabla archivocargado
        // idarchivocargado, acnombre, acdescripcion, acicono, idusuario, aclinkacceso, accantidaddescarga, accantidadusada, acfechainiciocompartir
        // acefechafincompartir, acprotegidoclave
        $AC->set_cantidadDescarga($limite);
        $AC->set_fechaInicioCompartir($dateTime->format("Y-m-d H:i:s"));
        $AC->set_fechaFinCompartir($dateTime->add(new DateInterval('P'.$vencimiento.'D')));
        $AC->set_protegidoClave($contraseña);

        // Intentamos modificar db archivocargado
        if ($AC->modificar())
        {
            // Completamos la información de la tabla archivocargadoestado
            $ACE->set_usuario($usuario);
            $ACE->set_estadoTipos("2");
            $ACE->set_descripcion("una descripción que no me acuerdo que poner...");
            $ACE->set_fechaIngreso($dateTime->format("Y-m-d H:i:s"));
            
            // Intentamos modificar db
            if ($ACE->modificar())
            {
                $operacion = true;
                $this->set_ruta($AC->get_linkAcceso());
            } else { echo $ACE->get_error(); }

        } else { echo $AC->get_error(); }

        return $operacion;
    }

     /**
     * Esta función retorna la información obtenida de las tablas "archivocargado" y "archivocargadoestado" segun la id
     * @param string $id idarchivocargadoestado
     * 
     * @return array 
     */
    public function get_info($id)
    {
        $arreglo = null;

        // Modelos a usar
        $ACE = new ArchivoCargadoEstado();
        $AC = new ArchivoCargado();

        if ($ACE->buscar($id))
        {
            if ($AC->buscar($ACE->get_archivoCargado()->get_id()))
            {
                $arreglo['nombre'] = $AC->get_nombre();
                $arreglo['usuario'] = $ACE->get_usuario()->get_id();
                $arreglo['contraseña'] = $AC->get_protegidoClave();
                $arreglo['limite'] = $AC->get_cantidadDescarga();
                $arreglo['enlace'] = $AC->get_linkAcceso();
                $arreglo['fechaFin'] = $AC->get_fechaFinCompartir();
            }
        }
        return $arreglo;
    }

    // Métodos de acceso
    public function get_ruta(){ return $this->ruta; }
    public function set_ruta($data){ $this->ruta = $data; }
}