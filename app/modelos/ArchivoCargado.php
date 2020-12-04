<?php

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 23/10/2020
 */

include_once('Usuario.php');

class ArchivoCargado
{
    private $id;                    // int(11)
    private $nombre;                // varchar(150)
    private $descripcion;            // text
    private $icono;                 // varchar(150)
    private $linkAcceso;             // text
    private $cantidadDescarga;      // int(11)
    private $cantidadUsada;         // int(11)
    private $fechaInicioCompartir;  // timestamp
    private $fechaFinCompartir;     // timestamp
    private $protegidoClave;        // text
    private $Usuario;               // Objeto Usuario a partir del ID
    // Extras
    private $error;

    public function __construct()
    {
        $this->id = "";
        $this->nombre = "";
        $this->descripcion = "";
        $this->icono = "";
        $this->linkAcceso = "";
        $this->cantidadDescarga = "";
        $this->cantidadUsada = "";
        $this->fechaInicioCompartir = "";
        $this->fechaFinCompartir = "";
        $this->protegidoClave = "";
        $this->Usuario = new Usuario();
        $this->error = null;
    }

    /**
     * Esta función es para cargar al objeto de información
     * @param string $id, $nombre, $descripcion, $icono, $linkAcceso, $cantidadDescarga Datos instancias de la BD
     */
    public function cargar($nombre, $descripcion, $icono, $linkAcceso, $cantidadDescarga, $cantidadUsada, $fechaInicioCompartir, $fechaFinCompartir, $protegidoClave, $usuario)
    {
        $this->set_nombre($nombre);
        $this->set_descripcion($descripcion);
        $this->set_icono($icono);
        $this->set_linkAcceso($linkAcceso);
        $this->set_cantidadDescarga($cantidadDescarga);
        $this->set_cantidadUsada($cantidadUsada);
        $this->set_fechaInicioCompartir($fechaInicioCompartir);
        $this->set_fechaFinCompartir($fechaFinCompartir);
        $this->set_protegidoClave($protegidoClave);
        $this->set_usuario($usuario);
    }

