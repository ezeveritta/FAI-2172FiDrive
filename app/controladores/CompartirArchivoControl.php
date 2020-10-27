<?php
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 24/10/2020
 */

class CompartirArchivoControl
{
    private $ruta;
    private $error;

    /**
     * Esta función valida los datos del formulario
     * @param array $datos Contiene todos los datos provenientes del formulario
     * 
     * @return boolean
     */
    public function validar($datos)
    {
        if(!isset($datos['usuario']) || !isset($datos['vencimiento']) || !isset($datos['limite']))
        {
            $this->set_error('Uno ó más datos no se cargaron correctamente.');
            return false;
        }
        
        // Valido que el campo usuario esté seleccionado
        if (strlen($datos['usuario']) == 0)
        {
            $this->set_error('El campo "usuario" debe ser seleccionado.');
            return false;
        }
        
        // Validación correcta
        $this->set_error('');
        return true;
    }

    /**
     * Esta función actualiza la BD con la nueva información de compartir
     * @param array $datos Contiene todos los datos provenientes del formulario
     * 
     * @return boolean
     */
    public function cargar($datos)
    {
        // Definimos las variables para un uso mas cómodo
        $idArchivoCargadoEstado = $datos['id'];
        $usuario     = $datos['usuario'];
        $vencimiento = $datos['vencimiento'];
        $limite      = $datos['limite'];
        $contraseña  = (isset($datos['contraseña']) ? $datos['contraseña'] : '');
        $enlace      = $datos['enlace'];
        $fechaInicio = new DateTime();
        $fechaFin    = new DateTime();
        $fechaFin->add(new DateInterval("P{$vencimiento}D"));

        // Variables de este método
        $ArchivoCargado = new ArchivoCargado();
        $ArchivoCargadoEstado = new ArchivoCargadoEstado();

        // Buscamos el archivocargado y archivocargadoestado que queremos modificar
        $ArchivoCargadoEstado->buscar($idArchivoCargadoEstado);
        $ArchivoCargado = $ArchivoCargadoEstado->get_archivoCargado();

        // Guardo temporalmente para en caso de un error poder restablecer la información
        $respaldo_ArchivoCargado = $ArchivoCargado;

        // Completamos la información de la tabla archivocargado
        $ArchivoCargado->set_cantidadDescarga($limite);
        $ArchivoCargado->set_fechaInicioCompartir($fechaInicio->format("Y-m-d H:i:s"));
        $ArchivoCargado->set_fechaFinCompartir($fechaFin->format("Y-m-d H:i:s"));
        $ArchivoCargado->set_protegidoClave($contraseña);

        // Actualizamos archivocargado
        if (!$ArchivoCargado->modificar())
        {
            $this->set_error( $ArchivoCargado->get_error() );
            return false;
        }

        // Completamos la información de la tabla archivocargadoestado
        $ArchivoCargadoEstado->set_usuario($usuario);
        $ArchivoCargadoEstado->set_estadoTipos("2");
        $ArchivoCargadoEstado->set_descripcion("Archivo compartiendo");
        $ArchivoCargadoEstado->set_fechaIngreso($fechaInicio->format("Y-m-d H:i:s"));

        // Actualizamos archivocargadoestado
         if (!$ArchivoCargadoEstado->modificar())
        {
            $respaldo_ArchivoCargado->modificar();  // Reestablesco los valores originales
            $this->set_error( $ArchivoCargadoEstado->get_error() );
            return false;
        }

        //Operación exitosa
        $this->set_ruta( dirname($ArchivoCargado->get_linkAcceso()) );
        $this->set_error('');
        return true;
    }

     /**
     * Esta función retorna la información obtenida de las tablas "archivocargado" y "archivocargadoestado" segun la id
     * @param string $id idarchivocargadoestado
     * 
     * @return array 
     */
    public function get_info($datos)
    {
        $arreglo = null;

        // Modelos a usar
        $ArchivoCargadoEstado = new ArchivoCargadoEstado();
        $ArchivoCargado = new ArchivoCargado();

        // SI busco por ID
        if(isset($datos['id']))
        {
            // Busco registro en la tabla archivocargadoestado
            if (!$ArchivoCargadoEstado->buscar($datos['id']))
            {
                $this->set_error("No se encontró un registro con la id: {$datos['id']}");
                return false;
            }
            
            // Busco registro en la tabla archivocargado
            $idArchivoCargadoEstado = $ArchivoCargadoEstado->get_archivoCargado()->get_id();
            if (!$ArchivoCargado->buscar($idArchivoCargadoEstado))
            {
                $this->set_error("No se encontró un registro con la id: $idArchivoCargadoEstado");
                return false;
            }

        }

        // Si busco por ruta
        else
        {
            // Busco registro en la tabla archivocargado donde aclinkacceso es igual a la ruta pasada por parámetro
            if (!$ArchivoCargado->buscar($datos['archivo'], 'aclinkacceso'))
            {
                $this->set_error("No se encontró un registro del archivo: {$datos['archivo']}");
                return false;
            }

            // Busco registro en la tabla archivocargadoestado con el id encontrado previamente
            if (!$ArchivoCargadoEstado->buscar($ArchivoCargado->get_id()))
            {
                $this->set_error("No se encontró un registro perteneciente al id: {$ArchivoCargado->get_id()}");
                return false;
            }

        }

        // Si llegamos a éste punto, la operación fue exitosa
        // Completo el arreglo a retornar
        $arreglo['id'] = $ArchivoCargado->get_id();
        $arreglo['nombre'] = $ArchivoCargado->get_nombre();
        $arreglo['usuario'] = $ArchivoCargadoEstado->get_usuario()->get_id();
        $arreglo['contraseña'] = $ArchivoCargado->get_protegidoClave();
        $arreglo['limite'] = $ArchivoCargado->get_cantidadDescarga();
        $arreglo['enlace'] = $ArchivoCargado->get_linkAcceso();
        $arreglo['fechaFin'] = $ArchivoCargado->get_fechaFinCompartir();
        $this->set_error('');
        return $arreglo;
    }

    // Métodos de acceso
    public function get_ruta(){ return $this->ruta; }
    public function get_error(){ return $this->error; }
    public function set_ruta($data){ $this->ruta = $data; }
    public function set_error($data){ $this->error = $data; }
    public function __toString() 
    {
        return  "Objeto CompartirArchivocontrol:
                 <br> Error: $this->get_error()
                 <br> Ruta: $this->get_ruta()";
    }
}