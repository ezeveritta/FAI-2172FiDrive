<?php

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 23/10/2020
 */

class ArchivoCargadoEstado
{
    private $id;                    // int(11) PRIMARY KEY
    private $descripcion;           // text
    private $fechaIngreso;          // timestamp
    private $fechaFin;              // timestamp
    private $EstadoTipos;           // int(11) Objeto EstadoTipo a partir del ID
    private $Usuario;               // int(11) Objeto Usuario a partir del ID
    private $ArchivoCargado;        // int(11) Objeto EstadoTipo a partir del ID
    // Extras
    private $error;

    public function __construct()
    {
        $this->id = "";
        $this->descripcion = "";
        $this->fechaIngreso = "";
        $this->fechaFin = "";
        $this->EstadoTipos = new EstadoTipos();
        $this->Usuario = new Usuario();
        $this->ArchivoCargado = new ArchivoCargado();
        $this->error = null;
    }

    /**
     * Esta función es para cargar al objeto de información
     * @param string $descripcion, $fechaIngreso, $fechaFin, $EstadoTipos, $Usuario, $ArchivoCargado === Datos instancias de la BD
     */
    public function cargar($descripcion, $fechaIngreso, $fechaFin, $EstadoTipos, $Usuario, $ArchivoCargado)
    {
        $this->set_descripcion($descripcion);
        $this->set_fechaIngreso($fechaIngreso);
        $this->set_fechaFin($fechaFin);

        $this->set_estadoTipos($EstadoTipos);
        $this->set_usuario($Usuario);
        $this->set_archivoCargado($ArchivoCargado);
    }

    /**
     * Función para buscar datos desde la base de datos según un id dado
     * @param int $id
     * 
     * @return boolean
     */
    public function buscar($id = '', $where = '')
    {
        $bd = new BaseDatos();
        $query = "SELECT * from archivocargadoestado ";
        if ($id != '')
            $query .= "where idarchivocargadoestado=$id";
        if ($where != '')
            $query .= "where $where";

        $output = false;

        // Inicio conexión con bd
        if ($bd->Iniciar()) {
            // Ejecuto la consulta
            if ($bd->Ejecutar($query)) {
                // Recupero la información
                if ($row2 = $bd->Registro()) {
                    $this->set_id($row2['idarchivocargadoestado']);
                    $this->set_descripcion($row2['acedescripcion']);
                    $this->set_fechaIngreso($row2['acefechaingreso']);
                    $this->set_fechaFin($row2['acefechafin']);
                    $this->set_estadoTipos($row2['idestadotipos']);
                    $this->set_usuario($row2['idusuario']);
                    $this->set_archivoCargado($row2['idarchivocargado']);
                    $output = true;
                }
            } else {
                $this->set_error($bd->getError());
            }
        } else {
            $this->set_error($bd->getError());
        }
        return $output;
    }

    /**
     * Retornar toda la información de la base de datos
     * @param string $where
     * @param string $order
     * @return array
     */
    public static function listar($where = "", $order = "idarchivocargadoestado")
    {
        $listaArchivosCargadosEstado = null;
        $query = "Select * from archivocargadoestado";

        if ($where != "")
            $query = $query . ' where ' . $where;

        $query .= " order by " . $order;

        // Iniciamos conexión con bd
        $bd = new BaseDatos();
        if ($bd->Iniciar()) {
            // Ejecutamos la consulta
            if ($bd->Ejecutar($query)) {
                $listaArchivosCargadosEstado = array();
                while ($row2 = $bd->Registro()) {
                    $id = $row2['idarchivocargadoestado'];
                    $descripcion = $row2['acedescripcion'];
                    $fechaIngreso = $row2['acefechaingreso'];
                    $fechaFin = $row2['acefechafin'];
                    $idEstadoTipos = $row2['idestadotipos'];
                    $idUsuario = $row2['idusuario'];
                    $idArchivoCargado = $row2['idarchivocargado'];

                    // Creamos el nuevo objeto Usuario con los datos obtenidos
                    $tmpArchivoCargadoEstado = new ArchivoCargadoEstado();
                    $tmpArchivoCargadoEstado->set_id($id);
                    $tmpArchivoCargadoEstado->cargar($descripcion, $fechaIngreso, $fechaFin, $idEstadoTipos, $idUsuario, $idArchivoCargado);
                    // Agregamos al arreglo
                    array_push($listaArchivosCargadosEstado, $tmpArchivoCargadoEstado);
                }
            } else {
                $listaArchivosCargadosEstado = "Error al consultar Base de Datos.";
            }
        } else {
            $listaArchivosCargadosEstado = "Error al conectar con la Base de Datos.";
        }

        return $listaArchivosCargadosEstado;
    }


