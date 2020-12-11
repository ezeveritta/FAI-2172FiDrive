<?php

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 04/12/2020 - 15:24
 */

class DescargaControl
{
    private $info;
    private $error;

    public function __construct()
    {
        $this->error = '';
    }

    /**
     * Esta función obtiene todo el contenido de la base de datos que tiene estado "compartido"
     * @param string $hash  : parámetro 'aclinkacceso' para encontrar en la BD
     * @return boolean
     */
    public function info($hash)
    {
        # Inicio los modelos a utilizar
        $ArchivoCargado = new ArchivoCargado();
        $ArchivoCargadoEstado = new ArchivoCargadoEstado();

        # Busco ArchivoCargado
        if ( !$ArchivoCargado->buscar('', "aclinkacceso='$hash'") ) {
            $this->set_error( $ArchivoCargado->get_error() );
            return false;
        }
        
        # Busco ArchivoCargadoEstado
        if ( !$ArchivoCargadoEstado->buscar('', "idarchivocargado={$ArchivoCargado->get_id()}") ) {
            $this->set_error( $ArchivoCargadoEstado->get_error() );
            return false;
        }

        # Retorno un arreglo
        $info = [
            "usuario" => $ArchivoCargado->get_usuario()->get_login(),
            "usuario_activo" => $ArchivoCargado->get_usuario()->get_activo(),
            "nombre" => nombreArchivo( $ArchivoCargado->get_nombre() ),
            "path" => $ArchivoCargado->get_nombre(),
            "estadoTipo" => $ArchivoCargadoEstado->get_estadoTipos()->get_id(),
            "descripcion" => $ArchivoCargado->get_descripcion(),
            "fechaInicioCompartir" => $ArchivoCargado->get_fechaInicioCompartir(),
            "fechaFinCompartir" => $ArchivoCargado->get_fechaFinCompartir(),
            "cantidadDescarga" => $ArchivoCargado->get_cantidadDescarga(),
            "cantidadUsada" => $ArchivoCargado->get_cantidadUsada(),
            "clave" => $ArchivoCargado->get_protegidoClave()
        ];

        $this->set_info($info);

        # Compruebo si se puede descargar

        if ($info["usuario_activo"] != "1") {
            $this->set_error( "La cuenta del dueño del archivo ha sido desactivada." );
            return false;
        }

        if ($info["estadoTipo"] != "2") {
            $this->set_error( "El archivo no está siendo compartido." );
            return false;
        }

        $date = new DateTime();
        $fecha_actual = $date->format('Y-m-d H:i:s');
        
        if ( $info["fechaFinCompartir"] != $info["fechaInicioCompartir"])
        {
            if ($fecha_actual > $info["fechaFinCompartir"]) {
                $this->set_error( "El tiempo para descargar expiró." );
                return false;
            }
        }
        
        if ( $info["cantidadDescarga"] != '0' )
        {
            if ($info["cantidadDescarga"] < $info["cantidadUsada"])
            {
                $this->set_error( "Se alcanzó el límite de descargas." );
                return false;
            }
        }

        return true;
    }


    /**
     * Métodos de Acceso
     */
    public function get_error() { return $this->error; }
    public function get_info() { return $this->info; }
    public function set_error($data) { $this->error = $data; }
    public function set_info($data) { $this->info = $data; }

    public function __toString()
    {
        return "Objeto ContenidoControl:
                <br> Error: {$this->get_error()}";
    }
}
