<?php

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 30/09/2020
 */

class Usuario
{
    // Instancias de bd
    private $id;
    private $nombre;
    private $apellido;
    private $login;
    private $clave;
    private $activo;
    // Extras
    private $error;

    public function __construct()
    {
        $this->id = "";
        $this->nombre = "";
        $this->apellido = "";
        $this->login = "";
        $this->clave = "";
        $this->activo = "";
        $this->error = null;
    }

    /**
     * Esta función es para cargar al objeto de información
     * @param string $id, $nombre, $apellido, $login, $clave, $activo Datos instancias de la BD
     */
    public function cargar($nombre, $apellido, $login, $clave, $activo)
    {
        $this->set_nombre($nombre);
        $this->set_apellido($apellido);
        $this->set_login($login);
        $this->set_clave($clave);
        $this->set_activo($activo);
    }

    /**
     * Función para buscar datos desde la base de datos según un id dado
     * @param int $id
     * 
     * @return boolean
     */
    public function buscar($id)
    {
        $bd = new BaseDatos();
        $query = "SELECT * from usuario where idusuario=" . $id;
        $output = false;

        // Inicio conexión con bd
        if ($bd->Iniciar()) {
            // Ejecuto la consulta
            if ($bd->Ejecutar($query)) {
                // Recupero la información
                if ($row2 = $bd->Registro()) {
                    $this->set_id($id);
                    $this->set_nombre($row2['usnombre']);
                    $this->set_apellido($row2['usapellido']);
                    $this->set_login($row2['uslogin']);
                    $this->set_clave($row2['usclave']);
                    $this->set_activo($row2['usactivo']);
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
    public static function listar($where = "", $order = "idusuario")
    {
        $listaUsuarios = null;
        $query = "Select * from usuario";

        if ($where != "")
            $query = $query . ' where ' . $where;

        $query .= " order by " . $order;

        // Iniciamos conexión con bd
        $bd = new BaseDatos();
        if ($bd->Iniciar()) {
            // Ejecutamos la consulta
            if ($bd->Ejecutar($query)) {
                $listaUsuarios = array();
                while ($row2 = $bd->Registro()) {
                    $id = $row2['idusuario'];
                    $nombre = $row2['usnombre'];
                    $apellido = $row2['usapellido'];
                    $login = $row2['uslogin'];
                    $clave = $row2['usclave'];
                    $activo = $row2['usactivo'];

                    // Creamos el nuevo objeto Usuario con los datos obtenidos
                    $tmpUsuario = new Usuario();
                    $tmpUsuario->set_id($id);
                    $tmpUsuario->cargar($nombre, $apellido, $login, $clave, $activo);
                    // Agregamos al arreglo
                    array_push($listaUsuarios, $tmpUsuario);
                }
            } else {
                $listaUsuarios = $bd->getError();
            }
        } else {
            $listaUsuarios = $bd->getError();
        }

        return $listaUsuarios;
    }


    /**
     * Funcion para insertar los datos del objeto a la base de datos
     * @return boolean
     */
    public function insertar()
    {
        $bd     = new BaseDatos();
        $output = false;
        $query  = "INSERT INTO usuario(usnombre, usapellido, uslogin, usclave, usactivo) 
				   VALUES ('" . $this->get_nombre() . "','" . $this->get_apellido() . "','" . $this->get_login() . "','" . $this->get_clave() . "','" . $this->get_activo() . "')";

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
        $query = "UPDATE usuario SET usnombre='" . $this->get_nombre() . "',usapellido='" . $this->get_apellido()
            . "',uslogin='" . $this->get_login() . "',usclave='" . $this->get_clave()
            . "',usactivo=" . $this->get_activo() . " WHERE idusuario=" . $this->get_id();

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
            $query = "DELETE FROM usuario WHERE idusuario=" . $this->get_id();

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
     * Éste método valida que los datos provistos pertenezcan a un usuario en la base de datos
     * @param string $usuario       : nombre de usuario
     * @param string $contraseña    : contraseña sin md5
     * @return mixed boolean|string
     */
    public static function validar_cuenta(string $usuario, string $contraseña)
    {
        $conexion = new BaseDatos();
        $contraseña = md5($contraseña);
        $consulta = "SELECT u.idusuario FROM usuario u  WHERE u.uslogin='$usuario' AND u.usclave='$contraseña' LIMIT 1";
        
        // Iniciamos conexión con BD.
        if (!$conexion->Iniciar())
        {
            return false;
        }

        // Ejecutamos la consulta.
        if (!$conexion->Ejecutar($consulta))
        {
            return false;
        }

        // Retornamos la información obtenida.
        $row2 = $conexion->Registro();

        if (isset($row2['idusuario'])) return $row2['idusuario'];

        return false;
    }


    /**
     * Metodos de Acceso
     */
    public function get_id() { return $this->id; }
    public function get_nombre() { return $this->nombre; }
    public function get_apellido() { return $this->apellido; }
    public function get_login() { return $this->login; }
    public function get_clave() { return $this->clave; }
    public function get_activo() { return $this->activo; }
    public function get_error() { return $this->error; }
    
    public function set_id($data) { $this->id = $data; }
    public function set_nombre($data) { $this->nombre = $data; }
    public function set_apellido($data) { $this->apellido = $data; }
    public function set_login($data) { $this->login = $data; }
    public function set_clave($data) { $this->clave = $data; }
    public function set_activo($data) { $this->activo = $data; }
    public function set_error($data) { $this->error = $data; }

    public function __toString()
    {
        return "<b>Objeto Usuario: </b>"
            . "<br>id: " . $this->get_id()
            . "<br>nombre: " . $this->get_nombre()
            . "<br>apellido: " . $this->get_apellido()
            . "<br>login: " . $this->get_login()
            . "<br>clave: " . $this->get_clave()
            . "<br>activo: " . $this->get_activo();
    }
}