    /**
     * Función para buscar datos desde la base de datos según un id dado
     * @param int $id
     * 
     * @return boolean
     */
    public function buscar($valor = '', $where = '')
    {
        $bd = new BaseDatos();
        $query = "SELECT * from archivocargado ";

        if ($where != '')
            $query .= "WHERE $where";
        if ($valor != '')
            $query .= "WHERE idarchivocargado=$valor";

        $output = false;

        // Inicio conexión con bd
        if ($bd->Iniciar()) {
            // Ejecuto la consulta
            if ($bd->Ejecutar($query)) {
                // Recupero la información
                if ($row2 = $bd->Registro()) {
                    $this->set_id($row2['idarchivocargado']);
                    $this->set_nombre($row2['acnombre']);
                    $this->set_descripcion($row2['acdescripcion']);
                    $this->set_icono($row2['acicono']);
                    $this->set_linkAcceso($row2['aclinkacceso']);
                    $this->set_cantidadDescarga($row2['accantidaddescarga']);
                    $this->set_cantidadUsada($row2['accantidadusada']);
                    $this->set_fechaInicioCompartir($row2['acfechainiciocompartir']);
                    $this->set_fechaFinCompartir($row2['acefechafincompartir']);
                    $this->set_protegidoClave($row2['acprotegidoclave']);
                    $this->set_usuario($row2['idusuario']);
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
    public static function listar($where = "", $order = "idarchivocargado")
    {
        $listaArchivosCargados = null;
        $query = "Select * from archivocargado";

        if ($where != "")
            $query = $query . ' where ' . $where;

        $query .= " order by " . $order;

        // Iniciamos conexión con bd
        $bd = new BaseDatos();
        if ($bd->Iniciar()) {
            // Ejecutamos la consulta
            if ($bd->Ejecutar($query)) {
                $listaArchivosCargados = array();
                while ($row2 = $bd->Registro()) {
                    $id = $row2['idarchivocargado'];
                    $nombre = $row2['acnombre'];
                    $descripcion = $row2['acdescripcion'];
                    $icono = $row2['acicono'];
                    $linkAcceso = $row2['aclinkacceso'];
                    $cantidadDescarga = $row2['accantidaddescarga'];
                    $cantidadUsada = $row2['accantidadusada'];
                    $fechaInicioCompartir = $row2['acfechainiciocompartir'];
                    $fechaFinCompartir = $row2['acefechafincompartir'];
                    $protegidoClave = $row2['acprotegidoclave'];
                    $idUsuario = $row2['idusuario'];

                    // Creamos el nuevo objeto Usuario con los datos obtenidos
                    $tmpArchivoCargado = new ArchivoCargado();
                    $tmpArchivoCargado->set_id($id);
                    $tmpArchivoCargado->cargar($nombre, $descripcion, $icono, $linkAcceso, $cantidadDescarga, $cantidadUsada, $fechaInicioCompartir, $fechaFinCompartir, $protegidoClave, $idUsuario);
                    // Agregamos al arreglo
                    array_push($listaArchivosCargados, $tmpArchivoCargado);
                }
            } else {
                $listaArchivosCargados = $bd->getError();
            }
        } else {
            $listaArchivosCargados = $bd->getError();
        }

        return $listaArchivosCargados;
    }


    /**
     * Funcion para insertar los datos del objeto a la base de datos
     * @return boolean
     */
    public function insertar()
    {
        $bd     = new BaseDatos();
        $output = false;
        $query  = "INSERT INTO archivocargado(acnombre, acdescripcion, acicono, aclinkacceso, accantidaddescarga
                                              , accantidadusada, acfechainiciocompartir, acefechafincompartir, acprotegidoclave, idusuario)
				   VALUES ('" . $this->get_nombre() . "','" . $this->get_descripcion() . "','" . $this->get_icono() . "','" . $this->get_linkAcceso() . "'," . $this->get_cantidadDescarga()
            . "," . $this->get_cantidadUsada() . ",'" . $this->get_fechaInicioCompartir() . "','" . $this->get_fechaFinCompartir()
            . "','" . $this->get_protegidoClave() . "'," . $this->get_usuario()->get_id() . ")";

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
        $query = "UPDATE archivocargado SET acnombre='" . $this->get_nombre() . "',acdescripcion='" . $this->get_descripcion()
            . "',acicono='" . $this->get_icono() . "',aclinkacceso='" . $this->get_linkAcceso()
            . "',accantidaddescarga=" . $this->get_cantidadDescarga() . ",accantidadusada=" . $this->get_cantidadUsada()
            . ",acfechainiciocompartir='" . $this->get_fechaInicioCompartir()
            . "',acefechafincompartir='" . $this->get_fechaFinCompartir()
            . "',acprotegidoclave='" . $this->get_protegidoClave()
            . "',idusuario=" . $this->get_usuario()->get_id()
            . " WHERE idarchivocargado=" . $this->get_id();

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
            $query = "DELETE FROM archivocargado WHERE idarchivocargado=" . $this->get_id();

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
    public function get_nombre() { return $this->nombre; }
    public function get_descripcion() { return $this->descripcion; }
    public function get_icono() { return $this->icono; }
    public function get_linkAcceso() { return $this->linkAcceso; }
    public function get_cantidadDescarga() { return $this->cantidadDescarga; }
    public function get_cantidadUsada() { return $this->cantidadUsada; }
    public function get_fechaInicioCompartir() { return $this->fechaInicioCompartir; }
    public function get_fechaFinCompartir() { return $this->fechaFinCompartir; }
    public function get_protegidoClave() { return $this->protegidoClave; }
    public function get_usuario() { return $this->Usuario; }
    public function get_error() { return $this->error; }

    public function set_id($data) { $this->id = $data; }
    public function set_nombre($data) { $this->nombre = $data; }
    public function set_descripcion($data) { $this->descripcion = $data; }
    public function set_icono($data) { $this->icono = $data; }
    public function set_linkAcceso($data) { $this->linkAcceso = $data; }
    public function set_cantidadDescarga($data) { $this->cantidadDescarga = $data; }
    public function set_cantidadUsada($data) { $this->cantidadUsada = $data; }
    public function set_fechaInicioCompartir($data) { $this->fechaInicioCompartir = $data; }
    public function set_fechaFinCompartir($data) { $this->fechaFinCompartir = $data; }
    public function set_protegidoClave($data) { $this->protegidoClave = $data; }
    public function set_usuario($data) { $this->Usuario->buscar($data); }
    public function set_error($data) { $this->error = $data; }

    public function __toString()
    {
        return "<b>Objeto ArchivoCargado: </b>"
            . "<br>id: " . $this->get_id()
            . "<br>nombre: " . $this->get_nombre()
            . "<br>descipción: " . $this->get_descripcion()
            . "<br>icono: " . $this->get_icono()
            . "<br>linkAcceso: " . $this->get_linkAcceso()
            . "<br>cantidadDescarga: " . $this->get_cantidadDescarga()
            . "<br>cantidadUsada: " . $this->get_cantidadUsada()
            . "<br>fechaInicioCompartir: " . $this->get_fechaInicioCompartir()
            . "<br>fechaFinCompartir: " . $this->get_fechaFinCompartir()
            . "<br>protegidoClave: " . $this->get_protegidoClave()
            . "<br>Usuario: " . $this->get_usuario();
    }
}