    /**
     * Funcion para insertar los datos del objeto a la base de datos
     * @return boolean
     */
    public function insertar()
    {
        $bd     = new BaseDatos();
        $output = false;
        $query  = "INSERT INTO archivocargadoestado(acedescripcion, acefechaingreso, acefechafin, idestadotipos, idusuario, idarchivocargado)
				   VALUES ('" . $this->get_descripcion() . "','" . $this->get_fechaIngreso() . "','" . $this->get_fechaFin()
            . "'," . $this->get_estadoTipos()->get_id() . "," . $this->get_usuario()->get_id() . "," . $this->get_archivoCargado()->get_id() . ")";

        // Iniciamos conexión
        if ($bd->Iniciar()) {
            // Ejecutamos consulta
            if ($id = $bd->Ejecutar($query)) {
                $this->set_id($id);
                $output = true;
            } else {
                $this->set_error($bd->getError());
            }
        } else {
            $this->set_error($bd->getError());
        }

        return $output;
    }

    /**
     * Esta función modifica los datos de la bd según las variables instancias
     * @return boolean
     */
    public function modificar()
    {
        $output = false;
        $bd = new BaseDatos();
        $query = "UPDATE archivocargadoestado SET acedescripcion='" . $this->get_descripcion()
            . "',acefechaingreso='" . $this->get_fechaIngreso()
            . "',acefechafin='" . $this->get_fechaIngreso()
            . "',idestadotipos=" . $this->get_estadoTipos()->get_id()
            . ",idusuario=" . $this->get_usuario()->get_id()
            . ",idarchivocargado=" . $this->get_archivoCargado()->get_id()
            . " WHERE idarchivocargadoestado=" . $this->get_id();
        // Iniciamos conexión
        if ($bd->Iniciar()) {
            // Ejecutamos consulta
            if ($bd->Ejecutar($query)) {
                $output = true;
            } else {
                $this->set_error($bd->getError());
            }
        } else {
            $this->set_error($bd->getError());
        }

        return $output;
    }

    /**
     * Con ésta función eliminamos una tupla según la id.
     * @return boolean
     */
    public function eliminar()
    {
        $bd = new BaseDatos();
        $output = false;

        // Iniciamos conexión
        if ($bd->Iniciar()) {
            $query = "DELETE FROM archivocargadoestado WHERE idarchivocargadoestado=" . $this->get_id();

            // Ejecutamos consulta
            if ($bd->Ejecutar($query)) {
                $output = true;
            } else {
                $this->set_error($bd->getError());
            }
        } else {
            $this->set_error($bd->getError());
        }

        return $output;
    }


    /**
     * Metodos de Acceso
     */
    public function get_id() { return $this->id; }
    public function get_descripcion() { return $this->descripcion; }
    public function get_fechaIngreso() { return $this->fechaIngreso; }
    public function get_fechaFin() { return $this->fechaFin; }
    public function get_estadoTipos() { return $this->EstadoTipos; }
    public function get_usuario() { return $this->Usuario; }
    public function get_archivoCargado() { return $this->ArchivoCargado; }
    public function get_error() { return $this->error; }
    
    public function set_id($data) { $this->id = $data; }
    public function set_descripcion($data) { $this->descripcion = $data; }
    public function set_fechaIngreso($data) { $this->fechaIngreso = $data; }
    public function set_fechaFin($data) { $this->fechaFin = $data; }
    public function set_estadoTipos($data) { $this->EstadoTipos->buscar($data); }
    public function set_usuario($data) { $this->Usuario->buscar($data); }
    public function set_archivoCargado($data) { $this->ArchivoCargado->buscar($data); }
    public function set_error($data) { $this->error = $data; }

    public function __toString()
    {
        return "<b>Objeto ArchivoCargadoEstado: </b>"
            . "<br>id: " . $this->get_id()
            . "<br>descripción: " . $this->get_descripcion()
            . "<br>fechaIngreso: " . $this->get_fechaIngreso()
            . "<br>fechaFin: " . $this->get_fechaFin()
            . "<br>EstadoTipos: " . $this->get_estadoTipos()
            . "<br>Usuario: " . $this->get_usuario()
            . "<br>ArchivoCargado: " . $this->get_archivoCargado();
    }
}
